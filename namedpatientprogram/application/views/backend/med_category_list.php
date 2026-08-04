<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="custom-alert custom-success">
    <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
    <?= $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Med Category</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php
                    if ($this->session->userdata("user_type")) {
                        echo base_url() . "dashboard";
                    } else {
                        echo base_url();
                    } ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Med Category</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;
                <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button class="btn btn-info" data-toggle="modal" data-target="#addMedCategoryModal">
                    <i class="fa fa-plus"></i> Add Med Category
                </button>
                <!-- <p><strong>Selected Categories: <span id="selectedCount">0</span>/20</strong></p> -->
            </div>
        </div>

        <div class="card card-outline-info">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Med Category List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="medCategoryTable" class="display nowrap table table-hover table-striped table-bordered"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th> <!-- NEW -->
                                <th>ID</th>
                                <th>Med Category Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($med_categories)): ?>
                            <?php foreach ($med_categories as $category): ?>
                            <tr>
                                <td><input type="checkbox" class="category-checkbox"></td> <!-- NEW -->
                                <td>
                                    <?= $category->id ?>
                                </td>
                                <td>
                                    <?= $category->name ?>
                                </td>
                                <td>
                                    <?php if (!empty($category->image)): ?>
                                    <img src="<?= base_url("./assets/images/category/" . $category->image) ?>"
                                        width="60" height="50">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= word_limiter($category->description, 5) ?>
                                </td>
                                <td>
                                    <?= $category->slug ?>
                                </td>
                                <td>
                                    <?= $category->status ?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm editMedCategoryBtn"
                                        data-id="<?= $category->id ?>" data-name="<?= $category->name ?>"
                                        data-slug="<?= $category->slug ?>" data-status="<?= $category->status ?>"
                                        data-description="<?= htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8') ?>"
                                        data-image="<?= $category->image ?>">
                                        Edit
                                    </button>

                                    <a href="<?= base_url("admin_panel/med_category/delete/" . $category->id) ?>"
                                        class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Med Category Modal -->
<div class="modal fade" id="addMedCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url("admin_panel/med_category/add") ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>Add Med Category</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><b>Med Category Name</b></label>
                    <input type="text" name="name" id="med_category_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label><b>Slug</b></label>
                    <input type="text" name="slug" id="med_slug" class="form-control" required>
                    <span class="fs-6 text-secondary">allow only letter,hyphen</span>
                </div>

                <div class="form-group">
                    <label><b>Status</b></label>
                    <select name="status" id="med_category_status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><b>Description</b></label>
                    <textarea name="description" id="med_category_description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label><b>Image</b></label>
                    <input type="file" name="image" id="med_category_image" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Add Med Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Med Category Modal -->
<div class="modal fade" id="editMedCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url("admin_panel/med_category/edit") ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <input type="hidden" name="id" id="edit_med_category_id">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Med Category</b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><b>Med Category Name</b></label>
                    <input type="text" name="name" id="edit_med_category_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label><b>Slug</b></label>
                    <input type="text" name="slug" id="edit_med_slug" class="form-control" required>
                    <span class="fs-6 text-secondary">allow only letter,hyphen</span>
                </div>

                <div class="form-group">
                    <label><b>Status</b></label>
                    <select name="status" id="edit_med_category_status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><b>Description</b></label>
                    <textarea name="description" id="edit_med_category_description" class="form-control"
                        required></textarea>
                </div>

                <div class="form-group">
                    <label><b>Current Image</b></label><br>
                    <img id="edit_med_category_current_image" src="" alt="Current Image" width="60"><br><br>
                </div>

                <div class="form-group">
                    <label><b>Change Image</b></label>
                    <input type="file" name="image" id="edit_med_category_image" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update Med Category</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view("backend/footer"); ?>

<script>
setTimeout(function() {
    var alert = document.querySelector('.custom-alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 5000);

$(document).ready(function() {
    $('#medCategoryTable').DataTable({
        "aaSorting": [
            [0, 'desc']
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    // $('.editMedCategoryBtn').on('click', function () {
    //     const id = $(this).data('id');
    //     const name = $(this).data('name');
    //     const slug = $(this).data('slug');
    //     const status = $(this).data('status');
    //     const description = $(this).data('description');
    //     const image = $(this).data('image');

    //     $('#edit_med_category_id').val(id);
    //     $('#edit_med_category_name').val(name);
    //     $('#edit_med_slug').val(slug);
    //     $('#edit_med_category_status').val(status.toLowerCase());
    //     $('#edit_med_category_description').val(description);
    //     $('#edit_med_category_current_image')
    //         .attr('src', '<?= base_url("./assets/images/category/") ?>' + image);
    //     $('#editMedCategoryModal form')
    //         .attr('action', '<?= base_url("admin_panel/med_category/edit/") ?>' + id);
    //     $('#editMedCategoryModal').modal('show');
    // });
    $(document).on('click', '.editMedCategoryBtn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const slug = $(this).data('slug');
        const status = $(this).data('status');
        const description = $(this).data('description');
        const image = $(this).data('image');

        $('#edit_med_category_id').val(id);
        $('#edit_med_category_name').val(name);
        $('#edit_med_slug').val(slug);
        $('#edit_med_category_status').val(status.toLowerCase());
        $('#edit_med_category_description').val(description);

        $('#edit_med_category_current_image')
            .attr('src', '<?= base_url("./assets/images/category/") ?>' + image);

        $('#editMedCategoryModal form')
            .attr('action', '<?= base_url("admin_panel/med_category/edit/") ?>' + id);
        $('#editMedCategoryModal').modal('show');
    });

    // Simple validation (optional)
    $('form[action*="admin_panel/med_category/add"]').on('submit', function(e) {
        var isValid = true;
        var name = $('#med_category_name').val().trim();
        var slug = $('#med_slug').val().trim();
        var desc = $('#med_category_description').val().trim();
        var image = $('#med_category_image').val().trim();

        if (!name || !desc || !image || !slug) {
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });

    $('form[action*="admin_panel/med_category/edit"]').on('submit', function(e) {
        var isValid = true;
        var name = $('#edit_med_category_name').val().trim();
        var slug = $('#edit_med_slug').val().trim();
        var desc = $('#edit_med_category_description').val().trim();

        if (!name || !desc || !slug) {
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });
});
</script>
<!-- <script>
    let maxSelection = 20;

    $(document).ready(function() {

        function updateCount() {
            let count = $(".category-checkbox:checked").length;
            $("#selectedCount").text(count);
            return count;
        }

        $(".category-checkbox").on("change", function() {
            let count = updateCount();

            if (count > maxSelection) {
                alert("You can select only " + maxSelection + " categories.");
                $(this).prop("checked", false);
                updateCount();
            }
        });

        $("#selectAll").on("change", function() {
            if (this.checked) {
                $(".category-checkbox").prop("checked", true);
                let count = updateCount();
                if (count > maxSelection) {
                    alert("You can select only " + maxSelection + " categories.");
                    $(".category-checkbox").prop("checked", false);
                    updateCount();
                }
            } else {
                $(".category-checkbox").prop("checked", false);
                updateCount();
            }
        });

    });
</script> -->