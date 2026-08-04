<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-pills"></i>
                Patent Medicines Management
            </h1>
            <p class="page-subtitle">Manage all patent medicines inventory</p>
        </div>
        <div class="header-right">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                <i class="fas fa-plus"></i> Add Medicine
            </button>
        </div>
    </div>

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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-table"></i> All Patent Medicines
                <span class="badge bg-light text-dark ms-2" id="selectedCount">Selected: 0/20</span>
            </h5>
            <div>
                <button id="toggleHomeSelection" class="btn btn-sm btn-warning" type="button">
                    <i class="fas fa-home"></i> Select Homepage (Max 20)
                </button>
                <button type="button" id="saveHomeBtn" class="btn btn-sm btn-success d-none">
                    <i class="fas fa-save"></i> Save Selection
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="medicinesTable" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="home-col d-none text-center" style="width: 50px;">
                                <input type="checkbox" id="checkAllHome" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Company</th>
                            <th>Price</th>
                            <th>Actions</th>
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
                                    <td class="home-col d-none text-center">
                                        <input type="checkbox" class="home-checkbox form-check-input" name="home_ids[]"
                                            value="<?= $m->id; ?>" <?= $isChecked ? 'checked' : ''; ?>>
                                    </td>
                                    <td><strong>#<?= $m->id; ?></strong></td>
                                    <td>
                                        <?php if (!empty($m->image)): ?>
                                            <img src="<?= base_url('assets/images/medicines/' . $m->image); ?>"
                                                alt="<?= $m->name; ?>" class="table-img">
                                        <?php else: ?>
                                            <div class="no-image">No Image</div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $m->name; ?></strong></td>
                                    <td>
                                        <?php
                                        // Get category name from categories
                                        $cat_name = 'N/A';
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->id == $m->category_id) {
                                                    $cat_name = $cat->name;
                                                    break;
                                                }
                                            }
                                        }
                                        echo $cat_name;
                                        ?>
                                    </td>
                                    <td><?= $m->company_name ?? 'N/A'; ?></td>
                                    <td><?= $m->price ? '₹' . number_format($m->price, 2) : 'N/A'; ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-info editBtn" type="button" data-id="<?= $m->id ?>"
                                                data-name="<?= htmlspecialchars($m->name, ENT_QUOTES, 'UTF-8') ?>"
                                                data-category="<?= $m->category_id ?>" data-price="<?= $m->price ?>"
                                                data-company="<?= htmlspecialchars($m->company_name, ENT_QUOTES, 'UTF-8') ?>"
                                                data-origin="<?= htmlspecialchars($m->origin, ENT_QUOTES, 'UTF-8') ?>"
                                                data-strength="<?= htmlspecialchars($m->strength, ENT_QUOTES, 'UTF-8') ?>"
                                                data-active="<?= htmlspecialchars($m->active_ingredient, ENT_QUOTES, 'UTF-8') ?>"
                                                data-supplied="<?= htmlspecialchars($m->how_supplied, ENT_QUOTES, 'UTF-8') ?>"
                                                data-storage="<?= htmlspecialchars($m->storage, ENT_QUOTES, 'UTF-8') ?>"
                                                data-dosage="<?= htmlspecialchars($m->dosage_form, ENT_QUOTES, 'UTF-8') ?>"
                                                data-pack="<?= htmlspecialchars($m->pack_size, ENT_QUOTES, 'UTF-8') ?>"
                                                data-detail="<?= htmlspecialchars($m->detail, ENT_QUOTES, 'UTF-8') ?>"
                                                data-note="<?= htmlspecialchars($m->note, ENT_QUOTES, 'UTF-8') ?>"
                                                data-source="<?= htmlspecialchars($m->source_url, ENT_QUOTES, 'UTF-8') ?>"
                                                data-request="<?= (int)$m->on_request ?>" data-image="<?= $m->image ?>"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="<?= base_url('admin_panel/Patent_Medicines/delete/' . $m->id); ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this medicine?');"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('admin_panel/Patent_Medicines/add') ?>" method="post" enctype="multipart/form-data"
            class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> Add New Medicine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Active Ingredient</label>
                        <input type="text" name="active_ingredient" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Strength</label>
                        <input type="text" name="strength" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">How Supplied</label>
                        <input type="text" name="how_supplied" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Storage</label>
                        <input type="text" name="storage" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dosage Form</label>
                        <input type="text" name="dosage_form" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pack Size</label>
                        <input type="text" name="pack_size" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Origin</label>
                        <input type="text" name="origin" class="form-control" value="India">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">On Request</label>
                        <select name="on_request" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Source URL</label>
                        <input type="url" name="source_url" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Medicine Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Details</label>
                        <textarea name="detail" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Save Medicine
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Medicine Modal -->
<div class="modal fade" id="editMedicineModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form id="editMedicineForm" method="post" enctype="multipart/form-data" class="modal-content">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Edit Medicine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="edit_category_id" class="form-select">
                            <option value="">Select Category</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" id="edit_company_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="edit_price" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Active Ingredient</label>
                        <input type="text" name="active_ingredient" id="edit_active_ingredient" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Strength</label>
                        <input type="text" name="strength" id="edit_strength" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">How Supplied</label>
                        <input type="text" name="how_supplied" id="edit_how_supplied" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Storage</label>
                        <input type="text" name="storage" id="edit_storage" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dosage Form</label>
                        <input type="text" name="dosage_form" id="edit_dosage_form" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pack Size</label>
                        <input type="text" name="pack_size" id="edit_pack_size" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Origin</label>
                        <input type="text" name="origin" id="edit_origin" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">On Request</label>
                        <select name="on_request" id="edit_on_request" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Source URL</label>
                        <input type="url" name="source_url" id="edit_source_url" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Current Image</label>
                        <div class="mb-2">
                            <img id="edit_current_image" src="" alt="Current" class="preview-img" style="display:none;">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Change Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Details</label>
                        <textarea name="detail" id="edit_detail" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Note</label>
                        <textarea name="note" id="edit_note" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Update Medicine
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* CRITICAL: Force checkbox visibility */
    .home-checkbox,
    #checkAllHome {
        position: static !important;
        opacity: 1 !important;
        width: 20px !important;
        height: 20px !important;
        margin: 0 auto !important;
        display: inline-block !important;
        visibility: visible !important;
        cursor: pointer !important;
        -webkit-appearance: checkbox !important;
        -moz-appearance: checkbox !important;
        appearance: checkbox !important;
    }

    .home-col {
        text-align: center !important;
        vertical-align: middle !important;
    }

    table.dataTable tbody td input[type="checkbox"],
    table.dataTable thead th input[type="checkbox"] {
        position: static !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>

<script>
    $(document).ready(function() {
        const maxHome = 20;
        let medicinesTable;

        // Initialize DataTable
        medicinesTable = $('#medicinesTable').DataTable({
            order: [
                [1, 'desc']
            ],
            pageLength: 10,
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });

        // Update selected count
        function updateSelectedCount() {
            const count = $('.home-checkbox:checked').length;
            $('#selectedCount').text('Selected: ' + count + '/20');
        }

        updateSelectedCount();

        // Toggle home selection
        $('#toggleHomeSelection').on('click', function() {
            $('.home-col').toggleClass('d-none');
            $('#saveHomeBtn').toggleClass('d-none');
        });

        // Select All checkbox
        $('#checkAllHome').on('change', function() {
            const isChecked = $(this).prop('checked');
            let count = 0;

            $('.home-checkbox').each(function() {
                if (count < maxHome && isChecked) {
                    $(this).prop('checked', true);
                    count++;
                } else if (!isChecked) {
                    $(this).prop('checked', false);
                }
            });

            updateSelectedCount();
        });

        // Individual checkbox change
        $(document).on('change', '.home-checkbox', function() {
            const count = $('.home-checkbox:checked').length;

            if (count > maxHome) {
                $(this).prop('checked', false);
                alert('Maximum ' + maxHome + ' medicines can be selected for homepage.');
            }

            updateSelectedCount();
        });

        // Save home selection
        $('#saveHomeBtn').on('click', function() {
            const ids = [];
            $('.home-checkbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                alert('Please select at least one medicine.');
                return;
            }

            if (ids.length > maxHome) {
                alert('Please select maximum ' + maxHome + ' medicines.');
                return;
            }

            $.ajax({
                url: '<?= base_url("admin_panel/Patent_Medicines/save_home") ?>',
                type: 'POST',
                data: {
                    home_ids: ids
                },
                beforeSend: function() {
                    $('#loadingSpinner').show();
                },
                success: function(response) {
                    $('#loadingSpinner').hide();
                    alert('Homepage selection saved successfully!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('#loadingSpinner').hide();
                    alert('Error saving selection: ' + error);
                }
            });
        });

        // Edit button
        $('.editBtn').on('click', function() {
            const id = $(this).data('id');

            $('#edit_id').val(id);
            $('#edit_name').val($(this).data('name'));
            $('#edit_category_id').val($(this).data('category'));
            $('#edit_price').val($(this).data('price'));
            $('#edit_company_name').val($(this).data('company'));
            $('#edit_origin').val($(this).data('origin'));
            $('#edit_strength').val($(this).data('strength'));
            $('#edit_active_ingredient').val($(this).data('active'));
            $('#edit_how_supplied').val($(this).data('supplied'));
            $('#edit_storage').val($(this).data('storage'));
            $('#edit_dosage_form').val($(this).data('dosage'));
            $('#edit_pack_size').val($(this).data('pack'));
            $('#edit_detail').val($(this).data('detail'));
            $('#edit_note').val($(this).data('note'));
            $('#edit_source_url').val($(this).data('source'));
            $('#edit_on_request').val($(this).data('request'));

            const img = $(this).data('image');
            if (img) {
                $('#edit_current_image')
                    .attr('src', '<?= base_url("assets/images/medicines/") ?>' + img)
                    .show();
            }

            $('#editMedicineForm').attr('action', '<?= base_url("admin_panel/Patent_Medicines/edit/") ?>' +
                id);

            const editModal = new bootstrap.Modal(document.getElementById('editMedicineModal'));
            editModal.show();
        });
    });
</script>

<?php $this->load->view("backend/footer"); ?>