<?php
defined('BASEPATH') or exit('No direct script access allowed');

// ========================================
// CORE ROUTES
// ========================================
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ========================================
// AUTHENTICATION & DASHBOARD
// ========================================
$route['nppdashboard'] = 'login';
$route['login/Login_Auth'] = 'Login/Login_Auth';
$route['dashboard'] = 'Dashboard/index';
$route['dashboard/Dashboard'] = 'Dashboard/Dashboard';
$route['Login/logout'] = 'Login/logout';
$route['login/logout'] = 'Login/logout';
$route['logout'] = 'Login/logout';

// ========================================
// CONTACT US (NEW - DYNAMIC FROM SETTINGS)
// ========================================
$route['contact-us'] = 'Contact_us/index';
$route['inquire'] = 'Contact_us/inquire';
$route['contact-us/submit'] = 'Contact_us/submit';
$route['medicine_details_query'] = 'Contact_us/medicine_details_query';

// ========================================
// CONTACT (ADMIN PANEL)
// ========================================
// Prescription Routes
$route['contact/prescriptions'] = 'contact/prescriptions';
$route['contact/view_prescription/(:num)'] = 'contact/view_prescription/$1';
$route['contact/delete_prescription/(:num)'] = 'contact/delete_prescription/$1';
$route['contact/submit'] = 'contact/submit';

// Contact Routes
$route['contact'] = 'contact/index';
$route['contact/view/(:num)'] = 'contact/view/$1';
$route['contact/delete/(:num)'] = 'contact/delete/$1';
$route['contact/bulk_delete'] = 'contact/bulk_delete';

$route['home'] = 'contact/submit';
$route['thanku'] = 'pages/thanku';

// ========================================
// Legal & Document
// ========================================

$route['report_adverse/store'] = 'AdverseController/store';
$route['report_adverse/records'] = 'AdverseController/records';
$route['report_adverse/view/(:num)'] = 'AdverseController/view/$1';
$route['report_adverse/delete/(:num)'] = 'AdverseController/delete/$1';
$route['compliance-and-safety/report-adverse'] = 'AdverseController/report_adverse';
$route['compliance-and-safety/temperature-controlled-shipping'] = 'Pages/temp_and_logistics';
$route['compliance-and-safety/prescription-guidelines'] = 'Pages/why_prescription';
$route['compliance-and-safety/product-safety-standards'] = 'Pages/medicine_safety';
$route['compliance-and-safety/indian-import-regulations'] = 'Pages/indian_import_regulations';

// ========================================
// Resource & Information
// ========================================
$route['blogs'] = 'BlogController/blogs';
$route['blog-detail/(:any)'] = 'News/blog_detail/$1';
// =========================================
// Named Patient Program
// =========================================
$route['named-patient-program'] = 'Named_patient_program_controller/named_patient_program';
$route['npp_query'] = 'Named_patient_program_controller/npp_query';

// =========================================
// About Us
// =========================================
$route['about-us'] = 'pages/about_us';

// ========================================
// FOOTER CMS
// ========================================

$route['admin_panel/FooterCms'] =
    'FooterCms/index';

$route['admin_panel/FooterCms/add'] =
    'FooterCms/add';

$route['admin_panel/FooterCms/delete/(:num)'] =
    'FooterCms/delete/$1';

$route['footer/(:any)'] =
    'Footer/view/$1';

// ========================================
// SETTINGS
// ========================================
$route['settings/Settings'] = 'Settings/Settings';
$route['settings/Add_Settings'] = 'Settings/Add_Settings';

// ========================================
// Footer - Links 
// ========================================
$route['admin_panel/footer_links'] = 'Footer_links_controller/index';

$route['admin_panel/footer_links/save'] = 'Footer_links_controller/save';

$route['admin_panel/footer_links/edit/(:num)'] = 'Footer_links_controller/edit/$1';

$route['admin_panel/footer_links/delete/(:num)'] = 'Footer_links_controller/delete/$1';

// ========================================
// ADMIN PANEL - CMS (MUST BE BEFORE MEDICINE ROUTES)
// ========================================
$route['admin_panel/cms'] = 'Cms/index';
$route['admin_panel/cms/add'] = 'Cms/add';
$route['admin_panel/cms/edit/(:num)'] = 'Cms/edit/$1';
$route['admin_panel/cms/delete/(:num)'] = 'Cms/delete/$1';

// ========================================
// ADMIN PANEL - CATEGORIES
// ========================================
$route['admin_panel/category'] = 'Category/index';
$route['admin_panel/category/add'] = 'Category/add';
$route['admin_panel/category/edit/(:num)'] = 'Category/edit/$1';
$route['admin_panel/category/delete/(:num)'] = 'Category/delete/$1';

// ========================================
// ADMIN PANEL - MED CATEGORIES
// ========================================
$route['admin_panel/med_category'] = 'Med_category/index';
$route['admin_panel/med_category/add'] = 'Med_category/add';
$route['admin_panel/med_category/edit/(:num)'] = 'Med_category/edit/$1';
$route['admin_panel/med_category/delete/(:num)'] = 'Med_category/delete/$1';

// ========================================
// ADMIN PANEL - MEDICINES
// ========================================
$route['admin_panel/Patent_Medicines'] = 'MedicineController/adminIndex';
$route['admin_panel/Patent_Medicines/add'] = 'MedicineController/add';
$route['admin_panel/Patent_Medicines/edit/(:num)'] = 'MedicineController/edit/$1';
$route['admin_panel/Patent_Medicines/delete/(:num)'] = 'MedicineController/delete/$1';
$route['admin_panel/Patent_Medicines/save_home'] = 'MedicineController/save_home_selection';
$route['admin_panel/Patent_Medicines/import_excel'] = 'MedicineController/import_excel';
$route['admin_panel/medicine_import'] = 'MedicineImport/index';
$route['admin_panel/medicine_import/downloadTemplate'] = 'MedicineImport/downloadTemplate';
$route['admin_panel/medicine_import/processImport'] = 'MedicineImport/processImport';
$route['admin_panel/Patent_Medicines/bulk_delete'] = 'MedicineController/bulk_delete';

// ========================================
// ADMIN PANEL - NEWS
// ========================================
$route['admin_panel/News'] = 'News/adminIndex';
$route['admin_panel/news/insert'] = 'news/insert';
$route['admin_panel/news/update'] = 'news/update';
$route['admin_panel/news/delete/(:num)'] = 'news/delete/$1';
$route['admin_panel/news/save_home'] = 'News/save_home_selection';

$route['admin_panel/latest_news'] = 'Latest_news/adminIndex';
$route['admin_panel/latest_news/add'] = 'Latest_news/add';
$route['admin_panel/latest_news/insert'] = 'Latest_news/insert';
$route['admin_panel/latest_news/edit/(:num)'] = 'Latest_news/edit/$1';
$route['admin_panel/latest_news/update'] = 'Latest_news/update';
$route['admin_panel/latest_news/delete/(:num)'] = 'Latest_news/delete/$1';

// ========================================
// FRONTEND - MEDICINES
// ========================================
$route['medicine'] = 'MedicineController/all';
$route['medicine/all'] = 'MedicineController/all';
$route['medicine/all/(:any)'] = 'MedicineController/all/$1';
$route['medicine/search'] = 'MedicineController/search';
$route['medicine/letter/(:any)'] = 'MedicineController/browse_letter/$1';
$route['medicine/category/(:num)'] = 'MedicineController/browse_category/$1';
$route['medicine/category/(:num)/(:any)'] = 'MedicineController/browse_category/$1/$2';
$route['medicine/liveSearch'] = 'MedicineController/liveSearch';
$route['medicine/ajaxSearch'] = 'MedicineController/ajaxSearch';
// $route['medicine/detail/(:num)'] = 'MedicineController/detail/$1';
$route['m/(:any)/(:any)'] = 'MedicineController/detail/$1/$2';

$route['med_update'] = 'MedicineController/index';
$route['med_update/(:num)'] = 'MedicineController/index/$1';
$route['med_update/category/(:any)'] = 'MedicineController/category/$1';
$route['med_update/category/(:any)/(:num)'] = 'MedicineController/category/$1/$2';

// ========================================
// FRONTEND - NEWS
// ========================================
$route['news-and-updates'] = 'news/index';
$route['news'] = 'news/index';
$route['news/index'] = 'news/index';
$route['news/index/(:num)'] = 'news/index/$1';
$route['news/category/(:any)'] = 'news/category/$1';
$route['news/category/(:any)/(:num)'] = 'news/category/$1/$2';
$route['news/(:any)'] = 'news/details_slug/$1';
$route['news_details_query'] = 'Contact_us/news_details_query';

// ========================================
// IMAGE UPLOAD
// ========================================
$route['image-upload'] = 'ImageUpload';
$route['image-upload/post']['get'] = 'ImageUpload/create';
$route['image-upload/post']['post'] = 'ImageUpload/store';

// ========================================
// TRACKING
// ========================================
$route['tracking'] = 'Tracking/index';
$route['tracking/ajax'] = 'Tracking/ajax_track';

// ========================================
// MEDICINE TEMPLATES
// ========================================
$route['admin_panel/Patent_Medicines/download_template'] = 'MedicineController/download_template';
$route['admin_panel/Patent_Medicines/download_excel_template'] = 'MedicineController/download_excel_template';

// ========================================
// COOKIE CONSENT
// ========================================
$route['privacy-policy'] = 'Pages/privacy';
$route['terms-and-conditions'] = 'Pages/terms_and_conditions';
$route['cookies/accept'] = 'Pages/accept';

// ========================================
// For know about npp
// ========================================
$route['for-know-more-about-npp'] = 'Pages/know_more_npp';

// =========================================
// Category page
// ============================================
$route['therapeutic-area/category-page'] = 'Category_page_controller/index';
$route['therapeutic-area/(:any)'] = 'Category_page_controller/index/$1';
$route['therapeutic-area/(:any)/(:num)'] = 'Category_page_controller/index/$1/$2';

// ========================================
// FRONTEND - CMS PAGES (CRITICAL - BEFORE CATCH-ALL)
// ========================================
$route['faqs'] = 'Pages/faqs';
$route['what-we-offer'] = 'Pages/service_real_world_data';
$route['(:any)'] = 'Pages/cms_page/$1';
$route['(:any)/(:num)'] = 'Pages/cms_page/$1/$2';

// ========================================
// CATCH-ALL ROUTE (MUST BE LAST!)
// ========================================
$route['(:any)/(:any)'] = 'news/details/$1/$2';