<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<style>
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

<?php if ($this->session->flashdata('error')): ?>
    <div class="custom-alert custom-danger">
        <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-address-book"></i> Contact Enquiries</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url() . "dashboard"; ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Contact Enquiries</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;
                <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button id="enableBulkBtn" class="btn btn-warning btn-sm">
                    <i class="fa fa-check-square"></i> Enable Bulk Delete
                </button>
                <button id="deleteSelectedBtn" class="btn btn-danger btn-sm" style="display:none;">
                    <i class="fa fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <!-- <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Contact Enquiries List</h4>
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="query_type" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Queries</option>
                                        <option value="cq" <?= ($selected_type == 'cq') ? 'selected' : ''; ?>>Contact Us
                                        </option>
                                        <option value="hcq" <?= ($selected_type == 'hcq') ? 'selected' : ''; ?>>Home
                                            Page</option>
                                        <option value="mdq" <?= ($selected_type == 'mdq') ? 'selected' : ''; ?>>Medicine
                                            Details</option>
                                        <option value="ndq" <?= ($selected_type == 'ndq') ? 'selected' : ''; ?>>News &
                                            Blog</option>
                                        <option value="npp" <?= ($selected_type == 'npp') ? 'selected' : ''; ?>>NPP
                                            Query</option>
                                        <option value="pq" <?= ($selected_type == 'pq') ? 'selected' : ''; ?>>
                                            Prescription
                                            Query</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="m-b-0 text-white">
                            <i class="fa fa-list"></i> Contact Enquiries List
                        </h4>

                        <form method="GET" class="mb-0">
                            <select name="query_type" class="form-control" onchange="this.form.submit()">
                                <option value="">All Queries</option>
                                <option value="cq" <?= ($selected_type == 'cq') ? 'selected' : ''; ?>>
                                    Contact Us
                                </option>
                                <option value="hcq" <?= ($selected_type == 'hcq') ? 'selected' : ''; ?>>
                                    Home Page
                                </option>
                                <option value="mdq" <?= ($selected_type == 'mdq') ? 'selected' : ''; ?>>
                                    Medicine Details
                                </option>
                                <option value="ndq" <?= ($selected_type == 'ndq') ? 'selected' : ''; ?>>
                                    News & Blog
                                </option>
                                <option value="npp" <?= ($selected_type == 'npp') ? 'selected' : ''; ?>>
                                    NPP Query
                                </option>
                                <option value="pq" <?= ($selected_type == 'pq') ? 'selected' : ''; ?>>
                                    Prescription Query
                                </option>
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="contactTable"
                                class="display nowrap table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="checkboxCol" style="display:none; width:40px;">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Query Type</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($contacts)): ?>
                                        <?php foreach ($contacts as $con): ?>
                                            <tr>
                                                <td class="checkboxCol" style="display:none;">
                                                    <input type="checkbox" class="rowCheckbox" value="<?= $con->id ?>">
                                                </td>
                                                <td><?= $con->id ?></td>
                                                <td><?= htmlspecialchars($con->name) ?></td>
                                                <td><?= htmlspecialchars($con->email) ?></td>
                                                <td><?= htmlspecialchars($con->phone) ?></td>
                                                <td><?= word_limiter(htmlspecialchars($con->message), 10) ?></td>
                                                <td>
                                                    <?php $queryType = $con->query_type;
                                                    if ($queryType == "cq") {
                                                        echo "Contact Query";
                                                    } elseif ($queryType == "pq") {
                                                        echo "Prescription Query";
                                                    } elseif ($queryType == "hcq") {
                                                        echo "Home Page Query";
                                                    } elseif ($queryType == "npp") {
                                                        echo "NPP Query";
                                                    } elseif ($queryType == "mdq") {
                                                        echo "Medicine Details Query";
                                                    } elseif ($queryType == "ndq") {
                                                        echo "News Details Query";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= date('d M Y', strtotime($con->created_at)) ?></td>
                                                <td>
                                                    <!-- <a href="<?= base_url("contact/view/" . $con->id) ?>"
                                                class="btn btn-info btn-sm" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a> -->
                                                    <a href="<?= base_url("contact/delete/" . $con->id) ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this contact?')"
                                                        title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No contact enquiries found.</td>
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
</div>

<?php $this->load->view("backend/footer"); ?>

<script>
    setTimeout(function () {
        var alert = document.querySelector('.custom-alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);

    $(document).ready(function () {
        $('#contactTable').DataTable({
            aaSorting: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Enable bulk mode
        $("#enableBulkBtn").click(function () {
            $(".checkboxCol").show();
            $("#deleteSelectedBtn").show();
            $(this).hide();
        });

        // Select/Deselect all
        $("#selectAll").click(function () {
            $(".rowCheckbox").prop("checked", $(this).prop("checked"));
        });

        // Delete selected
        $("#deleteSelectedBtn").click(function () {
            let ids = [];
            $(".rowCheckbox:checked").each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                alert("No records selected!");
                return;
            }

            if (!confirm("Are you sure you want to delete selected contacts?")) return;

            $.post("<?= base_url('contact/bulk_delete') ?>", {
                ids: ids
            }, function (response) {
                let res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    location.reload();
                } else {
                    alert(res.message);
                }
            });
        });
    });
</script>