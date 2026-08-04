<?php
class Latest_model extends CI_Model
{
    public function emselect()
    {
        return $this->db->order_by("id", "DESC")->get("latest")->result();
    }

    public function insert($data)
    {
        return $this->db->insert("latest", $data);
    }

    public function update($id, $data)
    {
        return $this->db->where("id", $id)->update("latest", $data);
    }

    public function getLatestById($id)
    {
        return $this->db->get_where("latest", ["id" => $id])->row_array();
    }

    public function delete($id)
    {
        return $this->db->where("id", $id)->delete("latest");
    }
    public function get_latest($limit = 5)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('latest')->result();
    }
}
