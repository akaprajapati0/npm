<?php

Defined('BASEPATH') or exit('No direct script access allowed');

class Named_patient_program_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_npp_query($data)
    {
        return $this->db->insert('contact_messages', $data);
    }
}