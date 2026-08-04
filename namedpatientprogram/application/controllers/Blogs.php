<?php
defined("BASEPATH") or exit("No direct script access allowed");

class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("News_model");
        $this->load->model("employee_model");
        $this->load->model("category_model");
        $this->load->model("login_model");
        $this->load->model("settings_model");
        $this->load->helper(["url", "text"]);
        $this->load->library("session");
        $this->load->library("pagination");

    }

    public function index()
    {
        $data["categories"] = $this->news_model->getAllCategories();
        $data["news"] = $this->news_model->getAllNews();
        $this->load->view("backend/news_list", $data);
    }

    public function add()
    {
        $this->load->view("backend/header");
        $this->load->view("backend/sidebar");
        $this->load->view("backend/news_list");
        $this->load->view("backend/footer");
    }


    //test start
/*
    public function view($category = null, $slug = null)
    {
        if (!$category || !$slug) {
            show_404();
        }

        $data['article'] = $this->News_model->get_article($category, $slug);

        if (empty($data['article'])) {
            show_404();
        }

        $this->load->view('news/view', $data);
    }

    // Example insert method (optional)
    public function insert_example()
    {
        $title = "My Name is Radhesh";
        $data = [
            'title' => $title,
            'slug' => create_slug($title),
            'category' => 'news',
            'content' => 'This is the full news content...',
            'meta_description' => 'Meta description for SEO.',
            'meta_keywords' => 'news, ikris, radhesh'
        ];
        $this->News_model->insert_article($data);
        echo "Article inserted!";
    }*/
    //   test end
    // public function insert()
    // {
    //     // Get all POST data
    //     $data = $this->input->post();
    //     // print_r($data);
    //     // exit;
    //     $data["createdAt"] = date("Y-m-d H:i:s");

    //     // Validate name (optional)
    //     $this->load->library("form_validation");
    //     $this->form_validation->set_error_delimiters(
    //         '<p class="text-danger">',
    //         "</p>"
    //     );
    //     $this->form_validation->set_rules(
    //         "name",
    //         "News Title",
    //         "trim|required|min_length[3]|max_length[120]|xss_clean"
    //     );

    //     if ($this->form_validation->run() == false) {
    //         echo validation_errors(); // Optional: Use flashdata instead for redirection
    //         exit();
    //     }

    //     // Handle image upload
    //     if (!empty($_FILES["image"]["name"])) {
    //         $clean_name = preg_replace(
    //             "/[^a-zA-Z0-9_-]/",
    //             "",
    //             strtolower($data["name"])
    //         );
    //         $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    //         $new_file_name = time() . "_" . $clean_name . "." . $extension;

    //         $config = [
    //             "upload_path" => "./assets/images/news/",
    //             "allowed_types" => "jpg|jpeg|png|gif|webp",
    //             "file_name" => $new_file_name,
    //             "overwrite" => false,
    //             "max_size" => "2048", // Optional: 2MB
    //         ];

    //         $this->load->library("upload", $config);
    //         $this->upload->initialize($config);

    //         if (!$this->upload->do_upload("image")) {
    //             echo $this->upload->display_errors(); // Optional: Use flashdata for UI
    //             $data["image"] = "";
    //         } else {
    //             $uploadData = $this->upload->data();
    //             $data["image"] = $uploadData["file_name"];
    //         }
    //     } else {
    //         $data["image"] = "";
    //     }

    //     // Generate unique slug if empty
    //     if (empty($data["slug"])) {
    //         $data["slug"] = $this->news_model->generateUniqueSlug(
    //             $data["name"]
    //         );
    //     }

    //     // Insert into database
    //     $this->news_model->insertNews($data);

    //     // Optional: Flash message
    //    $this->session->set_flashdata(
    //         "success",
    //         "News Added successfully"
    //     );
    //     // Redirect to News list

    //     redirect("News","refresh");
    // }
    public function insert()
    {
        // Get all POST data
        $data = $this->input->post();
        $data["createdAt"] = date("Y-m-d H:i:s");

        // Validate name
        $this->load->library("form_validation");
        $this->form_validation->set_error_delimiters('<p class="text-danger">', "</p>");
        $this->form_validation->set_rules(
            "name",
            "News Title",
            "trim|required|min_length[3]|max_length[120]|xss_clean"
        );

        if ($this->form_validation->run() == false) {
            echo validation_errors();
            exit();
        }

        // ✅ Fetch category_name using category_id
        if (!empty($data['category_id'])) {
            $this->db->select('name');
            $this->db->from('category');
            $this->db->where('id', $data['category_id']);
            $query = $this->db->get();
            $row = $query->row();

            $data['category_name'] = ($row) ? $row->name : ""; // Set category_name or blank if not found
        } else {
            $data['category_name'] = "";
        }

        // Handle image upload
        if (!empty($_FILES["image"]["name"])) {
            $clean_name = preg_replace("/[^a-zA-Z0-9_-]/", "", strtolower($data["name"]));
            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_file_name = time() . "_" . $clean_name . "." . $extension;

            $config = [
                "upload_path" => "./assets/images/news/",
                "allowed_types" => "jpg|jpeg|png|gif|webp",
                "file_name" => $new_file_name,
                "overwrite" => false,
                "max_size" => "2048",
            ];

            $this->load->library("upload", $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("image")) {
                echo $this->upload->display_errors();
                $data["image"] = "";
            } else {
                $uploadData = $this->upload->data();
                $data["image"] = $uploadData["file_name"];
            }
        } else {
            $data["image"] = "";
        }

        // Generate unique slug if empty
        if (empty($data["slug"])) {
            $data["slug"] = $this->news_model->generateUniqueSlug($data["name"]);
        }

        // Insert into database
        $this->news_model->insertNews($data);

        // Flash message and redirect
        $this->session->set_flashdata("success", "News Added successfully");
        redirect("News", "refresh");
    }

    public function edit($id)
    {
        $data["news"] = $this->news_model->getNewsById($id);
        $this->load->view("backend/header");
        $this->load->view("backend/sidebar");
        $this->load->view("backend/news/edit_news", $data);
        $this->load->view("backend/footer");
    }

    // public function update()
    // {
    //     $id = $this->input->post("id");
    //     $name = $this->input->post("name");
    //     $slug = $this->input->post("slug");
    //     $category_id = $this->input->post("category_id");
    //     $description = $this->input->post("description");
    //     $metaTitle = $this->input->post("metaTitle");
    //     $metaDescription = $this->input->post("metaDescription");
    //     $metaKeywords = $this->input->post("metaKeywords");
    //     $metaCanonical = $this->input->post("metaCanonical");
    //     $metaSchema = $this->input->post("metaSchema");
    //     $ogMetaTitle = $this->input->post("ogMetaTitle");
    //     $ogMetaDescription = $this->input->post("ogMetaDescription");
    //     $ogMetaKeywords = $this->input->post("ogMetaKeywords");
    //     $ogMetaUrl = $this->input->post("ogMetaUrl");
    //     $status = $this->input->post("status");

    //     // Generate slug if empty
    //     if (empty($slug)) {
    //         $slug = $this->generateUniqueSlug($name);
    //     }

    //     $data = [
    //         "name" => $name,
    //         "slug" => $slug,
    //         "category_id" => $category_id,
    //         "description" => $description,
    //         "metaTitle" => $metaTitle,
    //         "metaDescription" => $metaDescription,
    //         "metaKeywords" => $metaKeywords,
    //         "metaCanonical" => $metaCanonical,
    //         "metaSchema" => $metaSchema,
    //         "ogMetaTitle" => $ogMetaTitle,
    //         "ogMetaDescription" => $ogMetaDescription,
    //         "ogMetaKeywords" => $ogMetaKeywords,
    //         "ogMetaUrl" => $ogMetaUrl,
    //         "status" => $status,
    //     ];

    //     // Handle image upload
    //     if ($_FILES["image"]["name"]) {
    //         $file_name = $_FILES["image"]["name"];
    //         $new_file_name =
    //             time() .
    //             "_" .
    //             preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file_name);

    //         $config = [
    //             "upload_path" => "./assets/images/news/", // ✅ Target folder
    //             "allowed_types" => "gif|jpg|png|jpeg|webp",
    //             "file_name" => $new_file_name,
    //             "overwrite" => false,
    //             "max_size" => "2048", // Optional limit in KB
    //         ];

    //         $this->load->library("upload", $config);
    //         $this->upload->initialize($config);

    //         if (!$this->upload->do_upload("image")) {
    //             echo $this->upload->display_errors();
    //             exit();
    //         } else {
    //             $upload_data = $this->upload->data();
    //             $data["image"] = $upload_data["file_name"];
    //         }
    //     }

    //     // Update record
    //     $this->db->where("id", $id);
    //     $this->db->update("news", $data);
    //     $this->session->set_flashdata(
    //         "success",
    //         "News Updated successfully!"
    //     );

    //     redirect("News","refresh");
    // }

    public function update()
    {
        $id = $this->input->post("id");
        $name = $this->input->post("name");
        $slug = $this->input->post("slug");
        $category_id = $this->input->post("category_id");
        $description = $this->input->post("description");
        $metaTitle = $this->input->post("metaTitle");
        $metaDescription = $this->input->post("metaDescription");
        $metaKeywords = $this->input->post("metaKeywords");
        $metaCanonical = $this->input->post("metaCanonical");
        $metaSchema = $this->input->post("metaSchema");
        $ogMetaTitle = $this->input->post("ogMetaTitle");
        $ogMetaDescription = $this->input->post("ogMetaDescription");
        $ogMetaKeywords = $this->input->post("ogMetaKeywords");
        $ogMetaUrl = $this->input->post("ogMetaUrl");
        $status = $this->input->post("status");

        // Generate slug if empty
        if (empty($slug)) {
            $slug = $this->generateUniqueSlug($name);
        }

        // ✅ Get category_name from category_id
        $category_name = '';
        if (!empty($category_id)) {
            $this->db->select('name');
            $this->db->from('category');
            $this->db->where('id', $category_id);
            $query = $this->db->get();
            $row = $query->row();
            $category_name = $row ? $row->name : '';
        }

        $data = [
            "name" => $name,
            "slug" => $slug,
            "category_id" => $category_id,
            "category_name" => $category_name, // ✅ Add category name
            "description" => $description,
            "metaTitle" => $metaTitle,
            "metaDescription" => $metaDescription,
            "metaKeywords" => $metaKeywords,
            "metaCanonical" => $metaCanonical,
            "metaSchema" => $metaSchema,
            "ogMetaTitle" => $ogMetaTitle,
            "ogMetaDescription" => $ogMetaDescription,
            "ogMetaKeywords" => $ogMetaKeywords,
            "ogMetaUrl" => $ogMetaUrl,
            "status" => $status,
        ];

        // Handle image upload
        if ($_FILES["image"]["name"]) {
            $file_name = $_FILES["image"]["name"];
            $new_file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file_name);

            $config = [
                "upload_path" => "./assets/images/news/",
                "allowed_types" => "gif|jpg|png|jpeg|webp",
                "file_name" => $new_file_name,
                "overwrite" => false,
                "max_size" => "2048",
            ];

            $this->load->library("upload", $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("image")) {
                echo $this->upload->display_errors();
                exit();
            } else {
                $upload_data = $this->upload->data();
                $data["image"] = $upload_data["file_name"];
            }
        }

        // Update record
        $this->db->where("id", $id);
        $this->db->update("news", $data);

        $this->session->set_flashdata("success", "News Updated successfully!");
        redirect("News", "refresh");
    }

    public function generateUniqueSlug($title)
    {
        $slug = strtolower(trim(preg_replace("/[^A-Za-z0-9-]+/", "-", $title)));
        $original_slug = $slug;
        $i = 1;

        while (
            $this->db->get_where("news", ["slug" => $slug])->num_rows() > 0
        ) {
            $slug = $original_slug . "-" . $i;
            $i++;
        }

        return $slug;
    }

    public function delete($id)
    {
        // Step 1: Get news record by id (to get image filename)
        $news = $this->news_model->getNewsById($id);

        // Step 2: Delete image file if exists
        if (!empty($news['image'])) {
            $image_path = FCPATH . 'assets/images/news/' . $news['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Step 3: Delete record from DB
        $this->news_model->deleteNews($id);

        // Step 4: Set flash message and redirect
        $this->session->set_flashdata("success", "News deleted successfully!");
        redirect("News");
    }
    public function news_details($slug)
    {
        $data['article'] = $this->news_model->getNewsBySlug($slug);

        if (!$data['article']) {
            show_404();
        }

        $data['selected_category'] = 'all';
        $data['categories'] = $this->news_model->getAllCategories();

        $data['latest_news'] = $this->news_model->get_latest_news(
            6,
            $data['article']['id']
        );

        $this->load->view('pages/news-details', $data);
    }

}