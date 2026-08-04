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
            <h3 class="text-themecolor"><i class="fa fa-list" aria-hidden="true"></i> Latest</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Latest</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;
                <strong><a href="<?= base_url(); ?>" target="_blank">Visit Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button class="btn btn-info" data-toggle="modal" data-target="#addLatestModal">
                    <i class="fa fa-plus"></i> Add Latest
                </button>
            </div>
        </div>

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Latest List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="latestTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest as $row): ?>
                                <tr>
                                    <td><?= $row->id ?></td>
                                    <td><?= $row->title ?></td>
                                    <td><a href="<?= $row->url ?>" target="_blank"><?= $row->url ?></a></td>
                                    <td>
                                        <button class="btn btn-info btn-sm editLatestBtn"
                                            data-id="<?= $row->id ?>"
                                            data-title="<?= $row->title ?>"
                                            data-url="<?= $row->url ?>">
                                            Edit
                                        </button>
                                        <a href="<?= base_url("admin_panel/latest/delete/" . $row->id) ?>"
                                            class="btn btn-danger btn-sm"
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

<!-- Add Latest Modal -->
<div class="modal fade" id="addLatestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url("admin_panel/latest/add") ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>Add Latest</b></h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="latest_title"><b>Title</b></label>
                    <input type="text" name="title" id="latest_title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="latest_url"><b>URL</b></label>
                    <input type="text" name="url" id="latest_url" class="form-control" placeholder="https://example.com" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Add Latest</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Latest Modal -->
<div class="modal fade" id="editLatestModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url("admin_panel/latest/edit") ?>" method="post" class="modal-content">
            <input type="hidden" name="id" id="edit_latest_id">
            <div class="modal-header">
                <h5 class="modal-title"><b>Edit Latest</b></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="edit_latest_title"><b>Title</b></label>
                    <input type="text" name="title" id="edit_latest_title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit_latest_url"><b>URL</b></label>
                    <input type="text" name="url" id="edit_latest_url" class="form-control" placeholder="https://example.com" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update Latest</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view("backend/footer"); ?>

<script>
    $(document).ready(function() {
        $('#latestTable').DataTable({
            "aaSorting": [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        $('.editLatestBtn').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const url = $(this).data('url');

            $('#edit_latest_id').val(id);
            $('#edit_latest_title').val(title);
            $('#edit_latest_url').val(url);
            $('#editLatestModal form').attr('action', '<?= base_url("admin_panel/latest/edit/") ?>' + id);
            $('#editLatestModal').modal('show');
        });
    });
</script>