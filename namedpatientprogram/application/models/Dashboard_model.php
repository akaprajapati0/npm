<?php

class Dashboard_model extends CI_Model
{
    function __consturct()
    {
        parent::__construct();
    }
    public function getEnquiryCount()
    {
        return $this->db->count_all("query"); // yahan 'contact' table ka naam hai, aapke table ka actual naam dalen
    }

    public function getNewsCount()
    {
        return $this->db->count_all("news"); // 'news' table ka actual naam dalen agar kuch aur hai
    }

    public function getCategoryCount()
    {
        return $this->db->count_all("category"); // Table ka naam confirm kar lena
    }
    public function getLatestCount()
    {
        return $this->db->count_all("latest");
    }


    public function getMedCategoryCount()
    {
        // change table name if yours is different
        return $this->db->count_all('med_categories');
    }

    public function getPatentMedicineCount()
    {
        // Patent medicines table (you mentioned `medicians` in routes)
        return $this->db->count_all('medicians');
    }
}
