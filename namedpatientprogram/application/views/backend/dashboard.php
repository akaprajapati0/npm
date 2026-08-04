<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="page-wrapper">
    <div class="message"></div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-th-large page-title-icon"></i>
                    Dashboard
                </h1>
                <p class="page-subtitle">Welcome to Ikris Pharma Network Admin Panel</p>
            </div>
            <div class="page-header-actions">
                <!-- <span class="badge-time">
                    <i class="far fa-clock"></i>
                    <?php echo $curr_date_time; ?>
                </span> -->
                <a href="<?php echo base_url(); ?>" target="_blank" class="btn-visit-site">
                    <i class="fas fa-external-link-alt"></i>
                    Visit Website
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-number"><?php echo $category_count; ?></div>
                        <div class="stat-card-label">Categories</div>
                        <div class="stat-card-progress">
                            <div class="progress-bar" style="width: 75%;"></div>
                        </div>
                    </div>
                    <a href="<?php echo base_url("admin_panel/category"); ?>" class="stat-card-footer">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-number"><?php echo $news_count; ?></div>
                        <div class="stat-card-label">News & Articles</div>
                        <div class="stat-card-progress">
                            <div class="progress-bar" style="width: 60%;"></div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>admin_panel/News" class="stat-card-footer">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-number"><?php echo $patent_medicine_count; ?></div>
                        <div class="stat-card-label">Patent Medicines</div>
                        <div class="stat-card-progress">
                            <div class="progress-bar" style="width: 90%;"></div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>admin_panel/Patent_Medicines" class="stat-card-footer">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-icon">
                        <i class="fas fa-capsules"></i>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-number"><?php echo $med_category_count; ?></div>
                        <div class="stat-card-label">Medicine Categories</div>
                        <div class="stat-card-progress">
                            <div class="progress-bar" style="width: 85%;"></div>
                        </div>
                    </div>
                    <a href="<?php echo base_url("admin_panel/med_category"); ?>" class="stat-card-footer">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-card-body">
                        <div class="stat-card-number"><?php echo $footer_links_count; ?></div>
                        <div class="stat-card-label">Footer Links</div>
                        <div class="stat-card-progress">
                            <div class="progress-bar" style="width: 70%;"></div>
                        </div>
                    </div>
                    <a href="<?php echo base_url("admin_panel/footer_links"); ?>" class="stat-card-footer">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>



        <!-- Quick Actions -->
        <!-- <div class="row mt-4">
            <div class="col-12">
                <div class="card pharma-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo base_url("admin_panel/category"); ?>" class="quick-action-card">
                                    <div class="quick-action-icon"
                                        style="background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);">
                                        <i class="fas fa-folder-plus"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <h3>Manage Categories</h3>
                                        <p>Add & organize content categories</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo base_url(); ?>admin_panel/News" class="quick-action-card">
                                    <div class="quick-action-icon"
                                        style="background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <h3>Publish News</h3>
                                        <p>Create & manage articles</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo base_url(); ?>admin_panel/Patent_Medicines"
                                    class="quick-action-card">
                                    <div class="quick-action-icon"
                                        style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                        <i class="fas fa-prescription-bottle-alt"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <h3>Add Medicine</h3>
                                        <p>Register new patent medicines</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="<?php echo base_url("settings/Settings"); ?>" class="quick-action-card">
                                    <div class="quick-action-icon"
                                        style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="quick-action-content">
                                        <h3>Settings</h3>
                                        <p>Configure system preferences</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

        <style>
            /* ========================================
       PHARMACEUTICAL DASHBOARD STYLING
    ======================================== */

            /* Page Header */
            .page-header {
                background: var(--pharma-white);
                border-radius: var(--radius-lg);
                padding: var(--space-6);
                margin-bottom: var(--space-6);
                box-shadow: var(--shadow-sm);
            }

            .page-header-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: var(--space-4);
            }

            .page-title {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                margin: 0;
                font-size: var(--font-size-3xl);
                font-weight: 700;
                color: var(--pharma-gray-900);
            }

            .page-title-icon {
                color: var(--pharma-primary);
            }

            .page-subtitle {
                margin: var(--space-2) 0 0 0;
                font-size: var(--font-size-base);
                color: var(--pharma-gray-600);
            }

            .page-header-actions {
                display: flex;
                align-items: center;
                gap: var(--space-3);
            }

            .badge-time {
                display: inline-flex;
                align-items: center;
                gap: var(--space-2);
                padding: var(--space-2) var(--space-4);
                background: var(--pharma-gray-100);
                color: var(--pharma-gray-700);
                border-radius: var(--radius-md);
                font-size: var(--font-size-sm);
                font-weight: 500;
            }

            .btn-visit-site {
                display: inline-flex;
                align-items: center;
                gap: var(--space-2);
                padding: var(--space-3) var(--space-5);
                background: var(--pharma-primary);
                color: var(--pharma-white);
                border-radius: var(--radius-md);
                text-decoration: none;
                font-size: var(--font-size-sm);
                font-weight: 600;
                transition: all var(--transition-base);
            }

            .btn-visit-site:hover {
                background: var(--pharma-primary-dark);
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            /* Statistics Cards */
            .stat-card {
                background: var(--pharma-white);
                border-radius: var(--radius-lg);
                overflow: hidden;
                box-shadow: var(--shadow-sm);
                transition: all var(--transition-slow);
                height: 100%;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-lg);
            }

            .stat-card-icon {
                padding: var(--space-5);
                font-size: 40px;
                color: var(--pharma-white);
                text-align: center;
            }

            .stat-card-primary .stat-card-icon {
                background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
            }

            .stat-card-info .stat-card-icon {
                background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
            }

            .stat-card-success .stat-card-icon {
                background: linear-gradient(135deg, #059669 0%, #047857 100%);
            }

            .stat-card-warning .stat-card-icon {
                background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            }

            .stat-card-body {
                padding: var(--space-5);
            }

            .stat-card-number {
                font-size: 36px;
                font-weight: 700;
                color: var(--pharma-gray-900);
                margin-bottom: var(--space-2);
                line-height: 1;
            }

            .stat-card-label {
                font-size: var(--font-size-sm);
                color: var(--pharma-gray-600);
                font-weight: 500;
                margin-bottom: var(--space-4);
            }

            .stat-card-progress {
                height: 4px;
                background: var(--pharma-gray-200);
                border-radius: var(--radius-full);
                overflow: hidden;
            }

            .stat-card-progress .progress-bar {
                height: 100%;
                background: var(--pharma-primary);
                border-radius: var(--radius-full);
                transition: width var(--transition-slow);
            }

            .stat-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: var(--space-3) var(--space-5);
                background: var(--pharma-gray-50);
                color: var(--pharma-primary);
                text-decoration: none;
                font-size: var(--font-size-sm);
                font-weight: 600;
                transition: all var(--transition-base);
            }

            .stat-card-footer:hover {
                background: var(--pharma-primary);
                color: var(--pharma-white);
            }

            /* Pharmaceutical Card */
            .pharma-card {
                background: var(--pharma-white);
                border: none;
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
            }

            .pharma-card .card-header {
                background: linear-gradient(135deg, var(--pharma-primary) 0%, var(--pharma-secondary) 100%);
                border: none;
                padding: var(--space-5);
            }

            .pharma-card .card-title {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                margin: 0;
                font-size: var(--font-size-xl);
                font-weight: 600;
                color: var(--pharma-white);
            }

            .pharma-card .card-body {
                padding: var(--space-6);
            }

            /* Quick Action Cards */
            .quick-action-card {
                display: block;
                background: var(--pharma-white);
                border: 2px solid var(--pharma-gray-200);
                border-radius: var(--radius-lg);
                padding: var(--space-5);
                text-decoration: none;
                transition: all var(--transition-base);
                height: 100%;
            }

            .quick-action-card:hover {
                border-color: var(--pharma-primary);
                transform: translateY(-4px);
                box-shadow: var(--shadow-lg);
            }

            .quick-action-icon {
                width: 56px;
                height: 56px;
                border-radius: var(--radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: var(--space-4);
            }

            .quick-action-icon i {
                font-size: 24px;
                color: var(--pharma-white);
            }

            .quick-action-content h3 {
                margin: 0 0 var(--space-2) 0;
                font-size: var(--font-size-lg);
                font-weight: 600;
                color: var(--pharma-gray-900);
            }

            .quick-action-content p {
                margin: 0;
                font-size: var(--font-size-sm);
                color: var(--pharma-gray-600);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .page-header-content {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .page-title {
                    font-size: var(--font-size-2xl);
                }

                .page-header-actions {
                    width: 100%;
                    justify-content: flex-start;
                }

                .stat-card-number {
                    font-size: 28px;
                }
            }
        </style>

        <?php $this->load->view("backend/footer"); ?>