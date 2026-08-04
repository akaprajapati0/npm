<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MedicineController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Medicine_Model');
        $this->load->model("settings_model");
        $this->load->model('employee_model');
        $this->load->library(['pagination', 'session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form', 'text']);
        $this->load->helper('slug');
    }

    public function index($offset = 0)
    {
        $category = 'all';
        $data['selected_category'] = $category;
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();

        $config['base_url'] = base_url('med_update/');
        $config['total_rows'] = $this->Medicine_Model->countAllNews();
        $config['per_page'] = 15;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);
        $data['medicines'] = $this->Medicine_Model->getNewsPaginated($config['per_page'], $offset);
        $this->load->view('pages/med_update', $data);
    }

    public function category($name = null, $offset = 0)
    {
        $name = urldecode($name);
        $name = str_replace('-', ' ', $name);
        $medicines = $this->Medicine_Model->getNewsBySlug($name);

        if (!empty($name) && $medicines) {
            $data['medicines'] = $medicines;
            $this->load->view('pages/news-details', $data);
            return;
        }

        $data['selected_category'] = $name;
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();
        $category = $this->db->get_where('med_categories', ['name' => $name])->row();

        if (!$category) {
            show_404();
        }

        $config['base_url'] = base_url('med_update/category/' . urlencode($name) . '/');
        $config['total_rows'] = $this->Medicine_Model->countMedicinesByCategory($category->id);
        $config['per_page'] = 15;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = ['class' => 'page-link'];

        $this->pagination->initialize($config);
        $data['medicines'] = $this->Medicine_Model->getMedicinesByCategoryPaginated($category->id, $config['per_page'], $offset);

        $this->load->view('pages/med_update', $data);
    }


    /**
     * ========================================
     * MEDICINE ALL PAGE - A-Z + CATEGORIES
     * ========================================
     */
    public function all()
    {
        // Get alphabet statistics (count per letter)
        $data['alphabet_stats'] = $this->Medicine_Model->getAlphabetStats();

        // Get all medicine categories
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();

        // Initially no letter selected
        $data['selected_letter'] = 'A'; // Default to 'A'

        // Get medicines starting with 'A' by default, grouped by letter
        $data['grouped_medicines'] = $this->Medicine_Model->getMedicinesGroupedByLetter('A');

        // Page title
        $data['title'] = 'Browse All Medicines';

        $this->load->view('Medicine/all', $data);
    }

    /**
     * ========================================
     * ENHANCED SEARCH PAGE
     * Supports: ?letter=A, ?category=5, or both
     * ========================================
     */
    public function search()
    {
        $letter = $this->input->get('letter'); // A-Z
        $category_id = $this->input->get('category'); // Category ID
        $search_term = trim($this->input->get('q')); // Text search

        // If search term provided, do text search
        if (!empty($search_term)) {
            $this->handleTextSearch($search_term);
            return;
        }

        // Handle letter/category filtering
        if (!empty($letter) || !empty($category_id)) {
            $this->handleFilteredSearch($letter, $category_id);
            return;
        }

        // Default: show all medicines grouped alphabetically
        $this->handleDefaultBrowse();
    }

    /**
     * Handle text-based search
     */
    private function handleTextSearch($search_term)
    {
        if (strlen($search_term) < 1) {
            $this->session->set_flashdata('error', 'Please enter at least 1 character to search');
            redirect('/');
            return;
        }

        $config['base_url'] = site_url('medicine/search?q=' . urlencode($search_term));
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['per_page'] = 20;
        $config['total_rows'] = $this->Medicine_Model->countSearchMedicines($search_term);

        $page = (int) $this->input->get('page');
        if ($page < 0)
            $page = 0;

        $this->pagination->initialize($config);

        $data['medicines'] = $this->Medicine_Model->searchMedicines($search_term, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_count'] = $config['total_rows'];
        $data['search_term'] = $search_term;
        $data['title'] = 'Search Results for: ' . htmlspecialchars($search_term);
        $data['filter_type'] = 'text_search';

        $this->load->view('Medicine/search_results', $data);
    }

    /**
     * Handle letter and/or category filtering
     */
    private function handleFilteredSearch($letter, $category_id)
    {
        // Validate letter
        if (!empty($letter)) {
            $letter = strtoupper(substr($letter, 0, 1));
            if (!preg_match('/^[A-Z]$/', $letter)) {
                $letter = null;
            }
        }

        // Validate category
        if (!empty($category_id) && !is_numeric($category_id)) {
            $category_id = null;
        }

        // Get filtered medicines grouped by letter
        $data['grouped_medicines'] = $this->Medicine_Model->getMedicinesGroupedByLetter($letter, $category_id);
        $data['selected_letter'] = $letter;
        $data['selected_category_id'] = $category_id;
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();
        $data['alphabet_stats'] = $this->Medicine_Model->getAlphabetStats($category_id);

        // Count total results
        $total = 0;
        foreach ($data['grouped_medicines'] as $medicines) {
            $total += count($medicines);
        }

        $data['total_count'] = $total;
        $data['filter_type'] = 'filtered';

        // Build title
        $title_parts = [];
        if ($letter)
            $title_parts[] = "Letter '$letter'";
        if ($category_id) {
            $cat = $this->db->get_where('med_categories', ['id' => $category_id])->row();
            if ($cat)
                $title_parts[] = "Category '{$cat->name}'";
        }
        $data['title'] = !empty($title_parts) ? 'Medicines: ' . implode(' + ', $title_parts) : 'All Medicines';

        $this->load->view('Medicine/search_results', $data);
    }

    /**
     * Default browse: all medicines grouped A-Z
     */
    private function handleDefaultBrowse()
    {
        $data['grouped_medicines'] = $this->Medicine_Model->getMedicinesGroupedByLetter();
        $data['selected_letter'] = null;
        $data['selected_category_id'] = null;
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();
        $data['alphabet_stats'] = $this->Medicine_Model->getAlphabetStats();
        $data['title'] = 'Browse All Medicines';
        $data['filter_type'] = 'default';

        // Count total
        $total = 0;
        foreach ($data['grouped_medicines'] as $medicines) {
            $total += count($medicines);
        }
        $data['total_count'] = $total;

        $this->load->view('Medicine/search_results', $data);
    }

    /**
     * ========================================
     * EXISTING METHODS (UNCHANGED)
     * ========================================
     */

    public function liveSearch()
    {
        $term = $this->input->get('term');

        if (empty($term) || strlen($term) < 2) {
            echo json_encode([]);
            return;
        }

        $results = $this->Medicine_Model->searchMedicines($term, 10);

        $autocomplete_data = [];
        foreach ($results as $medicine) {
            $autocomplete_data[] = [
                'id' => $medicine->id,
                'label' => $medicine->name,
                'value' => $medicine->name,
            ];
        }

        echo json_encode($autocomplete_data);
    }

    public function ajaxSearch()
    {
        $search_term = $this->input->post('search_term') ?? $this->input->get('term');

        if (empty($search_term) || strlen($search_term) < 2) {
            echo json_encode([
                'status' => 0,
                'message' => 'Please enter at least 2 characters',
                'results' => []
            ]);
            return;
        }

        $results = $this->Medicine_Model->searchMedicines($search_term, 15);

        if (empty($results)) {
            echo json_encode([
                'status' => 0,
                'message' => 'No medicines found matching your search',
                'results' => []
            ]);
            return;
        }

        $formatted = [];
        foreach ($results as $m) {
            $formatted[] = [
                'id' => $m->id,
                'name' => $m->name,
                'active_ingredient' => $m->active_ingredient ?? 'N/A',
                'strength' => $m->strength ?? 'N/A',
                'storage' => $m->storage ?? 'N/A',
                'company_name' => $m->company_name ?? 'N/A',
                'origin' => $m->origin ?? 'India',
                //'detail_url'        => site_url('medicine/detail/' . $m->id),
                'detail_url' => site_url(
                    'm/' . create_slug($m->category_name) . '/' . create_slug($m->name)
                ),
            ];
        }

        echo json_encode([
            'status' => 1,
            'message' => 'OK',
            'results' => $formatted,
        ]);
    }

    public function detail($category = null, $medicine = null)
    {
        // echo $category;
        // echo "<br>";
        // echo $medicine;
        // die();



        if (!$category || !$medicine) {
            show_404();
        }

        $category = create_slug(urldecode($category));
        $medicine = create_slug(urldecode($medicine));

        $medicineData = $this->Medicine_Model->getMedicineBySlug($category, $medicine);

        if (!$medicineData) {
            show_404();
        }

        $images = $this->Medicine_Model->getMedicineImages($medicineData->id);

        $related = [];
        if (!empty($medicineData->category_id)) {
            $related = $this->Medicine_Model->getRelatedMedicines($medicineData->category_id, $medicineData->id, 4);
        }

        $data = [
            'title' => $medicineData->name,
            'medicine' => $medicineData,
            'images' => $images,
            'related_medicines' => $related
        ];

        $this->load->view('Medicine/detail', $data);
    }

    // ========================================
    // ADMIN PANEL METHODS
    // ========================================

    // public function adminIndex()
    // {
    //     if ($this->session->userdata('user_login_access') != 1) {
    //         redirect(base_url('login'), 'refresh');
    //     }

    //     // Load ALL medicines — pagination is handled client-side by DataTables
    //     $data['medicines'] = $this->Medicine_Model->getAdminPaginated(0, 0);
    //     $data['home_selected_ids'] = $this->Medicine_Model->getHomeSelectedIds();
    //     $data['success'] = $this->session->flashdata('success');
    //     $data['error'] = $this->session->flashdata('error');
    //     $data['med_categories'] = $this->Medicine_Model->getAllCategories();

    //     $this->load->view('backend/patent_medicines_list', $data);
    // }

    // filter to show the medicine
    public function adminIndex()
    {
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url('login'), 'refresh');
        }

        $category_id = $this->input->get('category_id');

        $data['medicines'] = $this->Medicine_Model->getAdminPaginated(0, 0, $category_id);

        $data['home_selected_ids'] = $this->Medicine_Model->getHomeSelectedIds();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();
        $category_id = $this->input->get('category_id');

        $data['selected_category'] = $category_id;

        $data['medicines'] = $this->Medicine_Model->getAdminPaginated(0, 0, $category_id);

        $this->load->view('backend/patent_medicines_list', $data);
    }

    public function save_home_selection()
    {
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url('login'), 'refresh');
        }

        $ids = $this->input->post('home_ids');
        if (!is_array($ids)) {
            $ids = [];
        }

        if (count($ids) > 20) {
            $this->session->set_flashdata('error', 'You can select maximum 20 medicines for homepage.');
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        $this->Medicine_Model->resetHomeSelection();
        if (!empty($ids)) {
            $this->Medicine_Model->setHomeSelection($ids);
        }

        $this->session->set_flashdata('success', 'Homepage medicines updated successfully.');
        redirect('admin_panel/Patent_Medicines');
    }

    public function add()
    {
        if (!$this->input->post()) {
            redirect('admin_panel/Patent_Medicines');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin_panel/Patent_Medicines');
        }

        $data = [
            'name' => $this->input->post('name'),
            'category_id' => $this->input->post('category_id'),
            'price' => $this->input->post('price'),
            'company_name' => $this->input->post('company_name'),
            'active_ingredient' => $this->input->post('active_ingredient'),
            'how_supplied' => $this->input->post('how_supplied'),
            'storage' => $this->input->post('storage'),
            'dosage_form' => $this->input->post('dosage_form'),
            'pack_size' => $this->input->post('pack_size'),
            'origin' => $this->input->post('origin'),
            'strength' => $this->input->post('strength'),
            'routes' => $this->input->post('routes'),
            'regulatory_approval' => $this->input->post('regulatory_approval'),
            'detail' => $this->input->post('detail'),
            'note' => $this->input->post('note'),
            'on_request' => $this->input->post('on_request') ? 1 : 0,
            'source_url' => $this->input->post('source_url'),
            'drug_class' => $this->input->post('drug_class'),
            'medical_uses' => $this->input->post('medical_uses'),
            'warning_precautions' => $this->input->post('warning_precautions'),
            'documentation_availability' => $this->input->post('documentation_availability'),
            'sourcing_delivery' => $this->input->post('sourcing_delivery'),
            'our_process' => $this->input->post('our_process'),
            'treatment_access' => $this->input->post('treatment_access'),
            'written_by' => $this->input->post('written_by'),
            'medically_reviewed_by' => $this->input->post('medically_reviewed_by'),
            'faq' => $this->input->post('faq'),
            'disclaimer' => $this->input->post('disclaimer'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($_FILES['image']['name'])) {
            $newName = time() . '_' . $_FILES['image']['name'];
            $config = [
                'file_name' => $newName,
                'upload_path' => FCPATH . 'assets/images/medicines/',
                'allowed_types' => 'jpg|jpeg|png|gif|webp|avif',
                'max_size' => 20480
            ];

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $up = $this->upload->data();
                $data['image'] = $up['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('admin_panel/Patent_Medicines');
            }
        }

        $insert_id = $this->Medicine_Model->insertMedicine($data);

        if ($insert_id) {
            $this->session->set_flashdata('success', 'Medicine added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add medicine.');
        }

        redirect('admin_panel/Patent_Medicines');
    }

    public function edit($id = null)
    {
        if (!$id)
            redirect('admin_panel/Patent_Medicines');

        if ($this->input->post()) {
            $updateData = [
                'name' => $this->input->post('name'),
                'category_id' => $this->input->post('category_id'),
                'price' => $this->input->post('price'),
                'company_name' => $this->input->post('company_name'),
                'active_ingredient' => $this->input->post('active_ingredient'),
                'how_supplied' => $this->input->post('how_supplied'),
                'storage' => $this->input->post('storage'),
                'dosage_form' => $this->input->post('dosage_form'),
                'pack_size' => $this->input->post('pack_size'),
                'origin' => $this->input->post('origin'),
                'strength' => $this->input->post('strength'),
                'routes' => $this->input->post('routes'),
                'regulatory_approval' => $this->input->post('regulatory_approval'),
                'detail' => $this->input->post('detail'),
                'note' => $this->input->post('note'),
                'on_request' => $this->input->post('on_request') ? 1 : 0,
                'source_url' => $this->input->post('source_url'),
                'drug_class' => $this->input->post('drug_class'),
                'medical_uses' => $this->input->post('medical_uses'),
                'warning_precautions' => $this->input->post('warning_precautions'),
                'documentation_availability' => $this->input->post('documentation_availability'),
                'sourcing_delivery' => $this->input->post('sourcing_delivery'),
                'our_process' => $this->input->post('our_process'),
                'faq' => $this->input->post('faq'),
                'treatment_access' => $this->input->post('treatment_access'),
                'written_by' => $this->input->post('written_by'),
                'medically_reviewed_by' => $this->input->post('medically_reviewed_by'),
                'disclaimer' => $this->input->post('disclaimer'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($_FILES['image']['name'])) {
                $newName = time() . '_' . $_FILES['image']['name'];
                $config = [
                    'upload_path' => FCPATH . 'assets/images/medicines/',
                    'file_name' => $newName,
                    'allowed_types' => 'jpg|jpeg|png|gif|webp|avif',
                    'max_size' => 20480
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $uploaded = $this->upload->data();
                    $old = $this->Medicine_Model->getById($id);

                    if (!empty($old->image) && file_exists(FCPATH . 'assets/images/medicines/' . $old->image)) {
                        unlink(FCPATH . 'assets/images/medicines/' . $old->image);
                    }

                    $updateData['image'] = $uploaded['file_name'];
                }
            }

            $this->Medicine_Model->updateMedicine($id, $updateData);
            $this->session->set_flashdata('success', 'Medicine updated successfully.');
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        $data['medicine'] = $this->Medicine_Model->getById($id);
        $data['med_categories'] = $this->Medicine_Model->getAllCategories();
        $this->load->view('backend/medicine_edit', $data);
    }

    public function delete($id = null)
    {
        if (!$id)
            redirect('admin_panel/Patent_Medicines');

        $row = $this->Medicine_Model->getById($id);

        if ($row && !empty($row->image) && file_exists(FCPATH . 'assets/images/medicines/' . $row->image)) {
            @unlink(FCPATH . 'assets/images/medicines/' . $row->image);
        }

        $this->Medicine_Model->deleteMedicine($id);
        $this->session->set_flashdata('success', 'Medicine deleted.');
        redirect('admin_panel/Patent_Medicines');
    }

    // Bulk Delete medicine
    public function bulk_delete()
    {
        if ($this->session->userdata('user_login_access') != 1) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            return;
        }

        $ids = $this->input->post('ids');

        if (!is_array($ids) || empty($ids)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please select at least one medicine.'
            ]);
            return;
        }

        // Delete medicine images
        foreach ($ids as $id) {

            $medicine = $this->Medicine_Model->getById($id);

            if ($medicine && !empty($medicine->image)) {

                $file = FCPATH . 'assets/images/medicines/' . $medicine->image;

                if (file_exists($file)) {
                    @unlink($file);
                }
            }
        }

        $this->Medicine_Model->bulkDelete($ids);

        echo json_encode([
            'status' => 'success',
            'message' => 'Selected medicines deleted successfully.'
        ]);
    }
    /**
     * Download CSV Template
     */
    public function download_template()
    {
        $filename = 'medicine_import_template.csv';
        $filepath = FCPATH . 'assets/templates/' . $filename;

        // If file doesn't exist, generate it dynamically
        if (!file_exists($filepath)) {
            $this->generate_template_file($filepath);
        }

        // Force download with correct headers
        if (file_exists($filepath)) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Pragma: public');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            readfile($filepath);
            exit;
        } else {
            show_error('Template file not found. Please contact administrator.');
        }
    }

    /**
     * Download Excel Template
     */
    public function download_excel_template()
    {
        $csv_file = FCPATH . 'assets/templates/medicine_import_template.csv';

        // Generate CSV if not exists
        if (!file_exists($csv_file)) {
            $this->generate_template_file($csv_file);
        }

        // Convert to Excel and download
        $excel_file = $this->convert_csv_to_excel($csv_file);

        if ($excel_file && file_exists($excel_file)) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="medicine_import_template.xlsx"');
            header('Content-Length: ' . filesize($excel_file));
            header('Pragma: public');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            readfile($excel_file);
            @unlink($excel_file); // Delete temp file
            exit;
        } else {
            // Fallback to CSV
            $this->download_template();
        }
    }

    /**
     * Generate template file dynamically
     */
    private function generate_template_file($filepath)
    {
        $dir = dirname($filepath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Get categories for reference
        $med_categories = $this->Medicine_Model->getAllCategories();
        $category_id = !empty($med_categories) ? $med_categories[0]->id : 1;

        $csv_content = "name,category_id,strength,price,company_name,active_ingredient,storage,dosage_form,pack_size,origin,detail,note,on_request,source_url,medical_uses,warning_precautions,documentation_availability,sourcing_delivery,our_process,faq,disclaimer\n";
        $csv_content .= "\"Aspirin Tablets\",{$category_id},\"500mg\",12.50,\"PharmaCo\",\"Acetylsalicylic Acid\",\"Store at room temperature\",\"Tablet\",\"100 tablets\",\"India\",\"Pain reliever and fever reducer\",\"Take with food\",0,\"https://example.com\",\"Used for pain and fever\",\"Do not exceed recommended dose\",\"Requires prescription\",\"2-3 business days\",\"Q: How to take? A: With water\",\"For informational purposes only\"\n";
        $csv_content .= "\"Amoxicillin Capsules\",{$category_id},\"250mg\",25.00,\"HealthMed\",\"Amoxicillin Trihydrate\",\"Store in cool dry place\",\"Capsule\",\"30 capsules\",\"USA\",\"Antibiotic for bacterial infections\",\"Complete full course\",0,\"\",\"Treats bacterial infections\",\"Consult doctor if allergic to penicillin\",\"Available on request\",\"5-7 business days\",\"\",\"Prescription required\"\n";
        $csv_content .= "\"Paracetamol Syrup\",{$category_id},\"120mg/5ml\",8.75,\"MediCare\",\"Paracetamol\",\"Store below 25Â°C\",\"Syrup\",\"60ml bottle\",\"India\",\"Fever and pain relief for children\",\"Shake well before use\",0,\"\",\"Pediatric pain relief\",\"Do not use with other paracetamol products\",\"In stock\",\"Next day delivery\",\"Q: Age limit? A: 2 years and above\",\"Keep out of reach of children\"\n";

        file_put_contents($filepath, $csv_content);
        return true;
    }

    /**
     * Import medicines from Excel/CSV file - ENHANCED VERSION
     */
    public function import_excel()
    {
        if ($this->session->userdata('user_login_access') != 1) {
            redirect(base_url('login'), 'refresh');
        }

        if (empty($_FILES['excel_file']['name'])) {
            $this->session->set_flashdata('error', 'Please select a file to import.');
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
            $upload_errors = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds PHP upload_max_filesize',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'Upload stopped by extension',
            ];

            $error_message = $upload_errors[$_FILES['excel_file']['error']] ?? 'Unknown upload error';
            $this->session->set_flashdata('error', 'Upload error: ' . $error_message);
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        $upload_path = FCPATH . 'uploads/temp/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        if (!is_writable($upload_path)) {
            $this->session->set_flashdata('error', 'Upload directory is not writable. Please check permissions.');
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = 10240; // 10MB
        $config['file_name'] = 'medicine_import_' . time();

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excel_file')) {
            $error = $this->upload->display_errors('', '');
            log_message('error', 'Upload failed: ' . $error);
            $this->session->set_flashdata('error', 'Upload failed: ' . $error);
            redirect('admin_panel/Patent_Medicines');
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];
        $file_ext = strtolower($upload_data['file_ext']);

        log_message('info', '=== File Upload Success ===');
        log_message('info', 'File: ' . $file_path);
        log_message('info', 'Extension: ' . $file_ext);

        try {
            // Convert Excel to CSV if needed
            if ($file_ext === '.xlsx' || $file_ext === '.xls') {
                log_message('info', 'Converting Excel to CSV...');
                $csv_path = $this->convert_excel_to_csv_simple($file_path, $file_ext);

                if (!$csv_path) {
                    throw new Exception('Failed to convert Excel to CSV. Please try uploading a CSV file instead, or check server logs for details.');
                }

                @unlink($file_path);
                $file_path = $csv_path;
                log_message('info', 'Conversion successful: ' . $csv_path);
            }

            // Process CSV file
            $result = $this->Medicine_Model->importMedicinesFromCSV($file_path);

            // Delete the uploaded file
            @unlink($file_path);

            // Prepare response message
            if ($result['success'] > 0) {
                $message = "âœ“ Successfully imported {$result['success']} medicine(s).";

                if ($result['failed'] > 0) {
                    $message .= " {$result['failed']} failed.";
                }

                if (!empty($result['errors']) && count($result['errors']) <= 10) {
                    $message .= " Errors: " . implode('; ', $result['errors']);
                } elseif (!empty($result['errors']) && count($result['errors']) > 10) {
                    $error_sample = array_slice($result['errors'], 0, 5);
                    $message .= " Sample errors: " . implode('; ', $error_sample);
                    $message .= " (+" . (count($result['errors']) - 5) . " more)";
                }

                $this->session->set_flashdata('success', $message);
            } else {
                $error_msg = 'Import failed. No medicines were imported.';

                if (!empty($result['errors'])) {
                    if (count($result['errors']) <= 5) {
                        $error_msg .= ' Errors: ' . implode('; ', $result['errors']);
                    } else {
                        $error_sample = array_slice($result['errors'], 0, 3);
                        $error_msg .= ' Sample errors: ' . implode('; ', $error_sample);
                        $error_msg .= ' (and ' . (count($result['errors']) - 3) . ' more)';
                    }
                }

                $this->session->set_flashdata('error', $error_msg);
            }
        } catch (Exception $e) {
            @unlink($file_path);

            log_message('error', 'Import exception: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Import error: ' . $e->getMessage());
        }

        redirect('admin_panel/Patent_Medicines');
    }

    /**
     * Simple Excel to CSV converter using PHP built-in functions
     * Works without external libraries for basic Excel files
     */
    private function convert_excel_to_csv_simple($file_path, $file_ext)
    {
        $csv_path = str_replace([$file_ext], '.csv', $file_path);

        // Try multiple methods in order of preference

        // Method 1: Try XMLReader for .xlsx (built-in, no libraries needed)
        if ($file_ext === '.xlsx') {
            try {
                if ($this->convert_xlsx_to_csv_xmlreader($file_path, $csv_path)) {
                    return $csv_path;
                }
            } catch (Exception $e) {
                log_message('error', 'XMLReader conversion failed: ' . $e->getMessage());
            }
        }

        // Method 2: Try PhpSpreadsheet if available
        $phpspreadsheet = APPPATH . 'third_party/PhpSpreadsheet/autoload.php';
        if (file_exists($phpspreadsheet)) {
            try {
                require_once $phpspreadsheet;
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
                $writer->setDelimiter(',');
                $writer->setEnclosure('"');
                $writer->setLineEnding("\n");
                $writer->setSheetIndex(0);
                $writer->save($csv_path);

                log_message('info', 'Converted using PhpSpreadsheet');
                return $csv_path;
            } catch (Exception $e) {
                log_message('error', 'PhpSpreadsheet failed: ' . $e->getMessage());
            }
        }

        // Method 3: Try PHPExcel if available
        $phpexcel = APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        if (file_exists($phpexcel)) {
            try {
                require_once $phpexcel;
                $objPHPExcel = PHPExcel_IOFactory::load($file_path);
                $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
                $objWriter->setDelimiter(',');
                $objWriter->setEnclosure('"');
                $objWriter->setLineEnding("\n");
                $objWriter->setSheetIndex(0);
                $objWriter->save($csv_path);

                log_message('info', 'Converted using PHPExcel');
                return $csv_path;
            } catch (Exception $e) {
                log_message('error', 'PHPExcel failed: ' . $e->getMessage());
            }
        }

        log_message('error', 'All Excel conversion methods failed');
        return false;
    }

    /**
     * Convert XLSX to CSV using PHP's XMLReader (no external libraries)
     * This works for simple .xlsx files
     */
    private function convert_xlsx_to_csv_xmlreader($xlsx_path, $csv_path)
    {
        $zip = new ZipArchive();
        if ($zip->open($xlsx_path) !== true) {
            return false;
        }

        // Extract sheet data
        $xml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $strings_xml = $zip->getFromName('xl/sharedStrings.xml');
        $zip->close();

        if (!$xml) {
            return false;
        }

        // Parse shared strings
        $shared_strings = [];
        if ($strings_xml) {
            $strings = simplexml_load_string($strings_xml);
            foreach ($strings->si as $si) {
                $shared_strings[] = (string) $si->t;
            }
        }

        // Parse sheet data
        $sheet = simplexml_load_string($xml);
        $csv_handle = fopen($csv_path, 'w');

        $current_row = [];
        $last_row_num = 0;

        foreach ($sheet->sheetData->row as $row) {
            $row_num = (int) $row['r'];

            // Write previous row if we're on a new row
            if ($row_num != $last_row_num && !empty($current_row)) {
                fputcsv($csv_handle, $current_row);
                $current_row = [];
            }

            $last_row_num = $row_num;
            $col_index = 0;

            foreach ($row->c as $cell) {
                $value = '';

                // Handle cell type
                $type = (string) $cell['t'];
                if ($type == 's') {
                    // Shared string
                    $index = (int) $cell->v;
                    $value = isset($shared_strings[$index]) ? $shared_strings[$index] : '';
                } else {
                    // Regular value
                    $value = (string) $cell->v;
                }

                $current_row[$col_index] = $value;
                $col_index++;
            }
        }

        // Write last row
        if (!empty($current_row)) {
            fputcsv($csv_handle, $current_row);
        }

        fclose($csv_handle);
        return true;
    }

    /**
     * Convert CSV to Excel (for template download)
     */
    private function convert_csv_to_excel($csv_file)
    {
        $excel_file = str_replace('.csv', '.xlsx', $csv_file);

        // Try PhpSpreadsheet
        $phpspreadsheet = APPPATH . 'third_party/PhpSpreadsheet/autoload.php';
        if (file_exists($phpspreadsheet)) {
            try {
                require_once $phpspreadsheet;
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                $spreadsheet = $reader->load($csv_file);
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($excel_file);
                return $excel_file;
            } catch (Exception $e) {
                log_message('error', 'CSV to Excel conversion failed: ' . $e->getMessage());
            }
        }

        return false;
    }


    /**
     * Convert using PHPSpreadsheet (modern library)
     */
    private function convert_with_phpspreadsheet($file_path)
    {
        require_once APPPATH . 'third_party/PhpSpreadsheet/autoload.php';

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $csv_path = str_replace(['.xlsx', '.xls'], '.csv', $file_path);

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setDelimiter(',');
            $writer->setEnclosure('"');
            $writer->setLineEnding("\r\n");
            $writer->setSheetIndex(0);
            $writer->save($csv_path);

            log_message('info', 'Excel converted to CSV using PhpSpreadsheet: ' . $csv_path);
            return $csv_path;
        } catch (Exception $e) {
            log_message('error', 'PhpSpreadsheet conversion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Convert using PHPExcel (legacy library)
     */
    private function convert_with_phpexcel($file_path)
    {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($file_path);
            $csv_path = str_replace(['.xlsx', '.xls'], '.csv', $file_path);

            $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
            $objWriter->setDelimiter(',');
            $objWriter->setEnclosure('"');
            $objWriter->setLineEnding("\r\n");
            $objWriter->setSheetIndex(0);
            $objWriter->save($csv_path);

            log_message('info', 'Excel converted to CSV using PHPExcel: ' . $csv_path);
            return $csv_path;
        } catch (Exception $e) {
            log_message('error', 'PHPExcel conversion failed: ' . $e->getMessage());
            return false;
        }
    }
}