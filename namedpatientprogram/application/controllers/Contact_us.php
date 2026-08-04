<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Contact_us extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'text']);
        $this->load->library(['form_validation', 'session', 'email']);
        $this->load->model(['settings_model', 'Contact_model']);
    }

    /**
     * Display Contact Us page with dynamic settings data
     */
    public function index()
    {
        // Get settings data from database
        $data['settings'] = $this->settings_model->GetSettingsValue();

        // Load view with settings data
        $this->load->view('pages/contact_us', $data);
    }

    /**
     * Handle contact form submission
     */

    // Contact Us Query Form
    public function submit()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules(
            'full_phone',
            'Phone Number',
            'trim|required|regex_match[/^\+[1-9]\d{7,14}$/]'
        );
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[500]|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('contact-us');
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('full_phone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "cq",
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Save to database
        $this->Contact_model->insert_query($data);

        // Get settings for email
        $settings = $this->settings_model->GetSettingsValue();


        $this->session->set_flashdata('success', 'Your message has been sent successfully. We will contact you soon!');
        redirect('contact-us');
    }

    // Home Page Query Form
    public function inquire()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/]|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[500]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('/') . '#inquiry-section');
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('first_name', true)),
            'l_name' => strip_tags($this->input->post('l_name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('phone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "hcq",
            'created_at' => date('Y-m-d H:i:s'),

        ];

        // Save to database
        $this->Contact_model->insert_query($data);

        $this->session->set_flashdata('success', 'Your message has been sent successfully. We will contact you soon!');
        redirect(base_url('/') . '#inquiry-section');
    }


    // Medicine Details Page Query
    public function medicine_details_query()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/]|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[500]|trim');

        $return_url = $this->input->post('return_url');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());

            redirect($return_url . '#medicine-details-section');
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('first_name', true)),
            'l_name' => strip_tags($this->input->post('l_name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('phone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "mdq",
            'created_at' => date('Y-m-d H:i:s'),

        ];

        // Save to database
        $this->Contact_model->insert_query($data);

        $this->session->set_flashdata('success', 'Your message has been sent successfully. We will contact you soon!');
        redirect($return_url . '#medicine-details-section');
    }

    // News and Blog Page Query From
    public function news_details_query()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/]|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[500]|trim');

        $return_url = $this->input->post('return_url');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());

            redirect($return_url . '#inquiry-section');
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('first_name', true)),
            'l_name' => strip_tags($this->input->post('l_name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('phone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "ndq",
            'created_at' => date('Y-m-d H:i:s'),

        ];

        // Save to database
        $this->Contact_model->insert_query($data);

        $this->session->set_flashdata('success', 'Your message has been sent successfully. We will contact you soon!');
        redirect($return_url . '#inquiry-section');
    }

}