<?php

class Employee_model extends CI_Model
{
    function __consturct()
    {
        parent::__construct();
    }

    public function GetBasic($id)
    {
        $sql = "SELECT *
      FROM `employee`
      WHERE `em_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
}
?>
