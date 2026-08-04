<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-12 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-file-medical"></i> View Prescription</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('contact/prescriptions'); ?>">Prescriptions</a>
                    </li>
                    <li class="breadcrumb-item active">View Prescription</li>
                    &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;
                    <strong><a href="<?= base_url(); ?>" target="_blank">Visit Site</a></strong>
                </ol>
            </div>
        </div>

        <div class="row">
            <!-- Patient Details Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="mb-0 text-white"><i class="fa fa-user"></i> Patient Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="100">Name:</th>
                                <td><?= htmlspecialchars($prescription->name) ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= htmlspecialchars($prescription->email) ?></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td><?= htmlspecialchars($prescription->phone) ?></td>
                            </tr>
                            <tr>
                                <th>Message:</th>
                                <td><?= nl2br(htmlspecialchars($prescription->message)) ?></td>
                            </tr>
                            <tr>
                                <th>Submitted:</th>
                                <td><?= date('F d, Y h:i A', strtotime($prescription->created_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Prescription Preview Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success">
                        <h4 class="mb-0 text-white"><i class="fa fa-file-medical"></i> Prescription Document</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        $file_path = base_url('uploads/prescriptions/' . $prescription->prescription);
                        $file_exists = file_exists(FCPATH . 'uploads/prescriptions/' . $prescription->prescription);
                        ?>

                        <?php if ($file_exists): ?>
                            <div class="prescription-container text-center">
                                <?php if ($prescription->prescription_type === 'image'): ?>
                                    <!-- Image Preview -->
                                    <div class="mb-3">
                                        <img src="<?= $file_path ?>" alt="Prescription" class="img-fluid rounded shadow"
                                            style="max-height: 600px; cursor: pointer;"
                                            onclick="viewImageFullscreen('<?= $file_path ?>')">
                                        <br><br>
                                        <small class="text-muted"><i class="fa fa-info-circle"></i> Click image to view full
                                            size</small>
                                    </div>
                                <?php else: ?>
                                    <!-- PDF Preview -->
                                    <div class="pdf-preview mb-3">
                                        <iframe src="<?= $file_path ?>" width="100%" height="600px"
                                            style="border: 2px solid #ddd; border-radius: 8px;"></iframe>
                                    </div>
                                <?php endif; ?>

                                <!-- Action Buttons -->
                                <div class="btn-group" role="group">
                                    <a href="<?= $file_path ?>" class="btn btn-primary"
                                        download="<?= $prescription->prescription ?>">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    <a href="<?= $file_path ?>" class="btn btn-info" target="_blank">
                                        <i class="fa fa-external-link-alt"></i> Open in New Tab
                                    </a>
                                    <a href="<?= base_url('contact/prescriptions'); ?>" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back to List
                                    </a>
                                    <a href="<?= base_url('contact/delete_prescription/' . $prescription->id); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this prescription?')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">
                                <i class="fa fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>File Not Found</h5>
                                <p>The prescription file could not be found on the server.</p>
                                <a href="<?= base_url('contact/prescriptions'); ?>" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Image Modal -->
<div id="imageModal"
    style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); overflow: auto;">
    <span onclick="closeImageModal()"
        style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 10000;">&times;</span>
    <img id="modalImage"
        style="margin: auto; display: block; max-width: 95%; max-height: 95%; margin-top: 30px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
</div>

<script>
    function viewImageFullscreen(imageSrc) {
        document.getElementById('imageModal').style.display = 'block';
        document.getElementById('modalImage').src = imageSrc;
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal on click outside image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target.id === 'imageModal') {
            closeImageModal();
        }
    });
</script>

<style>
    .prescription-container {
        padding: 20px;
        background: #f9f9f9;
        border-radius: 8px;
    }

    .img-fluid {
        transition: transform 0.2s;
    }

    .img-fluid:hover {
        transform: scale(1.02);
    }

    #imageModal img {
        animation: zoom 0.3s;
    }

    @keyframes zoom {
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .btn-group .btn {
        margin: 0 5px;
    }

    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-group .btn {
            margin: 0;
            width: 100%;
        }
    }
</style>

<?php $this->load->view("backend/footer"); ?>