<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CMS Menu Hook
 * Loads hierarchical CMS navigation and legacy menu items
 * Automatically called on every request via hooks.php
 */
class CmsMenuHook
{
    public function load_cms_menu()
    {
        $CI = &get_instance();

        try {
            // Load database if not loaded
            if (!isset($CI->db)) {
                $CI->load->database();
            }

            // Load CMS model if not already loaded
            if (!isset($CI->Cms_model)) {
                $CI->load->model('Cms_model');
            }

            // Load CMS navigation helper
            $CI->load->helper('cms_navigation');

            // Get legacy menu items (for backward compatibility)
            $cms_menu = $CI->Cms_model->get_menu_items();

            // Get hierarchical navigation (for new multi-level menus)
            $cms_navigation = $CI->Cms_model->get_navigation_hierarchy();

            // Make available to all views
            $CI->load->vars([
                'cms_menu'        => $cms_menu,
                'cms_navigation'  => $cms_navigation
            ]);

            log_message('info', 'CMS Menu Hook: Loaded ' . count($cms_navigation) . ' top-level categories');
        } catch (Exception $e) {
            // Silently fail if CMS table doesn't exist yet
            log_message('error', 'CMS Menu Hook Error: ' . $e->getMessage());
            $CI->load->vars([
                'cms_menu'       => [],
                'cms_navigation' => []
            ]);
        }
    }
}
