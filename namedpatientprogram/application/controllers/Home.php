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

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("text");
        $this->load->database();
        $this->load->model("Med_categories_model");
        $this->load->model("Medicine_Model");
        $this->load->model("News_model");
        $this->load->model("Category_model");

        $this->load->model("Settings_model");
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->model('Cms_model');
        $data['cms_navigation'] = $this->Cms_model->get_navigation_hierarchy();
    }

    // public function index()
    // {

    //     // Fetch latest 3 news (any category)
    //     $this->db->order_by('createdAt', 'DESC');
    //     $this->db->limit(3);
    //     $data['latest_news'] = $this->db->get('news')->result_array();

    //     $data["page"] = "Ikris Home";
    //     $this->load->view("home/ikrishome", $data);
    // }


    public function index()
    {
        // latest news (your existing code)

        $this->load->model('Cms_model');
        $data['cms_navigation'] = $this->Cms_model->get_navigation_hierarchy();

        $this->db->order_by('createdAt', 'DESC');
        $this->db->limit(3);
        $data['latest_news'] = $this->db->get('news')->result_array();


        // $this->load->model('Patent_Medicines_model');
        // $data['patent_medicines'] = $this->Patent_Medicines_model->getAll();




        // 2) Patent medicines slider (from medicians table)
        $data['patent_medicines'] = $this->Medicine_Model->getHomePatentMedicines(12);

        // 👇 ALSO USE SAME CASE HERE
        $data['med_categories'] = $this->Med_categories_model->emselect();

        // 4) NEW: homepage news (News, Articles and Resources)
        $this->load->model('News_model');
        $data['home_news'] = $this->News_model->getHomeNews(3);

        $data["page"] = "Ikris Home";
        $this->load->view("home/ikrishome", $data);
    }

    public function pm()
    {
        $this->load->model('Cms_model');
        $data['cms_navigation'] = $this->Cms_model->get_navigation_hierarchy();
        // Load Model
        // $this->load->model('Patent_Medicines_model');

        // Fetch Data
        // $data['patent_medicines'] = $this->Patent_Medicines_model->getAll();
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->emselect();
        $this->load->model('Medicine_Model');
        $data['patent_medicines'] = $this->Medicine_Model->getHomePatentMedicines(12);


        // Load Views
        $this->load->view('home_header', $data);
        $this->load->view('pages/home', $data);
        $this->load->view('home_footer', $data);
    }
}
