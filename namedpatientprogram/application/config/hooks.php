<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['post_controller_constructor'] = [
    [
        'class'    => 'Cms_MenuHook',
        'function' => 'load_cms_menu',
        'filename' => 'Cms_MenuHook.php',
        'filepath' => 'hooks',


    ],
    [
        'class'    => 'News_CatHook',
        'function' => 'load_news_categories',
        'filename' => 'News_CatHook.php',
        'filepath' => 'hooks',
    ],
];
