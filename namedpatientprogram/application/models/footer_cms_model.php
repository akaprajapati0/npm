<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Footer_cms_model extends CI_Model
{
    private $table = 'footer_pages';

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    // =======================
    // Categories
    // =======================

    public function get_categories()
    {
        return $this->db
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('category_name', 'ASC')
            ->get('footer_categories')
            ->result();
    }

    public function get_category($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('footer_categories')
            ->row();
    }

    // ==========================
    // Pages
    // ==========================

    public function get_all_pages()
    {
        return $this->db

            ->select('footer_pages.*, footer_categories.category_name')

            ->from('footer_pages')

            ->join(
                'footer_categories',
                'footer_categories.id = footer_pages.category_id'
            )

            ->where('footer_pages.status', 'active')

            ->order_by('footer_categories.sort_order', 'ASC')

            ->order_by('footer_pages.sort_order', 'ASC')

            ->get()

            ->result();
    }

    public function get_page_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    public function get_pages_by_slug($slug)
    {
        return $this->db
            ->where('slug', $slug)
            ->where('status', 'active')
            ->get($this->table)
            ->row();
    }

    public function insert_page($data)
    {
        return $this->db
            ->insert($this->table, $data);
    }

    public function update_page($id, $data)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    public function delete_page($id)
    {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    public function slug_exists($slug, $exclude_id = null)
    {
        $this->db
            ->where('slug', $slug);

        if ($exclude_id) {

            $this->db
                ->where('id !=', $exclude_id);
        }

        return $this->db
            ->get($this->table)
            ->num_rows() > 0;
    }

    // ==========================
    // Frontend Footer
    // ==========================

    public function get_footer_menu()
    {
        $categories = $this->get_categories();

        $menu = [];

        foreach ($categories as $category) {

            $pages = $this->db

                ->where('category_id', $category->id)

                ->where('footer_pages.status', 'active')

                ->order_by('sort_order', 'ASC')

                ->order_by('page_name', 'ASC')

                ->get($this->table)

                ->result();

            $menu[] = [

                'category' => $category,

                'pages' => $pages
            ];
        }

        return $menu;
    }
}