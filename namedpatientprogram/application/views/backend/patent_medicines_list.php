<?php $this->load->view("backend/header"); ?>
<style>
    .home - checkbox,
    #checkAllHome {
        position: static !important;
        left: auto !important;
        opacity: 1 !important;
        display: block !important;
        margin: 0 auto;
        width: auto;
        height: auto;
    }

    th.home - col,
    td.home - col {
        width: 40 px;
        text - align: center;
    }

    .custom - alert {
        position: fixed;
        top: 80 px;
        right: 20 px;
        z - index: 9999;
        padding: 15 px 20 px;
        border - radius: 5 px;
        box - shadow: 0 4 px 8 px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3 s ease - out;
    }

    .custom - success {
        background - color: #28a745;
        color: white;
    }

    .custom-danger {
        background - color: # dc3545;
        color: white;
    }

    .custom - close {
        cursor: pointer;
        float: right;
        font - size: 20 px;
        font - weight: bold;
        margin - left: 15 px;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100 %);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
<style>
    /* Custom styling for import modal */
    #importExcelModal .modal-dialog {
        max-width: 900px;
    }

    #importExcelModal pre {
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        white-space: pre-wrap;
    }

    #importExcelModal .card-body {
        scrollbar-width: thin;
    }

    #importExcelModal .card-body::-webkit-scrollbar {
        width: 8px;
    }

    #importExcelModal .card-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    #importExcelModal .alert {
        border-left: 4px solid;
    }

    #importExcelModal .alert-info {
        border-left-color: #17a2b8;
    }

    #importExcelModal .alert-warning {
        border-left-color: #ffc107;
    }

    #importExcelModal .alert-success {
        border-left-color: #28a745;
    }

    #importExcelModal .btn-outline-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
</style>
<?php $this->load->view("backend/sidebar"); ?>

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
            <h3><i class="fa fa-medkit"></i> Patent Medicines</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Patent Medicines</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button class="btn btn-info" data-toggle="modal" data-target="#addMedicineModal">
                    <i class="fa fa-plus"></i> Add Medicine
                </button>
                <button class="btn btn-success" data-toggle="modal" data-target="#importExcelModal">
                    <i class="fa fa-file-excel"></i> Import Excel
                </button>
                <button id="bulkDeleteToggle" class="btn btn-danger ">
                    <i class="fa fa-trash"></i> Bulk Delete
                </button>
            </div>
        </div>

        <div class="card card-outline-info">
            <!-- <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-b-0 text-white"><i class="fa fa-list"></i> Patent Medicines List</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form method="GET">
                            <select name="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">All Categories</option>

                                <?php foreach ($med_categories as $category): ?>
                                    <option value="<?= $category->id; ?>" <?= ($selected_category == $category->id) ? 'selected' : ''; ?>>
                                        <?= $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
                <button id="toggleHomeSelection" class="btn btn-warning btn-sm" type="button">
                    Select Homepage Medicines
                </button>
            </div> -->
            <div class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center">

                    <!-- Left Side -->
                    <h4 class="m-0 text-white">
                        <i class="fa fa-list"></i> Patent Medicines List
                    </h4>

                    <!-- Right Side -->
                    <div class="d-flex align-items-center">

                        <form method="GET" class="mr-2 mb-0">
                            <select name="category_id" class="form-control" onchange="this.form.submit()"
                                style="min-width:220px;">
                                <option value="">Filter Medicines</option>

                                <?php foreach ($med_categories as $category): ?>
                                    <option value="<?= $category->id; ?>" <?= ($selected_category == $category->id) ? 'selected' : ''; ?>>
                                        <?= $category->name; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </form>

                        <button id="toggleHomeSelection" class="btn btn-warning btn-sm">
                            <i class="fa fa-home"></i> Select Homepage Medicines
                        </button>

                    </div>

                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin_panel/Patent_Medicines/save_home'); ?>" method="post" id="homeForm">
                    <div class="table-responsive">
                        <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                            width="100%" id="medicinesTable">
                            <thead>

                                <tr>
                                    <th class="bulk-col d-none" width="40">
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th class="home-col d-none"></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Company</th>
                                    <th>Strength</th>
                                    <th>Origin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($medicines)): ?>
                                    <?php
                                    $selected_ids = isset($home_selected_ids) ? $home_selected_ids : [];
                                    foreach ($medicines as $m):
                                        $isChecked = in_array($m->id, $selected_ids);
                                        ?>
                                        <tr>
                                            <td class="bulk-col d-none">
                                                <input type="checkbox" class="medicine-checkbox" value="<?= $m->id; ?>">
                                            </td>
                                            <td class="home-col d-none">
                                                <input type="checkbox" class="home-checkbox" name="home_ids[]"
                                                    value="<?= $m->id; ?>" <?= $isChecked ? 'checked' : ''; ?>>
                                            </td>
                                            <td><?= $m->id; ?></td>
                                            <td><?= $m->name; ?></td>
                                            <td>
                                                <?php if (!empty($m->image)): ?>
                                                    <img src="<?= base_url('assets/images/medicines/' . $m->image); ?>" width="40">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $m->category_name; ?></td>
                                            <td><?= $m->price; ?></td>
                                            <td><?= $m->company_name; ?></td>
                                            <td><?= $m->strength; ?></td>
                                            <td><?= $m->origin; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm editBtn"
                                                    data-id="<?= (int) $m->id ?>"
                                                    data-name="<?= htmlspecialchars($m->name, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-category="<?= htmlspecialchars($m->category_id, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-price="<?= htmlspecialchars($m->price, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-company="<?= htmlspecialchars($m->company_name, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-origin="<?= htmlspecialchars($m->origin, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-strength="<?= htmlspecialchars($m->strength, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-routes="<?= htmlspecialchars($m->routes, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-regulatory_approval="<?= htmlspecialchars($m->regulatory_approval, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-image="<?= htmlspecialchars($m->image, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-active="<?= htmlspecialchars($m->active_ingredient, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-supplied="<?= htmlspecialchars($m->how_supplied, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-storage="<?= htmlspecialchars($m->storage, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-dosage="<?= htmlspecialchars($m->dosage_form, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-pack="<?= htmlspecialchars($m->pack_size, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-detail="<?= htmlspecialchars($m->detail, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-note="<?= htmlspecialchars($m->note, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-source="<?= htmlspecialchars($m->source_url, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-drug_class="<?= htmlspecialchars($m->drug_class, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-request="<?= (int) $m->on_request ?>"
                                                    data-medical_uses="<?= htmlspecialchars($m->medical_uses, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-warning_precautions="<?= htmlspecialchars($m->warning_precautions, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-documentation_availability="<?= htmlspecialchars($m->documentation_availability, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-sourcing_delivery="<?= htmlspecialchars($m->sourcing_delivery, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-our_process="<?= htmlspecialchars($m->our_process, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-faq="<?= htmlspecialchars($m->faq, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-disclaimer="<?= htmlspecialchars($m->disclaimer, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-treatment_access="<?= htmlspecialchars($m->treatment_access, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-written_by="<?= htmlspecialchars($m->written_by, ENT_QUOTES, 'UTF-8') ?>"
                                                    data-medically_reviewed_by="<?= htmlspecialchars($m->medically_reviewed_by, ENT_QUOTES, 'UTF-8') ?>">
                                                    Edit
                                                </button>
                                                <a href="<?= base_url('admin_panel/Patent_Medicines/delete/' . $m->id); ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="saveHomeWrapper" class="m-t-15 d-none">
                        <button type="submit" class="btn btn-success">Save Homepage Medicines (max 20)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ADD MEDICINE MODAL -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form action="<?= base_url('admin_panel/Patent_Medicines/add') ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Medicine</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($med_categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Price</label>
                        <input type="number" step="any" name="price" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Active Ingredient</label>
                        <input type="text" name="active_ingredient" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>How Supplied</label>
                        <input type="text" name="how_supplied" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Storage</label>
                        <input type="text" name="storage" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Dosage Form</label>
                        <input type="text" name="dosage_form" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Pack Size</label>
                        <input type="text" name="pack_size" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Origin</label>
                        <input type="text" name="origin" class="form-control" value="India">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Strength</label>
                        <input type="text" name="strength" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>On Request</label>
                        <select name="on_request" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Routes</label>
                        <input type="text" name="routes" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Regulatory Approval</label>
                        <input type="text" name="regulatory_approval" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Drug Class</label>
                    <input type="text" name="drug_class" class="form-control">
                </div>
                <div class="form-group">
                    <label>Source URL</label>
                    <input type="text" name="source_url" class="form-control">
                </div>
                <div class="form-group">
                    <label>Image (jpeg, png, webp, avif)</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Detail</label>
                    <textarea name="detail" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" class="form-control" rows="3"></textarea>
                </div>
                <hr>
                <h5 class="text-primary mt-3 mb-3">Additional Information</h5>
                <div class="form-group">
                    <label>Medical Uses & Therapeutic Indications</label>
                    <textarea id="medical_uses" name="medical_uses" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Warnings, Precautions & Contraindications</label>
                    <textarea id="warning_precautions" name="warning_precautions" class="form-control"
                        rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Documentation & Product Availability</label>
                    <textarea id="documentation_availability" name="documentation_availability" class="form-control"
                        rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Sourcing Process & Delivery Timeline</label>
                    <textarea id="sourcing_delivery" name="sourcing_delivery" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Our Process</label>
                    <textarea id="our_process" name="our_process" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Treatment Access</label>
                    <textarea id="treatment_access" name="treatment_access" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>FAQ (Frequently Asked Questions)</label>
                    <textarea id="faq" name="faq" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Disclaimer & Legal Notices</label>
                    <textarea id="disclaimer" name="disclaimer" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Treatment Access</label>
                    <textarea id="treatment_access" name="treatment_access" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Written By</label>
                    <textarea id="written_by" name="written_by" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Medically Reviewed By</label>
                    <textarea id="medically_reviewed_by" name="medically_reviewed_by" class="form-control"
                        rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save Medicine</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT MEDICINE MODAL -->
<div class="modal fade" id="editMedicineModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form id="editMedicineForm" method="post" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header">
                <h4 class="modal-title">Edit Medicine</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Category</label>
                        <select name="category_id" id="edit_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($med_categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Price</label>
                        <input type="number" step="any" name="price" id="edit_price" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Company Name</label>
                        <input type="text" name="company_name" id="edit_company_name" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Active Ingredient</label>
                        <input type="text" name="active_ingredient" id="edit_active_ingredient" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>How Supplied</label>
                        <input type="text" name="how_supplied" id="edit_how_supplied" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Storage</label>
                        <input type="text" name="storage" id="edit_storage" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Dosage Form</label>
                        <input type="text" name="dosage_form" id="edit_dosage_form" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Pack Size</label>
                        <input type="text" name="pack_size" id="edit_pack_size" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Origin</label>
                        <input type="text" name="origin" id="edit_origin" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Strength</label>
                        <input type="text" name="strength" id="edit_strength" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>On Request</label>
                        <select name="on_request" id="edit_on_request" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Routes</label>
                        <input type="text" name="routes" id="edit_routes" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Regulatory Approval</label>
                        <input type="text" name="regulatory_approval" id="edit_regulatory_approval"
                            class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Drug Class</label>
                    <input type="text" name="drug_class" id="edit_drug_class" class="form-control">
                </div>
                <div class="form-group">
                    <label>Source URL</label>
                    <input type="text" name="source_url" id="edit_source_url" class="form-control">
                </div>
                <div class="form-group">
                    <label>Current Image</label><br>
                    <img id="edit_current_image" src="" width="80px">
                </div>
                <div class="form-group">
                    <label>New Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>Detail</label>
                    <textarea name="detail" id="edit_detail" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" id="edit_note" class="form-control"></textarea>
                </div>
                <hr>
                <h5 class="text-primary mt-3 mb-3">Additional Information</h5>
                <div class="form-group">
                    <label>Medical Uses & Therapeutic Indications</label>
                    <textarea name="medical_uses" id="edit_medical_uses" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Warnings, Precautions & Contraindications</label>
                    <textarea name="warning_precautions" id="edit_warning_precautions" class="form-control"
                        rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Documentation & Product Availability</label>
                    <textarea name="documentation_availability" id="edit_documentation_availability"
                        class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Sourcing Process & Delivery Timeline</label>
                    <textarea name="sourcing_delivery" id="edit_sourcing_delivery" class="form-control"
                        rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Our Process</label>
                    <textarea name="our_process" id="edit_our_process" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>FAQ (Frequently Asked Questions)</label>
                    <textarea name="faq" id="edit_faq" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Disclaimer & Legal Notices</label>
                    <textarea name="disclaimer" id="edit_disclaimer" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Treatment Access</label>
                    <textarea name="treatment_access" id="edit_treatment_access" class="form-control"
                        rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Written By</label>
                    <textarea name="written_by" id="edit_written_by" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Medically Reviewed By</label>
                    <textarea name="medically_reviewed_by" id="edit_medically_reviewed_by" class="form-control"
                        rows="4"></textarea>
                </div>
                <!-- <div class="form-group">
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- IMPORT EXCEL MODAL - FIXED VERSION WITH WORKING DOWNLOADS -->
<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= base_url('admin_panel/Patent_Medicines/import_excel') ?>" method="post"
            enctype="multipart/form-data" id="importExcelForm" class="modal-content">

            <div class="modal-header bg-success text-white">
                <h4 class="modal-title">
                    <i class="fa fa-file-excel"></i> Import Medicines from CSV
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Important Instructions -->
                <div class="alert alert-info">
                    <h5><i class="fa fa-info-circle"></i> <strong>Required CSV Format:</strong></h5>
                    <p class="mb-2">Your file must contain these columns (exact names, case-insensitive):</p>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Required Columns:</strong>
                            <ul class="mb-0">
                                <li><code>name</code> - Medicine name</li>
                                <li><code>category_id</code> - Category ID (see table below)</li>
                                <li><code>strength</code> - Medicine strength/dosage</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <strong>Optional Columns:</strong>
                            <ul class="mb-0">
                                <li><code>price</code>, <code>company_name</code></li>
                                <li><code>active_ingredient</code></li>
                                <li><code>storage</code>, <code>origin</code></li>
                                <li><code>detail</code>, <code>note</code></li>
                                <li><code>medical_uses</code>, <code>faq</code>, etc.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">
                                <i class="fa fa-upload"></i> Select File CSV
                            </label>
                            <input type="file" name="excel_file" id="excelFileInput" class="form-control"
                                accept=".xlsx,.xls,.csv" required>
                            <small class="form-text text-muted">
                                Supported formats: <strong> .csv</strong> | Maximum file size:
                                <strong>10MB</strong>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Download Templates Section -->
                <!-- <div class="alert alert-success">
                    <div class="row">
                        <div class="col-md-12">
                            <strong><i class="fa fa-download"></i> Download Template Files:</strong>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <a href="<?= base_url('admin_panel/Patent_Medicines/download_template') ?>"
                                class="btn btn-outline-success btn-block" target="_blank">
                                <i class="fa fa-file-csv"></i> Download CSV Template
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('admin_panel/Patent_Medicines/download_excel_template') ?>"
                                class="btn btn-outline-success btn-block" target="_blank">
                                <i class="fa fa-file-excel"></i> Download Excel Template
                            </a>
                        </div>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fa fa-info-circle"></i> These templates contain sample data with all available columns
                    </small>
                </div> -->

                <!-- Sample Format Preview -->
                <div class="alert alert-warning">
                    <strong><i class="fa fa-table"></i> Sample Format:</strong>
                    <pre class="bg-dark text-white p-2 mt-2 mb-0" style="font-size: 10px; overflow-x: auto;">name,category_id,strength,price,company_name,active_ingredient,origin
Aspirin Tablets,1,500mg,12.50,PharmaCo,Acetylsalicylic Acid,India
Amoxicillin Capsules,2,250mg,25.00,HealthMed,Amoxicillin Trihydrate,USA</pre>
                </div>

                <!-- Category Reference Table -->
                <div class="card">
                    <div class="card-header bg-light">
                        <strong><i class="fa fa-list"></i> Available Categories (Use these IDs)</strong>
                    </div>
                    <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-sm table-striped table-bordered mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="80">ID</th>
                                    <th>Category Name</th>
                                    <th width="100">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($med_categories)): ?>
                                    <?php foreach ($med_categories as $cat): ?>
                                        <tr>
                                            <td class="text-center">
                                                <strong class="text-primary"><?= $cat->id ?></strong>
                                            </td>
                                            <td><?= htmlspecialchars($cat->name) ?></td>
                                            <td>
                                                <span
                                                    class="badge badge-<?= $cat->status === 'active' ? 'success' : 'secondary' ?>">
                                                    <?= ucfirst($cat->status) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-danger">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            No categories found. Please create categories first before importing medicines.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tips -->
                <div class="alert alert-info mt-3 mb-0">
                    <strong><i class="fa fa-lightbulb"></i> Tips:</strong>
                    <ul class="mb-0 mt-2">
                        <!-- <li>Excel files (.xlsx, .xls) are automatically converted to CSV</li> -->
                        <li>First row must contain column headers (case-insensitive)</li>
                        <li>Empty rows are automatically skipped</li>
                        <li>Category ID must match an existing category from the table above</li>
                        <li>Use <code>0</code> or <code>1</code> for on_request field (optional)</li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success" id="importBtn">
                    <i class="fa fa-upload"></i> Import Now
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Import Modal -->

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $('#checkAll').change(function () {
        $('.medicine-checkbox').prop('checked', this.checked);
    });

    $('#bulkDeleteBtn').click(function () {
        let ids = [];

        $('.medicine-checkbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length == 0) {
            alert('Please select at least one medicine.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected medicines?')) {
            return;
        }

        $.ajax({

            url: "<?= base_url('admin_panel/Patent_Medicines/bulk_delete'); ?>",
            type: "POST",

            data: {
                ids: ids
            },

            dataType: "json",

            success: function (response) {

                if (response.status == "success") {
                    location.reload();
                } else {
                    alert(response.message);
                }

            }

        });

    });
</script>

<script>
    $(document).ready(function () {
        $('#edit_medical_uses').summernote({
            height: 200
        });
        $('#edit_warning_precautions').summernote({
            height: 200
        });
        $('#edit_documentation_availability').summernote({
            height: 200
        });
        $('#edit_sourcing_delivery').summernote({
            height: 200
        });
        $('#edit_our_process').summernote({
            height: 200
        });
        $('#edit_faq').summernote({
            height: 200
        });
        $('#edit_disclaimer').summernote({
            height: 200
        });
        $('#edit_treatment_access').summernote({
            height: 200
        });
    });
</script>

<script>
    $(document).ready(function () {
        // File selection feedback
        $('#excelFileInput').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            var fileSize = this.files[0].size / 1024 / 1024; // Convert to MB

            if (fileSize > 10) {
                alert('File size must not exceed 10MB. Your file is ' + fileSize.toFixed(2) + 'MB');
                $(this).val('');
                return;
            }

            var fileExt = fileName.split('.').pop().toLowerCase();
            var icon = fileExt === 'csv' ? 'fa-file-csv' : 'fa-file-excel';

            $(this).next('.form-text').html(
                '<i class="fa ' + icon + ' text-success"></i> Selected: <strong>' + fileName +
                '</strong> (' +
                fileSize.toFixed(2) + ' MB)'
            );
        });

        // Form submission validation
        $('#importExcelForm').on('submit', function (e) {
            var fileInput = $('#excelFileInput')[0];

            // Check if file is selected
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Please select a file to import');
                return false;
            }

            var file = fileInput.files[0];
            var fileSize = file.size / 1024 / 1024; // MB

            // Validate file size
            if (fileSize > 10) {
                e.preventDefault();
                alert('File size must not exceed 10MB');
                return false;
            }

            // Validate file extension
            var allowedExtensions = /(\.xlsx|\.xls|\.csv)$/i;
            if (!allowedExtensions.exec(file.name)) {
                e.preventDefault();
                alert('Please upload a valid Excel (.xlsx, .xls) or CSV file');
                return false;
            }

            // Show loading state
            $('#importBtn').html('<i class="fa fa-spinner fa-spin"></i> Importing... Please wait').prop(
                'disabled', true);
            $('#excelFileInput').prop('disabled', true);
            $('.btn-secondary').prop('disabled', true);

            // Allow form to submit
            return true;
        });
    });
</script>



<?php $this->load->view("backend/footer"); ?>

<script>
    let bulkMode = false;

    $('#bulkDeleteToggle').click(function () {

        if (!bulkMode) {

            bulkMode = true;

            $('.bulk-col').removeClass('d-none');

            $(this)
                .removeClass('btn-danger')
                .addClass('btn-success')
                .html('<i class="fa fa-trash"></i> Delete Selected');

        } else {

            let ids = [];

            $('.medicine-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                alert('Please select at least one medicine.');
                return;
            }

            if (!confirm('Delete selected medicines?')) {
                return;
            }

            $.ajax({

                url: "<?= base_url('admin_panel/Patent_Medicines/bulk_delete'); ?>",

                type: "POST",

                data: {
                    ids: ids
                },

                dataType: "json",

                success: function (response) {

                    if (response.status == "success") {

                        alert(response.message);

                        location.reload();

                    } else {

                        alert(response.message);

                    }

                }

            });

        }

    });
    $(document).ready(function () {
        var table = $('#medicinesTable').DataTable({
            "order": [
                [1, 'desc']
            ],
            "pageLength": 25,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "columnDefs": [{
                "orderable": false,
                "searchable": false,
                "targets": 0
            }, // bulk-col
            {
                "orderable": false,
                "searchable": false,
                "targets": 1
            }, // home-col (good idea to add this too)
            {
                "orderable": false,
                "searchable": false,
                "targets": 4
            }, // Image
            {
                "orderable": false,
                "searchable": false,
                "targets": 10
            } // Action
            ],
            "language": {
                "search": "Search medicines:",
                "lengthMenu": "Show _MENU_ medicines per page",
                "info": "Showing _START_ to _END_ of _TOTAL_ medicines",
                "infoFiltered": "(filtered from _MAX_ total)",
                "zeroRecords": "No matching medicines found"
            }
        });

        const maxHome = 20;

        $('#toggleHomeSelection').on('click', function () {
            $('.home-col').toggleClass('d-none');
            $('#saveHomeWrapper').toggleClass('d-none');
        });

        $(document).on('change', '.home-checkbox', function () {
            let count = $('.home-checkbox:checked').length;
            if (count > maxHome) {
                this.checked = false;
                alert('You can select maximum ' + maxHome + ' medicines for homepage.');
            }
        });

        $('#excelFileInput').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.form-text').html('<i class="fa fa-check text-success"></i> Selected: ' +
                fileName);
        });

        $('#importExcelForm').on('submit', function (e) {
            var fileInput = $('#excelFileInput')[0];

            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Please select an Excel file');
                return false;
            }

            var file = fileInput.files[0];
            var fileSize = file.size / 1024 / 1024;

            if (fileSize > 10) {
                e.preventDefault();
                alert('File size must not exceed 10MB');
                return false;
            }

            var allowedExtensions = /(\.xlsx|\.xls|\.csv)$/i;
            if (!allowedExtensions.exec(file.name)) {
                e.preventDefault();
                alert('Please upload a valid Excel or CSV file');
                return false;
            }

            $('#importBtn').html('<i class="fa fa-spinner fa-spin"></i> Importing...').prop('disabled',
                true);
        });

        $('#medicinesTable').on('click', '.editBtn', function () {
            let id = $(this).data('id');
            $('#edit_id').val(id);
            $('#edit_name').val($(this).data('name'));
            $('#edit_category_id').val($(this).data('category'));
            $('#edit_price').val($(this).data('price'));
            $('#edit_company_name').val($(this).data('company'));
            $('#edit_origin').val($(this).data('origin'));
            $('#edit_strength').val($(this).data('strength'));
            $('#edit_routes').val($(this).data('routes'));
            $('#edit_regulatory_approval').val($(this).data('regulatory_approval'));
            $('#edit_active_ingredient').val($(this).data('active'));
            $('#edit_how_supplied').val($(this).data('supplied'));
            $('#edit_storage').val($(this).data('storage'));
            $('#edit_dosage_form').val($(this).data('dosage'));
            $('#edit_pack_size').val($(this).data('pack'));
            $('#edit_detail').val($(this).data('detail'));
            $('#edit_note').val($(this).data('note'));
            $('#edit_source_url').val($(this).data('source'));
            $('#edit_drug_class').val($(this).data('drug_class'));
            $('#edit_on_request').val($(this).data('request'));
            $('#edit_medical_uses').summernote('code', $(this).data('medical_uses'));
            $('#edit_warning_precautions').summernote('code', $(this).data('warning_precautions'));
            $('#edit_documentation_availability').summernote('code', $(this).data(
                'documentation_availability'));
            $('#edit_sourcing_delivery').summernote('code', $(this).data('sourcing_delivery'));
            $('#edit_our_process').summernote('code', $(this).data('our_process'));
            $('#edit_faq').summernote('code', $(this).data('faq'));
            $('#edit_disclaimer').summernote('code', $(this).data('disclaimer'));
            $('#edit_treatment_access').summernote('code', $(this).data('treatment_access'));
            $('#edit_written_by').val($(this).data('written_by'));
            $('#edit_medically_reviewed_by').val($(this).data('medically_reviewed_by'));
            let img = $(this).data('image');
            $('#edit_current_image').attr('src', '<?= base_url("assets/images/medicines/") ?>' + img);
            $('#editMedicineForm').attr('action', '<?= base_url("admin_panel/Patent_Medicines/edit/") ?>' +
                id);
            $('#editMedicineModal').modal('show');
        });
    });
</script>



<script>
    // $('.summernote').summernote({
    //     height: 200,
    //     dialogsInBody: true,
    //     disableDragAndDrop: false,
    //     codeviewFilter: false,
    //     codeviewIframeFilter: false
    // });
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

        fontNames: [
            'Arial',
            'Calibri',
            'Times New Roman',
            'Verdana',
            'Tahoma',
            'Georgia'
        ],

        fontSizes: [
            '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48', '64'
        ]
    });


    $(document).ready(function () {
        $('#medical_uses, #warning_precautions,#our_process, #documentation_availability, #sourcing_delivery, #faq, #disclaimer,#treatment_access, #edit_medical_uses, #edit_warning_precautions, #edit_documentation_availability, #edit_sourcing_delivery,#edit_our_process, #edit_faq, #edit_disclaimer,#edit_treatment_access')
            .summernote({
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

                fontNames: [
                    'Arial',
                    'Calibri',
                    'Times New Roman',
                    'Verdana',
                    'Tahoma',
                    'Georgia'
                ],

                fontSizes: [
                    '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48', '64'
                ]
            });
        // .summernote({
        //     height: 200,
        //     codeviewFilter: false,
        //     codeviewIframeFilter: false
        // });

    });
</script>

<script>
    $(document).ready(function () {



        const editors = [
            '#medical_uses',
            '#warning_precautions',
            '#documentation_availability',
            '#sourcing_delivery',
            '#our_process',
            '#faq',
            '#disclaimer',
            '#edit_medical_uses',
            '#edit_warning_precautions',
            '#edit_documentation_availability',
            '#edit_sourcing_delivery',
            '#edit_our_process',
            '#edit_faq',
            '#edit_disclaimer',
            '#edit_treatment_access'
        ];

        editors.forEach(function (id) {
            $(id).summernote({
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

                fontNames: [
                    'Arial',
                    'Calibri',
                    'Times New Roman',
                    'Verdana',
                    'Tahoma',
                    'Georgia'
                ],

                fontSizes: [
                    '8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36',
                    '48', '64'
                ]
            });
            // summernote({
            //     height: 200
            // });
        });

    });
</script>