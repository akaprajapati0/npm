<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News_CatHook
{
    public function load_news_categories()
    {
        $CI = &get_instance();

        try {
            // Load database if not loaded
            if (!isset($CI->db)) {
                $CI->load->database();
            }

            // Load News model if not already loaded
            if (!isset($CI->News_model)) {
                $CI->load->model('News_model');
            }

            // Get news categories
            $categories = $CI->News_model->getAllCategories();

            // Make available to all views
            $CI->load->vars(['categories' => $categories]);
        } catch (Exception $e) {
            // Silently fail if News table doesn't exist yet
            log_message('error', 'News Categories Hook Error: ' . $e->getMessage());
            $CI->load->vars(['categories' => []]);
        }
    }
}