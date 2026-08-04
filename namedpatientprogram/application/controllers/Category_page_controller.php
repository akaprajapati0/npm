<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Category_page_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model("Category_page_model");
        $this->load->model("Settings_model");

        $this->load->helper("url");
        $this->load->helper("form");

        // ADD THIS
        $this->load->library('pagination');

        $this->load->model('Cms_model');
    }


    public function index($slug = null, $offset = 0)
    {
        if (empty($slug)) {
            $slug = 'cardiology';
        }

        $category_name = str_replace('-', ' ', $slug);

        $category = $this->db
            ->where('LOWER(name)', strtolower($category_name))
            ->get('med_categories')
            ->row();

        if (!$category) {
            show_404();
        }

        $category_id = $category->id;

        $data['categories'] = $this->Category_page_model->getAllCategories();

        $config['base_url'] = base_url('therapeutic-area/' . $slug);

        $config['total_rows'] = $this->Category_page_model
            ->countMedicinesByCategory($category_id);

        $config['per_page'] = 12;
        $config['uri_segment'] = 4;

        $config['full_tag_open'] = '<div class="custom-pagination">';
        $config['full_tag_close'] = '</div>';

        $config['cur_tag_open'] = '<a class="active">';
        $config['cur_tag_close'] = '</a>';

        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $this->pagination->initialize($config);

        $data['medicines'] = $this->Category_page_model->getMedicinesByCategory(
            $category_id,
            $config['per_page'],
            $offset
        );

        $data['pagination'] = $this->pagination->create_links();

        $data['category'] = $category;

        $this->load->view('pages/category-page', $data);
    }
}