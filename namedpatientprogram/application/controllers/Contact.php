<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Contact extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("news_model");
        $this->load->model("employee_model");
        $this->load->model("login_model");
        $this->load->model("settings_model");
        $this->load->helper(["url", "text"]);
        $this->load->library("session");
        $this->load->library("email");
        $this->load->library("upload");
        $this->load->model("Contact_model");
    }

    // public function index()
    // {
    //     if ($this->session->userdata("user_login_access") != 1) {
    //         redirect(base_url() . "login", "refresh");
    //     }

    //     // Get only contacts WITHOUT prescriptions
    //     $data["contacts"] = $this->Contact_model->getContactsOnly();
    //     $this->load->view("backend/contact_list", $data);
    // }
    public function index()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        $query_type = $this->input->get('query_type');

        $data['selected_type'] = $query_type;
        $data['contacts'] = $this->Contact_model->getContactsOnly($query_type);

        $this->load->view("backend/contact_list", $data);
    }

    public function view($id = null)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        if (!$id) {
            redirect(base_url("contact"), "refresh");
        }

        $data["contact"] = $this->Contact_model->getContactById($id);

        if (!$data["contact"]) {
            $this->session->set_flashdata("error", "Contact not found.");
            redirect(base_url("contact"), "refresh");
        }

        $this->load->view("backend/contact_view", $data);
    }

    public function delete($id = null)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        if (!$id) {
            redirect(base_url("contact"), "refresh");
        }

        // Get contact to delete prescription file
        $contact = $this->Contact_model->getContactById($id);
        if ($contact && !empty($contact->prescription)) {
            $file_path = FCPATH . 'uploads/prescriptions/' . $contact->prescription;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
        }

        $this->Contact_model->deleteContact($id);
        $this->session->set_flashdata("success", "Contact deleted successfully.");
        redirect(base_url("contact"), "refresh");
    }

    public function bulk_delete()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            echo json_encode(["status" => "error", "message" => "Unauthorized"]);
            return;
        }

        $ids = $this->input->post("ids");

        if (!is_array($ids) || empty($ids)) {
            echo json_encode(["status" => "error", "message" => "No contacts selected"]);
            return;
        }

        // Delete prescription files before deleting records
        foreach ($ids as $id) {
            $contact = $this->Contact_model->getContactById($id);
            if ($contact && !empty($contact->prescription)) {
                $file_path = FCPATH . 'uploads/prescriptions/' . $contact->prescription;
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
        }

        $this->Contact_model->bulkDelete($ids);
        echo json_encode(["status" => "success", "message" => "Contacts deleted successfully"]);
    }

    // ========================================
    // PRESCRIPTION MANAGEMENT METHODS
    // ========================================
    public function prescriptions()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        // Get all contacts with prescriptions
        $data["prescriptions"] = $this->Contact_model->getAllPrescriptions();
        $this->load->view("backend/prescription_list", $data);
    }

    public function view_prescription($id = null)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        if (!$id) {
            redirect(base_url("contact/prescriptions"), "refresh");
        }

        $data["prescription"] = $this->Contact_model->getContactById($id);

        if (!$data["prescription"]) {
            $this->session->set_flashdata("error", "Prescription not found.");
            redirect(base_url("contact/prescriptions"), "refresh");
        }

        if (empty($data["prescription"]->prescription)) {
            $this->session->set_flashdata("error", "No prescription file found for this contact.");
            redirect(base_url("contact/prescriptions"), "refresh");
        }

        $this->load->view("backend/prescription_view", $data);
    }

    public function delete_prescription($id = null)
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        if (!$id) {
            redirect(base_url("contact/prescriptions"), "refresh");
        }

        $contact = $this->Contact_model->getContactById($id);

        if ($contact) {
            // Delete the prescription file if it exists
            if (!empty($contact->prescription)) {
                $file_path = FCPATH . 'uploads/prescriptions/' . $contact->prescription;
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }

            // Delete the entire record
            $this->Contact_model->deleteContact($id);
            $this->session->set_flashdata("success", "Prescription deleted successfully.");
        } else {
            $this->session->set_flashdata("error", "Prescription not found.");
        }

        redirect(base_url("contact/prescriptions"), "refresh");
    }

    public function submit()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[A-Za-z\s]{2,40}$/]|trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');
        $this->form_validation->set_rules('pphone', 'Phone', 'required|regex_match[/^\+[0-9]{1,4}[ ]?[0-9]{6,12}$/]|trim|xss_clean');
        $this->form_validation->set_rules('message', 'Message', 'required|max_length[250]|trim|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect(base_url('home'));
            return;
        }

        $data = [
            'name' => strip_tags($this->input->post('name', true)),
            'email' => strip_tags($this->input->post('email', true)),
            'phone' => strip_tags($this->input->post('pphone', true)),
            'message' => strip_tags($this->input->post('message', true)),
            'query_type' => "pq",
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle prescription upload
        if (!empty($_FILES['prescription']['name'])) {
            $upload_path = FCPATH . 'uploads/prescriptions/';

            // Create directory if it doesn't exist
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $file_ext = strtolower(pathinfo($_FILES['prescription']['name'], PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];

            if (!in_array($file_ext, $allowed_types)) {
                $this->session->set_flashdata('error', 'Only JPG, PNG, and PDF files are allowed for prescription upload.');
                // redirect(base_url('home'));
                return;
            }

            $new_filename = 'prescription_' . time() . '_' . uniqid() . '.' . $file_ext;

            $config = [
                'upload_path' => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|pdf',
                'file_name' => $new_filename,
                'max_size' => 5120, // 5MB
                'encrypt_name' => false
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('prescription')) {
                $upload_data = $this->upload->data();
                $data['prescription'] = $upload_data['file_name'];
                $data['prescription_type'] = ($file_ext === 'pdf') ? 'pdf' : 'image';
            } else {
                $error = $this->upload->display_errors('', '');
                log_message('error', 'Prescription upload failed: ' . $error);
                $this->session->set_flashdata('error', 'Prescription upload failed: ' . $error);
                redirect(base_url('home'));
                return;
            }
        }

        // Insert into database
        if ($this->Contact_model->insert_query($data)) {
            // Email config
            $this->session->set_flashdata('success', 'Your enquiry has been submitted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to submit your enquiry. Please try again.');
        }

        redirect(base_url('thanku'));
    }
}