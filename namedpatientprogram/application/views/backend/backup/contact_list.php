<!-- //contact_list.php -->

<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>
<style>
    /* Force checkboxes inside datatables to show properly */
    table.dataTable td input[type="checkbox"],
    table.dataTable th input[type="checkbox"] {
        display: inline-block !important;
        width: 18px !important;
        height: 18px !important;
        opacity: 1 !important;
        visibility: visible !important;
        position: static !important;
        margin: 0 auto !important;
    }
</style>



<?php if ($this->session->flashdata('success')): ?>
    <div class="custom-alert custom-success">
        <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-address-book"></i> Contact</h3>
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
                <li class="breadcrumb-item active">Contact</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp; <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></strong>
            </ol>

        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <!-- <button class="btn btn-info text-white" data-toggle="modal" data-target="#addContactModal">
                    <i class="fa fa-plus"></i> Add Contact
                </button> -->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Contact List</h4>

                    </div>
                    <div>
                        <div>
                            <button id="enableBulkBtn" class="btn btn-warning btn-sm" style="margin-left:10px;">
                                <i class="fa fa-check-square"></i> Enable Bulk Delete
                            </button>

                            <button id="deleteSelectedBtn" class="btn btn-danger btn-sm" style="display:none; margin-left:10px;">
                                <i class="fa fa-trash"></i> Delete Selected
                            </button>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="contactTable" class="display nowrap table table-hover table-striped table-bordered">
                                <!-- ... Inside the table head -->
                                <thead>
                                    <tr>
                                        <th class="checkboxCol" style="display:none; width:40px;">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <!-- <th>Email</th> -->
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <!-- <th>Message</th>
        <th>Consent</th> -->
                                        <th>Status</th>
                                        <!-- <th>From Page</th>
        <th>Created At</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $con): ?>
                                        <tr>
                                            <td class="checkboxCol" style="display:none;">
                                                <input type="checkbox" class="rowCheckbox" value="<?= $con->id ?>">
                                            </td>
                                            <td><?= word_limiter($con->id, 5) ?></td>
                                            <td><?= $con->name ?></td>
                                            <!-- <td><?= $con->email ?></td> -->
                                            <td><?= $con->country ?></td>
                                            <td><?= $con->mobile ?></td>
                                            <td><?= $con->department ?></td>
                                            <!-- <td><?= word_limiter($con->message, 10) ?></td>
    <td><?= $con->consent ?></td> -->
                                            <td><?= $con->status ?></td>
                                            <!-- <td><?= $con->from_page ?></td>
    <td><?= $con->created_at ?></td> -->
                                            <td>
                                                <!-- <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateContactModal"
           data-id="<?= $con->id ?>" data-name="<?= $con->name ?>" data-email="<?= $con->email ?>"
           data-country="<?= $con->country ?>" data-phone="<?= $con->mobile ?>" data-department="<?= $con->department ?>"
           data-message="<?= htmlspecialchars(
                                            $con->message,
                                            ENT_QUOTES
                                        ) ?>" data-consent="<?= $con->consent ?>"
           data-status="<?= $con->status ?>" data-frompage="<?= $con->from_page ?>">
           <i class="fa fa-edit"></i>
        </a> -->
                                                <a href="<?= base_url(
                                                                "contact/delete/" . $con->id
                                                            ) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <!-- <i class="fa fa-trash"></i> -->Delete
                                                </a>

                                                <a href="<?= base_url("contact/view/" . $con->id) ?>" class="btn btn-info btn-sm">
                                                    <!-- <i class="fa fa-eye"></i> -->View
                                                </a>

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
    </div>

</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal">
    <div class="modal-dialog">
        <form action="<?= base_url("contact/add") ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contact</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Name" class="form-control mb-2" required>
                    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
                    <input type="text" name="country" placeholder="Country" class="form-control mb-2">
                    <input type="text" name="phone" placeholder="Phone" class="form-control mb-2" required>
                    <input type="text" name="department" placeholder="Department" class="form-control mb-2">
                    <textarea name="message" placeholder="Message" class="form-control mb-2"></textarea>
                    <select name="consent" class="form-control mb-2">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <select name="status" class="form-control mb-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <input type="text" name="from_page" placeholder="From Page" class="form-control mb-2">
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Save</button></div>
            </div>
        </form>
    </div>
</div>


<!-- Update Contact Modal -->
<div class="modal fade" id="updateContactModal">
    <div class="modal-dialog">
        <form action="<?= base_url("contact/edit") ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Contact</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="update_id" name="id">
                    <input type="text" id="update_name" name="name" class="form-control mb-2" required>
                    <input type="email" id="update_email" name="email" class="form-control mb-2" required>
                    <input type="text" id="update_country" name="country" class="form-control mb-2">
                    <input type="text" id="update_phone" name="phone" class="form-control mb-2" required>
                    <input type="text" id="update_department" name="department" class="form-control mb-2">
                    <textarea id="update_message" name="message" class="form-control mb-2"></textarea>
                    <select id="update_consent" name="consent" class="form-control mb-2">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <select id="update_status" name="status" class="form-control mb-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <input type="text" id="update_from_page" name="from_page" class="form-control mb-2">
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success">Update</button></div>
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
</script>

<script>
    $('#contactTable').DataTable({
        aaSorting: [
            [0, 'desc']
        ],
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    $('#updateContactModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        $('#update_id').val(button.data('id'));
        $('#update_name').val(button.data('name'));
        $('#update_email').val(button.data('email'));
        $('#update_country').val(button.data('country'));
        $('#update_phone').val(button.data('phone'));
        $('#update_department').val(button.data('department'));
        $('#update_message').val(button.data('message'));
        $('#update_consent').val(button.data('consent'));
        $('#update_status').val(button.data('status'));
        $('#update_from_page').val(button.data('frompage'));
    });
</script>



<script>
    $(document).ready(function() {
        // Enable bulk mode
        $("#enableBulkBtn").click(function() {
            $(".checkboxCol").show();
            $("#deleteSelectedBtn").show();
            $(this).hide();
        });

        // Select/Deselect all
        $("#selectAll").click(function() {
            $(".rowCheckbox").prop("checked", $(this).prop("checked"));
        });

        // Delete selected
        $("#deleteSelectedBtn").click(function() {
            let ids = [];
            $(".rowCheckbox:checked").each(function() {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                alert("No records selected!");
                return;
            }

            if (!confirm("Are you sure to delete selected contacts?")) return;

            $.post("<?= base_url('contact/bulk_delete') ?>", {
                ids: ids
            }, function(response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
        });
    });
</script>