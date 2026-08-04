<?php

class Settings_model extends CI_Model
{
    function __construct()  // FIX SPELLING
    {
        parent::__construct();
    }

    public function GetSettingsValue()
    {
        return $this->db->get('settings')->row();
    }

    public function SettingsUpdate($id, $data)
    {
        return $this->db->where('id', $id)->update('settings', $data);
    }

}

