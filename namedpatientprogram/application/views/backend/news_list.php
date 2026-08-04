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
            <h3 class="text-themecolor"><i class="fa fa-newspaper-o"></i> News</h3>
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
                <li class="breadcrumb-item active">News
                </li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp; <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit
                        Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button class="btn btn-info" data-toggle="modal" data-target="#addNewsModal"><i class="fa fa-plus"></i>
                    Add News</button>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card card-outline-info">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> News List</h4>

                    <div>
                        <button id="toggleHomeSelectBtn" class="btn btn-warning btn-sm">
                            Show on Homepage
                        </button>
                        <button id="saveHomeSelectionBtn" class="btn btn-success btn-sm d-none">
                            Save Selection
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="newsTable" class="display nowrap table table-hover table-striped table-bordered"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <!-- <th>Created At</th> -->
                                    <th class="home-col d-none">Show on Home</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($news as $item): ?>
                                    <tr>
                                        <td>
                                            <?= $item->id ?>
                                        </td>
                                        <td>
                                            <?= $item->category_name ?>
                                        </td>
                                        <td>
                                            <?= word_limiter($item->name, 8) ?>
                                        </td>


                                        <td><img src="<?= base_url(
                                            "./assets/images/news/" . $item->image
                                        ) ?>" width="60" height="50px"></td>
                                        <td>
                                            <?= $item->status ?>
                                        </td>


                                        <!-- NEW: Home selection checkbox -->
                                        <td class="home-col d-none">
                                            <input type="checkbox" class="home-checkbox" value="<?= $item->id ?>"
                                                <?= !empty($item->show_on_home) && $item->show_on_home == 1 ? 'checked' : '' ?>>
                                        </td>


                                        <!-- <td><?= $item->createdAt ?></td> -->
                                        <td>
                                            <button class="btn btn-info btn-sm editBtn"
                                                data-id="<?= htmlspecialchars($item->id) ?>"
                                                data-name="<?= htmlspecialchars($item->name) ?>"
                                                data-category_id="<?= htmlspecialchars($item->category_id) ?>"
                                                data-slug="<?= htmlspecialchars($item->slug) ?>"
                                                data-description="<?= htmlspecialchars($item->description) ?>"
                                                data-meta_title="<?= htmlspecialchars($item->metaTitle) ?>"
                                                data-meta_description="<?= htmlspecialchars($item->metaDescription) ?>"
                                                data-meta_keywords="<?= htmlspecialchars($item->metaKeywords) ?>"
                                                data-meta_canonical="<?= htmlspecialchars($item->metaCanonical) ?>"
                                                data-meta_schema="<?= htmlspecialchars($item->metaSchema) ?>"
                                                data-og_meta_title="<?= htmlspecialchars($item->ogMetaTitle) ?>"
                                                data-og_meta_description="<?= htmlspecialchars($item->ogMetaDescription) ?>"
                                                data-og_meta_keywords="<?= htmlspecialchars($item->ogMetaKeywords) ?>"
                                                data-og_meta_url="<?= htmlspecialchars($item->ogMetaUrl) ?>"
                                                data-status="<?= htmlspecialchars($item->status) ?>"
                                                data-author_name="<?= htmlspecialchars($item->author_name) ?>"
                                                data-image="<?= base_url("assets/images/news/" . $item->image) ?>"
                                                data-toggle="modal" data-target="#editNewsModal">
                                                Edit
                                            </button>
                                            <!-- //change view btn added -->
                                            <!-- <button class="btn btn-success btn-sm viewBtn"
                                                data-id="<?= htmlspecialchars($item->id) ?>"
                                                data-name="<?= htmlspecialchars($item->name) ?>"
                                                data-category="<?= htmlspecialchars($item->category_name) ?>"
                                                data-description="<?= htmlspecialchars($item->description) ?>"
                                                data-status="<?= htmlspecialchars($item->status) ?>"
                                                data-image="<?= base_url("assets/images/news/" . $item->image) ?>"
                                                data-toggle="modal" data-target="#viewNewsModal">
                                                View
                                            </button> -->
                                            <button class="btn btn-success btn-sm viewBtn"
                                                data-id="<?= htmlspecialchars($item->id) ?>"
                                                data-name="<?= htmlspecialchars($item->name) ?>"
                                                data-category="<?= htmlspecialchars($item->category_name) ?>"
                                                data-description="<?= htmlspecialchars($item->description) ?>"
                                                data-meta_title="<?= htmlspecialchars($item->metaTitle) ?>"
                                                data-meta_description="<?= htmlspecialchars($item->metaDescription) ?>"
                                                data-meta_keywords="<?= htmlspecialchars($item->metaKeywords) ?>"
                                                data-meta_canonical="<?= htmlspecialchars($item->metaCanonical) ?>"
                                                data-meta_schema="<?= htmlspecialchars($item->metaSchema) ?>"
                                                data-og_meta_title="<?= htmlspecialchars($item->ogMetaTitle) ?>"
                                                data-og_meta_description="<?= htmlspecialchars($item->ogMetaDescription) ?>"
                                                data-og_meta_keywords="<?= htmlspecialchars($item->ogMetaKeywords) ?>"
                                                data-og_meta_url="<?= htmlspecialchars($item->ogMetaUrl) ?>"
                                                data-status="<?= htmlspecialchars($item->status) ?>"
                                                data-image="<?= base_url("assets/images/news/" . $item->image) ?>"
                                                data-toggle="modal" data-target="#viewNewsModal">
                                                View
                                            </button>


                                            <!-- assets/images/admin_panel/news/" . $item->image -->

                                            <a href="<?= base_url(
                                                "news/delete/" . $item->id
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

    <!-- Add News Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="add_news_form" action="<?= base_url(
                "admin_panel/news/insert"
            ) ?>" method="post" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Add News</b></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!-- News Title -->
                        <label><b><b>Title</b></label>
                        <input type="text" name="name" class="form-control" id="news_title" required>
                    </div>
                    <div class="form-group">
                        <label><b>Category</b></label>
                        <select name="category_id" class="form-control" id="news_category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>">
                                    <?= $category->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- News Description -->
                    <div class="form-group">
                        <label for="summernote"><b>Description</b></label>
                        <textarea id="summernote" name="description" required></textarea>
                    </div>
                    <!-- //newauthor name -->
                    <div class="form-group">
                        <label><b>Author Name</b></label>
                        <input type="text" name="author_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><b>Status</b></label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="in-active">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Image</b></label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <!-- Meta Title -->
                    <div class="form-group">
                        <label><b>Meta Title</b></label>
                        <input type="text" name="metaTitle" class="form-control">
                    </div>

                    <!-- Meta Description -->
                    <div class="form-group">
                        <label for="summernote"><b>Meta Description</b></label>
                        <textarea name="metaDescription" class="form-control" required></textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="form-group">
                        <label><b>Meta Keywords</b></label>
                        <textarea name="metaKeywords" class="form-control"></textarea>
                    </div>

                    <!-- Meta Canonical -->
                    <div class="form-group">
                        <label><b>Meta Canonical</b></label>
                        <input type="text" name="metaCanonical" class="form-control">
                    </div>

                    <!-- Meta Schema -->
                    <div class="form-group">
                        <label><b>Meta Schema</b></label>
                        <!-- <input type="text" name="metaSchema" class="form-control"> -->
                        <textarea name="metaSchema" class="form-control"></textarea>
                    </div>

                    <!-- OG Meta Title -->
                    <div class="form-group">
                        <label><b>OG Meta Title</b></label>
                        <input type="text" name="ogMetaTitle" class="form-control">
                    </div>

                    <!-- OG Meta Description -->
                    <div class="form-group">
                        <label><b>OG Meta Description</b></label>
                        <input type="text" name="ogMetaDescription" class="form-control">
                    </div>

                    <!-- OG Meta Keywords -->
                    <div class="form-group">
                        <label><b>OG Meta Keywords</b></label>
                        <input type="text" name="ogMetaKeywords" class="form-control">
                    </div>

                    <!-- OG Meta URL -->
                    <div class="form-group">
                        <label><b>OG Meta URL</b></label>
                        <input type="text" name="ogMetaUrl" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Add News</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit News Modal -->
    <!-- Edit News Modal -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <form action="<?= base_url(
                "admin_panel/news/update"
            ) ?>" method="post" enctype="multipart/form-data" class="modal-content">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Edit News</b></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- First Column -->

                    <!-- New Title/Name -->
                    <div class="form-group">
                        <label for="edit_name"><b>Title</b></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>

                        <!-- Slug (Hidden) -->
                        <div class="form-group ">
                            <label for="edit_slug"><b>Slug</b></label>
                            <input type="text" name="slug" id="edit_slug" class="form-control">
                        </div>
                        <!-- Category -->
                        <div class="form-group">
                            <label for="edit_category_id"><b>Category</b></label>
                            <select name="category_id" id="edit_category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category):
                                    $edit_category_id = 59; ?>
                                    <option value="<?= $category->id ?>" <?= $category->id == $edit_category_id
                                          ? "selected"
                                          : "" ?> id="edit_category_id">
                                        <?= $category->name ?>
                                    </option>
                                    <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <!-- News Description -->
                        <div class="form-group">
                            <label for="edit_summernote"><b>Description</b></label>
                            <textarea name="description" id="edit_summernote" class="form-control" required></textarea>


                        </div>
                        <!-- author_edit -->
                        <div class="form-group">
                            <label for="edit_author_name"><b>Author Name</b></label>
                            <input type="text" name="author_name" id="edit_author_name" class="form-control" required>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="edit_status"><b>Status</b></label>
                            <!-- <select name="status" id="edit_status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select> -->

                            <select id="edit_status" name="status" class="form-control mb-2">
                                <option value="active">Active</option>
                                <option value="in-active">Inactive</option>
                            </select>
                        </div>
                        <!-- Meta Title -->
                        <div class="form-group">
                            <label for="edit_metaTitle"><b>Meta Title</b></label>
                            <input type="text" name="metaTitle" id="edit_metaTitle" class="form-control">
                        </div>
                        <!-- Meta Description -->
                        <div class="form-group">
                            <label for="edit_metaDescription"><b>Meta Description</b></label>
                            <textarea name="metaDescription" id="edit_metaDescription" class="form-control"></textarea>
                        </div>
                        <!-- Meta Keywords -->
                        <div class="form-group">
                            <label for="edit_metaKeywords"><b>Meta Keywords</b></label>
                            <textarea name="metaKeywords" id="edit_metaKeywords" class="form-control"></textarea>
                        </div>
                        <!-- Meta Canonical -->
                        <div class="form-group">
                            <label for="edit_metaCanonical"><b>Meta Canonical</b></label>
                            <input type="text" name="metaCanonical" id="edit_metaCanonical" class="form-control">
                        </div>
                    </div>

                    <!-- Meta Schema -->
                    <div class="form-group">
                        <label for="edit_metaSchema"><b>Meta Schema</b></label>
                        <!-- <input type="text" name="metaSchema" id="edit_metaSchema" class="form-control"> -->
                        <textarea name="metaSchema" id="edit_metaSchema" class="form-control"></textarea>

                        <!-- OG Meta Title -->
                        <div class="form-group">
                            <label for="edit_ogMetaTitle"><b>OG Meta Title</b></label>
                            <input type="text" name="ogMetaTitle" id="edit_ogMetaTitle" class="form-control">
                        </div>
                        <!-- OG Meta Description -->
                        <div class="form-group">
                            <label for="edit_ogMetaDescription"><b>OG Meta Description</b></label>
                            <input type="text" name="ogMetaDescription" id="edit_ogMetaDescription"
                                class="form-control">
                        </div>
                        <!-- OG Meta Keywords -->
                        <div class="form-group">
                            <label for="edit_ogMetaKeywords"><b>OG Meta Keywords</b></label>
                            <input type="text" name="ogMetaKeywords" id="edit_ogMetaKeywords" class="form-control">
                        </div>
                        <!-- OG Meta URL -->
                        <div class="form-group">
                            <label for="edit_ogMetaUrl"><b>OG Meta URL</b></label>
                            <input type="text" name="ogMetaUrl" id="edit_ogMetaUrl" class="form-control">
                        </div>
                        <!-- Current Image Preview -->
                        <div class="form-group">
                            <label><b>Current Image</b></label><br>
                            <img id="currentImagePreview" src="" alt="Current Image"
                                style="max-width: 100%; height: auto; display: none;">
                        </div>
                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="edit_image"><b>New Image</b></label>
                            <input type="file" name="image" id="edit_image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update News</button>
                </div>
            </form>
        </div>
    </div>
    <!-- View News Modal -->
    <!-- <div class="modal fade" id="viewNewsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>News Details</b></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <p><b>Title:</b> <span id="view_name"></span></p>
                    <p><b>Category:</b> <span id="view_category"></span></p>

                    <p><b>Description:</b></p>
                    <div id="view_description" style="border:1px solid #ddd; padding:10px; border-radius:5px;"></div>
                    <p><b>Image:</b></p>
                    <img id="view_image" src="" alt="News Image"
                        style="max-width:100%; height:auto; border:1px solid #ccc; border-radius:5px;">
                </div>
            </div>
        </div>
    </div> -->
    <div class="modal fade" id="viewNewsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>News Details</b></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p><b>Title:</b> <span id="view_name"></span></p>
                    <p><b>Category:</b> <span id="view_category"></span></p>
                    <p><b>Status:</b> <span id="view_status"></span></p>

                    <p><b>Description:</b></p>
                    <div id="view_description" style="border:1px solid #ddd; padding:10px; border-radius:5px;"></div>

                    <hr>
                    <h5><b>Meta Information</b></h5>
                    <p><b>Meta Title:</b> <span id="view_metaTitle"></span></p>
                    <p><b>Meta Description:</b> <span id="view_metaDescription"></span></p>
                    <p><b>Meta Keywords:</b> <span id="view_metaKeywords"></span></p>
                    <p><b>Meta Canonical:</b> <span id="view_metaCanonical"></span></p>
                    <p><b>Meta Schema:</b> <span id="view_metaSchema"></span></p>

                    <hr>
                    <h5><b>OG Meta Information</b></h5>
                    <p><b>OG Meta Title:</b> <span id="view_ogMetaTitle"></span></p>
                    <p><b>OG Meta Description:</b> <span id="view_ogMetaDescription"></span></p>
                    <p><b>OG Meta Keywords:</b> <span id="view_ogMetaKeywords"></span></p>
                    <p><b>OG Meta URL:</b> <span id="view_ogMetaUrl"></span></p>

                    <hr>
                    <p><b>Image:</b></p>
                    <img id="view_image" src="" alt="News Image"
                        style="max-width:100%; height:auto; border:1px solid #ccc; border-radius:5px;">
                </div>
            </div>
        </div>
    </div>


    <?php if ($this->session->flashdata("error")): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata("error") ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata("success")): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata("success") ?>
        </div>
    <?php endif; ?>


    <?php $this->load->view("backend/footer"); ?>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 200,
                placeholder: 'Write medicine details...',

                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],

                // 👇 Ensures the "style" dropdown shows Normal + H1-H6 as selectable options
                styleTags: [
                    // 'p',
                    {
                        title: 'Normal',
                        tag: 'p',
                        value: 'p'
                    },
                    {
                        title: 'Blockquote',
                        tag: 'blockquote',
                        value: 'blockquote'
                    },
                    {
                        title: 'Heading 1',
                        tag: 'h1',
                        value: 'h1'
                    },
                    {
                        title: 'Heading 2',
                        tag: 'h2',
                        value: 'h2'
                    },
                    {
                        title: 'Heading 3',
                        tag: 'h3',
                        value: 'h3'
                    },
                    {
                        title: 'Heading 4',
                        tag: 'h4',
                        value: 'h4'
                    },
                    {
                        title: 'Heading 5',
                        tag: 'h5',
                        value: 'h5'
                    },
                    {
                        title: 'Heading 6',
                        tag: 'h6',
                        value: 'h6'
                    }
                ],

                fontNames: [
                    'Arial',
                    'Calibri',
                    'Times New Roman',
                    'Verdana',
                    'Tahoma',
                    'Georgia'
                ],

                fontSizes: [
                    '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48',
                    '64'
                ],

                // 👇 Auto-fix: after pressing Enter inside a heading, switch new line back to <p>
                callbacks: {
                    onKeyup: function (e) {
                        if (e.keyCode === 13) { // Enter key
                            var selection = document.getSelection();
                            if (!selection.rangeCount) return;

                            var node = selection.getRangeAt(0).startContainer;
                            var block = node.nodeType === 3 ? node.parentNode : node;

                            if (block && /^H[1-6]$/i.test(block.tagName)) {
                                document.execCommand('formatBlock', false, 'p');
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#edit_summernote').summernote({
                height: 200,
                placeholder: 'Write medicine details...',

                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],

                // 👇 Ensures the "style" dropdown shows Normal + H1-H6 as selectable options
                styleTags: [
                    // 'p',
                    {
                        title: 'Normal',
                        tag: 'p',
                        value: 'p'
                    },
                    {
                        title: 'Blockquote',
                        tag: 'blockquote',
                        value: 'blockquote'
                    },
                    {
                        title: 'Heading 1',
                        tag: 'h1',
                        value: 'h1'
                    },
                    {
                        title: 'Heading 2',
                        tag: 'h2',
                        value: 'h2'
                    },
                    {
                        title: 'Heading 3',
                        tag: 'h3',
                        value: 'h3'
                    },
                    {
                        title: 'Heading 4',
                        tag: 'h4',
                        value: 'h4'
                    },
                    {
                        title: 'Heading 5',
                        tag: 'h5',
                        value: 'h5'
                    },
                    {
                        title: 'Heading 6',
                        tag: 'h6',
                        value: 'h6'
                    }
                ],

                fontNames: [
                    'Arial',
                    'Calibri',
                    'Times New Roman',
                    'Verdana',
                    'Tahoma',
                    'Georgia'
                ],

                fontSizes: [
                    '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48',
                    '64'
                ],

                // 👇 Auto-fix: after pressing Enter inside a heading, switch new line back to <p>
                callbacks: {
                    onKeyup: function (e) {
                        if (e.keyCode === 13) { // Enter key
                            var selection = document.getSelection();
                            if (!selection.rangeCount) return;

                            var node = selection.getRangeAt(0).startContainer;
                            var block = node.nodeType === 3 ? node.parentNode : node;

                            if (block && /^H[1-6]$/i.test(block.tagName)) {
                                document.execCommand('formatBlock', false, 'p');
                            }
                        }
                    }
                }
            });
        });

        $(document).on('hidden.bs.modal', function () {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });
    </script>
    <script>
        setTimeout(function () {
            var alert = document.querySelector('.custom-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>

    <script>
        $(document).ready(function () {
            $('#add_news_form').on('submit', function (e) {
                var isValid = true;

                var title = $('#news_title');
                var category = $('#news_category');
                var description = $('#summernote');

                // Summernote content check
                if (description.summernote('isEmpty')) {
                    description.next('.invalid-feedback').remove();
                    description.addClass('is-invalid');
                    description.after('<div class="invalid-feedback">Description is required.</div>');
                    isValid = false;
                } else {
                    description.removeClass('is-invalid');
                    description.next('.invalid-feedback').remove();
                }

                // Title validation
                if ($.trim(title.val()) === '') {
                    title.addClass('is-invalid');
                    if (title.next('.invalid-feedback').length === 0) {
                        title.after('<div class="invalid-feedback"></div>');
                    }
                    isValid = false;
                } else {
                    title.removeClass('is-invalid');
                    title.next('.invalid-feedback').remove();
                }

                // Category validation
                if ($.trim(category.val()) === '') {
                    category.addClass('is-invalid');
                    if (category.next('.invalid-feedback').length === 0) {
                        category.after('<div class="invalid-feedback"></div>');
                    }
                    isValid = false;
                } else {
                    category.removeClass('is-invalid');
                    category.next('.invalid-feedback').remove();
                }

                if (!isValid) e.preventDefault();
            });
        });
    </script>


    <script>
        // $('#newsTable').DataTable({
        //     "aaSorting": [
        //         [0, 'desc']
        //     ],
        //     dom: 'Bfrtip',
        //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        // });

        // $(document).ready(function() {
        //     $('.editBtn').on('click', function() {
        //         $('#edit_id').val($(this).data('id'));
        //         $('#edit_name').val($(this).data('name'));
        //         $('#edit_slug').val($(this).data('slug'));
        //         $('#edit_category_id').val($(this).data('category_id'));
        //         $('#edit_summernote').summernote('code', $(this).data('description'));
        //         $('#edit_metaTitle').val($(this).data('meta_title'));
        //         $('#edit_metaDescription').val($(this).data('meta_description'));
        //         $('#edit_metaKeywords').val($(this).data('meta_keywords'));
        //         $('#edit_metaCanonical').val($(this).data('meta_canonical'));
        //         $('#edit_metaSchema').val($(this).data('meta_schema'));
        //         $('#edit_ogMetaTitle').val($(this).data('og_meta_title'));
        //         $('#edit_ogMetaDescription').val($(this).data('og_meta_description'));
        //         $('#edit_ogMetaKeywords').val($(this).data('og_meta_keywords'));
        //         $('#edit_ogMetaUrl').val($(this).data('og_meta_url'));
        //         $('#edit_status').val($(this).data('status'));
        //         $('#edit_author_name').val($(this).data('author_name')); // ✅ NEW

        //         const imageUrl = $(this).data('image');
        //         if (imageUrl) {
        //             $('#currentImagePreview').attr('src', imageUrl).show();
        //         } else {
        //             $('#currentImagePreview').hide();
        //         }
        //     });
        // For Edit Button
        $(document).on('click', '.editBtn', function () {
            $('#edit_id').val($(this).data('id'));
            $('#edit_name').val($(this).data('name'));
            $('#edit_slug').val($(this).data('slug'));
            $('#edit_category_id').val($(this).data('category_id'));
            $('#edit_summernote').summernote('code', $(this).data('description'));
            $('#edit_metaTitle').val($(this).data('meta_title'));
            $('#edit_metaDescription').val($(this).data('meta_description'));
            $('#edit_metaKeywords').val($(this).data('meta_keywords'));
            $('#edit_metaCanonical').val($(this).data('meta_canonical'));
            $('#edit_metaSchema').val($(this).data('meta_schema'));
            $('#edit_ogMetaTitle').val($(this).data('og_meta_title'));
            $('#edit_ogMetaDescription').val($(this).data('og_meta_description'));
            $('#edit_ogMetaKeywords').val($(this).data('og_meta_keywords'));
            $('#edit_ogMetaUrl').val($(this).data('og_meta_url'));
            $('#edit_status').val($(this).data('status'));
            $('#edit_author_name').val($(this).data('author_name'));

            const imageUrl = $(this).data('image');
            if (imageUrl) {
                $('#currentImagePreview').attr('src', imageUrl).show();
            } else {
                $('#currentImagePreview').hide();
            }
        });

        // For View Button
        $(document).on('click', '.viewBtn', function () {
            $('#view_name').text($(this).data('name'));
            $('#view_category').text($(this).data('category'));
            $('#view_status').text($(this).data('status'));
            $('#view_description').html($(this).data('description'));

            // Meta Fields
            $('#view_metaTitle').text($(this).data('meta_title'));
            $('#view_metaDescription').text($(this).data('meta_description'));
            $('#view_metaKeywords').text($(this).data('meta_keywords'));
            $('#view_metaCanonical').text($(this).data('meta_canonical'));
            $('#view_metaSchema').text($(this).data('meta_schema'));

            // OG Meta Fields
            $('#view_ogMetaTitle').text($(this).data('og_meta_title'));
            $('#view_ogMetaDescription').text($(this).data('og_meta_description'));
            $('#view_ogMetaKeywords').text($(this).data('og_meta_keywords'));
            $('#view_ogMetaUrl').text($(this).data('og_meta_url'));

            // Image
            $('#view_image').attr('src', $(this).data('image'));
        });



        // });

        // $(document).ready(function() {
        //     $('.viewBtn').on('click', function() {
        //         $('#view_id').text($(this).data('id'));
        //         $('#view_name').text($(this).data('name'));
        //         $('#view_category').text($(this).data('category'));
        //         $('#view_status').text($(this).data('status'));
        //         $('#view_description').html($(this).data('description'));
        //         $('#view_image').attr('src', $(this).data('image'));
        //     });
        // });



        // $(document).ready(function() {
        //     $('.viewBtn').on('click', function() {
        //         $('#view_name').text($(this).data('name'));
        //         $('#view_category').text($(this).data('category'));
        //         $('#view_status').text($(this).data('status'));
        //         $('#view_description').html($(this).data('description'));

        //         // Meta Fields
        //         $('#view_metaTitle').text($(this).data('meta_title'));
        //         $('#view_metaDescription').text($(this).data('meta_description'));
        //         $('#view_metaKeywords').text($(this).data('meta_keywords'));
        //         $('#view_metaCanonical').text($(this).data('meta_canonical'));
        //         $('#view_metaSchema').text($(this).data('meta_schema'));

        //         // OG Meta Fields
        //         $('#view_ogMetaTitle').text($(this).data('og_meta_title'));
        //         $('#view_ogMetaDescription').text($(this).data('og_meta_description'));
        //         $('#view_ogMetaKeywords').text($(this).data('og_meta_keywords'));
        //         $('#view_ogMetaUrl').text($(this).data('og_meta_url'));

        //         // Image
        //         $('#view_image').attr('src', $(this).data('image'));
        //     });
        // });
        $(document).on('click', '.viewBtn', function () {
            $('#view_name').text($(this).data('name'));
            $('#view_category').text($(this).data('category'));
            $('#view_status').text($(this).data('status'));
            $('#view_description').html($(this).data('description'));

            // Meta Fields
            $('#view_metaTitle').text($(this).data('meta_title'));
            $('#view_metaDescription').text($(this).data('meta_description'));
            $('#view_metaKeywords').text($(this).data('meta_keywords'));
            $('#view_metaCanonical').text($(this).data('meta_canonical'));
            $('#view_metaSchema').text($(this).data('meta_schema'));

            // OG Meta Fields
            $('#view_ogMetaTitle').text($(this).data('og_meta_title'));
            $('#view_ogMetaDescription').text($(this).data('og_meta_description'));
            $('#view_ogMetaKeywords').text($(this).data('og_meta_keywords'));
            $('#view_ogMetaUrl').text($(this).data('og_meta_url'));

            // Image
            $('#view_image').attr('src', $(this).data('image'));
        });
    </script>




    <script>
        $(document).ready(function () {

            // 1) Show/Hide checkbox column
            $('#toggleHomeSelectBtn').on('click', function () {
                $('th.home-col, td.home-col').toggleClass('d-none');
                $('#saveHomeSelectionBtn').toggleClass('d-none');
            });

            // 2) Limit selection to 3
            $(document).on('change', '.home-checkbox', function () {
                var checkedCount = $('.home-checkbox:checked').length;
                if (checkedCount > 3) {
                    this.checked = false;
                    alert('You can select maximum 3 news items for homepage.');
                }
            });

            // 3) Save selection
            $('#saveHomeSelectionBtn').on('click', function () {
                var ids = [];
                $('.home-checkbox:checked').each(function () {
                    ids.push($(this).val());
                });

                $.ajax({
                    url: '<?= base_url("admin_panel/news/save_home"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ids: ids
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            alert(res.msg);
                            requestedPageReload();
                        } else {
                            alert(res.msg);
                            requestedPageReload();

                        }
                    },
                    error: function () {
                        alert('Something went wrong while saving selection.');
                    }
                });

            });
            requestedPageReload = function () {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            };

        });
    </script>


    <style>
        /* Center the column */
        #newsTable th.home-col,
        #newsTable td.home-col {
            text-align: center;
            vertical-align: middle;
        }

        /* Force the checkbox to be visible */
        #newsTable td.home-col input[type="checkbox"],
        #newsTable th.home-col input[type="checkbox"],
        .home-checkbox {
            position: static !important;
            opacity: 1 !important;
            display: inline-block !important;
            visibility: visible !important;
            width: 16px !important;
            height: 16px !important;
            margin: 0 auto;
            -webkit-appearance: checkbox !important;
            -moz-appearance: checkbox !important;
            appearance: checkbox !important;
            transform: scale(1) !important;
        }
    </style>