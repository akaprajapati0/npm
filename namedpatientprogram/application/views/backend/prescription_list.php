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
            <h3 class="text-themecolor"><i class="fa fa-file-medical"></i> Prescription Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo base_url() . "dashboard"; ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Prescriptions</li>
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
                        <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Uploaded Prescriptions</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="prescriptionTable"
                                class="display nowrap table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>File Type</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($prescriptions)): ?>
                                        <?php foreach ($prescriptions as $presc): ?>
                                            <tr>
                                                <td><?= $presc->id ?></td>
                                                <td><?= htmlspecialchars($presc->name) ?></td>
                                                <td><?= htmlspecialchars($presc->email) ?></td>
                                                <td><?= htmlspecialchars($presc->phone) ?></td>
                                                <td>
                                                    <?php if ($presc->prescription_type === 'image'): ?>
                                                        <span class="badge badge-success">
                                                            <i class="fa fa-image"></i> Image
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">
                                                            <i class="fa fa-file-pdf"></i> PDF
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date('d M Y', strtotime($presc->created_at)) ?></td>
                                                <td>
                                                    <a href="<?= base_url("contact/view_prescription/" . $presc->id) ?>"
                                                        class="btn btn-info btn-sm" title="View Prescription">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('uploads/prescriptions/' . $presc->prescription) ?>"
                                                        class="btn btn-success btn-sm" title="Download" download>
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <a href="<?= base_url("contact/delete_prescription/" . $presc->id) ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this prescription?')"
                                                        title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No prescriptions found.</td>
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
    setTimeout(function() {
        var alert = document.querySelector('.custom-alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);

    $(document).ready(function() {
        $('#prescriptionTable').DataTable({
            aaSorting: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });
</script>