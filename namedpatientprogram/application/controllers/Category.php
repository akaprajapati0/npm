<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Category extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("dashboard_model");
        $this->load->model("employee_model");
        $this->load->model("category_model");
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

        $data["categories"] = $this->category_model->emselect();
        $this->load->view("backend/category_list", $data);
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
            // $this->form_validation->set_rules(
            //     "description",
            //     "Description",
            //     "trim|required|min_length[10]|max_length[255]|xss_clean"
            // );
            $this->form_validation->set_rules("status", "Status", "required");

            if ($this->form_validation->run() == false) {
                echo validation_errors();
                return;
            }

            $data = [
                "name" => $this->input->post("name"),
                "status" => $this->input->post("status"),
                // "description" => $this->input->post("description"),
                "createdAt" => date("Y-m-d H:i:s"),
            ];

            // if ($_FILES["image"]["name"]) {
            //     $file_name = $_FILES["image"]["name"];
            //     $new_file_name = time() . "_" . $file_name;

            //     $config = [
            //         "file_name" => $new_file_name,
            //         "upload_path" => "assets/images/category/",
            //         "allowed_types" => "jpg|jpeg|png|gif|webp|avif",
            //         "overwrite" => false,
            //         "max_size" => "20480",
            //     ];

            //     $this->load->library("upload", $config);
            //     $this->upload->initialize($config);

            //     if (!$this->upload->do_upload("image")) {
            //         echo "<pre>Upload Error: " .
            //             $this->upload->display_errors() .
            //             "</pre>";
            //         return;
            //     } else {
            //         $upload_data = $this->upload->data();
            //         $data["image"] = $upload_data["file_name"];
            //     }
            // }

            $this->category_model->insert($data);
            // echo "Records Inserted Successfully";
            $this->session->set_flashdata(
                "success",
                "Records Inserted Successfully"

            );
            redirect("Category", "refresh");
        }
    }

    public function edit($id = null)
    {
        try {
            // Get ID from POST if not passed in URL
            if ($id === null) {
                $id = $this->input->post("id");
            }

            if (!$id) {
                show_404();
            }

            $data["category"] = $this->category_model->getCategoryById($id);

            // If form is submitted
            if ($this->input->post()) {
                $updateData = [
                    "name"        => $this->input->post("name"),
                    "status"      => $this->input->post("status"),
                    // "description" => $this->input->post("description"),
                ];

                // Handle image upload (optional)
                // if (!empty($_FILES["image"]["name"])) {
                //     $file_name     = $_FILES["image"]["name"];
                //     $new_file_name = time() . "_" . $file_name;

                //     $config = [
                //         "file_name"     => $new_file_name,
                //         "upload_path"   => "assets/images/category/",
                //         "allowed_types" => "jpg|jpeg|png|gif|webp|avif",
                //         "overwrite"     => false,
                //         "max_size"      => "20480",
                //     ];

                //     $this->load->library("upload", $config);
                //     $this->upload->initialize($config);

                //     if ($this->upload->do_upload("image")) {
                //         $upload_data = $this->upload->data();
                //         $updateData["image"] = $upload_data["file_name"];
                //     } else {
                //         $this->session->set_flashdata("error", $this->upload->display_errors());
                //         redirect("admin_panel/category/edit/" . $id);
                //     }
                // }

                // Update record
                $this->category_model->update($id, $updateData);

                $this->session->set_flashdata("success", "Category updated successfully!");
                redirect("admin_panel/category", "refresh");
            } else {
                // If form is not submitted, show edit view
                $this->load->view("backend/category_edit", $data);
            }
        } catch (Exception $e) {
            log_message("error", "Category Edit Error: " . $e->getMessage());
            $this->session->set_flashdata("error", "An error occurred while updating the category.");
            redirect("admin_panel/category", "refresh");
        }
    }



    // public function delete($id)
    // {
    //     // Step 1: Get category details including image filename
    //     $category = $this->category_model->getCategoryById($id);

    //     // Step 2: Delete image file from folder if exists
    //     if (!empty($category['image'])) {
    //         $image_path = FCPATH . 'assets/images/category/' . $category['image'];
    //         if (file_exists($image_path)) {
    //             unlink($image_path);
    //         }
    //     }

    //     // Step 3: Delete category record from database
    //     $this->category_model->delete($id);

    //     // Step 4: Flash success message and redirect
    //     $this->session->set_flashdata("success", "Category deleted successfully!");
    //     redirect("category");
    // }
    public function delete($id)
    {
        // Step 1: Get category details including image filename
        $category = $this->category_model->getCategoryById($id);

        // Step 2: Delete image file from folder if exists
        if (!empty($category['image'])) {
            $image_path = FCPATH . 'assets/images/category/' . $category['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Step 3: Delete category record from database
        $this->category_model->delete($id);

        // Step 4: Flash success message and redirect
        $this->session->set_flashdata("success", "Category deleted successfully!");
        redirect("admin_panel/category", "refresh");   // ✅ Corrected redirect
    }
}
