<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">CMS Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>Dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">CMS Pages</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <!-- Alert Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Add New Button -->
        <div class="row mb-3">
            <div class="col-12">
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i> Add New Item
                </button>
            </div>
        </div>

        <!-- CMS Pages Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All CMS Pages & Categories</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Parent</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Sort Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($cms_pages)): ?>
                                        <?php foreach ($cms_pages as $page): ?>
                                            <tr>
                                                <td><?= $page->id ?></td>
                                                <td><?= htmlspecialchars($page->page_name) ?></td>
                                                <td>
                                                    <span
                                                        class="badge badge-<?= $page->node_type == 'category' ? 'info' : 'success' ?>">
                                                        <?= ucfirst($page->node_type) ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($page->category) ?></td>
                                                <td>
                                                    <?php if ($page->parent_id): ?>
                                                        <?php
                                                        $parent = $this->Cms_model->get_page_by_id($page->parent_id);
                                                        echo $parent ? htmlspecialchars($parent->page_name) : '-';
                                                        ?>
                                                    <?php else: ?>
                                                        <span class="text-muted">Top Level</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($page->node_type === 'page' && !empty($page->slug)): ?>
                                                        <a href="<?= site_url($page->slug) ?>" target="_blank" class="text-primary">
                                                            <?= htmlspecialchars($page->slug) ?>
                                                            <i class="fa fa-external-link-alt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-<?= $page->status == 'active' ? 'success' : 'secondary' ?>">
                                                        <?= ucfirst($page->status) ?>
                                                    </span>
                                                </td>
                                                <td><?= $page->sort_order ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info edit-btn" data-id="<?= $page->id ?>"
                                                        data-page_name="<?= htmlspecialchars($page->page_name) ?>"
                                                        data-node_type="<?= $page->node_type ?>"
                                                        data-category="<?= htmlspecialchars($page->category) ?>"
                                                        data-parent_id="<?= $page->parent_id ?>"
                                                        data-parent_type="<?= $page->parent_type ?>"
                                                        data-slug="<?= htmlspecialchars($page->slug ?? '') ?>"
                                                        data-hero_title="<?= htmlspecialchars($page->hero_title ?? '') ?>"
                                                        data-hero_description="<?= htmlspecialchars($page->hero_description ?? '') ?>"
                                                        data-content_description="<?= htmlspecialchars($page->content_description ?? '') ?>"
                                                        data-cta_text="<?= htmlspecialchars($page->cta_text ?? '') ?>"
                                                        data-cta_url="<?= htmlspecialchars($page->cta_url ?? '') ?>"
                                                        data-hero_image="<?= htmlspecialchars($page->hero_image ?? '') ?>"
                                                        data-status="<?= $page->status ?>"
                                                        data-sort_order="<?= $page->sort_order ?>" data-toggle="modal"
                                                        data-target="#editModal">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                    <a href="<?= site_url('admin_panel/cms/delete/' . $page->id) ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this item?')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No CMS pages found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php $this->load->view('backend/footer'); ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New CMS Item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= site_url('admin_panel/cms/add') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <!-- Node Type Selection -->
                    <div class="form-group">
                        <label>Item Type <span class="text-danger">*</span></label>
                        <select name="node_type" id="add_node_type" class="form-control" required>
                            <option value="category">Category (Container for other items)</option>
                            <option value="page">Page (Actual content page)</option>
                        </select>
                    </div>

                    <!-- Basic Fields -->
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="page_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Top Level Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="Quick Links" selected>Quick Links</option>
                            <option value="Imported Medicine">Imported Medicine</option>
                            <option value="Best Treatment">Best Treatment</option>
                            <option value="Top Articles">Top Articles</option>
                            <option value="FDA Drug Approvals">FDA Drug Approvals</option>
                            <option value="Latest News">Latest News</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Parent Item</label>
                        <select name="parent_selection" id="add_parent_selection" class="form-control">
                            <option value="none">None (Top Level)</option>
                            <?php foreach ($parent_options as $option): ?>
                                <option value="<?= $option['type'] ?>_<?= $option['id'] ?>">
                                    <?= htmlspecialchars($option['display']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Page-Specific Fields (hidden by default) -->
                    <div id="add_page_fields" style="display:none;">
                        <hr>
                        <h5 class="mb-3">Page Content</h5>

                        <div class="form-group">
                            <label>URL Slug</label>
                            <input type="text" name="slug" class="form-control"
                                placeholder="Leave empty to auto-generate">
                            <small class="form-text text-muted">URL-friendly identifier (e.g., about-us)</small>
                        </div>

                        <div class="form-group">
                            <label>Hero Title</label>
                            <input type="text" name="hero_title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Hero Description</label>
                            <textarea name="hero_description" class="form-control summernote" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Hero Image</label>
                            <input type="file" name="hero_image" class="form-control-file" accept="image/*">
                            <small class="form-text text-muted">Recommended size: 1200x600px</small>
                        </div>

                        <div class="form-group">
                            <label>Main Content</label>
                            <textarea name="content_description" class="form-control summernote" rows="10"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Call-to-Action Text</label>
                                    <input type="text" name="cta_text" class="form-control"
                                        placeholder="e.g., Learn More">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Call-to-Action URL</label>
                                    <input type="text" name="cta_url" class="form-control"
                                        placeholder="e.g., /contact-us">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit CMS Item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <!-- Node Type Selection -->
                    <div class="form-group">
                        <label>Item Type <span class="text-danger">*</span></label>
                        <select name="node_type" id="edit_node_type" class="form-control" required>
                            <option value="category">Category (Container for other items)</option>
                            <option value="page">Page (Actual content page)</option>
                        </select>
                    </div>

                    <!-- Basic Fields -->
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="page_name" id="edit_page_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Top Level Category <span class="text-danger">*</span></label>
                        <select name="category" id="edit_category" class="form-control" required>
                            <!-- <option value="Who We Are">Who We Are</option>
                            <option value="What We Do">What We Do</option>
                            <option value="What We Offer">What We Offer</option>
                            <option value="Patient Safety">Patient Safety</option>
                            <option value="Support">Support</option> -->
                            <!-- <option value="Therapeutics Area">Therapeutics Area</option>
                            <option value="Legal & Documents">Legal & Documents</option>
                            <option value="Resource (Blog Home Page)">Resource (Blog Home Page)</option> -->

                            <option value="Quick Links">Quick Links</option>
                            <option value="Imported Medicines">Imported Medicines</option>
                            <option value="Best Treatment">Best Treatment</option>
                            <option value="Top Articles">Top Articles</option>
                            <option value="FDA Drug Approvals">FDA Drug Approvals</option>
                            <option value="Latest News">Latest News</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Parent Item</label>
                        <select name="parent_selection" id="edit_parent_selection" class="form-control">
                            <option value="none">None (Top Level)</option>
                            <?php foreach ($parent_options as $option): ?>
                                <option value="<?= $option['type'] ?>_<?= $option['id'] ?>">
                                    <?= htmlspecialchars($option['display']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="edit_status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sort Order</label>
                                <input type="number" name="sort_order" id="edit_sort_order" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Page-Specific Fields -->
                    <div id="edit_page_fields" style="display:none;">
                        <hr>
                        <h5 class="mb-3">Page Content</h5>

                        <div class="form-group">
                            <label>URL Slug</label>
                            <input type="text" name="slug" id="edit_slug" class="form-control">
                            <small class="form-text text-muted">URL-friendly identifier</small>
                        </div>

                        <div class="form-group">
                            <label>Hero Title</label>
                            <input type="text" name="hero_title" id="edit_hero_title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Hero Description</label>
                            <textarea name="hero_description" id="edit_hero_description" class="form-control summernote"
                                rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Current Image</label>
                            <div id="edit_current_image"></div>
                        </div>

                        <div class="form-group">
                            <label>Upload New Image (leave empty to keep current)</label>
                            <input type="file" name="hero_image" class="form-control-file" accept="image/*">
                            <small class="form-text text-muted">Recommended size: 1200x600px</small>
                        </div>

                        <div class="form-group">
                            <label>Main Content</label>
                            <textarea name="content_description" id="edit_content_description"
                                class="form-control summernote" rows="10"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Call-to-Action Text</label>
                                    <input type="text" name="cta_text" id="edit_cta_text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Call-to-Action URL</label>
                                    <input type="text" name="cta_url" id="edit_cta_url" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<script>
    $(document).ready(function () {
        // Initialize Summernote
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Add Modal: Toggle page fields based on node type
        $('#add_node_type').on('change', function () {
            if ($(this).val() === 'page') {
                $('#add_page_fields').slideDown();
            } else {
                $('#add_page_fields').slideUp();
            }
        });

        // Edit Modal: Toggle page fields
        $('#edit_node_type').on('change', function () {
            if ($(this).val() === 'page') {
                $('#edit_page_fields').slideDown();
            } else {
                $('#edit_page_fields').slideUp();
            }
        });

        // Edit button click handler
        $('.edit-btn').on('click', function () {
            var id = $(this).data('id');
            var page_name = $(this).data('page_name');
            var node_type = $(this).data('node_type');
            var category = $(this).data('category');
            var parent_id = $(this).data('parent_id');
            var parent_type = $(this).data('parent_type');
            var slug = $(this).data('slug');
            var hero_title = $(this).data('hero_title');
            var hero_description = $(this).data('hero_description');
            var content_description = $(this).data('content_description');
            var cta_text = $(this).data('cta_text');
            var cta_url = $(this).data('cta_url');
            var hero_image = $(this).data('hero_image');
            var status = $(this).data('status');
            var sort_order = $(this).data('sort_order');

            // Set form action
            $('#editForm').attr('action', '<?= site_url("admin_panel/cms/edit/") ?>' + id);

            // Set basic fields
            $('#edit_page_name').val(page_name);
            $('#edit_node_type').val(node_type);
            $('#edit_category').val(category);
            $('#edit_status').val(status);
            $('#edit_sort_order').val(sort_order);

            // Set parent selection
            if (parent_id && parent_type) {
                $('#edit_parent_selection').val(parent_type + '_' + parent_id);
            } else {
                $('#edit_parent_selection').val('none');
            }

            // Show/hide page fields
            if (node_type === 'page') {
                $('#edit_page_fields').show();
                $('#edit_slug').val(slug);
                $('#edit_hero_title').val(hero_title);
                $('#edit_hero_description').summernote('code', hero_description || '');
                $('#edit_content_description').summernote('code', content_description || '');
                $('#edit_cta_text').val(cta_text);
                $('#edit_cta_url').val(cta_url);

                // Display current image
                if (hero_image) {
                    $('#edit_current_image').html('<img src="<?= base_url("assets/images/cms/") ?>' +
                        hero_image + '" class="img-thumbnail" style="max-width: 200px;">');
                } else {
                    $('#edit_current_image').html('<p class="text-muted">No image uploaded</p>');
                }
            } else {
                $('#edit_page_fields').hide();
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>