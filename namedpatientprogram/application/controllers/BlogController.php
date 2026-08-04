<?php
defined("BASEPATH") or exit("No direct script access allowed");

class BlogController extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->model('News_model');
    // }

    public function blogs()
    {
        $this->load->view('pages/blog/blogs');
    }
}