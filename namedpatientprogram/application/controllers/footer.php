<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Footer_cms_model');
    }

    // ====================================
    // FRONTEND PAGE VIEW
    // ====================================

    public function view($slug = null)
    {
        // CHECK SLUG

        if (!$slug) {
            show_404();
        }

        // GET PAGE

        $data['page'] =
            $this->Footer_cms_model
                ->get_pages_by_slug($slug);

        // PAGE NOT FOUND

        if (!$data['page']) {
            show_404();
        }

        // LOAD FOOTER MENU

        $data['footer_menu'] =
            $this->Footer_cms_model
                ->get_footer_menu();

        // LOAD FRONTEND PAGE VIEW

        $this->load->view(
            'frontend/footer_page',
            $data
        );
    }
}