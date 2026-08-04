<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Latest_news extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("Latest_news_model", "latest_news");
        $this->load->model("employee_model");
        $this->load->model("category_model");
        $this->load->model("settings_model");

        $this->load->helper(["url", "text"]);
        $this->load->library(["session", "form_validation", "upload", "pagination"]);
    }

    // ===============================
    // Admin List Page
    // ===============================
    public function adminIndex($offset = 0)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        $data['selected_category'] = 'all';
        $data['categories'] = $this->latest_news->getAllCategories();

        $config['base_url'] = base_url('latest_news/adminIndex');
        $config['total_rows'] = $this->latest_news->countAllNews();
        $config['per_page'] = $config['total_rows']; // Show all
        $config['uri_segment'] = 3;

        // Pagination UI
        $this->_pagination_style($config);
        $this->pagination->initialize($config);

        $data['news'] = $this->latest_news->getNewsPaginated($config['per_page'], $offset);

        $this->load->view('backend/news_list', $data);
    }

    // ===============================
    // Frontend Listing Page
    // ===============================
    public function index($offset = 0)
    {
        $data['selected_category'] = 'all';
        $data['categories'] = $this->latest_news->getAllCategories();

        $config['base_url'] = base_url('latest_news/index');
        $config['total_rows'] = $this->latest_news->countAllNews();
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;

        $this->_pagination_style($config);
        $this->pagination->initialize($config);

        $data['news'] = $this->latest_news->getNewsPaginated($config['per_page'], $offset);

        $this->load->view('pages/latest-news', $data);
    }

    // Pagination design
    private function _pagination_style(&$config)
    {
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['attributes'] = ['class' => 'page-link'];
    }

    // ===============================
    // Add News View
    // ===============================
    public function add()
    {
        $this->load->view("backend/header");
        $this->load->view("backend/sidebar");
        $this->load->view("backend/news_list");
        $this->load->view("backend/footer");
    }

    // ===============================
    // INSERT
    // ===============================
    public function insert()
    {
        $data = $this->input->post();
        $data["createdAt"] = date("Y-m-d H:i:s");

        // Validation
        $this->form_validation->set_rules(
            "name",
            "News Title",
            "trim|required|min_length[3]|max_length[120]|xss_clean"
        );

        if ($this->form_validation->run() == false) {
            echo validation_errors();
            exit();
        }

        // Get category name
        $data['category_name'] = $this->latest_news->getCategoryName($data['category_id']);

        // Upload Image
        $data['image'] = $this->_upload_image();

        // Generate Slug
        if (empty($data["slug"])) {
            $data["slug"] = $this->latest_news->generateUniqueSlug($data["name"]);
        }

        $this->latest_news->insertNews($data);

        $this->session->set_flashdata("success", "Latest News Added successfully");
        redirect("Latest_news", "refresh");
    }

    // Reusable upload function
    private function _upload_image()
    {
        if (empty($_FILES["image"]["name"])) {
            return "";
        }

        $upload_path = FCPATH . "assets/images/latest_news/";

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config = [
            "upload_path" => $upload_path,
            "allowed_types" => "jpg|jpeg|png|gif|webp",
            "file_name" => time() . "_" . uniqid(),
            "max_size" => 20480, // 20MB
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload("image")) {
            $this->session->set_flashdata("error", $this->upload->display_errors());
            return "";
        }

        $uploadData = $this->upload->data();
        return $uploadData["file_name"];
    }

    // ===============================
    // EDIT
    // ===============================
    public function edit($id)
    {
        $data["news"] = $this->latest_news->getNewsById($id);

        $this->load->view("backend/header");
        $this->load->view("backend/sidebar");
        $this->load->view("backend/news/edit_news", $data);
        $this->load->view("backend/footer");
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update()
    {
        $id = $this->input->post("id");

        $data = $this->input->post();
        $data['category_name'] = $this->latest_news->getCategoryName($data['category_id']);

        if ($_FILES["image"]["name"]) {
            $data["image"] = $this->_upload_image();
        }

        $this->latest_news->updateNews($id, $data);

        $this->session->set_flashdata("success", "Latest News Updated successfully");
        redirect("Latest_news", "refresh");
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        if ($this->latest_news->delete_news($id)) {
            $this->session->set_flashdata('success', 'Latest News deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete.');
        }

        redirect($this->input->server('HTTP_REFERER') ?? "Latest_news");
    }

    // ===============================
    // CATEGORY LISTING + DETAILS
    // ===============================
    public function category($slug = null, $offset = 0)
    {
        $slug = urldecode($slug);

        // If slug refers to article
        if ($this->latest_news->getNewsBySlug($slug)) {
            $data['article'] = $this->latest_news->getNewsBySlug($slug);
            $this->load->view('pages/latest-news-details', $data);
            return;
        }

        // Otherwise list by category
        $data['selected_category'] = $slug;
        $data['categories'] = $this->latest_news->getAllCategories();

        $config['base_url'] = base_url('latest_news/category/' . urlencode($slug));
        $config['total_rows'] = $this->latest_news->countNewsByCategory($slug);
        $config['per_page'] = 15;
        $config['uri_segment'] = 4;

        $this->_pagination_style($config);
        $this->pagination->initialize($config);

        $data['news'] = $this->latest_news->getNewsByCategoryPaginated($slug, $config['per_page'], $offset);

        $this->load->view('pages/latest-news', $data);
    }

    public function details($category = null, $slug = null)
    {
        if (!$category || !$slug) show_404();

        $article = $this->latest_news->getNewsBySlug($slug);
        if (!$article) show_404();

        if (strtolower($article['category_name']) !== strtolower(str_replace('-', ' ', $category))) {
            show_404();
        }

        $data['article'] = $article;
        $this->load->view('pages/latest-news-details', $data);
    }
}
