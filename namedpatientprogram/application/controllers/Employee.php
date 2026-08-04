<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Employee extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("dashboard_model");
        $this->load->model("employee_model");
        $this->load->model("login_model");
        $this->load->model("settings_model");
        $this->load->helper("url");
    }

    public function index()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }
        if ($this->session->userdata("user_login_access") == 1) {
            $data = [];
        }
        redirect("employee/Employees");
    }
    public function Employees()
    {
        if ($this->session->userdata("user_login_access") != false) {
            $data["employee"] = $this->employee_model->emselect();
            $this->load->view("backend/employees", $data);
        } else {
            redirect(base_url(), "refresh");
        }
    }
}
