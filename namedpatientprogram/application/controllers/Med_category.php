<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Med_category extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("dashboard_model");
        $this->load->model("employee_model");
        $this->load->model("med_categories_model");
        $this->load->model("login_model");
        $this->load->model("settings_model");
        $this->load->helper("url");
        $this->load->helper("text");
        $this->load->library("session");
    }

    public function index()
    {
        if ($this->session->userdata("user_login_access") != 1) {
            redirect(base_url() . "login", "refresh");
        }

        $data["med_categories"] = $this->med_categories_model->emselect();
        $this->load->view("backend/med_category_list", $data);
    }

    public function add()
    {
        if ($this->input->post()) {
            $this->load->library("form_validation");
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules(
                "name",
                "Name",
                "trim|required|min_length[3]|max_length[100]|xss_clean"
            );
            $this->form_validation->set_rules(
                "slug",
                "Slug",
                "trim|required|min_length[3]|max_length[100]|regex_match[/^[a-z0-9-]+$/]"
            );
            $this->form_validation->set_rules(
                "description",
                "Description",
                "trim|required|min_length[10]|max_length[255]|xss_clean"
            );
            $this->form_validation->set_rules("status", "Status", "required");

            if ($this->form_validation->run() == false) {
                echo validation_errors();
                return;
            }

            $data = [
                "name" => $this->input->post("name"),
                "slug" => strtolower($this->input->post("slug")),
                "status" => $this->input->post("status"),
                "description" => $this->input->post("description"),
                "createdAt" => date("Y-m-d H:i:s"),
            ];

            // ✅ You can keep same image folder or create another, I keep same as category
            if ($_FILES["image"]["name"]) {
                $file_name = $_FILES["image"]["name"];
                $new_file_name = time() . "_" . $file_name;

                $config = [
                    "file_name" => $new_file_name,
                    "upload_path" => "assets/images/category/",
                    "allowed_types" => "jpg|jpeg|png|gif|webp|avif",
                    "overwrite" => false,
                    "max_size" => "20480",
                ];

                $this->load->library("upload", $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("image")) {
                    echo "<pre>Upload Error: " . $this->upload->display_errors() . "</pre>";
                    return;
                } else {
                    $upload_data = $this->upload->data();
                    $data["image"] = $upload_data["file_name"];
                }
            }

            $this->med_categories_model->insert($data);

            $this->session->set_flashdata("success", "Med Category inserted successfully");
            redirect("admin_panel/med_category", "refresh");
        }
    }

    public function edit($id = null)
    {
        try {
            if ($id === null) {
                $id = $this->input->post("id");
            }

            if (!$id) {
                show_404();
            }

            $data["med_category"] = $this->med_categories_model->getCategoryById($id);

            if ($this->input->post()) {


                $updateData = [
                    "name" => $this->input->post("name"),
                    "slug" => strtolower($this->input->post("slug")),
                    "status" => $this->input->post("status"),
                    "description" => $this->input->post("description"),
                ];

                if (!empty($_FILES["image"]["name"])) {
                    $file_name = $_FILES["image"]["name"];
                    $new_file_name = time() . "_" . $file_name;

                    $config = [
                        "file_name" => $new_file_name,
                        "upload_path" => "assets/images/category/",
                        "allowed_types" => "jpg|jpeg|png|gif|webp|avif",
                        "overwrite" => false,
                        "max_size" => "20480",
                    ];

                    $this->load->library("upload", $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload("image")) {
                        $upload_data = $this->upload->data();
                        $updateData["image"] = $upload_data["file_name"];
                    } else {
                        $this->session->set_flashdata("error", $this->upload->display_errors());
                        redirect("admin_panel/med_category/edit/" . $id);
                    }
                }

                $this->med_categories_model->update($id, $updateData);

                $this->session->set_flashdata("success", "Med Category updated successfully!");
                redirect("admin_panel/med_category", "refresh");
            } else {
                $this->load->view("backend/med_category_edit", $data);
            }
        } catch (Exception $e) {
            log_message("error", "Med Category Edit Error: " . $e->getMessage());
            $this->session->set_flashdata("error", "An error occurred while updating the Med Category.");
            redirect("admin_panel/med_category", "refresh");
        }
    }

    public function delete($id)
    {
        $category = $this->med_categories_model->getCategoryById($id);

        if (!empty($category['image'])) {
            $image_path = FCPATH . 'assets/images/category/' . $category['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $this->med_categories_model->delete($id);

        $this->session->set_flashdata("success", "Med Category deleted successfully!");
        redirect("admin_panel/med_category", "refresh");
    }
}