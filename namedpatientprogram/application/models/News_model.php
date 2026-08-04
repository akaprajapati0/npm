<?php
defined("BASEPATH") or exit("No direct script access allowed");

class News_model extends CI_Model
{
    // Fetch all news records ordered by descending id
    public function getAllNews()
    {
        $this->db->select("news.*, category.name as category_name"); // Select all fields from 'news' and 'name' from 'categories'
        $this->db->from("news");
        $this->db->join("category", "category.id = news.category_id", "left"); // Join with 'categories' table on 'category_id'
        $query = $this->db->get();
        return $query->result(); // Return all news records with category name
    }


    public function getAllNewsByCatergory($category)
    {
        $this->db->select("news.*, category.name as category_name"); // Select all fields from 'news' and 'name' from 'categories'
        $this->db->from("news");
        $this->db->join("category", "category.id = news.category_id", "left"); // Join with 'categories' table on 'category_id'
        $this->db->where("category.name", $category); // Correct way to add WHERE clause
        $query = $this->db->get();
        return $query->result(); // Return all news records with category name
    }
    // Generate a unique slug based on title
    public function generateUniqueSlug($title)
    {
        // Convert the title into a slug
        $slug = strtolower(
            trim(preg_replace("/[^A-Za-z0-9-]+/", "-", $title), "-")
        );

        // Ensure the slug is unique by appending a number if it already exists
        $original_slug = $slug;
        $i = 1;
        while (
            $this->db->get_where("news", ["slug" => $slug])->num_rows() > 0
        ) {
            $slug = $original_slug . "-" . $i;
            $i++;
        }

        return $slug;
    }

    // Fetch all categories
    public function getAllCategories()
    {
        return $this->db->get("category")->result();
    }

    // Insert a new news record into the database
    public function insertNews($data)
    {
        $this->db->insert("news", $data);
    }

    // Update an existing news record by ID
    public function updateNews($id, $data)
    {
        return $this->db->where("id", $id)->update("news", $data);
    }

    // Delete a news record by ID
    // public function deleteNews($id)
    // {
    //     return $this->db->where("id", $id)->delete("news");
    // }

    public function delete_news($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('news');
    }

    // Fetch a specific news record by ID
    // public function getNewsById($id)
    // {
    //     return $this->db
    //         ->where("id", $id)
    //         ->get("news")
    //         ->row();
    // }
    public function getNewsById($id)
    {
        return $this->db->get_where('news', ['id' => $id])->row_array();
    }



    public function get_article($category, $slug)
    {
        $this->db->where('category', $category);
        $this->db->where('slug', $slug);
        $query = $this->db->get('news');
        return $query->row_array();
    }

    public function countAllNews()
    {
        return $this->db->count_all('news');
    }

    public function getNewsPaginated($limit, $offset)
    {
        $this->db->select("news.*, category.name as category_name");
        $this->db->from("news");
        $this->db->join("category", "category.id = news.category_id", "left");
        $this->db->order_by("news.id", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function countNewsByCategory($category)
    {
        $this->db->from('news');
        $this->db->join('category', 'category.id = news.category_id', 'left');
        $this->db->where('category.name', $category);
        return $this->db->count_all_results();
    }

    public function getNewsByCategoryPaginated($category, $limit, $offset)
    {
        $this->db->select("news.*, category.name as category_name");
        $this->db->from("news");
        $this->db->join("category", "category.id = news.category_id", "left");
        $this->db->where("category.name", $category);
        $this->db->order_by("news.id", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    //latest
    public function get_latest_news($limit = 5)
    {
        $this->db->select('id, slug, name, createdAt, category_name');
        $this->db->from('news');
        $this->db->order_by('createdAt', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }



    public function getNewsBySlug($slug)
    {
        $this->db->select("news.*, news.createdAt as created_at, news.name as title, category.name as category");
        $this->db->from("news");
        $this->db->join("category", "category.id = news.category_id", "left");
        $this->db->where("news.slug", $slug);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Clear all home selections
    public function clearHomeNews()
    {
        $this->db->set('show_on_home', 0);
        $this->db->update('news');
    }

    // Set selected IDs as home news
    public function setHomeNews($ids = [])
    {
        if (empty($ids))
            return;

        $this->db->where_in('id', $ids);
        $this->db->set('show_on_home', 1);
        $this->db->update('news');
    }

    // Get home news for homepage (max 3)
    public function getHomeNews($limit = 3)
    {
        $this->db->select('id, slug, name, description, image');
        $this->db->from('news');
        $this->db->where('show_on_home', 1);
        $this->db->order_by('createdAt', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

}