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
            <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Category</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php if (
                                                            $this->session->userdata("user_type")
                                                        ) {
                                                            echo base_url() . "dashboard";
                                                        } else {
                                                            echo base_url();
                                                        } ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Category</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp; <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit
                        Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button class="btn btn-info" data-toggle="modal" data-target="#addCategoryModal"><i
                        class="fa fa-plus"></i> Add Category</button>
            </div>
        </div>

        <div class="card card-outline-info">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Category List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="categoryTable" class="display nowrap table table-hover table-striped table-bordered"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category->id ?></td>
                                    <td><?= $category->name ?></td>
                                    <td><?= $category->status ?></td>
                                    <td>
                                        <button class="btn btn-info btn-sm editCategoryBtn" data-id="<?= $category->id ?>"
                                            data-name="<?= $category->name ?>" data-status="<?= $category->status ?>">
                                            Edit
                                        </button>

                                        <a href="<?= base_url(
                                                        "admin_panel/category/delete/" . $category->id
                                                    ) ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url(
                            "admin_panel/category/add"
                        ) ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>Add Category</b></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="category_name"><b>Category Name</b></label>
                    <input type="text" name="name" id="category_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category_status"><b>Status</b></label>
                    <select name="status" id="category_status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- <div class="form-group">
                    <label for="category_description"><b>Description</b></label>
                    <textarea name="description" id="category_description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="category_image"><b>Image</b></label>
                    <input type="file" name="image" id="category_image" class="form-control" required>
                </div> -->
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Add Category</button>
            </div>
        </form>
    </div>
</div>


<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url(
                            "admin_panel/category/edit"
                        ) . $category->id ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="id" id="edit_category_id">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Category</b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_category_name"><b>Category Name</b></label>
                    <input type="text" name="name" id="edit_category_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="edit_category_status"><b>Status</b></label>
                    <select name="status" id="edit_category_status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- <div class="form-group">
                    <label for="edit_category_description"><b>Description</b></label>
                    <textarea name="description" id="edit_category_description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label><b>Current Image</b></label><br>
                    <img id="edit_category_current_image" src="" alt="Current Image" width="60"><br><br>
                </div> -->

                <!-- <div class="form-group">
                    <label for="edit_category_image"><b>Change Image</b></label>
                    <input type="file" name="image" id="edit_category_image" class="form-control">
                </div> -->
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update Category</button>
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

    // Add Category Validation
    $('form[action*="admin_panel/category/add"]').on('submit', function(e) {
        let valid = true;
        const name = $('#category_name').val().trim();
        // const description = $('#category_description').val().trim();

        if (!name) {
            $('#name_error').show();
            valid = false;
        } else {
            $('#name_error').hide();
        }

        if (!description) {
            $('#description_error').show();
            valid = false;
        } else {
            $('#description_error').hide();
        }

        if (!valid) {
            e.preventDefault(); // Form submit roke
        }
    });

    // Edit Category Validation
    $('form[action*="admin_panel/category/edit"]').on('submit', function(e) {
        let valid = true;
        const name = $('#edit_category_name').val().trim();
        // const description = $('#edit_category_description').val().trim();

        if (!name) {
            $('#edit_name_error').show();
            valid = false;
        } else {
            $('#edit_name_error').hide();
        }

        // if (!description) {
        //     $('#edit_description_error').show();
        //     valid = false;
        // } else {
        //     $('#edit_description_error').hide();
        // }

        if (!valid) {
            e.preventDefault(); // Form submit roke
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Form validation for Add Category
        $('form[action*="admin_panel/Category/add"]').on('submit', function(e) {
            var isValid = true;

            var name = $('#category_name');
            // var desc = $('#category_description');
            // var image = $('#category_image');

            // Name Validation
            if ($.trim(name.val()) === '') {
                name.addClass('is-invalid');
                if (name.next('.invalid-feedback').length === 0) {
                    name.after('<div class="invalid-feedback"></div>');
                }
                isValid = false;
            } else {
                name.removeClass('is-invalid');
                name.next('.invalid-feedback').remove();
            }

            // Description Validation
            if ($.trim(desc.val()) === '') {
                desc.addClass('is-invalid');
                if (desc.next('.invalid-feedback').length === 0) {
                    desc.after('<div class="invalid-feedback"> </div>');
                }
                isValid = false;
            } else {
                desc.removeClass('is-invalid');
                desc.next('.invalid-feedback').remove();
            }

            // Image Validation
            if ($.trim(image.val()) === '') {
                image.addClass('is-invalid');
                if (image.next('.invalid-feedback').length === 0) {
                    image.after('<div class="invalid-feedback"></div>');
                }
                isValid = false;
            } else {
                image.removeClass('is-invalid');
                image.next('.invalid-feedback').remove();
            }

            if (!isValid) e.preventDefault();
        });

        // Form validation for Edit Category
        $('form[action*="admin_panel/category/edit"]').on('submit', function(e) {
            var isValid = true;

            var name = $('#edit_category_name');
            // var desc = $('#edit_category_description');

            // Name Validation
            if ($.trim(name.val()) === '') {
                name.addClass('is-invalid');
                if (name.next('.invalid-feedback').length === 0) {
                    name.after('<div class="invalid-feedback">Category Name is required.</div>');
                }
                isValid = false;
            } else {
                name.removeClass('is-invalid');
                name.next('.invalid-feedback').remove();
            }

            // Description Validation
            // if ($.trim(desc.val()) === '') {
            //     desc.addClass('is-invalid');
            //     if (desc.next('.invalid-feedback').length === 0) {
            //         desc.after('<div class="invalid-feedback">Description is required.</div>');
            //     }
            //     isValid = false;
            // } else {
            //     desc.removeClass('is-invalid');
            //     desc.next('.invalid-feedback').remove();
            // }

            // Image is optional in edit, no validation required

            if (!isValid) e.preventDefault();
        });
    });
</script>




<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable({
            "aaSorting": [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        $('.editCategoryBtn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const status = $(this).data('status');
            // const description = $(this).data('description');
            const image = $(this).data('image');

            $('#edit_category_id').val(id);
            $('#edit_category_name').val(name);
            $('#edit_category_status').val(status.toLowerCase());
            // $('#edit_category_description').val(description);
            $('#edit_category_current_image').attr('src', '<?= base_url("./assets/images/category/") ?>' +
                image);
            $('#editCategoryModal form').attr('action', '<?= base_url("admin_panel/category/edit/") ?>' +
                id);
            $('#editCategoryModal').modal('show');
        });

    });
</script>