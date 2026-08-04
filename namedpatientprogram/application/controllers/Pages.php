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
class Pages extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Cms_model');
        $this->load->model('settings_model');
        $this->load->helper(['url', 'text']);
        $this->load->model("news_model");
    }

    /**
     * CMS Page View - Display dynamic CMS pages by slug
     */
    public function cms_page($slug = '')
    {
        if (empty($slug)) {
            show_404();
            return;
        }

        // Get the page
        $page = $this->Cms_model->get_page_by_slug($slug);

        if (!$page || $page->node_type !== 'page') {
            show_404();
            return;
        }

        // Get navigation for header
        $data['cms_navigation'] = $this->Cms_model->get_navigation_hierarchy();

        // Get breadcrumb
        $data['breadcrumb'] = $this->Cms_model->get_breadcrumb($page->id);

        // Get child pages (if any)
        $data['child_pages'] = $this->Cms_model->get_children('page', $page->id);

        $data['page'] = $page;


        $this->load->library('pagination');

        //     $category = $this->db
        //     ->where('name', $slug)
        //     ->get('med_categories')
        //     ->row();


        // if ($category) {
        //     $data['medicines'] = $this->db
        //     ->select('medicians.*, med_categories.name as category_name')
        //     ->from('medicians')
        //     ->join('med_categories', 'med_categories.id = medicians.category_id', 'left')
        //     ->where('medicians.category_id', $category->id)
        //     ->get()
        //     ->result();

        // } else {
        //     $data['medicines'] = [];
        // }

        $category = $this->db
            ->where('name', $slug)
            ->get('med_categories')
            ->row();

        if (!$category) {
            $data['medicines'] = [];
            $data['pagination'] = '';
        } else {

            // Pagination config
            $config['base_url'] = base_url($slug);
            $config['total_rows'] = $this->db
                ->where('category_id', $category->id)
                ->count_all_results('medicians');

            $config['per_page'] = 8;
            $config['uri_segment'] = 2;

            // Pagination style
            $config['full_tag_open'] = '<div class="flex justify-center mt-12"><ul class="flex gap-2">';
            $config['full_tag_close'] = '</ul></div>';

            $config['num_tag_open'] = '<li class="px-4 py-2 border rounded hover:bg-gray-100">';
            $config['num_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="px-4 py-2 bg-blue-600 text-white rounded">';
            $config['cur_tag_close'] = '</li>';

            $config['prev_tag_open'] = '<li class="px-4 py-2 border rounded">';
            $config['prev_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="px-4 py-2 border rounded">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '←';
            $config['next_link'] = '→';
            $config['first_link'] = false;
            $config['last_link'] = false;

            $this->pagination->initialize($config);

            // Get offset
            $offset = $this->uri->segment(2) ? $this->uri->segment(2) : 0;

            // Get medicines
            $data['medicines'] = $this->db
                ->select('medicians.*, med_categories.name as category_name')
                ->from('medicians')
                ->join('med_categories', 'med_categories.id = medicians.category_id', 'left')
                ->where('medicians.category_id', $category->id)
                ->limit($config['per_page'], $offset)
                ->get()
                ->result();

            $data['pagination'] = $this->pagination->create_links();
        }
        $this->load->view('layouts/includes/head-links', $data);
        $this->load->view('layouts/includes/header', $data);
        $this->load->view('pages/cms_page', $data);
        $this->load->view('layouts/includes/footer', $data);
    }


    // Named Patient Program


    // All your other existing methods below
    public function thanku()
    {
        $this->load->view('thanku');
    }

    //==========================================
    // Legal & Document
    //==========================================
    public function temp_and_logistics()
    {
        $this->load->view('pages/temp-and-logistics');
    }
    public function why_prescription()
    {
        $this->load->view('pages/why-prescription');
    }
    public function medicine_safety()
    {
        $this->load->view('pages/medicine-safety');
    }


    public function about_us()
    {
        // $data["page"] = "About Us";
        $this->load->view("pages/about-us");
    }

    public function contact_us()
    {
        $data["page"] = "Contact Us";
        $this->load->view("pages/contact-us", $data);
    }

    public function privacy()
    {
        $data["page"] = "Privacy Policy";
        $this->load->view("pages/privacy", $data);
    }
    public function indian_import_regulations()
    {
        $this->load->view('pages/indian-import-regulations');
    }
    public function terms_and_conditions()
    {
        $data["page"] = "Terms and Conditions";
        $this->load->view("pages/terms-and-conditions", $data);
    }
    public function disclaimer()
    {
        $data["page"] = "Disclaimer";
        $this->load->view("pages/disclaimer", $data);
    }

    public function career()
    {
        $data["page"] = "Career";
        $this->load->view("pages/career", $data);
    }

    public function adverse_event_reporting()
    {
        $data["page"] = "Adverse Event Reporting";
        $this->load->view("pages/adverse-event-reporting", $data);
    }

    public function resources()
    {
        $data["page"] = "Resources";
        $this->load->view("pages/resources", $data);
    }

    public function partners()
    {
        $data["page"] = "Partners";
        $this->load->view("pages/partners", $data);
    }

    public function service_named_patient_management()
    {
        $data["page"] = "Service Named Patient Management";
        $this->load->view("pages/service-named-patient-management", $data);
    }

    public function service_clinical_trial_sourcing()
    {
        $data["page"] = "Service Clinical Trial Sourcing";
        $this->load->view("pages/service-clinical-trial-sourcing", $data);
    }

    public function service_named_patient_medicines()
    {
        $data["page"] = "Service Named Patient Medicines";
        $this->load->view("pages/service-named-patient-medicines", $data);
    }

    public function service_indian_generic_medicines()
    {
        $data["page"] = "Service Indian Generic Medicines";
        $this->load->view("pages/service-indian-generic-medicines", $data);
    }

    public function service_real_world_data()
    {
        $data["page"] = "Service Real World Data";
        $this->load->view("pages/service-real-world-data", $data);
    }

    public function our_product_triokris()
    {
        $data["page"] = "Our Product Triokris";
        $this->load->view("pages/our-product-triokris", $data);
    }

    public function newsletter()
    {
        $data["page"] = "Newsletter";
        $this->load->view("pages/newsletter", $data);
    }

    public function news_and_updates()
    {
        $data["page"] = "News and Updates";
        $this->load->view("pages/news-and-updates", $data);
    }

    public function newsdata()
    {
        $data["page"] = "News Data";
        $this->load->view("pages/news-data", $data);
    }

    public function ikris_health_plus()
    {
        $data["page"] = "Ikris Health Plus";
        $this->load->view("pages/ikris-health-plus", $data);
    }

    public function index()
    {
        $data["page"] = "Home";
        $this->load->view("home/ikrishome", $data);
    }

    public function news_details()
    {
        $data["page"] = "News Details";
        $this->load->view("pages/news-details", $data);
    }

    public function home()
    {
        $data["page"] = "home";
        $this->load->view("pages/home", $data);
    }
    public function tracking()
    {
        $data["page"] = "Tracking";
        $this->load->view("pages/tracking", $data);
    }

    public function faqs()
    {
        $data["page"] = "FAQs";
        $this->load->view('pages/faqs', $data);
    }
    ///Know More about npp
    public function know_more_npp()
    {
        $this->load->view('pages/for-know-more-about-npp');
    }

    public function accept()
    {
        $this->load->helper('cookie');

        set_cookie([
            'name' => 'cookie_consent',
            'value' => 'accepted',
            'expire' => 3600 * 24 * 365, // 1 year
            'secure' => false,
            'httponly' => true
        ]);
    }
}