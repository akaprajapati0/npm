<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-eye"></i> View Contact Details</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php if (
                    $this->session->userdata("user_type")
                ) {
                    echo base_url() . "dashboard";
                } else {
                    echo base_url();
                } ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Contact Details</li>
                    
                &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp; <strong><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></strong>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info ">
                <h4 class="mb-0 text-white">Contact ID: <?= $contact->id ?></h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr><th>Name</th><td><?= $contact->name ?></td></tr>
                    <tr><th>Email</th><td><?= $contact->email ?></td></tr>
                    <tr><th>Country</th><td><?= $contact->country ?></td></tr>
                    <tr><th>Mobile</th><td><?= $contact->mobile ?></td></tr>
                    <tr><th>Department</th><td><?= $contact->department ?></td></tr>
                    <tr><th>Message</th><td><?= $contact->message ?></td></tr>
                    <tr><th>Consent</th><td><?= $contact->consent ?></td></tr>
                    <tr><th>Status</th><td><?= $contact->status ?></td></tr>
                    <tr><th>From Page</th><td><?= $contact->from_page ?></td></tr>
                    <tr><th>Created At</th><td><?= $contact->created_at ?></td></tr>
                </table>
                <a href="<?= base_url('contact'); ?>" class="btn btn-info">Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("backend/footer"); ?>
