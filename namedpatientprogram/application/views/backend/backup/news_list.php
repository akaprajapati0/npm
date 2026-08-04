<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-newspaper"></i>
                News & Blog Management
            </h1>
            <p class="page-subtitle">Manage all news articles and blog posts</p>
        </div>
        <div class="header-right">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewsModal">
                <i class="fas fa-plus"></i> Add News
            </button>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="custom-alert custom-success">
            <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="custom-alert custom-danger">
            <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <!-- News Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-table"></i> All News Articles
            </h5>
            <div>
                <button id="toggleHomeSelectBtn" class="btn btn-sm btn-warning">
                    <i class="fas fa-home"></i> Select Homepage News
                </button>
                <button id="saveHomeSelectionBtn" class="btn btn-sm btn-success d-none">
                    <i class="fas fa-save"></i> Save Selection
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="newsTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="home-col d-none" style="width: 50px;">
                                <input type="checkbox" id="selectAllHome">
                            </th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $item): ?>
                            <tr>
                                <td class="home-col d-none text-center">
                                    <input type="checkbox" class="home-checkbox form-check-input" value="<?= $item->id ?>"
                                        <?= !empty($item->show_on_home) && $item->show_on_home == 1 ? 'checked' : '' ?>>
                                </td>
                                <td><strong>#<?= $item->id ?></strong></td>
                                <td>
                                    <img src="<?= base_url('./assets/images/news/' . $item->image) ?>"
                                        alt="<?= $item->name ?>" class="table-img">
                                </td>
                                <td><strong><?= word_limiter($item->name, 8) ?></strong></td>
                                <td><span class="badge bg-primary"><?= $item->category_name ?></span></td>
                                <td><?= $item->author_name ?? 'Admin' ?></td>
                                <td>
                                    <?php if ($item->status == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-success viewBtn" data-bs-toggle="modal"
                                            data-bs-target="#viewNewsModal" data-id="<?= $item->id ?>"
                                            data-name="<?= htmlspecialchars($item->name) ?>"
                                            data-category="<?= htmlspecialchars($item->category_name) ?>"
                                            data-description="<?= htmlspecialchars($item->description) ?>"
                                            data-image="<?= base_url('assets/images/news/' . $item->image) ?>" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info editBtn" data-bs-toggle="modal"
                                            data-bs-target="#editNewsModal" data-id="<?= $item->id ?>"
                                            data-name="<?= htmlspecialchars($item->name) ?>"
                                            data-category_id="<?= $item->category_id ?>"
                                            data-description="<?= htmlspecialchars($item->description) ?>"
                                            data-author_name="<?= htmlspecialchars($item->author_name) ?>"
                                            data-status="<?= $item->status ?>"
                                            data-image="<?= base_url('assets/images/news/' . $item->image) ?>" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('news/delete/' . $item->id) ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this news?')"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('admin_panel/news/insert') ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> Add New News Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required minlength="3" maxlength="120">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="author_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="in-active">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="description" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Save News
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View News Modal -->
<div class="modal fade" id="viewNewsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye"></i> News Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="view_image" src="" alt="News Image" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                <h4 id="view_name"></h4>
                <p><strong>Category:</strong> <span id="view_category" class="badge bg-primary"></span></p>
                <div id="view_description" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('admin_panel/news/update') ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Edit News Article
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="edit_category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="author_name" id="edit_author_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="edit_status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="in-active">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea id="edit_summernote" name="description" required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Current Image</label>
                        <div class="mb-2">
                            <img id="currentImagePreview" src="" alt="Current" class="preview-img">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Update News
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .table-img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-img {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .home-checkbox {
        width: 20px !important;
        height: 20px !important;
        cursor: pointer;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize Summernote
        $('#summernote, #edit_summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // Initialize DataTable
        $('#newsTable').DataTable({
            order: [
                [1, 'desc']
            ],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search news..."
            }
        });

        // Toggle home selection
        $('#toggleHomeSelectBtn').on('click', function() {
            $('.home-col').toggleClass('d-none');
            $('#saveHomeSelectionBtn').toggleClass('d-none');
        });

        // Limit selection to 3
        $(document).on('change', '.home-checkbox', function() {
            if ($('.home-checkbox:checked').length > 3) {
                this.checked = false;
                alert('You can select maximum 3 news items for homepage.');
            }
        });

        // Save home selection
        $('#saveHomeSelectionBtn').on('click', function() {
            const ids = $('.home-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            $.ajax({
                url: '<?= base_url("admin_panel/news/save_home"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    ids: ids
                },
                success: function(res) {
                    alert(res.msg);
                    if (res.status === 'success') {
                        location.reload();
                    }
                }
            });
        });

        // View button
        $('.viewBtn').on('click', function() {
            $('#view_name').text($(this).data('name'));
            $('#view_category').text($(this).data('category'));
            $('#view_description').html($(this).data('description'));
            $('#view_image').attr('src', $(this).data('image'));
        });

        // Edit button
        $('.editBtn').on('click', function() {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_category_id').val($(this).data('category_id'));
            $('#edit_author_name').val($(this).data('author_name'));
            $('#edit_status').val($(this).data('status'));
            $('#edit_summernote').summernote('code', $(this).data('description'));
            $('#currentImagePreview').attr('src', $(this).data('image'));
        });
    });
</script>

<?php $this->load->view("backend/footer"); ?>