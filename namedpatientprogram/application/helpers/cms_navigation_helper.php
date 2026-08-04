<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Render breadcrumb trail
 */
if (!function_exists('render_breadcrumb')) {
    function render_breadcrumb($breadcrumb)
    {
        if (empty($breadcrumb)) return '';

        $html = '<nav class="breadcrumb-nav bg-gray-100 py-3 px-4">';
        $html .= '<div class="max-w-7xl mx-auto">';
        $html .= '<ol class="flex flex-wrap items-center gap-2 text-sm">';
        $html .= '<li><a href="' . base_url() . '" class="text-blue-600 hover:text-blue-800">Home</a></li>';

        foreach ($breadcrumb as $index => $crumb) {
            $html .= '<li class="flex items-center gap-2">';
            $html .= '<i class="fas fa-chevron-right text-gray-400 text-xs"></i>';

            if ($index === count($breadcrumb) - 1) {
                $html .= '<span class="text-gray-700 font-semibold">' . htmlspecialchars($crumb->page_name) . '</span>';
            } else {
                if (!empty($crumb->slug)) {
                    $html .= '<a href="' . site_url('page/' . $crumb->slug) . '" class="text-blue-600 hover:text-blue-800">';
                    $html .= htmlspecialchars($crumb->page_name);
                    $html .= '</a>';
                } else {
                    $html .= '<span class="text-gray-600">' . htmlspecialchars($crumb->page_name) . '</span>';
                }
            }

            $html .= '</li>';
        }

        $html .= '</ol></div></nav>';
        return $html;
    }
}
