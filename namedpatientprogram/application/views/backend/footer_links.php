<?php
$this->load->view('backend/header');
$this->load->view('backend/sidebar');
?>

<div class="page-wrapper">

    <div class="container-fluid pt-4">

        <div id="customMessage"></div>

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3 class="mb-0">
                Footer Links
            </h3>
            <!-- 
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">

                <i class="fa fa-plus"></i>
                Add Footer Links

            </button> -->
            <button type="button" class="btn btn-primary" id="addBtn">
                <i class="fa fa-plus"></i> Add Footer Links
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

                                <th>Title</th>

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
                                            <?= htmlspecialchars($page->title) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($page->category) ?>
                                        </td>

                                        <td>

                                            <a href="<?= $page->slug ?>" target="_blank">

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
                                            <a href="<?= site_url('admin_panel/footer_links/delete/' . $page->id) ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this footer link?');">

                                                <i class="fa fa-trash"></i>

                                            </a>
                                            <button class="btn btn-primary btn-sm editBtn" data-id="<?= $page->id; ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
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

<div class="modal fade" id="footerModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modalTitle">
                    Add Footer Links
                </h5>

                <button type="button" class="close" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form id="footerForm" class="normal-form" action="<?= site_url('admin_panel/footer_links/save') ?>"
                method="POST">

                <div class="modal-body">

                    <!-- CATEGORY -->

                    <div class="form-group">

                        <label><input type="hidden" name="id" id="footer_id">
                            Footer Category
                        </label>

                        <select id="category" name="category_name" class="form-control" required>
                            <option value="quick-links" selected>Quick Links</option>
                            <option value="imported-medicines">Imported Medicines</option>
                            <option value="best-treatment">Best Treatment</option>
                            <option value="top-articles">Top Articles</option>
                            <option value="fda-drug-approvals">FDA Drug Approvals</option>
                            <option value="latest-news">Latest News</option>

                        </select>

                    </div>

                    <!-- Links NAME -->

                    <div class="form-group">

                        <label>
                            Title
                        </label>

                        <input id="title" type="text" name="title" class="form-control" required>

                    </div>

                    <!-- SLUG -->

                    <div class="form-group">

                        <label>
                            Slug
                        </label>

                        <input id="slug" type="text" name="slug" class="form-control" placeholder="example-page"
                            required>

                    </div>

                    <!-- STATUS -->

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Status
                                </label>

                                <select id="status" name="status" class="form-control">

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

                                <input id="sort_order" type="number" name="sort_order" class="form-control" value="0">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" id="submitBtn" class="btn btn-primary">
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
    $(function () {

        let message = sessionStorage.getItem('footerMessage');

        if (message) {

            $('#customMessage').html(message);

            sessionStorage.removeItem('footerMessage');

            setTimeout(function () {
                $('#customMessage .alert').fadeOut();
            }, 3000);
        }

    });
</script>
<script>
    $('#footerForm').submit(function () {

        let id = $('#footer_id').val();

        if (id) {
            sessionStorage.setItem(
                'footerMessage',
                '<div class="alert alert-success">Footer link updated successfully.</div>'
            );
        } else {
            sessionStorage.setItem(
                'footerMessage',
                '<div class="alert alert-success">Footer link added successfully.</div>'
            );
        }

    });
    $('#addBtn').click(function () {

        $('#footerForm')[0].reset();

        $('#footer_id').val('');

        $('#modalTitle').text('Add Footer Link');

        $('#submitBtn').text('Save');

        $('#footerModal').modal('show');

    });
    $('.editBtn').click(function () {

        let id = $(this).data('id');

        $.get("<?= site_url('admin_panel/footer_links/edit/') ?>" + id, function (res) {

            res = JSON.parse(res);

            $('#footer_id').val(res.id);

            $('#category').val(res.category);

            $('#title').val(res.title);

            $('#slug').val(res.slug);

            $('#status').val(res.status);

            $('#sort_order').val(res.sort_order);

            $('#modalTitle').text('Edit Footer Link');

            $('#submitBtn').text('Update');

            $('#footerModal').modal('show');

        });

    });
</script>
<?php $this->load->view('backend/footer'); ?>