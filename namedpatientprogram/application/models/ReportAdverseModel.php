<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportAdverseModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | Main Report
    |--------------------------------------------------------------------------
    */

    public function insertReport($data)
    {
        $this->db->insert('adverse_reports', $data);

        return $this->db->insert_id();
    }

    // public function getAllReports()
    // {
    //     return $this->db
    //         ->order_by('id', 'DESC')
    //         ->get('adverse_reports')
    //         ->result();
    // }
    public function getAllReports()
    {
        $this->db->select("
        adverse_reports.*,
        GROUP_CONCAT(DISTINCT adverse_report_medicines.medicine_name SEPARATOR ', ') AS suspected_medicine_name
    ");

        $this->db->from('adverse_reports');

        $this->db->join(
            'adverse_report_medicines',
            'adverse_report_medicines.report_id = adverse_reports.id',
            'left'
        );

        $this->db->group_by('adverse_reports.id');

        $this->db->order_by('adverse_reports.id', 'DESC');

        return $this->db->get()->result();
    }

    public function getReportById($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('adverse_reports')
            ->row();
    }

    public function deleteReport($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('adverse_reports');
    }

    /*
    |--------------------------------------------------------------------------
    | Suspected Medicines
    |--------------------------------------------------------------------------
    */

    public function insertMedicine($data)
    {
        return $this->db->insert(
            'adverse_report_medicines',
            $data
        );
    }

    public function getMedicinesByReport($reportId)
    {
        return $this->db
            ->where('report_id', $reportId)
            ->get('adverse_report_medicines')
            ->result();
    }

    /*
    |--------------------------------------------------------------------------
    | Adverse Reactions
    |--------------------------------------------------------------------------
    */

    public function insertReaction($data)
    {
        return $this->db->insert(
            'adverse_report_reactions',
            $data
        );
    }

    public function getReactionsByReport($reportId)
    {
        return $this->db
            ->where('report_id', $reportId)
            ->get('adverse_report_reactions')
            ->result();
    }

    /*
    |--------------------------------------------------------------------------
    | Full Report Details
    |--------------------------------------------------------------------------
    */

    public function getFullReport($reportId)
    {
        $data = [];

        $data['report'] = $this->getReportById($reportId);

        $data['medicines'] = $this->getMedicinesByReport($reportId);

        $data['reactions'] = $this->getReactionsByReport($reportId);

        return $data;
    }
}