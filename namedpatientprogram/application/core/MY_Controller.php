<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Base Controller
 * Automatically loads navigation for all controllers
 */
class MY_Controller extends CI_Controller
{
    protected $data = array();

    public function __construct()
    {
        parent::__construct();

        // Load CMS navigation globally for ALL pages
        // $this->load->model('Cms_model');
        // $this->load->model('Category_model');

        // // Make CMS navigation available to all views
        // $this->data['cms_navigation'] = $this->Cms_model->get_navigation_hierarchy();
        // $this->data['categories'] = $this->Category_model->emselect();

        // LOAD MODELS

        $this->load->model('Cms_model');

        $this->load->model('Category_model');

        // FOOTER CMS MODEL

        // $this->load->model('Footer_cms_model');


        // GLOBAL CMS NAVIGATION

        $this->data['cms_navigation'] =
            $this->Cms_model
                ->get_navigation_hierarchy();


        // GLOBAL CATEGORIES

        // $this->data['categories'] =
        //     $this->Category_model
        //         ->emselect();

        $this->data['news_categories'] = $this->Category_model->emselect();

        $this->load->model('Category_page_model');

        $this->data['therapeutic_categories'] =
            $this->Category_page_model->getAllCategories();
        $this->load->model('Footer_links_model');
        $this->data['footer_links'] = $this->Footer_links_model->getFooterLinks();
        // GLOBAL FOOTER MENU

        // $this->data['footer_menu'] =
        //     $this->Footer_cms_model
        //         ->get_footer_menu();

        // Load these into view variables
        $this->load->vars($this->data);
    }
}

/**
 * Frontend Base Controller
 * Use this for all public-facing pages
 */
class Frontend_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Set default page title
        $this->data['page_title'] = 'IKRIS';
    }

    /**
     * Load frontend view with header/footer
     */
    protected function render($view, $data = array())
    {
        $data = array_merge($this->data, $data);

        $this->load->view('layouts/includes/header', $data);
        $this->load->view($view, $data);
        $this->load->view('layouts/includes/footer', $data);
    }
}

/**
 * Admin Base Controller
 * Use this for admin panel pages
 */
class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Check if user is logged in
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
    }
}