<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Cms_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->helper(['url', 'form', 'text']);
        $this->load->library(['session', 'form_validation', 'upload']);

        // Check admin access
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url() . 'login', 'refresh');
        }
    }

    public function index()
    {
        $data['cms_pages'] = $this->Cms_model->get_all_pages();
        $data['parent_options'] = $this->Cms_model->get_parent_options();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');

        $this->load->view('backend/cms_admin', $data);
    }

    public function add()
    {
        // CRITICAL: Only process POST requests
        if (!$this->input->post()) {
            redirect('admin_panel/cms');
            return;
        }

        log_message('info', '=== CMS ADD STARTED ===');
        log_message('info', 'POST Data: ' . print_r($this->input->post(), true));
        log_message('info', 'FILES Data: ' . print_r($_FILES, true));

        $node_type = $this->input->post('node_type');

        // Basic validation rules
        $this->form_validation->set_rules('page_name', 'Page Name', 'required|trim|min_length[3]|max_length[255]');
         $this->form_validation->set_rules('slug', 'Slug', 'required|trim|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        $this->form_validation->set_rules('node_type', 'Node Type', 'required|in_list[category,page]');

        // Slug is ONLY required for pages
        $slug = null;
        if ($node_type === 'page') {
            $slug = $this->input->post('slug');
            if (empty($slug)) {
                // Auto-generate from page_name
                $slug = $this->generate_slug($this->input->post('page_name'));
            }

            // Check uniqueness
            if ($this->Cms_model->slug_exists($slug)) {
                $this->session->set_flashdata('error', 'Slug already exists. Please use a different name or slug.');
                redirect('admin_panel/cms');
                return;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            log_message('error', 'Validation failed: ' . validation_errors());
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin_panel/cms');
            return;
        }

        // Validate parent-child relationship
        $parent_selection = $this->input->post('parent_selection');
        $parent_id = null;
        $parent_type = null;

        if ($parent_selection && $parent_selection !== 'none') {
            list($parent_type, $parent_id) = explode('_', $parent_selection);
            $parent_id = (int)$parent_id;

            // Validate hierarchy (max 4 levels)
            $validation = $this->Cms_model->validate_hierarchy($parent_id, $node_type);
            if (!$validation['valid']) {
                $this->session->set_flashdata('error', $validation['message']);
                redirect('admin_panel/cms');
                return;
            }
        }

        // Prepare base data
        $data = [
            'page_name' => $this->input->post('page_name'),
            'node_type' => $node_type,
            'category' => $this->input->post('category') ?: 'Therapeutics Area',
            'status' => $this->input->post('status'),
            'sort_order' => (int)$this->input->post('sort_order') ?: 0,
            'parent_id' => $parent_id,
            'parent_type' => $parent_type,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle content fields based on node type
        if ($node_type === 'page') {
            $data['slug'] = $slug;
            $data['hero_title'] = $this->input->post('hero_title');
            $data['hero_description'] = $this->input->post('hero_description');
            $data['content_description'] = $this->input->post('content_description');
            $data['cta_text'] = $this->input->post('cta_text');
            $data['cta_url'] = $this->input->post('cta_url');

            // Handle image upload
            if (!empty($_FILES['hero_image']['name'])) {
                $upload_result = $this->handle_image_upload('hero_image');
                if ($upload_result['success']) {
                    $data['hero_image'] = $upload_result['filename'];
                    log_message('info', 'Image uploaded successfully: ' . $upload_result['filename']);
                } else {
                    log_message('error', 'Image upload failed: ' . $upload_result['error']);
                    $this->session->set_flashdata('error', $upload_result['error']);
                    redirect('admin_panel/cms');
                    return;
                }
            }
        } else {
            // Category: null out page-specific fields
            $data['slug'] = null;
            $data['hero_title'] = null;
            $data['hero_description'] = null;
            $data['hero_image'] = null;
            $data['content_description'] = null;
            $data['cta_text'] = null;
            $data['cta_url'] = null;
        }

        log_message('info', 'Final data to insert: ' . print_r($data, true));

        // Insert into database
        $insert_id = $this->Cms_model->insertPage($data);

        if ($insert_id) {
            log_message('info', 'Item inserted successfully with ID: ' . $insert_id);
            $type_label = $node_type === 'category' ? 'Category' : 'Page';
            $this->session->set_flashdata('success', $type_label . ' added successfully.');
        } else {
            log_message('error', 'Failed to insert item into database');
            $this->session->set_flashdata('error', 'Failed to add item. Please try again.');
        }

        redirect('admin_panel/cms');
    }

    public function edit($id = null)
    {
        if (!$id) {
            redirect('admin_panel/cms');
            return;
        }

        log_message('info', '=== CMS EDIT STARTED FOR ID: ' . $id . ' ===');

        $page = $this->Cms_model->get_page_by_id($id);
        if (!$page) {
            show_404();
            return;
        }

        // If it's a POST request, process the update
        if ($this->input->post()) {
            log_message('info', 'POST Data: ' . print_r($this->input->post(), true));
            log_message('info', 'FILES Data: ' . print_r($_FILES, true));

            $node_type = $this->input->post('node_type');

            $this->form_validation->set_rules('page_name', 'Page Name', 'required|trim|min_length[3]|max_length[255]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
            $this->form_validation->set_rules('node_type', 'Node Type', 'required|in_list[category,page]');

            // Slug validation for pages
            $slug = null;
            if ($node_type === 'page') {
                $slug = $this->input->post('slug');
                if (empty($slug)) {
                    $slug = $this->generate_slug($this->input->post('page_name'));
                }

                // Check uniqueness (exclude current record)
                if ($this->Cms_model->slug_exists($slug, $id)) {
                    $this->session->set_flashdata('error', 'Slug already exists. Please use a different name or slug.');
                    redirect('admin_panel/cms');
                    return;
                }
            }

            if ($this->form_validation->run() == FALSE) {
                log_message('error', 'Validation failed: ' . validation_errors());
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin_panel/cms');
                return;
            }

            // Validate parent-child relationship
            $parent_selection = $this->input->post('parent_selection');
            $parent_id = null;
            $parent_type = null;

            if ($parent_selection && $parent_selection !== 'none') {
                list($parent_type, $parent_id) = explode('_', $parent_selection);
                $parent_id = (int)$parent_id;

                // Prevent setting parent to itself or its own children
                if ($parent_id == $id) {
                    $this->session->set_flashdata('error', 'Cannot set item as its own parent.');
                    redirect('admin_panel/cms');
                    return;
                }

                // Validate hierarchy
                $validation = $this->Cms_model->validate_hierarchy($parent_id, $node_type, $id);
                if (!$validation['valid']) {
                    $this->session->set_flashdata('error', $validation['message']);
                    redirect('admin_panel/cms');
                    return;
                }
            }

            $updateData = [
                'page_name' => $this->input->post('page_name'),
                'node_type' => $node_type,
                'category' => $this->input->post('category') ?: 'Therapeutics Area',
                'status' => $this->input->post('status'),
                'sort_order' => (int)$this->input->post('sort_order') ?: 0,
                'parent_id' => $parent_id,
                'parent_type' => $parent_type,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Handle content fields
            if ($node_type === 'page') {
                $updateData['slug'] = $slug;
                $updateData['hero_title'] = $this->input->post('hero_title');
                $updateData['hero_description'] = $this->input->post('hero_description');
                $updateData['content_description'] = $this->input->post('content_description');
                $updateData['cta_text'] = $this->input->post('cta_text');
                $updateData['cta_url'] = $this->input->post('cta_url');

                // Handle image upload
                if (!empty($_FILES['hero_image']['name'])) {
                    // Delete old image
                    if (!empty($page->hero_image) && file_exists(FCPATH . 'assets/images/cms/' . $page->hero_image)) {
                        @unlink(FCPATH . 'assets/images/cms/' . $page->hero_image);
                        log_message('info', 'Old image deleted: ' . $page->hero_image);
                    }

                    $upload_result = $this->handle_image_upload('hero_image');
                    if ($upload_result['success']) {
                        $updateData['hero_image'] = $upload_result['filename'];
                        log_message('info', 'New image uploaded: ' . $upload_result['filename']);
                    } else {
                        log_message('error', 'Image upload failed: ' . $upload_result['error']);
                        $this->session->set_flashdata('error', $upload_result['error']);
                        redirect('admin_panel/cms');
                        return;
                    }
                }
            } else {
                // Category: clear page-specific fields
                $updateData['slug'] = null;
                $updateData['hero_title'] = null;
                $updateData['hero_description'] = null;
                $updateData['content_description'] = null;
                $updateData['cta_text'] = null;
                $updateData['cta_url'] = null;

                // Delete image if changing from page to category
                if ($page->node_type === 'page' && !empty($page->hero_image)) {
                    if (file_exists(FCPATH . 'assets/images/cms/' . $page->hero_image)) {
                        @unlink(FCPATH . 'assets/images/cms/' . $page->hero_image);
                        log_message('info', 'Image deleted when converting to category');
                    }
                    $updateData['hero_image'] = null;
                }
            }

            log_message('info', 'Final update data: ' . print_r($updateData, true));

            $this->Cms_model->updatePage($id, $updateData);

            $type_label = $node_type === 'category' ? 'Category' : 'Page';
            $this->session->set_flashdata('success', $type_label . ' updated successfully!');
            redirect('admin_panel/cms');
            return;
        }

        // GET request - just redirect back to main page
        // The edit modal will be opened by JavaScript using data attributes
        redirect('admin_panel/cms');
    }

    public function delete($id = null)
    {
        if (!$id) {
            redirect('admin_panel/cms');
            return;
        }

        $row = $this->Cms_model->get_page_by_id($id);

        // Check if has children
        if ($this->Cms_model->has_children($id)) {
            $this->session->set_flashdata('error', 'Cannot delete: This item has child items. Delete children first.');
            redirect('admin_panel/cms');
            return;
        }

        // Delete image if exists
        if ($row && !empty($row->hero_image) && file_exists(FCPATH . 'assets/images/cms/' . $row->hero_image)) {
            @unlink(FCPATH . 'assets/images/cms/' . $row->hero_image);
        }

        $this->Cms_model->deletePage($id);
        $this->session->set_flashdata('success', 'Item deleted successfully.');
        redirect('admin_panel/cms');
    }

    // ========================================
    // HELPER FUNCTIONS
    // ========================================

    /**
     * Generate unique slug from text
     */
    private function generate_slug($text)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
        $original_slug = $slug;
        $i = 1;

        while ($this->Cms_model->slug_exists($slug)) {
            $slug = $original_slug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    /**
     * ✅ FIXED: Simplified image upload using CodeIgniter's native upload library
     */
    private function handle_image_upload($field_name)
    {
        $upload_path = FCPATH . 'assets/images/cms/';

        // Create directory if doesn't exist
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0755, true)) {
                log_message('error', 'Failed to create upload directory: ' . $upload_path);
                return [
                    'success' => false,
                    'error' => 'Failed to create upload directory. Please contact administrator.'
                ];
            }
            chmod($upload_path, 0755);
            log_message('info', 'Created upload directory: ' . $upload_path);
        }

        // Ensure directory is writable
        if (!is_writable($upload_path)) {
            @chmod($upload_path, 0755);
            if (!is_writable($upload_path)) {
                log_message('error', 'Upload directory not writable: ' . $upload_path);
                return [
                    'success' => false,
                    'error' => 'Upload directory is not writable. Please check permissions.'
                ];
            }
        }

        // Get file extension for unique filename
        $file_extension = '';
        if (isset($_FILES[$field_name]['name']) && !empty($_FILES[$field_name]['name'])) {
            $file_extension = strtolower(pathinfo($_FILES[$field_name]['name'], PATHINFO_EXTENSION));
        } else {
            return [
                'success' => false,
                'error' => 'No file selected for upload.'
            ];
        }

        // Configure upload using CI's library
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|webp|avif',
            'file_name'     => time() . '_' . uniqid() . '.' . $file_extension,
            'overwrite'     => false,
            'max_size'      => 20480, // 20MB
            'max_width'     => 0,
            'max_height'    => 0
        ];

        $this->upload->initialize($config);

        // Attempt upload
        if (!$this->upload->do_upload($field_name)) {
            $error = strip_tags($this->upload->display_errors());
            log_message('error', 'Upload failed: ' . $error);
            return [
                'success' => false,
                'error' => $error
            ];
        }

        // Get upload data
        $upload_data = $this->upload->data();
        log_message('info', 'File uploaded successfully: ' . $upload_data['file_name']);

        return [
            'success' => true,
            'filename' => $upload_data['file_name']
        ];
    }
}