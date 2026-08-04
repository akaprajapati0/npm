<aside class="left-sidebar">
    <div class="sidebar-brand">
        <h4 class="brand-title">
            Named Patient<br>
            <span>Medicine Portal</span>
        </h4>
    </div>

    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li class="nav-label">Main Navigation</li>

                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="fas fa-th-large nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-label">Content Management</li>

                <!-- <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-folder nav-icon"></i>
                        <span class="nav-text">Footer CMS</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/cms') ?>">Add Pages</a></li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-folder nav-icon"></i>
                        <span class="nav-text">Footer Links</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/footer_links') ?>">Add Links</a></li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-folder nav-icon"></i>
                        <span class="nav-text">News Categories</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/category') ?>">All News Categories</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-capsules nav-icon"></i>
                        <span class="nav-text">Medicine Categories</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/med_category') ?>">All Med Categories</a></li>
                    </ul>
                </li>

                <li class="nav-label">Pharmaceutical Products</li>

                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-pills nav-icon"></i>
                        <span class="nav-text">Patent Medicines</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/Patent_Medicines') ?>">All Medicines</a></li>
                    </ul>
                </li>

                <li class="nav-label">Publications</li>

                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link has-arrow">
                        <i class="fas fa-newspaper nav-icon"></i>
                        <span class="nav-text">News & Articles</span>

                    </a>
                    <ul class="submenu">
                        <li><a href="<?= base_url('admin_panel/News') ?>">All News</a></li>
                    </ul>
                </li>

                <li class="nav-label">Communication</li>

                <li class="nav-item">
                    <a href="<?= base_url('report_adverse/records') ?>" class="nav-link">
                        <i class="fas fa-address-book nav-icon"></i>
                        <span class="nav-text">Adverse Events Form</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('contact') ?>" class="nav-link">
                        <i class="fas fa-address-book nav-icon"></i>
                        <span class="nav-text">Contact Enquiries</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('contact/prescriptions') ?>" class="nav-link">
                        <i class="fas fa-file-medical nav-icon"></i>
                        <span class="nav-text">Prescriptions</span>
                    </a>
                </li>
                <ul>

                </ul>

                <li class="nav-label">Settings</li>
                <li class="nav-item">
                    <a href="<?= base_url('settings/Settings') ?>" class="nav-link">
                        <i class="fas fa-cogs nav-icon"></i>
                        <span class="nav-text">Site Settings</span>
                    </a>
                </li>

            </ul>
        </nav>


    </div>
</aside>

<div class="sidebar-overlay"></div>

<style>
    /* ===============================
   SIDEBAR CORE
================================ */
    .left-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 260px;
        background: #fff;
        border-right: 1px solid #e5e7eb;

        transition: width 0.3s ease, transform 0.3s ease;
    }

    .scroll-sidebar {
        height: calc(100% - 60px);
        overflow-y: auto;
    }

    /* Brand */
    .sidebar-brand {
        height: 60px;
        padding: 12px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #0891b2, #0284c7);
    }

    .brand-title {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.2;
    }

    .brand-title span {
        font-size: 12px;
        font-weight: 400;
        opacity: 0.9;
    }

    /* Navigation */
    .sidebar-nav {
        padding: 12px 0;
    }

    .nav-label {
        padding: 12px 20px 6px;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
    }

    .nav-item {
        margin: 2px 8px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s;
    }

    .nav-link:hover {
        background: #f3f4f6;
        color: #0891b2;
    }

    .nav-icon {
        width: 22px;
        text-align: center;
    }

    /* Submenu */
    .submenu {
        display: none;
        padding-left: 42px;
    }

    .submenu li a {
        display: block;
        padding: 8px 0;
        font-size: 13px;
        color: #4b5563;
    }

    .submenu li a:hover {
        color: #0891b2;
    }

    /* Expanded submenu */
    .nav-item.open>.submenu {
        display: block;
    }

    .arrow-icon {
        margin-left: auto;
        font-size: 11px;
        transition: transform 0.3s;
    }

    .nav-item.open .arrow-icon {
        transform: rotate(180deg);
    }

    /* Footer */
    .sidebar-footer {
        padding: 12px;
        border-top: 1px solid #e5e7eb;
    }

    .logout-btn {
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 10px;
        border-radius: 8px;
        background: #f9fafb;
        color: #374151;
        font-weight: 600;
    }

    /* ===============================
   COLLAPSED (DESKTOP)
================================ */
    body.sidebar-collapsed .left-sidebar {
        width: 80px;
    }

    body.sidebar-collapsed .nav-text,
    body.sidebar-collapsed .nav-label,
    body.sidebar-collapsed .arrow-icon,
    body.sidebar-collapsed .submenu,
    body.sidebar-collapsed .sidebar-brand span {
        display: none !important;
    }

    body.sidebar-collapsed .nav-link {
        justify-content: center;
    }

    /* Page wrapper sync */
    body.sidebar-collapsed .page-wrapper {
        margin-left: 80px;
    }

    /* ===============================
   MOBILE
================================ */
    @media (max-width: 768px) {
        .left-sidebar {
            transform: translateX(-100%);
        }

        .left-sidebar.show {
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .page-wrapper {
            margin-left: 0 !important;
        }
    }
</style>
<script>
    (function ($) {
        'use strict';

        $(function () {

            const isMobile = () => window.innerWidth <= 768;

            // Sidebar toggle
            $('.nav-toggler, .sidebartoggler').on('click', function (e) {
                e.preventDefault();

                if (isMobile()) {
                    $('.left-sidebar').toggleClass('show');
                    $('.sidebar-overlay').toggleClass('show');
                } else {
                    $('body').toggleClass('sidebar-collapsed');
                }
            });

            // Submenu toggle
            $('.has-arrow').on('click', function (e) {
                e.preventDefault();
                const parent = $(this).closest('.nav-item');

                if ($('body').hasClass('sidebar-collapsed')) return;

                parent.toggleClass('open')
                    .siblings('.nav-item')
                    .removeClass('open');
            });

            // Overlay close
            $('.sidebar-overlay').on('click', function () {
                $('.left-sidebar').removeClass('show');
                $('.sidebar-overlay').removeClass('show');
            });

            // Resize reset
            $(window).on('resize', function () {
                if (!isMobile()) {
                    $('.left-sidebar').removeClass('show');
                    $('.sidebar-overlay').removeClass('show');
                }
            });

        });
    })(jQuery);
</script>