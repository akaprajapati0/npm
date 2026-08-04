<?php
defined("BASEPATH") or exit("No direct script access allowed");
/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 * @property CI_Image_lib $image_lib
 * @property CI_Email $email
 * @property News_model $news_model
 * @property Employee_model $employee_model
 * @property Category_model $category_model
 * @property Login_model $login_model
 * @property Settings_model $settings_model
 * @property CI_Pagination $pagination
 */
class News extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("news_model");
        $this->load->model("employee_model");
        $this->load->model("category_model");
        $this->load->model("login_model");
        $this->load->model("settings_model");
        $this->load->helper(["url", "text"]);
        $this->load->library("session");
        $this->load->library("form_validation");
        $this->load->library("upload");
        $this->load->library("pagination");
    }

    public function adminIndex($offset = 0)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        $category = 'all';
        $data['selected_category'] = $category;
        $data['categories'] = $this->news_model->getAllCategories();

        $config['base_url'] = base_url('news/index');
        $config['total_rows'] = $this->news_model->countAllNews();
        // $config['per_page'] = 15;
        $config['per_page'] = $config['total_rows'];
        $config['uri_segment'] = 3;

        // Bootstrap 4 Pagination
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['news'] = $this->news_model->getNewsPaginated($config['per_page'], $offset);

        $this->load->view('backend/news_list', $data);
    }


    public function index($offset = 0)
    {
        $category = 'all';
        $data['selected_category'] = $category;
        $data['categories'] = $this->news_model->getAllCategories();

        $config['base_url'] = base_url('news/index');
        $config['total_rows'] = $this->news_model->countAllNews();
        $config['per_page'] = 15;
        //$config['per_page'] = $config['total_rows'];
        $config['uri_segment'] = 3;

        // Bootstrap 4 Pagination
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['news'] = $this->news_model->getNewsPaginated($config['per_page'], $offset);

        $this->load->view('pages/news-and-updates', $data);
    }

    public function add()
    {
        $this->load->view("backend/header");
        $this->load->view("backend/sidebar");
        $this->load->view("backend/news_list");
        $this->load->view("backend/footer");
    }

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
        // if (!empty($_FILES["image"]["name"])) {
        //     $clean_name = preg_replace("/[^a-zA-Z0-9_-]/", "", strtolower($data["name"]));
        //     $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        //     $new_file_name = time() . "_" . $clean_name . "." . $extension;

        //     $config = [
        //         "upload_path" => "./assets/images/news/",
        //         "allowed_types" => "jpg|jpeg|png|gif|webp",
        //         "file_name" => $new_file_name,
        //         "overwrite" => false,
        //         "max_size" => 20480


        //     ];

        //     $this->load->library("upload", $config);
        //     $this->upload->initialize($config);

        //     if (!$this->upload->do_upload("image")) {
        //         // echo $this->upload->display_errors();
        //         $this->session->set_flashdata("error", $this->upload->display_errors());
        //         $data["image"] = "";
        //     } else {
        //         $uploadData = $this->upload->data();
        //         $data["image"] = $uploadData["file_name"];
        //     }
        // } else {
        //     $data["image"] = "";
        // }
        // Make sure upload folder exists
        $upload_path = FCPATH . "assets/images/news/";
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true); // create folder if not exists
        }

        $config = [
            "upload_path"   => $upload_path,
            "allowed_types" => "jpg|jpeg|png|gif|webp|avif",
            "file_name"     => time() . "_" . uniqid(), // safe unique filename
            "overwrite"     => false,
            "max_size"      => 20480 // 20MB
        ];

        $this->load->library("upload", $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload("image")) {
            // Save error in flashdata (you can display in admin view)
            $this->session->set_flashdata("error", $this->upload->display_errors());
            $data["image"] = ""; // store blank if failed
        } else {
            $uploadData = $this->upload->data();
            $data["image"] = $uploadData["file_name"];

            // Double-check if file is really saved
            $full_path = $upload_path . $uploadData["file_name"];
            if (!file_exists($full_path)) {
                log_message("error", "Upload failed: file not found after upload -> " . $full_path);
                $this->session->set_flashdata("error", "File upload error: could not save image.");
                $data["image"] = "";
            }
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
            'author_name' => $this->input->post('author_name'), // ✅ NEW
        ];

        // Handle image upload
        if ($_FILES["image"]["name"]) {
            $file_name = $_FILES["image"]["name"];
            $new_file_name = time() . "_" . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $file_name);

            $config = [
                "upload_path" => "./assets/images/news/",
                "allowed_types" => "gif|jpg|png|jpeg|webp|avif",
                "file_name" => $new_file_name,
                "overwrite" => false,
                "max_size" => "20480",
                "max_width" => 5000,
                "max_height" => 5000
            ];

            $this->load->library("upload", $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("image")) {
                // echo $this->upload->display_errors();
                $this->session->set_flashdata("error", $this->upload->display_errors());
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
            $this->db->where("slug", $slug)->get("news")->num_rows() > 0
        ) {
            $slug = $original_slug . "-" . $i;
            $i++;
        }

        return $slug;
    }

    // public function delete($id)
    // {
    //     // Step 1: Get news record by id (to get image filename)
    //     $news = $this->news_model->getNewsById($id);

    //     // Step 2: Delete image file if exists
    //     if (!empty($news['image'])) {
    //         $image_path = FCPATH . 'assets/images/news/' . $news['image'];
    //         if (file_exists($image_path)) {
    //             unlink($image_path);
    //         }
    //     }

    //     // Step 3: Delete record from DB
    //     $this->news_model->deleteNews($id);

    //     // Step 4: Set flash message and redirect
    //     $this->session->set_flashdata("success", "News deleted successfully!");
    //     redirect("News");
    // }
    public function delete($id)
    {
        if ($this->news_model->delete_news($id)) {
            $this->session->set_flashdata('success', 'News deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete news.');
        }
        // redirect('news'); // or redirect('admin_panel/news') if you move it
        $referrer = $this->input->server('HTTP_REFERER');
        if ($referrer) {
            redirect($referrer);
        } else {
            redirect('News'); // fallback if no referrer
        }
    }




    public function category($slug = null, $offset = 0)
    {
        $slug = urldecode($slug);

        // If a slug is provided, show the details page
        if (!empty($slug) && $this->news_model->getNewsBySlug($slug)) {
            $article = $this->news_model->getNewsBySlug($slug);
            if (!$article) {
                show_404();
            }
            $data['article'] = $article;
            // Optionally: $data['related_news'] = $this->news_model->getRelatedNews($slug);
            $this->load->view('pages/news-details', $data);
            return;
        }

        // Otherwise, show the category listing
        $data['selected_category'] = $slug;
        $data['categories'] = $this->news_model->getAllCategories();

        $config['base_url'] = base_url('news/category/' . urlencode($slug));
        $config['total_rows'] = $this->news_model->countNewsByCategory($slug);
        $config['per_page'] = 15;
        $config['uri_segment'] = 4;

        // Bootstrap 4 Pagination
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['news'] = $this->news_model->getNewsByCategoryPaginated($slug, $config['per_page'], $offset);

        $this->load->view('pages/news-and-updates', $data);
    }


    // public function details($slug)
    // {

    //     $article = $this->news_model->getNewsBySlug($slug);
    //     if (!$article) {
    //         show_404();
    //     }
    //     $data['article'] = $article;
    //     // Optionally: $data['related_news'] = $this->news_model->getRelatedNews($slug);
    //     $this->load->view('pages/news-details', $data);
    // }
    public function details($category = null, $slug = null)
    {
        if (empty($category) || empty($slug)) {
            show_404();
        }

        $article = $this->news_model->getNewsBySlug($slug);

        if (!$article) {
            show_404();
        }

        // Optional: Verify category matches DB category_name
        if (strtolower($article['category_name']) !== strtolower(str_replace('-', ' ', $category))) {
            show_404();
        }

        $data['article'] = $article;
        $this->load->view('pages/news-details', $data);
    }





    public function save_home_selection()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            echo json_encode(['status' => 'error', 'msg' => 'Unauthorized']);
            return;
        }

        $ids = $this->input->post('ids'); // array of selected IDs

        if (!is_array($ids)) {
            $ids = [];
        }

        if (count($ids) > 3) {
            echo json_encode([
                'status' => 'error',
                'msg'    => 'You can select maximum 3 news items for homepage.'
            ]);
            return;
        }

        // Reset all, then set new ones
        $this->news_model->clearHomeNews();
        if (!empty($ids)) {
            $this->news_model->setHomeNews($ids);
        }

        echo json_encode([
            'status' => 'success',
            'msg'    => 'Homepage news selection saved successfully.'
        ]);
    }


    public function details_slug($slug = null)
    {
        if (empty($slug)) {
            show_404();
        }

        $article = $this->news_model->getNewsBySlug($slug);

        if (!$article) {
            show_404();
        }

        $data['article'] = $article;
        $this->load->view('pages/news-details', $data);
    }
}