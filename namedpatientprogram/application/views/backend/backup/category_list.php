<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-list"></i>
                Category Management
            </h1>
            <p class="page-subtitle">Manage all news and blog categories</p>
        </div>
        <div class="header-right">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus"></i> Add Category
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

    <!-- Category Table Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-table"></i> All Categories
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="categoryTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><strong>#<?= $category->id ?></strong></td>
                                <td>
                                    <img src="<?= base_url('./assets/images/category/' . $category->image) ?>"
                                        alt="<?= $category->name ?>" class="table-img">
                                </td>
                                <td><strong><?= $category->name ?></strong></td>
                                <td><?= word_limiter($category->description, 10) ?></td>
                                <td>
                                    <?php if ($category->status == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-info editCategoryBtn" data-id="<?= $category->id ?>"
                                            data-name="<?= $category->name ?>" data-status="<?= $category->status ?>"
                                            data-description="<?= htmlspecialchars($category->description) ?>"
                                            data-image="<?= $category->image ?>" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="<?= base_url('admin_panel/category/delete/' . $category->id) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this category?')"
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="addCategoryForm" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required minlength="3" maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required minlength="10"
                            maxlength="255"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Accepted formats: JPG, PNG, GIF, WebP, AVIF (Max: 20MB)</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="editCategoryForm" method="post" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="id" id="edit_category_id">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_category_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="edit_category_status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="edit_category_description" class="form-control" rows="3"
                            required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Current Image</label>
                        <div class="mb-2">
                            <img id="edit_category_current_image" src="" alt="Current" class="preview-img">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .table-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-img {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-group {
        gap: 5px;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#categoryTable').DataTable({
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories..."
            }
        });

        // Add Category Form Submit
        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= base_url("admin_panel/category/add") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loadingSpinner').show();
                },
                success: function(response) {
                    $('#loadingSpinner').hide();
                    $('#addCategoryModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide();
                    alert('Error: ' + error);
                }
            });
        });

        // Edit Category Button Click
        $('.editCategoryBtn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const status = $(this).data('status');
            const description = $(this).data('description');
            const image = $(this).data('image');

            $('#edit_category_id').val(id);
            $('#edit_category_name').val(name);
            $('#edit_category_status').val(status);
            $('#edit_category_description').val(description);
            $('#edit_category_current_image').attr('src', '<?= base_url("./assets/images/category/") ?>' +
                image);
            $('#editCategoryForm').attr('action', '<?= base_url("admin_panel/category/edit/") ?>' + id);

            $('#editCategoryModal').modal('show');
        });

        // Edit Category Form Submit
        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const actionUrl = $(this).attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#loadingSpinner').show();
                },
                success: function(response) {
                    $('#loadingSpinner').hide();
                    $('#editCategoryModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide();
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>

<?php $this->load->view("backend/footer"); ?>