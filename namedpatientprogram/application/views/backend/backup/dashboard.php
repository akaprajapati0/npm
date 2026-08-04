<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-chart-line"></i>
                Dashboard Overview
            </h1>
            <p class="page-subtitle">Welcome back! Here's what's happening with your platform today.</p>
        </div>
        <div class="header-right">
            <div class="date-display">
                <i class="far fa-calendar-alt"></i>
                <span id="currentDateTime"><?php echo date('l, F d, Y - H:i:s'); ?></span>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Category Card -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card card-gradient-1">
                <div class="stats-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number"><?php echo $category_count; ?></h3>
                    <p class="stats-label">Categories</p>
                </div>
                <div class="stats-footer">
                    <a href="<?php echo base_url('admin_panel/category'); ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- News Card -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card card-gradient-2">
                <div class="stats-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number"><?php echo $news_count; ?></h3>
                    <p class="stats-label">News/Blog Posts</p>
                </div>
                <div class="stats-footer">
                    <a href="<?php echo base_url('admin_panel/News'); ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Patent Medicines Card -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card card-gradient-3">
                <div class="stats-icon">
                    <i class="fas fa-pills"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number"><?php echo $patent_medicine_count; ?></h3>
                    <p class="stats-label">Patent Medicines</p>
                </div>
                <div class="stats-footer">
                    <a href="<?php echo base_url('admin_panel/Patent_Medicines'); ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Med Categories Card -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stats-card card-gradient-4">
                <div class="stats-icon">
                    <i class="fas fa-capsules"></i>
                </div>
                <div class="stats-info">
                    <h3 class="stats-number"><?php echo $med_category_count; ?></h3>
                    <p class="stats-label">Med Categories</p>
                </div>
                <div class="stats-footer">
                    <a href="<?php echo base_url('admin_panel/med_category'); ?>">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <!-- <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="quick-actions-grid">
                        <a href="<?php echo base_url('admin_panel/category'); ?>" class="quick-action-btn">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Category</span>
                        </a>
                        <a href="<?php echo base_url('admin_panel/News'); ?>" class="quick-action-btn">
                            <i class="fas fa-file-alt"></i>
                            <span>Add News</span>
                        </a>
                        <a href="<?php echo base_url('admin_panel/Patent_Medicines'); ?>" class="quick-action-btn">
                            <i class="fas fa-prescription-bottle"></i>
                            <span>Add Medicine</span>
                        </a>
                        <a href="<?php echo base_url('admin_panel/med_category'); ?>" class="quick-action-btn">
                            <i class="fas fa-layer-group"></i>
                            <span>Add Med Category</span>
                        </a>
                        <a href="<?php echo base_url('settings/Settings'); ?>" class="quick-action-btn">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <a href="<?php echo base_url(); ?>" target="_blank" class="quick-action-btn">
                            <i class="fas fa-globe"></i>
                            <span>Visit Website</span>
                        </a>
                    </div>
                </div>
            </div>
        </div> -->

    <!-- System Info -->
    <!-- <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> System Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="system-info-list">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-server"></i> Platform
                            </span>
                            <span class="info-value">Ikris Pharma Network</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-code-branch"></i> Version
                            </span>
                            <span class="info-value">v2.0.0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-database"></i> Database
                            </span>
                            <span class="info-value badge bg-success">Connected</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-shield-alt"></i> Security
                            </span>
                            <span class="info-value badge bg-success">Active</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-clock"></i> Last Updated
                            </span>
                            <span class="info-value"><?php echo date('Y-m-d H:i:s'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Recent Activity Timeline -->
    <!-- <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Activity Overview
                    </h5>
                    <button class="btn btn-sm btn-info">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>System Status</h6>
                                <p>All systems operational and running smoothly</p>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> Just now
                                </small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6>Database Connection</h6>
                                <p>Successfully connected to the database</p>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> 2 minutes ago
                                </small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6>Login Activity</h6>
                                <p>Admin logged in from AlÄ«garh, Uttar Pradesh, IN</p>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> 5 minutes ago
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

    <style>
        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            color: var(--primary-color);
        }

        .page-subtitle {
            color: #64748b;
            margin: 8px 0 0 0;
            font-size: 0.95rem;
        }

        .date-display {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-weight: 500;
        }

        .date-display i {
            color: var(--primary-color);
        }

        /* Statistics Cards */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .card-gradient-1::before {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .card-gradient-2::before {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
        }

        .card-gradient-3::before {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .card-gradient-4::before {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(67, 97, 238, 0.2));
        }

        .card-gradient-1 .stats-icon {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.2));
        }

        .card-gradient-2 .stats-icon {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1), rgba(245, 87, 108, 0.2));
        }

        .card-gradient-3 .stats-icon {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.2));
        }

        .card-gradient-4 .stats-icon {
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1), rgba(56, 249, 215, 0.2));
        }

        .stats-icon i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .card-gradient-1 .stats-icon i {
            color: #667eea;
        }

        .card-gradient-2 .stats-icon i {
            color: #f5576c;
        }

        .card-gradient-3 .stats-icon i {
            color: #00f2fe;
        }

        .card-gradient-4 .stats-icon i {
            color: #43e97b;
        }

        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0;
        }

        .stats-label {
            color: #64748b;
            font-size: 0.95rem;
            margin: 5px 0 0 0;
        }

        .stats-footer {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .stats-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .stats-footer a:hover {
            gap: 10px;
            color: var(--secondary-color);
        }


        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .stats-number {
                font-size: 1.8rem;
            }
        }
    </style>

    <script>
        // Update time every second
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const dateTimeString = now.toLocaleDateString('en-US', options);
            const element = document.getElementById('currentDateTime');
            if (element) {
                element.textContent = dateTimeString;
            }
        }

        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <?php $this->load->view("backend/footer"); ?>