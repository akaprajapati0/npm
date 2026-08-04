<?php

defined('BASEPATH') OR exit('No direct script allow');

class Footer_links_model extends CI_Model
{
    private $table = 'footer_links';
    public function __construct()
    {
        parent::__construct();
    }

    // public function insert($data)
    // {
    //     return $this->db->insert('footer_links', $data);
    // }
    public function save($data, $id = null)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('footer_links', $data);
        } else {
            return $this->db->insert('footer_links', $data);
        }
    }

    public function getAll()
    {
        return $this->db
            ->order_by('sort_order', 'ASC')
            ->get('footer_links')
            ->result();
    }

    public function getSingleRecord($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('footer_links')
            ->row();
    }
    public function delete($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete('footer_links');
    }
    public function getFooterLinks()
    {
        $result = $this->db
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->get('footer_links')
            ->result();

        $data = [];

        foreach ($result as $row) {
            $data[$row->category][] = $row;
        }

        return $data;
    }

    public function count_all_footer_links()
    {
        return $this->db->count_all_results($this->table);
    }
}