<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdverseController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->model('ReportAdverseModel');

        $this->load->model('Cms_model');
        $this->load->model('settings_model');
        $this->load->model('employee_model');
        $this->load->model('login_model');

        $this->load->helper(['url', 'form', 'text']);
    }

    public function report_adverse()
    {
        $this->load->view('pages/report-adverse');
    }

    public function store()
    {
        $seriousness = $this->input->post('seriousness');

        /*
        |--------------------------------------------------------------------------
        | Main Report Data
        |--------------------------------------------------------------------------
        */

        $mainData = [

            // Patient Details
            'patient_name' => $this->input->post('patient_name', TRUE),
            'date_of_birth' => $this->input->post('date_of_birth', TRUE),
            'age' => $this->input->post('age', TRUE),
            'gender' => $this->input->post('gender', TRUE),
            'weight' => $this->input->post('weight', TRUE),
            'height' => $this->input->post('height', TRUE),
            'additional_info' => $this->input->post('additional_info', TRUE),

            // Reporter Information
            'reporter_name' => $this->input->post('reporter_name', TRUE),
            'reporter_address' => $this->input->post('reporter_address', TRUE),
            'reporter_email' => $this->input->post('reporter_email', TRUE),
            'reporter_qualification' => $this->input->post('reporter_qualification', TRUE),
            'other_qualification' => $this->input->post('other_qualification', TRUE),
            'country' => $this->input->post('country', TRUE),
            'phone_number' => $this->input->post('phone_number', TRUE),
            'report_date' => $this->input->post('report_date', TRUE),

            // Seriousness
            'seriousness' => !empty($seriousness)
                ? implode(',', $seriousness)
                : '',

            'cause_of_death' => $this->input->post('cause_of_death', TRUE),
            'date_of_death' => $this->input->post('date_of_death', TRUE),
            'autopsy' => $this->input->post('autopsy', TRUE),

            // Other Information
            'relevant_information' => $this->input->post('relevant_information', TRUE),
            'medical_history' => $this->input->post('medical_history', TRUE),

            /// Concomitant Medicine
            'concomitant_medicine_name' =>
                $this->input->post('concomitant_medicine_name', TRUE),

            'concomitant_medicine_manufacturer' =>
                $this->input->post('concomitant_medicine_manufacturer', TRUE),

            'concomitant_medicine_batch' =>
                $this->input->post('concomitant_medicine_batch', TRUE),

            'concomitant_medicine_indication' =>
                $this->input->post('concomitant_medicine_indication', TRUE),

            'concomitant_medicine_dose' =>
                $this->input->post('concomitant_medicine_dose', TRUE),

            'concomitant_medicine_route' =>
                $this->input->post('concomitant_medicine_route', TRUE),

            'concomitant_medicine_frequency' =>
                $this->input->post('concomitant_medicine_frequency', TRUE),

            'concomitant_medicine_start_date' =>
                $this->input->post('concomitant_medicine_start_date', TRUE),

            'concomitant_medicine_stop_date' =>
                $this->input->post('concomitant_medicine_stop_date', TRUE),

            'privacy_agreement' => $this->input->post('privacy_agreement') ? 1 : 0
        ];

        $this->db->trans_start();

        /*
        |--------------------------------------------------------------------------
        | Insert Main Report
        |--------------------------------------------------------------------------
        */

        $reportId = $this->ReportAdverseModel->insertReport($mainData);

        /*
        |--------------------------------------------------------------------------
        | Save Medicines
        |--------------------------------------------------------------------------
        */

        $medicineNames = $this->input->post('suspected_medicine_name');

        if (!empty($medicineNames)) {

            foreach ($medicineNames as $key => $medicine) {

                $medicineData = [

                    'report_id' => $reportId,

                    'medicine_name' =>
                        $this->input->post('suspected_medicine_name')[$key],

                    'manufacturer' =>
                        $this->input->post('suspected_medicine_manufacturer')[$key],

                    'batch' =>
                        $this->input->post('suspected_medicine_batch')[$key],

                    'expiry' =>
                        $this->input->post('suspected_medicine_expiry')[$key],

                    'indication' =>
                        $this->input->post('suspected_medicine_indication')[$key],

                    'dose' =>
                        $this->input->post('suspected_medicine_dose')[$key],

                    'route' =>
                        $this->input->post('suspected_medicine_route')[$key],

                    'frequency' =>
                        $this->input->post('suspected_medicine_frequency')[$key],

                    'treatment_start_date' =>
                        $this->input->post('suspected_medicine_treatment_start_date')[$key],

                    'treatment_stop_date' =>
                        $this->input->post('suspected_medicine_treatment_stop_date')[$key],

                    'causality_assessment' =>
                        $this->input->post('causality_assessment')[$key],

                    'dechallenge' =>
                        $this->input->post('dechallenge')[$key],

                    'rechallenge' =>
                        $this->input->post('rechallenge')[$key]
                ];

                $this->ReportAdverseModel->insertMedicine($medicineData);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Save Adverse Reactions
        |--------------------------------------------------------------------------
        */

        $symptoms = $this->input->post('symptoms');

        if (!empty($symptoms)) {

            foreach ($symptoms as $key => $symptom) {

                $reactionData = [

                    'report_id' => $reportId,

                    'symptoms' =>
                        $this->input->post('symptoms')[$key],

                    'treatment_start_date' =>
                        $this->input->post('adverse_treatment_start_date')[$key],

                    'treatment_stop_date' =>
                        $this->input->post('adverse_treatment_stop_date')[$key],

                    'intensity' =>
                        $this->input->post('intensity')[$key],

                    'outcome' =>
                        $this->input->post('outcome')[$key]
                ];

                $this->ReportAdverseModel->insertReaction($reactionData);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->session->set_flashdata(
                'error',
                'Something went wrong.'
            );

        } else {

            $this->session->set_flashdata(
                'success',
                'Form submitted successfully.'
            );
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin List
    |--------------------------------------------------------------------------
    */

    public function records()
    {
        $data['records'] = $this->ReportAdverseModel->getAllReports();

        $this->load->view(
            'backend/adverse_event_list',
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | View Single Report
    |--------------------------------------------------------------------------
    */

    // public function view($id)
    // {
    //     $data['record'] =
    //         $this->ReportAdverseModel->getReportById($id);

    //     if (!$data['record']) {
    //         show_404();
    //     }

    //     $data['medicines'] =
    //         $this->ReportAdverseModel->getMedicinesByReport($id);

    //     $data['reactions'] =
    //         $this->ReportAdverseModel->getReactionsByReport($id);

    //     $this->load->view(
    //         'backend/adverse_particular_record',
    //         $data
    //     );
    // }
    public function view($id)
    {
        $data['record'] =
            $this->ReportAdverseModel->getReportById($id);

        if (!$data['record']) {
            show_404();
        }

        $data['medicines'] =
            $this->ReportAdverseModel->getMedicinesByReport($id);

        $data['reactions'] =
            $this->ReportAdverseModel->getReactionsByReport($id);

        $this->load->view(
            'backend/adverse_particular_record',
            $data
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Delete Report
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        if (!$id) {
            show_404();
        }

        $delete = $this->ReportAdverseModel->deleteReport($id);

        if ($delete) {

            $this->session->set_flashdata(
                'success',
                'Record deleted successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Failed to delete record.'
            );
        }

        redirect('report_adverse/records');
    }
}