<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Med_categories_model extends CI_Model
{
    private $table = 'med_categories'; // ✅ your new table

    public function emselect()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function getCategoryById($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
