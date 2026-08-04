<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer_links_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->helper(['url', 'form', 'text']);
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->model('/Footer_links_model');
        // Check admin access
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
    }
    public function index()
    {
        // Here fetch all
        $data['pages'] = $this->Footer_links_model->getAll();
        $this->load->view('backend/footer_links', $data);
    }

    // public function add()
    // {
    //     $data = [
    //         'category' => $this->input->post('category_name'),
    //         'title' => $this->input->post('title'),
    //         'slug' => $this->input->post('slug'),
    //         'status' => $this->input->post('status'),
    //         'sort_order' => $this->input->post('sort_order')
    //     ];

    //     $this->Footer_links_model->save($data);
    //     $this->session->set_flashdata('success', 'Footer Links added successfully');
    //     // redirect('footer_links');
    // }
    public function save()
    {
        $id = $this->input->post('id');

        $data = [
            'category' => $this->input->post('category_name'),
            'title' => $this->input->post('title'),
            'slug' => $this->input->post('slug'),
            'status' => $this->input->post('status'),
            'sort_order' => $this->input->post('sort_order')
        ];

        $this->Footer_links_model->save($data, $id);

        if ($id) {
            $this->session->set_flashdata('success', 'Updated successfully.');
        } else {
            $this->session->set_flashdata('success', 'Added successfully.');
        }

        redirect('admin_panel/footer_links');
    }
    public function edit($id)
    {
        $page = $this->Footer_links_model->getSingleRecord($id);

        echo json_encode($page);
    }

    public function update()
    {
        $id = $this->input->post('id');

        $data = [
            'category' => $this->input->post('category_name'),
            'title' => $this->input->post('title'),
            'slug' => $this->input->post('slug'),
            'status' => $this->input->post('status'),
            'sort_order' => $this->input->post('sort_order')
        ];

        if ($this->Footer_links_model->save($data, $id)) {
            $this->session->set_flashdata('success', 'Footer link updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update footer link.');
        }

        redirect('admin_panel/footer_links');
    }
    public function delete($id = null)
    {
        if (!$id) {
            show_404();
        }

        if ($this->Footer_links_model->delete($id)) {

            $this->session->set_flashdata(
                'success',
                'Footer link deleted successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to delete footer link.'
            );

        }

        redirect('admin_panel/footer_links');
    }



}