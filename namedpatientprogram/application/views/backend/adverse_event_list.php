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
            <h3 class="text-themecolor"><i class="fa fa-address-book"></i>Adverse Events Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url() . "dashboard"; ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Adverse Events Form</li>
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;
                <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></strong>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Adverse Events List</h4>
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
                                        <th>Patient Name</th>
                                        <th>Gender</th>
                                        <th>Reporter Email</th>
                                        <th>Phone</th>
                                        <th>Medicine</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (!empty($records)): ?>

                                        <?php foreach ($records as $event): ?>

                                            <tr>
                                                <td class="checkboxCol" style="display:none;">
                                                    <input type="checkbox" class="rowCheckbox" value="<?= $event->id ?>">
                                                </td>
                                                <td><?= $event->id ?></td>
                                                <td><?= htmlspecialchars($event->patient_name) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($event->gender) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($event->reporter_email) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($event->phone_number) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($event->suspected_medicine_name) ?>
                                                </td>
                                                <td><?= date('d M Y', strtotime($event->created_at)) ?></td>
                                                <td>
                                                    <!-- <a href="#" class="btn btn-info btn-sm" title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a> -->
                                                    <a href="<?= base_url('report_adverse/view/' . $event->id) ?>"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('report_adverse/delete/' . $event->id) ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this record?')"
                                                        title="Delete Record">

                                                        <i class="fa fa-trash"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No Adverse Report Found.</td>
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