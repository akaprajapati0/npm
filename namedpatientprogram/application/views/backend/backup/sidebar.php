<!-- Modern Sidebar -->
<?php
// Get user info safely
$id = $this->session->userdata("user_login_id");
$basicinfo = $this->employee_model->GetBasic($id);

if (!$basicinfo) {
    $basicinfo = (object) [
        'em_image' => '',
        'first_name' => 'Guest',
        'last_name' => 'User',
        'em_email' => '',
        'em_id' => ''
    ];
}

$settingsvalue = $this->settings_model->GetSettingsValue();
?>

<aside class="modern-sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <!-- <img src="<?php echo base_url(); ?>assets/images/<?php echo $settingsvalue->sitelogo; ?>" alt="Ikris Pharma"
                class="logo-img"> -->
            <span class="logo-text">Ikris Admin</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <!-- <div class="user-avatar">
            <img src="<?php echo base_url(); ?>assets/images/users/<?php
                                                                    if (!empty($basicinfo->em_image)) {
                                                                        echo $basicinfo->em_image;
                                                                    } else {
                                                                        echo 'user.png';
                                                                    } ?>" alt="User"> 
            <span class="status-indicator"></span>

        </div> -->
        <div class="user-info">
            <h6 class="user-name"><?php echo trim($basicinfo->first_name . ' ' . $basicinfo->last_name); ?></h6>
            <p class="user-role">Administrator</p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>dashboard" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin_panel/category" class="nav-link">
                    <i class="fas fa-list"></i>
                    <span class="nav-text">Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin_panel/med_category" class="nav-link">
                    <i class="fas fa-capsules"></i>
                    <span class="nav-text">Med Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin_panel/Patent_Medicines" class="nav-link">
                    <i class="fas fa-pills"></i>
                    <span class="nav-text">Patent Medicines</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin_panel/News" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <span class="nav-text">News/Blog</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo base_url(); ?>settings/Settings" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span class="nav-text">CMS</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?php echo site_url('logout'); ?>" class="nav-link logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="<?php echo base_url(); ?>" target="_blank" class="visit-site-btn">
            <i class="fas fa-external-link-alt"></i>
            <span>Visit Website</span>
        </a>
    </div>
</aside>

<!-- Top Header Bar -->
<header class="modern-header" id="header">
    <div class="header-content">
        <button class="mobile-toggle" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="header-admin-title">
            <h2 class="text-xl font-semibold text-gray-800">Admin Dashboard</h2>
        </div>

        <!-- <div class="header-actions">
            <div class="action-item">
                <a href="<?php echo base_url(); ?>" target="_blank" title="Visit Website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>

            <div class="action-item user-dropdown">
                <img src="<?php echo base_url(); ?>assets/images/users/<?php
                                                                        if (!empty($basicinfo->em_image)) {
                                                                            echo $basicinfo->em_image;
                                                                        } else {
                                                                            echo 'user.png';
                                                                        } ?>" alt="User" class="user-avatar-small">
                <div class="dropdown-menu">
                    <a href="<?php echo base_url(); ?>settings/Settings">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <a href="<?php echo site_url('logout'); ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div> -->
    </div>
</header>

<style>
    /* Sidebar Styles */
    .modern-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        transition: all var(--transition-speed) ease;
        z-index: 1000;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .modern-sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar-header {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        border-radius: 8px;
    }

    .logo-text {
        font-size: 1.3rem;
        font-weight: 700;
        color: white;
        white-space: nowrap;
        transition: opacity var(--transition-speed);
    }

    .modern-sidebar.collapsed .logo-text {
        opacity: 0;
        display: none;
    }

    .sidebar-toggle {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .sidebar-user {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-avatar {
        position: relative;
        flex-shrink: 0;
    }

    .user-avatar img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: var(--success-color);
        border: 2px solid #1a1a2e;
        border-radius: 50%;
    }

    .user-info {
        flex: 1;
        min-width: 0;
        transition: opacity var(--transition-speed);
    }

    .modern-sidebar.collapsed .user-info {
        opacity: 0;
        display: none;
    }

    .user-name {
        color: white;
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-role {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.8rem;
        margin: 0;
    }

    .sidebar-nav {
        padding: 20px 0;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 5px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s;
        position: relative;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: var(--primary-color);
        transition: height 0.3s;
        border-radius: 0 4px 4px 0;
    }

    .nav-link:hover,
    .nav-link.active {
        background: rgba(67, 97, 238, 0.1);
        color: white;
    }

    .nav-link:hover::before,
    .nav-link.active::before {
        height: 70%;
    }

    .nav-link i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .nav-text {
        white-space: nowrap;
        transition: opacity var(--transition-speed);
    }

    .modern-sidebar.collapsed .nav-text {
        opacity: 0;
        display: none;
    }

    .logout-link {
        color: var(--danger-color) !important;
    }

    .logout-link:hover {
        background: rgba(239, 71, 111, 0.1) !important;
    }

    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: auto;
    }

    .visit-site-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px;
        background: rgba(67, 97, 238, 0.2);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .visit-site-btn:hover {
        background: rgba(67, 97, 238, 0.3);
        color: white;
    }

    .modern-sidebar.collapsed .visit-site-btn span {
        display: none;
    }

    /* Header Styles */
    .modern-header {
        position: fixed;
        top: 0;
        left: var(--sidebar-width);
        right: 0;
        height: var(--header-height);
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: left var(--transition-speed);
        z-index: 999;
    }

    .modern-sidebar.collapsed~.modern-header {
        left: var(--sidebar-collapsed-width);
    }

    .header-content {
        height: 100%;
        padding: 0 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--dark-color);
        cursor: pointer;
    }

    .header-search {
        flex: 1;
        max-width: 400px;
        position: relative;
        margin: 0 20px;
    }

    .header-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .header-search input {
        width: 100%;
        padding: 10px 15px 10px 45px;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        outline: none;
        transition: all 0.3s;
    }

    .header-search input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .action-item {
        position: relative;
        cursor: pointer;
    }

    .action-item i {
        font-size: 1.3rem;
        color: var(--dark-color);
        transition: color 0.3s;
    }

    .action-item:hover i {
        color: var(--primary-color);
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }

    .user-dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 10px;
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s;
    }

    .user-dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: var(--dark-color);
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.3s;
    }

    .dropdown-menu a:hover {
        background: rgba(67, 97, 238, 0.1);
    }

    /* Main Content Area */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-top: var(--header-height);
        padding: 25px;
        min-height: calc(100vh - var(--header-height));
        transition: margin-left var(--transition-speed);
    }

    .modern-sidebar.collapsed~.main-content {
        margin-left: var(--sidebar-collapsed-width);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-sidebar {
            transform: translateX(-100%);
        }

        .modern-sidebar.active {
            transform: translateX(0);
        }

        .modern-header {
            left: 0 !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding: 15px;
        }

        .mobile-toggle {
            display: block;
        }

        .header-search {
            display: none;
        }

        .sidebar-toggle {
            display: none;
        }


    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileToggle');

        // Desktop toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // Mobile toggle
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        // Remember sidebar state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }

        // Active link highlighting
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    });
</script>