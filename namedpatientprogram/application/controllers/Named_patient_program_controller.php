<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Named_patient_program_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_validation');

        $this->load->model('Cms_model');
        $this->load->model('settings_model');
        $this->load->model('Named_patient_program_model');

        $this->load->helper(['url', 'text']);
    }

    public function named_patient_program()
    {
        $this->load->view('pages/named-patient-program');
    }

    public function npp_query()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/]|trim');
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[500]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('named-patient-program') . '#npp-query-section');
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('first_name', true)),
            'l_name' => strip_tags($this->input->post('l_name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('phone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "npp",
            'created_at' => date('Y-m-d H:i:s'),

        ];

        // Save to database
        $this->Named_patient_program_model->insert_npp_query($data);

        $this->session->set_flashdata('success', 'Your message has been sent successfully. We will contact you soon!');
        redirect(base_url('named-patient-program') . '#npp-query-section');
    }
}