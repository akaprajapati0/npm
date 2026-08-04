<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-cog"></i>
                CMS Settings
            </h1>
            <p class="page-subtitle">Manage your website settings and configuration</p>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="custom-alert custom-success">
        <span class="custom-close" onclick="this.parentElement.style.display='none';">&times;</span>
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>


    <?php echo validation_errors('<div class="custom-alert custom-danger"><span class="custom-close" onclick="this.parentElement.style.display=\'none\';">&times;</span>', '</div>'); ?>

    <!-- Settings Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-sliders-h"></i> Website Configuration
            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('settings/Add_Settings'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $settingsvalue->id; ?>">

                <div class="row g-4">
                    <!-- Site Logo Section -->
                    <div class="col-12">
                        <div class="settings-section">
                            <h6 class="section-title">
                                <i class="fas fa-image"></i> Site Logo
                            </h6>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="logo-preview">
                                        <?php
$image_url = base_url('assets/images/default.png'); // fallback

if (!empty($settingsvalue->sitelogo) && file_exists(FCPATH . 'assets/images/' . $settingsvalue->sitelogo)) {
    $image_url = base_url('assets/images/' . $settingsvalue->sitelogo);
}
?>
<img src="<?= $image_url; ?>" alt="Site Logo" class="max-w-full max-h-[350px] md:max-h-[450px] object-contain">



                                    </div>
                                </div>
                                <div class="col-md-8">
    <label for="img_url" class="btn btn-info">
        <i class="fas fa-camera"></i> Change Logo
    </label>
    <input type="file" id="img_url" name="img_url" accept="image/*" style="display: none;">

    <p class="mt-2 text-primary fw-bold" id="currentFileName">
    <?= !empty($settingsvalue->sitelogo) ? $settingsvalue->sitelogo : 'No logo uploaded'; ?>
</p>

<p class="text-success mt-2 fw-semibold" id="newFileName" style="display:none;"></p>


    <p class="text-success mt-2 fw-semibold" id="newFileName"></p>

    <p class="text-muted mt-2 mb-0">Recommended size: 200x80px (PNG, JPG, SVG)</p>
</div>

                            </div>
                        </div>
                    </div>

                    <!-- Site Information -->
                    <div class="col-12">
                        <div class="settings-section">
                            <h6 class="section-title">
                                <i class="fas fa-info-circle"></i> Site Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Site Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title"
                                        value="<?php echo $settingsvalue->sitetitle; ?>" id="title" required
                                        minlength="7" maxlength="120">
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Site Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required
                                        minlength="20"
                                        maxlength="512"><?php echo $settingsvalue->description; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-12">
                        <div class="settings-section">
                            <h6 class="section-title">
                                <i class="fas fa-address-book"></i> Contact Information
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">System Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="<?php echo $settingsvalue->system_email; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" name="contact" id="contact"
                                        value="<?php echo $settingsvalue->contact; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="<?php echo $settingsvalue->address; ?>">
                                </div>
                                <div class="col-md-12">
                                    <label for="address2" class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control" name="address2" id="address2"
                                        value="<?php echo $settingsvalue->address2; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Settings -->
                    <div class="col-12">
                        <div class="settings-section">
                            <h6 class="section-title">
                                <i class="fas fa-dollar-sign"></i> Currency & Copyright
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="currency" class="form-label">Currency</label>
                                    <input type="text" class="form-control" name="currency" id="currency"
                                        value="<?php echo $settingsvalue->currency; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="symbol" class="form-label">Currency Symbol</label>
                                    <input type="text" class="form-control" name="symbol" id="symbol"
                                        value="<?php echo $settingsvalue->symbol; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="copyright" class="form-label">Copyright Text</label>
                                    <input type="text" class="form-control" name="copyright" id="copyright"
                                        value="<?php echo $settingsvalue->copyright; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-save"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .settings-section {
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .logo-preview {
        background: white;
        padding: 20px;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
        text-align: center;
        min-height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-preview img {
        max-height: 120px;
        max-width: 100%;
    }

    .btn-info[for="img_url"] {
        cursor: pointer;
    }

    .btn-info[for="img_url"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 201, 240, 0.4);
    }
</style>

<script>
$(document).ready(function() {

    // Show preview and update filename only when new file selected
    $('#img_url').on('change', function(e) {
        const file = e.target.files[0];

        if (file) {

            // Hide current file name
            $('#currentFileName').hide();

            // Show new selected file name
            $('#newFileName').text("Selected File: " + file.name).show();

            // Preview the uploaded image
            const reader = new FileReader();
            reader.onload = function(event) {
                $('.logo-preview img').attr('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Validation + auto alert fade
    $('form').on('submit', function(e) {
        const title = $('#title').val().trim();
        const description = $('#description').val().trim();

        if (title.length < 7) {
            e.preventDefault();
            alert('Site title must be at least 7 characters long.');
            $('#title').focus();
            return false;
        }

        if (description.length < 20) {
            e.preventDefault();
            alert('Site description must be at least 20 characters long.');
            $('#description').focus();
            return false;
        }
    });

    setTimeout(function(){
        $('.custom-alert').fadeOut('slow');
    }, 3000);
});
</script>




<?php $this->load->view('backend/footer'); ?>