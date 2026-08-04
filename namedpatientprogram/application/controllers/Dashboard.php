<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Dashboard extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Dhaka");
        $this->load->database();
        $this->load->model("login_model");
        $this->load->model("dashboard_model");
        $this->load->model("employee_model");
        $this->load->model("settings_model");
        $this->load->model('Cms_model');
        $this->load->model('Footer_links_model');
    }

    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata("user_login_access") == 1) {
            redirect("dashboard/Dashboard");
        }
        $data = [];
        #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
        $this->load->view("login");
    }
    function Dashboard()
    {
        if ($this->session->userdata("user_login_access") != false) {
            date_default_timezone_set("Asia/Kolkata");
            date_default_timezone_get();

            $data["curr_date_time"] = date(
                "d-m-Y H:i:s",
                strtotime("-2 minutes")
            );
            $data["enquiry_count"] = $this->dashboard_model->getEnquiryCount(); // <- add this line
            $data["news_count"] = $this->dashboard_model->getNewsCount();
            $data["category_count"] = $this->dashboard_model->getCategoryCount();
            $data["latest_count"] = $this->dashboard_model->getLatestCount();

            $data["med_category_count"] = $this->dashboard_model->getMedCategoryCount();
            $data["patent_medicine_count"] = $this->dashboard_model->getPatentMedicineCount();

            $data['footer_links_count'] = $this->Footer_links_model->count_all_footer_links();



            $this->load->view("backend/dashboard", $data);
        } else {
            redirect(base_url(), "refresh");
        }
    }
}