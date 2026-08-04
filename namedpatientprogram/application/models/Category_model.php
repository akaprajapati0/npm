<?php
class Category_model extends CI_Model
{
    public function emselect()
    {
        return $this->db->get("category")->result(); // category table
    }

    public function insert($data)
    {
        return $this->db->insert("category", $data);
    }
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('category', $data);
    }

    public function getCategoryById($id)
    {
        return $this->db->get_where('category', ['id' => $id])->row_array();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('category');
    }


    // public function delete($id)
    // {
    //     return $this->db->where("id", $id)->delete("category");
    // }
}
