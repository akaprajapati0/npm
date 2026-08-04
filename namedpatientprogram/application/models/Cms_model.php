<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cms_model extends CI_Model
{
    private $table = 'cms_pages';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ========================================
    // BASIC CRUD OPERATIONS
    // ========================================

    public function get_all_pages()
    {
        return $this->db
            ->order_by('category', 'ASC')
            ->order_by('sort_order', 'ASC')
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function count_all_pages()
    {
        return $this->db->count_all_results($this->table);
    }

    public function get_page_by_id($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();
    }

    public function get_page_by_slug($slug)
    {
        return $this->db
            ->where('slug', $slug)
            ->where('status', 'active')
            ->where('node_type', 'page')
            ->get($this->table)
            ->row();
    }

    public function slug_exists($slug, $exclude_id = null)
    {
        $this->db->where('slug', $slug);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }

    public function insertPage($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updatePage($id, $data)
    {
        return $this->db
            ->where('id', (int) $id)
            ->update($this->table, $data);
    }

    public function deletePage($id)
    {
        return $this->db
            ->where('id', (int) $id)
            ->delete($this->table);
    }

    public function has_children($node_id)
    {
        return $this->db
            ->where('parent_id', $node_id)
            ->count_all_results($this->table) > 0;
    }

    // ========================================
    // HIERARCHY VALIDATION (4 LEVELS)
    // ========================================

    public function get_node_level($node_id)
    {
        if (!$node_id)
            return 1; // Top level (static categories)

        $node = $this->get_page_by_id($node_id);
        if (!$node)
            return 0;

        if (!$node->parent_id)
            return 2; // Direct child of static category

        $level = 2;
        $current = $node;
        $max_iterations = 10; // Prevent infinite loops
        $iterations = 0;

        while ($current->parent_id && $level < 5 && $iterations < $max_iterations) {
            $parent = $this->get_page_by_id($current->parent_id);
            if (!$parent)
                break;
            $level++;
            $current = $parent;
            $iterations++;
        }

        return $level;
    }

    public function validate_hierarchy($parent_id, $node_type, $exclude_id = null)
    {
        if (!$parent_id) {
            // No parent means level 2 (directly under static category)
            return ['valid' => true];
        }

        $parent_level = $this->get_node_level($parent_id);

        // Maximum level is 4
        if ($parent_level >= 4) {
            return [
                'valid' => false,
                'message' => 'Maximum hierarchy depth (4 levels) reached. Cannot add items below this level.'
            ];
        }

        // Level 4 can only be pages
        if ($parent_level == 3 && $node_type == 'category') {
            return [
                'valid' => false,
                'message' => 'Level 4 can only contain pages, not categories.'
            ];
        }

        return ['valid' => true];
    }

    // ========================================
    // HIERARCHICAL NAVIGATION FOR FRONTEND
    // ========================================

    public function get_navigation_hierarchy()
    {
        // $static_categories = [
        //     ['id' => 'who-we-are', 'name' => 'Who We Are', 'db_name' => 'Who We Are'],
        //     ['id' => 'what-we-do', 'name' => 'What We Do', 'db_name' => 'What We Do'],
        //     ['id' => 'what-we-offer', 'name' => 'What We Offer', 'db_name' => 'What We Offer'],
        //     ['id' => 'patient-safety', 'name' => 'Patient Safety', 'db_name' => 'Patient Safety'],
        //     ['id' => 'support', 'name' => 'Support', 'db_name' => 'Support']
        // ];

        $static_categories = [
            ['id' => 'Quick Links', 'name' => 'Quick Links', 'db_name' => 'Quick Links'],
            ['id' => 'imported-medicines', 'name' => 'Imported Medicines', 'db_name' => 'Imported Medicines'],
            ['id' => 'Best Treatment', 'name' => 'Best Treatment', 'db_name' => 'Best Treatment'],
            ['id' => 'Top Articles', 'name' => 'Top Articles', 'db_name' => 'Top Articles'],
            ['id' => 'FDA Drug Approvals', 'name' => 'FDA Drug Approvals', 'db_name' => 'FDA Drug Approvals'],
            ['id' => 'Latest News', 'name' => 'Latest News', 'db_name' => 'Latest News'],

        ];

        $navigation = [];

        foreach ($static_categories as $cat) {
            $children = $this->get_top_level_items($cat['db_name']);

            $navigation[] = [
                'id' => $cat['id'],
                'name' => $cat['name'],
                'type' => 'static_category',
                'level' => 1,
                'children' => $this->build_navigation_tree($children, 2)
            ];
        }

        return $navigation;
    }

    private function get_top_level_items($category_name)
    {
        return $this->db
            ->select('id, page_name, slug, node_type, sort_order, parent_id')
            ->where('category', $category_name)
            ->group_start()
            ->where('parent_id IS NULL', NULL, FALSE)
            ->or_where('parent_id', '')
            ->or_where('parent_id', 0)
            ->group_end()
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    private function build_navigation_tree($items, $level = 2)
    {
        $tree = [];

        foreach ($items as $item) {
            $node = [
                'id' => $item['id'],
                'name' => $item['page_name'],
                'slug' => $item['slug'],
                'type' => $item['node_type'],
                'level' => $level,
                'children' => []
            ];

            // Get children (up to level 4)
            if ($level < 4) {
                $children = $this->get_children_items($item['id']);
                if (!empty($children)) {
                    $node['children'] = $this->build_navigation_tree($children, $level + 1);
                }
            }

            $tree[] = $node;
        }

        return $tree;
    }

    private function get_children_items($parent_id)
    {
        return $this->db
            ->select('id, page_name, slug, node_type, sort_order')
            ->where('parent_id', $parent_id)
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    // ========================================
    // ADMIN PARENT OPTIONS - UPDATED TO SHOW ONLY CATEGORIES
    // ========================================

    public function get_parent_options($exclude_id = null)
    {
        $options = [];
        // $static_categories = ['Who We Are', 'What We Do', 'What We Offer', 'Patient Safety', 'Support'];
        // $static_categories = ['Therapeutics Area', 'Legal & Documents', 'Resource (Blog Home Page)'];
        $static_categories = [
            'Quick Links',
            'Imported Medicines',
            'Best Treatment',
            'Top Articles',
            'FDA Drug Approvals',
            'Latest News'
        ];

        foreach ($static_categories as $cat_name) {
            // Get only categories at top level
            $top_items = $this->get_top_level_categories($cat_name);

            foreach ($top_items as $item) {
                if ($exclude_id && $item['id'] == $exclude_id) {
                    continue;
                }

                $level = $this->get_node_level($item['id']);

                // Don't show level 4 items as parent options (max depth reached)
                if ($level >= 4) {
                    continue;
                }

                $options[] = [
                    'id' => $item['id'],
                    'type' => 'category',
                    'name' => $item['page_name'],
                    'node_type' => $item['node_type'],
                    'level' => $level,
                    'display' => $item['page_name'] . ' (' . $cat_name . ') [Level ' . $level . ' - Category]'
                ];

                // Recursively add child categories
                $this->build_parent_options($item['id'], $level + 1, $options, $item['page_name'], $exclude_id);
            }
        }

        return $options;
    }

    /**
     * Get only categories (not pages) at top level for a static category
     */
    private function get_top_level_categories($category_name)
    {
        return $this->db
            ->select('id, page_name, slug, node_type, sort_order')
            ->where('category', $category_name)
            ->where('node_type', 'category') // ✅ ONLY CATEGORIES
            ->group_start()
            ->where('parent_id IS NULL', NULL, FALSE)
            ->or_where('parent_id', '')
            ->or_where('parent_id', 0)
            ->group_end()
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    /**
     * Build parent options recursively - ONLY CATEGORIES
     */
    private function build_parent_options($parent_id, $level, &$options, $parent_name = '', $exclude_id = null)
    {
        // Stop at level 4 (max depth)
        if ($level > 4)
            return;

        // Get only child categories (not pages)
        $children = $this->get_children_categories($parent_id);
        $indent = str_repeat('— ', $level - 2);

        foreach ($children as $child) {
            if ($exclude_id && $child['id'] == $exclude_id) {
                continue;
            }

            // Don't show level 4 items as parent options
            if ($level >= 4) {
                continue;
            }

            $options[] = [
                'id' => $child['id'],
                'type' => 'category',
                'name' => $child['page_name'],
                'node_type' => $child['node_type'],
                'level' => $level,
                'display' => $indent . $child['page_name'] . ' (under ' . $parent_name . ') [Level ' . $level . ' - Category]'
            ];

            if ($level < 4) {
                $this->build_parent_options($child['id'], $level + 1, $options, $child['page_name'], $exclude_id);
            }
        }
    }

    /**
     * Get only child categories (not pages)
     */
    private function get_children_categories($parent_id)
    {
        return $this->db
            ->select('id, page_name, slug, node_type, sort_order')
            ->where('parent_id', $parent_id)
            ->where('node_type', 'category') // ✅ ONLY CATEGORIES
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    // ========================================
    // BREADCRUMB
    // ========================================

    public function get_breadcrumb($page_id)
    {
        $breadcrumb = [];
        $current = $this->get_page_by_id($page_id);

        if (!$current)
            return $breadcrumb;

        $trail = [$current];
        $max_iterations = 10;
        $iterations = 0;

        while ($current->parent_id && $iterations < $max_iterations) {
            $parent = $this->get_page_by_id($current->parent_id);
            if ($parent) {
                array_unshift($trail, $parent);
                $current = $parent;
            } else {
                break;
            }
            $iterations++;
        }

        if (!empty($current->category)) {
            array_unshift($trail, (object) [
                'id' => 0,
                'page_name' => $current->category,
                'slug' => null,
                'node_type' => 'static_category'
            ]);
        }

        return $trail;
    }

    // ========================================
    // GET CHILDREN (PUBLIC METHOD)
    // ========================================

    public function get_children($parent_id)
    {
        return $this->db
            ->where('parent_id', $parent_id)
            ->where('status', 'active')
            ->order_by('sort_order', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result();
    }

    // ========================================
    // LEGACY SUPPORT
    // ========================================

    public function get_menu_items()
    {
        $pages = $this->db
            ->select('id, category, page_name, slug, node_type')
            ->where('status', 'active')
            ->group_start()
            ->where('parent_id IS NULL', NULL, FALSE)
            ->or_where('parent_id', '')
            ->or_where('parent_id', 0)
            ->group_end()
            ->order_by('category', 'ASC')
            ->order_by('page_name', 'ASC')
            ->get($this->table)
            ->result();

        $menu = [];
        foreach ($pages as $page) {
            $menu[$page->category][] = $page;
        }

        return $menu;
    }
}