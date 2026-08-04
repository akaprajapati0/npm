<!DOCTYPE html>
<html lang="en">
<?php date_default_timezone_set("Asia/Dhaka"); ?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ikrish India">

    <?php $settingsvalue = $this->settings_model->GetSettingsValue(); ?>
    <link rel="icon" type="image/ico" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <title><?php echo $settingsvalue->sitetitle; ?> - Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Morris CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.0.46/css/materialdesignicons.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link
        href="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
        rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/css/custum.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>assets/css/print.css" rel="stylesheet" media='print'>

    <!-- Theme Colors -->
    <link href="<?php echo base_url(); ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

    <link href="<?php echo base_url(); ?>assets/plugins/multiselect/css/multi-select.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/calendar/dist/fullcalendar.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">



    <style>
        /* Global Layout Fixes - Add this to your main CSS file or in header.php */

        /* Ensure proper body layout */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Main wrapper */
        #main-wrapper {
            position: relative;
            width: 100%;
            min-height: 100vh;
            z-index: 1000;
        }

        /* Page wrapper - main content area */
        .page-wrapper {
            margin-left: 260px;
            margin-top: 64px;
            min-height: calc(100vh - 64px);
            padding: 24px;
            background: #f9fafb;
            transition: margin-left 300ms cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            width: auto;
        }

        /* Container fluid inside page wrapper */
        .page-wrapper .container-fluid {
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        /* Fix for cards and content */
        .page-wrapper .card {
            margin-bottom: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: none;
            border-radius: 8px;
        }

        /* Page titles */
        .page-wrapper .page-titles {
            padding: 16px 0 24px;
            margin: 0 0 24px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-wrapper {
                margin-left: 0;
                padding: 16px;
            }

            .page-wrapper .container-fluid {
                padding-right: 10px;
                padding-left: 10px;
            }

            .page-wrapper .page-titles {
                padding: 12px 0 16px;
                margin: 0 0 16px;
            }
        }

        @media (max-width: 480px) {
            .page-wrapper {
                padding: 12px;
            }

            .page-wrapper .container-fluid {
                padding-right: 5px;
                padding-left: 5px;
            }
        }

        /* Ensure topbar stays fixed */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            z-index: 1001;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        /* Sidebar should not overlap content */
        .left-sidebar {
            position: fixed;
            top: 0px;
            left: 0;
            bottom: 0;
            width: 260px;
            z-index: 1000;

        }

        @media (max-width: 768px) {
            .left-sidebar {
                transform: translateX(-100%);
            }

            .left-sidebar.show {
                transform: translateX(0);
            }
        }

        /* Prevent body scroll when sidebar is open on mobile */
        body.show-sidebar {
            overflow: hidden;
            position: fixed;
            width: 100%;
        }

        @media (min-width: 769px) {
            body.show-sidebar {
                overflow: auto;
                position: static;
            }
        }

        /* Table responsive fixes */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {
            .table-responsive {
                margin-bottom: 15px;
            }

            .table-responsive table {
                min-width: 600px;
            }
        }

        /* Button group responsive */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .btn-group .btn {
                flex: 1 1 100%;
                margin-bottom: 8px;
            }
        }

        /* Alert messages */
        .custom-alert {
            position: fixed;
            top: 80px;
            right: 20px;
            min-width: 300px;
            max-width: 500px;
            z-index: 1000;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .custom-alert.custom-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #059669;
        }

        .custom-alert.custom-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .custom-close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            line-height: 1;
            color: inherit;
            cursor: pointer;
            opacity: 0.7;
            margin-left: 10px;
        }

        .custom-close:hover {
            opacity: 1;
        }

        @media (max-width: 576px) {
            .custom-alert {
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
            }
        }

        /* Fix for DataTables on mobile */
        @media (max-width: 768px) {

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: left;
                margin-bottom: 10px;
            }

            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
                margin-top: 10px;
            }
        }

        /* Card header responsive */
        .card-header {
            padding: 16px 20px;
            background: #0891b2;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }

        @media (max-width: 576px) {
            .card-header {
                padding: 12px 15px;
            }

            .card-header h4 {
                font-size: 16px;
            }
        }

        /* Breadcrumb responsive */
        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 8px 0;
            margin-bottom: 0;
            list-style: none;
            background: transparent;
        }

        @media (max-width: 576px) {
            .breadcrumb {
                font-size: 13px;
            }
        }

        /* Form elements responsive */
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                font-size: 14px;
            }

            .btn {
                padding: 8px 12px;
                font-size: 14px;
            }
        }

        /* ========================================
           PHARMACEUTICAL DESIGN SYSTEM
           Medical-grade UI with clinical precision
        ======================================== */

        :root {
            /* Pharmaceutical Color Palette */
            --pharma-primary: #0891b2;
            /* Medical Teal */
            --pharma-primary-dark: #0e7490;
            /* Deep Teal */
            --pharma-primary-light: #06b6d4;
            /* Light Cyan */
            --pharma-secondary: #0284c7;
            /* Medical Blue */
            --pharma-success: #059669;
            /* Medical Green */
            --pharma-danger: #dc2626;
            /* Alert Red */
            --pharma-warning: #d97706;
            /* Caution Amber */
            --pharma-info: #0891b2;
            /* Info Teal */

            /* Clinical Neutrals */
            --pharma-white: #ffffff;
            --pharma-gray-50: #f9fafb;
            --pharma-gray-100: #f3f4f6;
            --pharma-gray-200: #e5e7eb;
            --pharma-gray-300: #d1d5db;
            --pharma-gray-400: #9ca3af;
            --pharma-gray-500: #6b7280;
            --pharma-gray-600: #4b5563;
            --pharma-gray-700: #374151;
            --pharma-gray-800: #1f2937;
            --pharma-gray-900: #111827;

            /* Spacing System */
            --space-1: 4px;
            --space-2: 8px;
            --space-3: 12px;
            --space-4: 16px;
            --space-5: 20px;
            --space-6: 24px;
            --space-8: 32px;
            --space-10: 40px;
            --space-12: 48px;

            /* Shadow System */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-full: 9999px;

            /* Typography */
            --font-size-xs: 12px;
            --font-size-sm: 14px;
            --font-size-base: 15px;
            --font-size-lg: 16px;
            --font-size-xl: 18px;
            --font-size-2xl: 24px;
            --font-size-3xl: 30px;

            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 200ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========================================
           GLOBAL RESETS & BASE STYLES
        ======================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: var(--font-size-base);
            line-height: 1.6;
            color: var(--pharma-gray-700);
            background: var(--pharma-gray-50);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========================================
           PHARMACEUTICAL TOPBAR
        ======================================== */

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: var(--pharma-white);
            border-bottom: 1px solid var(--pharma-gray-200);
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .topbar .navbar {
            width: 100%;
            padding: 0;
            margin: 0;
            min-height: auto;
        }

        .topbar .navbar-header {
            display: flex;
            align-items: center;
            padding: 0 var(--space-6);
            height: 64px;
            border-right: 1px solid var(--pharma-gray-200);
            background: linear-gradient(135deg, var(--pharma-primary) 0%, var(--pharma-secondary) 100%);
            width: 260px;
            flex-shrink: 0;
        }

        .topbar .navbar-brand {
            display: flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .topbar .navbar-brand img {
            height: 44px;
            width: auto;
            max-width: 180px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        /* Navigation Links */
        .topbar .navbar-collapse {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 var(--space-6);
            flex: 1;
        }

        .topbar .navbar-nav {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .topbar .nav-item {
            list-style: none;
        }

        .topbar .nav-link {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            color: var(--pharma-gray-600);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: all var(--transition-base);
            font-size: var(--font-size-sm);
            font-weight: 500;
        }

        .topbar .nav-link:hover {
            color: var(--pharma-primary);
            background: var(--pharma-gray-100);
        }

        .topbar .nav-link i {
            font-size: 18px;
            color: #000;
        }

        /* Mobile Toggle Buttons */
        .nav-toggler,
        .sidebartoggler {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-base);
            border: none;
            background: transparent;
        }

        .nav-toggler:hover,
        .sidebartoggler:hover {
            background: var(--pharma-gray-100);
        }

        /* Notification Badge */
        .notify {
            position: relative;
            display: inline-block;
        }

        .notify .heartbit {
            position: absolute;
            top: -2px;
            right: -2px;
            height: 10px;
            width: 10px;
            border: 2px solid var(--pharma-danger);
            border-radius: var(--radius-full);
            background: transparent;
            animation: heartbit 1.5s ease-out infinite;
        }

        .notify .point {
            position: absolute;
            top: 1px;
            right: 1px;
            height: 6px;
            width: 6px;
            border-radius: var(--radius-full);
            background: var(--pharma-danger);
        }

        @keyframes heartbit {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        /* User Profile Dropdown */
        .topbar .profile-pic {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-full);
            border: 2px solid var(--pharma-gray-200);
            object-fit: cover;
            transition: all var(--transition-base);
        }

        .topbar .nav-link:hover .profile-pic {
            border-color: var(--pharma-primary);
            transform: scale(1.05);
            box-shadow: 0 0 0 4px rgba(8, 145, 178, 0.1);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            min-width: 280px;
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: var(--space-2);
            margin-top: var(--space-2);
            animation: dropdown-fade-in var(--transition-base);
        }

        @keyframes dropdown-fade-in {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-menu.mailbox {
            min-width: 320px;
        }

        .dropdown-menu .drop-title {
            padding: var(--space-4);
            font-weight: 600;
            font-size: var(--font-size-sm);
            color: var(--pharma-gray-900);
            border-bottom: 1px solid var(--pharma-gray-200);
            margin-bottom: var(--space-2);
        }

        .dropdown-menu .message-center a {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            color: var(--pharma-gray-700);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: all var(--transition-base);
        }

        .dropdown-menu .message-center a:hover {
            background: var(--pharma-gray-100);
        }

        .dropdown-menu .btn-circle {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* User Dropdown Specific */
        .dropdown-menu.scale-up {
            min-width: 300px;
        }

        .dropdown-user .dw-user-box {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            padding: var(--space-5);
            background: linear-gradient(135deg, var(--pharma-primary) 0%, var(--pharma-secondary) 100%);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-3);
        }

        .dropdown-user .u-img img {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-full);
            border: 3px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
        }

        .dropdown-user .u-text {
            flex: 1;
        }

        .dropdown-user .u-text h4 {
            margin: 0 0 var(--space-1) 0;
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--pharma-white);
        }

        .dropdown-user .u-text p {
            margin: 0;
            font-size: var(--font-size-xs);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }

        .dropdown-user li {
            list-style: none;
        }

        .dropdown-user li a {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            color: var(--pharma-gray-700);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: all var(--transition-base);
            font-size: var(--font-size-sm);
            font-weight: 500;
        }

        .dropdown-user li a:hover {
            background: var(--pharma-gray-100);
            color: var(--pharma-primary);
        }

        .dropdown-user li a i {
            width: 20px;
            text-align: center;
            color: var(--pharma-gray-500);
        }

        .dropdown-user .divider {
            height: 1px;
            background: var(--pharma-gray-200);
            margin: var(--space-2) 0;
        }

        /* ========================================
           PRELOADER - Medical Theme
        ======================================== */

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--pharma-white);
            z-index: 9000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circular {
            animation: rotate 1.5s linear infinite;
            height: 50px;
            width: 50px;
        }

        .path {
            stroke: var(--pharma-primary);
            stroke-linecap: round;
            animation: dash 1.5s ease-in-out infinite;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes dash {
            0% {
                stroke-dasharray: 1, 150;
                stroke-dashoffset: 0;
            }

            50% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -35;
            }

            100% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -124;
            }
        }

        /* ========================================
           RESPONSIVE BEHAVIOR
        ======================================== */

        @media (max-width: 768px) {
            .topbar .navbar-header {
                width: 200px;
                padding: 0 var(--space-4);
            }

            .topbar .navbar-brand img {
                height: 36px;
                max-width: 140px;
            }

            .topbar .navbar-collapse {
                padding: 0 var(--space-4);
            }

            .dropdown-menu {
                min-width: 280px;
                max-width: calc(100vw - 32px);
            }

            .hidden-md-up {
                display: flex !important;
            }

            .hidden-sm-down {
                display: none !important;
            }
        }

        @media (min-width: 769px) {
            .hidden-md-up {
                display: none !important;
            }

            .hidden-sm-down {
                display: flex !important;
            }
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <?php
    $id = $this->session->userdata("user_login_id");
    $basicinfo = $this->employee_model->GetBasic($id);

    if (!$basicinfo) {
        $basicinfo = (object) [
            'em_image' => '',
            'first_name' => '',
            'last_name' => '',
            'em_email' => '',
            'em_id' => ''
        ];
    }

    $settingsvalue = $this->settings_model->GetSettingsValue();
    ?>

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php if ($this->session->userdata("user_type")) {
                        echo base_url() . "dashboard";
                    } else {
                        echo base_url();
                    } ?>">
                        <img src="<?php echo base_url(); ?>assets/images/<?php echo $settingsvalue->sitelogo; ?>"
                            alt="<?php echo $settingsvalue->sitetitle; ?>" />
                    </a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                href="javascript:void(0)">
                                <i class="mdi mdi-menu"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)">
                                <i class="ti-menu"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center w-100">
                        <h1 class="mb-0 ml-3">Admin Panel</h1>

                        <a href="<?= site_url('logout') ?>" class="logout-btn ml-auto d-flex align-items-center">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </nav>
        </header>