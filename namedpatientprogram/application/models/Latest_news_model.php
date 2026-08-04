<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Latest_news_model extends CI_Model
{
    // ========== COMMON GETTERS =============

    public function getAllCategories()
    {
        return $this->db->get("category")->result_array();
    }

    public function getCategoryName($id)
    {
        $this->db->select('name');
        $this->db->where('id', $id);
        $row = $this->db->get('category')->row();
        return $row ? $row->name : "";
    }

    // ========== NEWS CRUD =============

    public function insertNews($data)
    {
        return $this->db->insert("latest_news", $data);
    }

    public function updateNews($id, $data)
    {
        return $this->db->where("id", $id)->update("latest_news", $data);
    }

    public function delete_news($id)
    {
        $row = $this->getNewsById($id);

        if (!empty($row['image'])) {
            $path = FCPATH . 'assets/images/latest_news/' . $row['image'];
            if (file_exists($path)) unlink($path);
        }

        return $this->db->delete("latest_news", ["id" => $id]);
    }

    public function getAllNews()
    {
        return $this->db
            ->order_by("id", "DESC")
            ->get("latest_news")
            ->result_array();
    }

    public function getNewsPaginated($limit, $offset)
    {
        return $this->db
            ->order_by("id", "DESC")
            ->limit($limit, $offset)
            ->get("latest_news")
            ->result_array();
    }

    public function getNewsById($id)
    {
        return $this->db->get_where("latest_news", ["id" => $id])->row_array();
    }

    public function getNewsBySlug($slug)
    {
        return $this->db->get_where("latest_news", ["slug" => $slug])->row_array();
    }

    // ========== CATEGORY FILTER =============

    public function countAllNews()
    {
        return $this->db->count_all("latest_news");
    }

    public function countNewsByCategory($category)
    {
        return $this->db->where("category_name", $category)
            ->count_all_results("latest_news");
    }

    public function getNewsByCategoryPaginated($category, $limit, $offset)
    {
        return $this->db
            ->where("category_name", $category)
            ->order_by("id", "DESC")
            ->limit($limit, $offset)
            ->get("latest_news")
            ->result_array();
    }

    // ========== SLUG GENERATOR =============

    public function generateUniqueSlug($title)
    {
        $slug = strtolower(trim(preg_replace("/[^A-Za-z0-9-]+/", "-", $title)));
        $original_slug = $slug;
        $i = 1;

        while ($this->db->where("slug", $slug)->get("latest_news")->num_rows() > 0) {
            $slug = $original_slug . "-" . $i;
            $i++;
        }

        return $slug;
    }
}
