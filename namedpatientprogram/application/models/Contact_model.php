<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact_model extends CI_Model
{
    //new
    public function insert_query($data)
    {
        return $this->db->insert('contact_messages', $data);
    }

    public function insert_inquire($data)
    {
        return $this->db->insert('inquire', $data);
    }

    // Get ALL contacts (including those with prescriptions)
    public function getAllContacts()
    {
        return $this->db
            ->order_by("id", "DESC")
            ->get("contact_messages")
            ->result();
    }

    // Get ONLY contacts WITHOUT prescriptions
    // public function getContactsOnly()
    // {
    //     return $this->db
    //         ->where("(prescription IS NULL OR prescription = '')")
    //         ->order_by("id", "DESC")
    //         ->get("contact_messages")
    //         ->result();
    // }
    public function getContactsOnly($query_type = '')
    {
        $this->db->where("(prescription IS NULL OR prescription = '')");

        if (!empty($query_type)) {
            $this->db->where('query_type', $query_type);
        }

        return $this->db
            ->order_by("id", "DESC")
            ->get("contact_messages")
            ->result();
    }

    // Get ONLY prescriptions (contacts WITH prescription files)
    public function getAllPrescriptions()
    {
        return $this->db
            ->where("prescription IS NOT NULL")
            ->where("prescription !=", "")
            ->order_by("id", "DESC")
            ->get("contact_messages")
            ->result();
    }

    public function deleteContact($id)
    {
        return $this->db->where("id", $id)->delete("contact_messages");
    }

    public function getContactById($id)
    {
        return $this->db->get_where('contact_messages', ['id' => $id])->row();
    }

    public function bulkDelete($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('contact_messages');
    }

    public function updateContact($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('contact_messages', $data);
    }

    // public function get_queries($query_type = null)
    // {
    //     if (!empty($query_type)) {
    //         $this->db->where('query_type', $query_type);
    //     }

    //     $this->db->order_by('created_at', 'DESC');
    //     return $this->db->get('contact_messages')->result();
    // }
}