<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FooterCms extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->model('Footer_cms_model');

        $this->load->model('employee_model');

        $this->load->model('settings_model');

        $this->load->helper(['url', 'form', 'text']);

        $this->load->library([
            'session',
            'form_validation',
            'upload'
        ]);

        // CHECK ADMIN LOGIN

        if (
            $this->session
                ->userdata('user_login_access') != 1
        ) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    // ========================================
    // INDEX
    // ========================================

    public function index()
    {
        $data['pages'] =
            $this->Footer_cms_model->get_all_pages();

        $data['categories'] =
            $this->Footer_cms_model->get_categories();

        $this->load->view(
            'backend/footer_cms',
            $data
        );
    }

    // ========================================
    // ADD PAGE
    // ========================================

    public function add()
    {
        $this->form_validation->set_rules(
            'page_name',
            'Page Name',
            'required'
        );

        $this->form_validation->set_rules(
            'slug',
            'Slug',
            'required'
        );

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata(
                'error',
                validation_errors()
            );

            redirect('admin_panel/FooterCms');
        }

        $slug = $this->input->post('slug');

        // CHECK SLUG EXISTS

        if (
            $this->Footer_cms_model
                ->slug_exists($slug)
        ) {

            $this->session->set_flashdata(
                'error',
                'Slug already exists'
            );

            redirect('admin_panel/FooterCms');
        }

        // INSERT DATA

        $data = [

            'category_id' =>
                $this->input->post('category_id'),

            'page_name' =>
                $this->input->post('page_name'),

            'slug' =>
                $slug,

            'status' =>
                $this->input->post('status'),

            'sort_order' =>
                $this->input->post('sort_order')

        ];

        // INSERT PAGE

        $this->Footer_cms_model
            ->insert_page($data);

        $this->session->set_flashdata(
            'success',
            'Footer page added successfully'
        );

        redirect('admin_panel/FooterCms');
    }

}