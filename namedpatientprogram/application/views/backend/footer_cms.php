<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>

<div class="page-wrapper">

    <div class="container-fluid pt-4">

        <!-- ALERTS -->

        <?php if ($this->session->flashdata('success')): ?>

            <div class="alert alert-success">

                <?= $this->session->flashdata('success') ?>

            </div>

        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">

                <?= $this->session->flashdata('error') ?>

            </div>

        <?php endif; ?>

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Footer CMS
            </h3>

            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">

                <i class="fa fa-plus"></i>
                Add Footer Page

            </button>

        </div>

        <!-- TABLE -->

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Page Name</th>

                                <th>Category</th>

                                <th>Slug</th>

                                <th>Status</th>

                                <th>Sort Order</th>

                                <th width="180">Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($pages)): ?>

                                <?php foreach ($pages as $page): ?>

                                    <tr>

                                        <td>
                                            <?= $page->id ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($page->page_name) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($page->category_name) ?>
                                        </td>

                                        <td>

                                            <a href="<?= site_url('footer/' . $page->slug) ?>" target="_blank">

                                                <?= htmlspecialchars($page->slug) ?>

                                            </a>

                                        </td>

                                        <td>

                                            <span class="badge badge-<?= $page->status == 'active' ? 'success' : 'danger' ?>">

                                                <?= ucfirst($page->status) ?>

                                            </span>

                                        </td>

                                        <td>
                                            <?= $page->sort_order ?>
                                        </td>

                                        <td>

                                            <a href="<?= site_url('admin_panel/FooterCms/delete/' . $page->id) ?>"
                                                class="btn btn-danger btn-sm" onclick="return confirm('Delete this page?')">

                                                <i class="fa fa-trash"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td colspan="7" class="text-center">

                                        No footer pages found

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ADD MODAL -->

<div class="modal fade" id="addModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Add Footer Page

                </h5>

                <button type="button" class="close" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form action="<?= site_url('admin_panel/FooterCms/add') ?>" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <!-- CATEGORY -->

                    <div class="form-group">

                        <label>
                            Footer Category
                        </label>

                        <select name="category_id" class="form-control" required>

                            <option value="">
                                Select Category
                            </option>

                            <?php foreach ($categories as $category): ?>

                                <option value="<?= $category->id ?>">

                                    <?= htmlspecialchars($category->category_name) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <!-- PAGE NAME -->

                    <div class="form-group">

                        <label>
                            Page Name
                        </label>

                        <input type="text" name="page_name" class="form-control" required>

                    </div>

                    <!-- SLUG -->

                    <div class="form-group">

                        <label>
                            Slug
                        </label>

                        <input type="text" name="slug" class="form-control" placeholder="example-page" required>

                    </div>

                    <!-- SHORT DESCRIPTION -->

                    <div class="form-group">

                        <label>
                            Short Description
                        </label>

                        <textarea name="short_description" class="form-control" rows="3"></textarea>

                    </div>

                    <!-- CONTENT -->

                    <div class="form-group">

                        <label>
                            Page Content
                        </label>

                        <textarea name="content" class="form-control summernote"></textarea>

                    </div>

                    <!-- IMAGE -->

                    <div class="form-group">

                        <label>
                            Featured Image
                        </label>

                        <input type="file" name="featured_image" class="form-control-file">
                    </div>

                    <!-- STATUS -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Status
                                </label>

                                <select name="status" class="form-control">

                                    <option value="active">
                                        Active
                                    </option>

                                    <option value="inactive">
                                        Inactive
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Sort Order
                                </label>

                                <input type="number" name="sort_order" class="form-control" value="0">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Save Page

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- SUMMERNOTE LITE -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js">
</script>

<script>

    $(document).ready(function () {

        $('.summernote').summernote({

            height: 250,

            placeholder: 'Write content here...'

        });

});
</script>

<?php $this->load->view('backend/footer'); ?>