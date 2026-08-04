<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Latest extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(["latest_model", "dashboard_model", "employee_model", "login_model", "settings_model"]);
        $this->load->helper(["url", "text"]);
        $this->load->library(["session", "form_validation"]);
    }

    public function index()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url("login"), "refresh");
        }

        $data["latest"] = $this->latest_model->emselect();
        $this->load->view("backend/latest_list", $data);
    }

    public function add()
    {
        if ($this->input->post()) {

            $this->form_validation->set_rules("title", "Title", "trim|required|min_length[3]|max_length[255]");
            $this->form_validation->set_rules("url", "URL", "trim|required|valid_url|max_length[255]");

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata("error", validation_errors());
                redirect("admin_panel/latest", "refresh");
            }

            $data = [
                "title"      => $this->input->post("title"),
                "url"        => $this->input->post("url"),
                "created_at" => date("Y-m-d H:i:s"),
            ];

            $this->latest_model->insert($data);
            $this->session->set_flashdata("success", "Latest record inserted successfully!");
            redirect("admin_panel/latest", "refresh");
        }
    }

    public function edit($id = null)
    {
        if ($id === null) {
            $id = $this->input->post("id");
        }

        $latest = $this->latest_model->getLatestById($id);
        if (!$latest) {
            $this->session->set_flashdata("error", "Record not found!");
            redirect("admin_panel/latest", "refresh");
        }

        if ($this->input->post()) {

            $this->form_validation->set_rules("title", "Title", "trim|required|min_length[3]|max_length[255]");
            $this->form_validation->set_rules("url", "URL", "trim|required|valid_url|max_length[255]");

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata("error", validation_errors());
                redirect("admin_panel/latest/edit/" . $id, "refresh");
            }

            $updateData = [
                "title" => $this->input->post("title"),
                "url"   => $this->input->post("url"),
            ];

            $this->latest_model->update($id, $updateData);
            $this->session->set_flashdata("success", "Latest record updated successfully!");
            redirect("admin_panel/latest", "refresh");
        } else {
            $data["latest"] = $latest;
            $this->load->view("backend/latest_edit", $data);
        }
    }

    public function delete($id)
    {
        $latest = $this->latest_model->getLatestById($id);

        if ($latest) {
            $this->latest_model->delete($id);
            $this->session->set_flashdata("success", "Latest record deleted successfully!");
        } else {
            $this->session->set_flashdata("error", "Record not found!");
        }

        redirect("admin_panel/latest", "refresh");
    }
}
