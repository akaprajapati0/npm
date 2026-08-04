<?php

defined("BASEPATH") or exit("No direct script access allowed");

class Category_page_model extends CI_Model
{


    // public function getAllCategories()
    // {
    //     return $this->db
    //         ->order_by('name', 'ASC')
    //         ->get('med_categories')
    //         ->result();
    // }
    public function getAllCategories()
    {
        return $this->db
            ->order_by("(CASE WHEN name = 'Other Therapeutic Areas' THEN 1 ELSE 0 END)", "", false)
            ->order_by('name', 'ASC')
            ->get('med_categories')
            ->result();
    }
    public function getAllMedicines()
    {
        return $this->db
            ->select('m.*, c.name as category_name')
            ->from('medicians m')
            ->join('med_categories c', 'c.id = m.category_id', 'left')
            ->order_by('m.name', 'ASC')
            ->get()
            ->result();
    }
    public function getMedicinesByCategory($category_id, $limit = 12, $offset = 0)
    {
        return $this->db
            ->select('m.*, c.name as category_name')
            ->from('medicians m')
            ->join('med_categories c', 'c.id = m.category_id', 'left')
            ->where('m.category_id', $category_id)
            ->order_by('m.name', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }
    public function countMedicinesByCategory($category_id)
    {
        return $this->db
            ->where('category_id', $category_id)
            ->count_all_results('medicians');
    }
    public function getCategory($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('med_categories')
            ->row();
    }
    public function getCategoryBySlug($slug)
    {
        return $this->db
            ->where('slug', $slug)
            ->get('med_categories')
            ->row();
    }
}