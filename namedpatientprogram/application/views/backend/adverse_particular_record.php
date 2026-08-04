<?php $this->load->view("backend/header"); ?>
<?php $this->load->view("backend/sidebar"); ?>

<div class="page-wrapper">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white">Adverse Event Details</h4>
            </div>

            <div class="card-body">

                <!-- Patient Details -->
                <h3 class="mb-3 text-primary">1. Patient Details</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Patient Name</th>
                        <td>
                            <?= $record->patient_name ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date Of Birth</th>
                        <td>
                            <?= $record->date_of_birth ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td>
                            <?= $record->age ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>
                            <?= $record->gender ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td>
                            <?= $record->weight ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Height</th>
                        <td>
                            <?= $record->height ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Additional Info</th>
                        <td>
                            <?= $record->additional_info ?>
                        </td>
                    </tr>
                </table>

                <!-- Reporter Information -->
                <h3 class="mb-3 mt-4 text-primary">2. Reporter Information</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Reporter Name</th>
                        <td>
                            <?= $record->reporter_name ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            <?= $record->reporter_address ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <?= $record->reporter_email ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Qualification</th>
                        <td>
                            <?= $record->reporter_qualification ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Other Qualification</th>
                        <td>
                            <?= $record->other_qualification ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>
                            <?= $record->country ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>
                            <?= $record->phone_number ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Report Date</th>
                        <td>
                            <?= $record->report_date ?>
                        </td>
                    </tr>
                </table>

                <!-- Suspected Medicine -->
                <h3 class="mb-3 mt-4 text-primary">3. Suspected Medicine</h3>
                <?php $i = 1; ?>

                <?php foreach ($medicines as $medicine): ?>
                    <h2 class="bg-secondary p-2 text-white">Medicine: <?= $i++ ?></h2>
                    <table class="table table-bordered">

                        <tr>
                            <th>Medicine Name</th>
                            <td><?= $medicine->medicine_name ?></td>
                        </tr>

                        <tr>
                            <th>Manufacturer</th>
                            <td><?= $medicine->manufacturer ?></td>
                        </tr>

                        <tr>
                            <th>Batch</th>
                            <td><?= $medicine->batch ?></td>
                        </tr>

                        <tr>
                            <th>Expiry</th>
                            <td><?= $medicine->expiry ?></td>
                        </tr>

                        <tr>
                            <th>Dose</th>
                            <td><?= $medicine->dose ?></td>
                        </tr>

                        <tr>
                            <th>Route</th>
                            <td><?= $medicine->route ?></td>
                        </tr>

                        <tr>
                            <th>Treatment Start Date</th>
                            <td><?= $medicine->treatment_start_date ?></td>
                        </tr>
                        <tr>
                            <th>Treatment End Date</th>
                            <td><?= $medicine->treatment_stop_date ?></td>
                        </tr>
                        <tr>
                            <th>Causality Assessment</th>
                            <td><?= $medicine->causality_assessment ?></td>
                        </tr>
                        <tr>
                            <th>Frequency</th>
                            <td><?= $medicine->frequency ?></td>
                        </tr>

                        <tr>
                            <th>Dechallenge</th>
                            <td><?= $medicine->dechallenge ?></td>
                        </tr>

                        <tr>
                            <th>Rechallenge</th>
                            <td><?= $medicine->rechallenge ?></td>
                        </tr>


                    </table>
                <?php endforeach; ?>
                <!-- Adverse Event Description -->
                <h3 class="mb-3 mt-4 text-primary">4. Adverse Event Description</h3>

                <table class="table table-bordered">
                    <?php foreach ($reactions as $reaction): ?>

                        <tr>
                            <th>Symptoms</th>
                            <td><?= $reaction->symptoms ?></td>
                        </tr>

                        <tr>
                            <th>Treatment Start</th>
                            <td><?= $reaction->treatment_start_date ?></td>
                        </tr>

                        <tr>
                            <th>Treatment Stop</th>
                            <td><?= $reaction->treatment_stop_date ?></td>
                        </tr>

                        <tr>
                            <th>Intensity</th>
                            <td><?= $reaction->intensity ?></td>
                        </tr>

                        <tr>
                            <th>Outcome</th>
                            <td><?= $reaction->outcome ?></td>
                        </tr>

                    <?php endforeach; ?>
                </table>

                <!-- Seriousness -->
                <h3 class="mb-3 mt-4 text-primary">5. Seriousness</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Seriousness</th>
                        <td>
                            <?= $record->seriousness ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Cause Of Death</th>
                        <td>
                            <?= $record->cause_of_death ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date Of Death</th>
                        <td>
                            <?= $record->date_of_death ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Autopsy</th>
                        <td>
                            <?= $record->autopsy ?>
                        </td>
                    </tr>
                </table>

                <!-- Relevant Information -->
                <h3 class="mb-3 mt-4 text-primary">6. Relevant Information</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Relevant Information</th>
                        <td>
                            <?= nl2br($record->relevant_information) ?>
                        </td>
                    </tr>
                </table>

                <!-- Medical History -->
                <h3 class="mb-3 mt-4 text-primary">7. Medical History</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Medical History</th>
                        <td>
                            <?= nl2br($record->medical_history) ?>
                        </td>
                    </tr>
                </table>

                <!-- Concomitant Medication -->
                <h3 class="mb-3 mt-4 text-primary">8. Concomitant Medication</h3>

                <table class="table table-bordered">
                    <tr>
                        <th>Medicine Name</th>
                        <td>
                            <?= $record->concomitant_medicine_name ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Manufacturer</th>
                        <td>
                            <?= $record->concomitant_medicine_manufacturer ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Batch</th>
                        <td>
                            <?= $record->concomitant_medicine_batch ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Indication</th>
                        <td>
                            <?= $record->concomitant_medicine_indication ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Dose</th>
                        <td>
                            <?= $record->concomitant_medicine_dose ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Route</th>
                        <td>
                            <?= $record->concomitant_medicine_route ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Frequency</th>
                        <td>
                            <?= $record->concomitant_medicine_frequency ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>
                            <?= $record->concomitant_medicine_start_date ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Stop Date</th>
                        <td>
                            <?= $record->concomitant_medicine_stop_date ?>
                        </td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="<?= base_url('report_adverse/records') ?>" class="btn btn-secondary">
                        Back to List
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<?php $this->load->view("backend/footer"); ?>