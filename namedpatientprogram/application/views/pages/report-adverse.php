<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Report Adverse Event | Drug Safety Reporting | NPP</title>
    <meta name="description"
        content="Report adverse drug events and medicine safety concerns through our secure reporting system. Support patient safety and pharmacovigilance efforts.">
    <meta name="keywords"
        content="Report Adverse Event, Adverse Drug Event Reporting, Medicine Safety Reporting, Drug Safety Monitoring, Pharmacovigilance Reporting, Report Side Effects, Adverse Reaction Reporting, Patient Safety Reporting, Drug Event Report Form, Medicine Safety Program">
    <link rel="canonical" href="<?= current_url(); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Ikris Pharma Network">
    <meta name="language" content="English">
    <meta name="geo.region" content="IN-UP">
    <meta name="geo.placename" content="Noida, Uttar Pradesh, India">

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5QFX8TJM');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QFX8TJM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php $this->load->view('layouts/includes/head-links'); ?>

</head>

<body>

    <?php $this->load->view('layouts/includes/header'); ?>

    <?php
    $data['title'] = "Temperature<br/>Controlled Shipping";
    $data['backgroundImage'] = "assets/images/report_adverse/report_adverse_banner.png";

    $this->load->view('components/banner', $data);
    ?>
    <section class="w-full py-8 p-4 md:p-8 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto">
            <div class="my-16">
                <h2 class="text-[20px] sm:text-[26px] md:text-[32px] lg:text-[44px] font-normal mb-3 leading-tight font-playfair">
                    Adverse Event <span class="text-blue-600">Reporting</span>
                </h2>
                <p class="text-sm leading-6 font-inter">
                    Patient safety is our highest priority. Continuous monitoring of medicine safety helps ensure that
                    treatments remain safe and effective for patients.
                </p>
                <p class="text-sm leading-6 mt-3 font-inter">
                    If an adverse drug event (ADE) or any unexpected reaction is suspected with a medicine facilitated
                    through us, it should be reported promptly. Reporting adverse events supports accurate safety
                    monitoring
                    and helps improve patient care.
                </p>
                <p class="text-sm leading-6 mt-3 font-inter">
                    Patients are advised to seek medical advice from their treating healthcare provider for any adverse
                    event. Patients participating in a clinical trial should report the event directly to their
                    coordinating
                    study site, as per trial protocol.
                </p>
            </div>
        </div>
    </section>
    <?php
    $title = 'Safety Monitoring &<br/><span class="text-blue-600"> Reporting Support</span> ';
    $description = "NPP facilitates the collection and communication of safety-related information associated with medicines supplied through the Named Patient Program. Our team works closely with healthcare providers, manufacturers, and regulatory stakeholders to ensure that adverse events and product quality concerns are documented and escalated through appropriate channels.";
    $image_src = base_url('assets/images/report_adverse/section_img.png');
    $image_alt = "Pharmacist handling temperature-controlled medicines";
    $layout = 'text-left';
    $bg = 'bg-[#ffff]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- ================= FORM ================= -->
    <div class="bg-[#F8FAFC]">
        <form action="<?= base_url('report_adverse/store') ?>" method="POST" style="max-width:100%;overflow-x:hidden;">

            <!-- ===== 1 & 2: Patient + Reporter ===== -->
            <section class="w-full py-4 px-4 md:px-8 md:my-8">
                <div class="max-w-7xl mx-auto">

                    <h1 class="text-center text-[20px] sm:text-[24px] md:text-[32px] font-bold mb-8">
                        Adverse Event Reporting Form
                    </h1>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- LEFT: Patient Details -->
                        <div class="min-w-0">
                            <h2 class="text-[18px] sm:text-[20px] font-semibold mb-5">1. Patient Details</h2>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.1. Patient Name :</label>
                                <input type="text" name="patient_name"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <!-- FIX: date input now full-width, no height forcing on mobile -->
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.2. Date of Birth :</label>
                                <input type="date" name="date_of_birth"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.3. Age :</label>
                                <input type="text" name="age"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-2">1.4. Gender :</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="gender" value="Male" class="w-4 h-4 shrink-0"> Male
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="gender" value="Female" class="w-4 h-4 shrink-0"> Female
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="gender" value="Other" class="w-4 h-4 shrink-0"> Other
                                    </label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.5. Weight in kg/lbs :</label>
                                <input type="text" name="weight"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.6. Height in cm/ft :</label>
                                <input type="text" name="height"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">1.7. Additional Information :</label>
                                <textarea name="additional_info"
                                    class="w-full border border-blue-300 h-[110px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                            </div>
                        </div>

                        <!-- RIGHT: Reporter Information -->
                        <div class="min-w-0">
                            <h2 class="text-[18px] sm:text-[20px] font-semibold mb-5">2. Reporter Information</h2>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">2.1. Reporter's Name :</label>
                                <input type="text" name="reporter_name"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">2.2. Reporter's Address :</label>
                                <textarea name="reporter_address"
                                    class="w-full border border-blue-300 h-[78px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">2.3. E-mail :</label>
                                <input type="email" name="reporter_email"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-2">2.4. Reporter Qualification :</label>
                                <div class="flex flex-wrap gap-4 mb-3">
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="reporter_qualification" value="Physician"
                                            class="w-4 h-4 shrink-0"> Physician
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="reporter_qualification" value="Pharmacist"
                                            class="w-4 h-4 shrink-0"> Pharmacist
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="reporter_qualification" value="Other"
                                            class="w-4 h-4 shrink-0"> Other
                                    </label>
                                </div>
                                <!-- FIX: stacks on mobile -->
                                <div class="flex flex-col xs:flex-row items-start xs:items-center gap-2">
                                    <span class="text-[14px] whitespace-nowrap">Please Specify :-</span>
                                    <input type="text" name="other_qualification"
                                        class="border-b border-gray-500 w-full outline-none px-2 py-1 text-sm">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">2.5. Country :</label>
                                <input type="text" name="country"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">2.6. Phone Number :</label>
                                <input type="tel" name="phone_number"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>

                            <div class="mb-2">
                                <label class="block text-[14px] mb-1.5">2.7. Date :</label>
                                <input type="date" name="report_date"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- ===== 3: Suspected Medicine ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">

                    <h2 class="text-[18px] sm:text-[20px] font-semibold mb-6">3. Suspected Medicine</h2>
                    <div id="suspected-medicine-section" class="mt-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="min-w-0">
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.1. Medicine Name :</label>
                                    <input type="text" name="suspected_medicine_name[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.2. Manufacturer :</label>
                                    <input type="text" name="suspected_medicine_manufacturer[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.3. Batch :</label>
                                    <input type="text" name="suspected_medicine_batch[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.4. Expiry :</label>
                                    <input type="date" name="suspected_medicine_expiry[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.5. Indication :</label>
                                    <textarea name="suspected_medicine_indication[]"
                                        class="w-full border border-blue-300 h-[110px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                                </div>
                            </div>

                            <div class="min-w-0">
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.6. Dose :</label>
                                    <input type="text" name="suspected_medicine_dose[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.7. Route :</label>
                                    <input type="text" name="suspected_medicine_route[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.8. Frequency :</label>
                                    <input type="text" name="suspected_medicine_frequency[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <!-- FIX: date-pair class stacks on mobile, side-by-side on 480px+ -->
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-2">3.9. Treatment :</label>
                                    <div class="date-pair">
                                        <div class="date-row">
                                            <span>Starting Date :</span>
                                            <input type="date" name="suspected_medicine_treatment_start_date[]"
                                                class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                        </div>
                                        <div class="date-row">
                                            <span>Stopped Date :</span>
                                            <input type="date" name="suspected_medicine_treatment_stop_date[]"
                                                class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-1.5">3.10. Causality Assessment :</label>
                                    <textarea name="causality_assessment[]"
                                        class="w-full border border-blue-300 h-[110px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Dechallenge / Rechallenge -->
                        <div class="space-y-5">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-3 border-b border-gray-100">
                                <h3 class="text-[14px] sm:text-[15px] font-semibold leading-tight">
                                    Did AE improve after stopping or reducing drug?
                                </h3>
                                <div class="flex items-center gap-6 shrink-0">
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="dechallenge[0]" value="Yes" class="w-4 h-4 shrink-0"> Yes
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="dechallenge[0]" value="No" class="w-4 h-4 shrink-0"> No
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="dechallenge[0]" value="N/A" class="w-4 h-4 shrink-0"> N/A
                                    </label>
                                </div>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-3 border-b border-gray-100">
                                <h3 class="text-[14px] sm:text-[15px] font-semibold leading-tight">
                                    Did AE reappear after reintroduction?
                                </h3>
                                <div class="flex items-center gap-6 shrink-0">
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="rechallenge[0]" value="Yes" class="w-4 h-4 shrink-0"> Yes
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="rechallenge[0]" value="No" class="w-4 h-4 shrink-0"> No
                                    </label>
                                    <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                        <input type="radio" name="rechallenge[0]" value="N/A" class="w-4 h-4 shrink-0"> N/A
                                    </label>
                                </div>
                            </div>

                            <!-- <button type="button"
                            class="text-blue-700 text-[14px] sm:text-[15px] font-medium hover:text-blue-900 transition">
                            Add new suspected medication +
                        </button> -->

                        </div>
                    </div>

                    <button type="button" id="add-suspected-medication"
                        class="text-blue-700 text-[14px] sm:text-[15px] font-medium hover:text-blue-900 transition mt-6">
                        Add new suspected medication +
                    </button>
                </div>
            </section>

            <!-- ===== 4: Adverse Event Description ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">

                    <div class="flex flex-wrap items-center gap-2 mb-6">
                        <h2 class="text-[18px] sm:text-[20px] font-bold leading-tight">4. Adverse Event Description</h2>
                        <span class="text-[12px] sm:text-[13px] text-gray-600">( Action Taken After Reaction )</span>
                    </div>
                    <div id="adverse-event-section" class="mt-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="min-w-0">
                                <div class="mb-5">
                                    <label class="block text-[14px] mb-1.5">4.1. Symptom(s) :</label>
                                    <input type="text" name="symptoms[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-[14px] mb-2">4.2. Treatment :</label>
                                    <div class="date-pair">
                                        <div class="date-row">
                                            <span>Starting Date :</span>
                                            <input type="date" name="adverse_treatment_start_date[]"
                                                class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                        </div>
                                        <div class="date-row">
                                            <span>Stopped Date :</span>
                                            <input type="date" name="adverse_treatment_stop_date[]"
                                                class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="min-w-0">
                                <div class="mb-5">
                                    <label class="block text-[14px] mb-3">4.3. Intensity :</label>
                                    <div class="flex flex-wrap items-center gap-5">
                                        <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                            <input type="radio" name="intensity[0]" value="Mild" class="w-4 h-4 shrink-0">
                                            Mild
                                        </label>
                                        <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                            <input type="radio" name="intensity[0]" value="Moderate"
                                                class="w-4 h-4 shrink-0">
                                            Moderate
                                        </label>
                                        <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                            <input type="radio" name="intensity[0]" value="Severe" class="w-4 h-4 shrink-0">
                                            Severe
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[14px] mb-1.5">4.4. Outcome :</label>
                                    <input type="text" name="outcome[]"
                                        class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="button" id="add-adverse-event"
                        class="mt-6 text-blue-700 text-[14px] sm:text-[15px] font-medium hover:text-blue-900 transition">
                        Add new adverse event +
                    </button>

                </div>
            </section>

            <!-- ===== 5: Seriousness ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">

                    <h2 class="text-[18px] sm:text-[20px] font-bold leading-tight mb-8">
                        5. Seriousness
                        <span class="font-normal text-[14px] sm:text-[16px] text-gray-600 ml-1">( Is the Adverse Event
                            Serious
                            )</span>
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8 text-center">
                        <div class="flex flex-col items-center">
                            <p class="text-[12px] sm:text-[13px] leading-snug min-h-[60px] flex items-start justify-center">
                                Death</p>
                            <input type="checkbox" name="seriousness[]" value="Death" class="w-5 h-5 accent-blue-600 mt-2">
                        </div>
                        <div class="flex flex-col items-center">
                            <p
                                class="text-[12px] sm:text-[13px] leading-snug min-h-[60px] flex items-start justify-center text-center">
                                Immediate<br>Life-Threatening</p>
                            <input type="checkbox" name="seriousness[]" value="Immediate Life-Threatening"
                                class="w-5 h-5 accent-blue-600 mt-2">
                        </div>
                        <div class="flex flex-col items-center">
                            <p
                                class="text-[12px] sm:text-[13px] leading-snug min-h-[60px] flex items-start justify-center text-center">
                                In-patient Hospitalization<br>/ Prolonging Existing</p>
                            <input type="checkbox" name="seriousness[]" value="In-patient Hospitalization"
                                class="w-5 h-5 accent-blue-600 mt-2">
                        </div>
                        <div class="flex flex-col items-center">
                            <p
                                class="text-[12px] sm:text-[13px] leading-snug min-h-[60px] flex items-start justify-center text-center">
                                Resulting in Persistent /<br>Significant Disability</p>
                            <input type="checkbox" name="seriousness[]"
                                value="Resulting in Persistent / Significant Disability"
                                class="w-5 h-5 accent-blue-600 mt-2">
                        </div>
                        <div class="flex flex-col items-center col-span-2 sm:col-span-1">
                            <p
                                class="text-[12px] sm:text-[13px] leading-snug min-h-[60px] flex items-start justify-center text-center">
                                Congenital Abnormality /<br>Birth Defect</p>
                            <input type="checkbox" name="seriousness[]" value="Congenital Abnormality / Birth Defect"
                                class="w-5 h-5 accent-blue-600 mt-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-[14px] mb-1.5">If Death, Specify Cause :</label>
                            <input type="text" name="cause_of_death"
                                class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-[14px] mb-1.5">Date of Death :</label>
                            <input type="date" name="date_of_death"
                                class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                        </div>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-3 border-t border-gray-100">
                        <h3 class="text-[14px] sm:text-[15px] font-semibold leading-tight">
                            Post Mortem / Autopsy Performed?
                        </h3>
                        <div class="flex items-center gap-6 shrink-0">
                            <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                <input type="radio" name="autopsy" value="Yes" class="w-4 h-4 shrink-0"> Yes
                            </label>
                            <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                <input type="radio" name="autopsy" value="No" class="w-4 h-4 shrink-0"> No
                            </label>
                            <label class="flex items-center gap-2 text-[14px] cursor-pointer">
                                <input type="radio" name="autopsy" value="N/A" class="w-4 h-4 shrink-0"> N/A
                            </label>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ===== 6: Relevant Information ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-[18px] sm:text-[20px] font-semibold mb-4">
                        6. Please Provide Any Relevant Information About AE
                    </h2>
                    <textarea name="relevant_information"
                        class="w-full border border-blue-300 h-[120px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                </div>
            </section>

            <!-- ===== 7: Medical History ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-[18px] sm:text-[20px] font-semibold mb-4">
                        7. Relevant Medical History / Concurrent Diseases
                    </h2>
                    <textarea name="medical_history"
                        class="w-full border border-blue-300 h-[120px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                </div>
            </section>

            <!-- ===== 8: Concomitant Medication ===== -->
            <section class="w-full py-4 px-4 md:px-8">
                <div class="max-w-7xl mx-auto">

                    <h2 class="text-[18px] sm:text-[20px] font-semibold mb-6">8. Concomitant Medication</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="min-w-0">
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.1. Medicine Name :</label>
                                <input type="text" name="concomitant_medicine_name"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.2. Manufacturer :</label>
                                <input type="text" name="concomitant_medicine_manufacturer"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.3. Batch :</label>
                                <input type="text" name="concomitant_medicine_batch"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.4. Indication :</label>
                                <textarea name="concomitant_medicine_indication"
                                    class="w-full border border-blue-300 h-[95px] p-3 outline-none resize-none rounded-sm text-sm"></textarea>
                            </div>
                        </div>

                        <div class="min-w-0">
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.5. Dose :</label>
                                <input type="text" name="concomitant_medicine_dose"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.6. Route :</label>
                                <input type="text" name="concomitant_medicine_route"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-1.5">8.7. Frequency :</label>
                                <input type="text" name="concomitant_medicine_frequency"
                                    class="w-full border border-blue-300 h-[42px] px-3 outline-none rounded-sm text-sm">
                            </div>
                            <div class="mb-4">
                                <label class="block text-[14px] mb-2">8.8. Treatment :</label>
                                <div class="date-pair">
                                    <div class="date-row">
                                        <span>Starting Date :</span>
                                        <input type="date" name="concomitant_medicine_start_date"
                                            class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                    </div>
                                    <div class="date-row">
                                        <span>Stopped Date :</span>
                                        <input type="date" name="concomitant_medicine_stop_date"
                                            class="border border-blue-300 h-[38px] px-2 outline-none rounded-sm text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Agreement & Submit -->
                    <div class="mt-6">
                        <div class="flex items-start gap-3 mt-4">
                            <input type="checkbox" value="1" name="privacy_agreement"
                                class="w-4 h-4 accent-blue-600 mt-1 shrink-0">
                            <p class="text-[13px] leading-[1.6] text-gray-700">
                                I accept that all enquiries submitted to "Adverse Event Reporting" are sent to the Sun
                                Pharma
                                global pharmacovigilance team, headquartered in India. I accept that my personal data are
                                shared
                                with the relevant local team. I accept the Sun Pharma general Privacy Policy, described
                                here.
                            </p>
                        </div>

                        <div class="mt-8 flex">
                            <button type="submit"
                                class="bg-[#2563EB] hover:bg-[#24459c] text-white text-[15px] font-medium px-10 py-3 rounded-[8px] transition w-full sm:w-auto">
                                Submit
                            </button>
                        </div>
                    </div>

                </div>
            </section>

        </form>
    </div>

    <!-- ================= CONTACT INFO BANNER ================= -->
    <section class="w-full bg-[#2563EB] py-10 px-4 md:px-8 md:py-[70px] mt-6">
        <div class="max-w-7xl mx-auto">
            <p class="text-white text-[13px] leading-[1.7] mb-5">
                If you would like to send us information by post, please
                <a href="#" class="text-yellow-300 underline hover:text-yellow-200 transition">download the form</a>
                and mail to the following address:
            </p>
            <div class=" text-[13px] leading-[1.9]">
                <p class="font-semibold text-white">Global Pharmacovigilance Department</p>
                <p class="text-white">Ikris Pharma Network 905 I-Thum Business Park Plot No. - 40, Block A, Unit No. 5,
                </p>
                <p class="text-white">Tower A Sector 62, Noida 201301 (INDIA)</p>
                <p class="text-white">Toll Free Number : 1-800-309-8112 (Toll free throughout India)</p>
            </div>
            <p class="text-white text-[13px] leading-[1.7] mt-5">
                To report adverse events, we recommend you to use the email address.
                If more information specific to your Country is required, you may also navigate to the Worldwide tab
                available on the website.
            </p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 md:py-28 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-start">

            <!-- LEFT -->
            <div>
                <h2 class="text-4xl md:text-5xl font-normal mb-6 font-playfair">
                    Frequently Asked<br>Questions
                </h2>

                <p class="text-gray-600 text-lg mb-4 max-w-md leading-tight">
                    Here are answers to questions<br class="hidden sm:block" /> we're often asked.
                </p>

                <a href="<?= base_url('faqs'); ?>"
                    class="text-[#2563EB] font-semibold transition tracking-wider">
                    Find your Answers?
                </a>
            </div>

            <!-- RIGHT -->
            <div class="space-y-8">

                <!-- ITEM 1 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(1)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What is adverse event reporting?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        Adverse event reporting is the process of notifying a company or health authority when a patient
                        experiences a harmful or unexpected reaction to a medicine. It supports ongoing drug-safety
                        monitoring (pharmacovigilance), helping identify risks early and improve patient care. Reports
                        can cover side effects, drug reactions, or lack of efficacy.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How do I report an adverse drug event?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600 space-y-3">
                        <p>You can report the adverse event by using the Adverse Event Report Form, to be filled by a
                            healthcare physician only. Click here to download the Adverse Event Reporting Form and
                            submit it by any of the following methods:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Hand it over to an Ikris Pharma Network representative.</li>
                            <li>Mail the completed form to our Pharmacovigilance Department with the subject line "ADE
                                Reporting" at: Ikris Pharma Network, 905 I-Thum Business Park, Plot No. 40, Block A,
                                Unit No. 5, Tower A, Sector 62, Noida 201301 (INDIA).</li>
                            <li>Or email the form to: <a href="mailto:drugsafety@ikrispharmanetwork.com"
                                    class="text-purple-600 hover:underline">drugsafety@ikrispharmanetwork.com</a></li>
                        </ul>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Who can report an adverse event?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        Healthcare professionals such as physicians and pharmacists typically complete the adverse event
                        report form. Patients who experience a reaction should inform their treating doctor, who can
                        then report it. Patients enrolled in a clinical trial should report the event directly to their
                        coordinating study site, following the trial protocol.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What information is needed to report an adverse event?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        An adverse event report generally includes patient details (such as age, gender, and weight),
                        the suspected medicine and its dose and route, a description of the reaction and its severity,
                        relevant medical history, and reporter contact information. Complete, accurate details help the
                        safety team assess the event properly.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Is adverse event reporting confidential?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        Personal information submitted in an adverse event report is kept confidential and is generally
                        disclosed only where required by law or by a regulatory authority. Reporting is intended to
                        protect patient safety and improve medicine quality, and it is handled under data-protection and
                        ethical-reporting standards.
                    </div>
                </div>

            </div>
        </div>
    </section>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ toggle functionality
            // var faqQuestions = document.querySelectorAll('.faq-question');
            // for (var i = 0; i < faqQuestions.length; i++) {
            //     faqQuestions[i].addEventListener('click', function() {
            //         var answer = this.nextElementSibling;
            //         var icon = this.querySelector('.fa');
            //         if (answer.style.display === 'none') {
            //             answer.style.display = 'block';
            //             icon.classList.remove('fa-plus');
            //             icon.classList.add('fa-minus');
            //         } else {
            //             answer.style.display = 'none';
            //             icon.classList.remove('fa-minus');
            //             icon.classList.add('fa-plus');
            //         }
            //     });
            // }

            // ===== ADD NEW SUSPECTED MEDICATION =====
            var suspectedMedicineSection = document.querySelector('#suspected-medicine-section');
            var addSuspectedBtn = document.querySelector('#add-suspected-medication');
            var suspectedCounter = 1;

            if (addSuspectedBtn && suspectedMedicineSection) {
                addSuspectedBtn.addEventListener('click', function() {

                    suspectedCounter++;

                    var clone = suspectedMedicineSection.cloneNode(true);

                    clearCloneInputs(clone);

                    clone.querySelectorAll('input[type="radio"]').forEach(function(radio) {

                        if (radio.name.indexOf('dechallenge') === 0) {
                            radio.name = 'dechallenge[' + (suspectedCounter - 1) + ']';
                        }

                        if (radio.name.indexOf('rechallenge') === 0) {
                            radio.name = 'rechallenge[' + (suspectedCounter - 1) + ']';
                        }

                    });

                    addRemoveButton(clone, 'Suspected Medication');

                    addSuspectedBtn.before(clone);

                });
            }

            // ===== ADD NEW ADVERSE EVENT =====
            var adverseEventSection = document.querySelector('#adverse-event-section');
            var addAdverseBtn = document.querySelector('#add-adverse-event');
            var adverseCounter = 1;

            if (addAdverseBtn && adverseEventSection) {
                addAdverseBtn.addEventListener('click', function() {

                    adverseCounter++;

                    var clone = adverseEventSection.cloneNode(true);

                    clearCloneInputs(clone);

                    clone.querySelectorAll('input[type="radio"]').forEach(function(radio) {

                        if (radio.name.indexOf('intensity') === 0) {
                            radio.name = 'intensity[' + (adverseCounter - 1) + ']';
                        }

                    });

                    addRemoveButton(clone, 'Adverse Event');

                    addAdverseBtn.before(clone);

                });
            }

            // Helper function to update name attributes
            function updateCloneNames(clone, prefix, counter) {
                var inputs = clone.querySelectorAll('input, textarea, select');
                inputs.forEach(function(input) {
                    if (input.name) {
                        // Replace existing index or add new one
                        input.name = input.name.replace(/_(\d+)_/, '_' + counter + '_');
                        if (!input.name.match(/_\d+_/)) {
                            input.name = input.name.replace(prefix, prefix + counter + '_');
                        }
                    }
                });
            }

            // Helper function to clear clone inputs
            function clearCloneInputs(clone) {
                var inputs = clone.querySelectorAll(
                    'input[type="text"], input[type="date"], input[type="email"], input[type="tel"], textarea');
                inputs.forEach(function(input) {
                    input.value = '';
                });
                var radios = clone.querySelectorAll('input[type="radio"]');
                radios.forEach(function(radio) {
                    radio.checked = false;
                });
            }

            // Helper function to add remove button
            function addRemoveButton(clone, sectionName) {
                var removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'text-red-600 text-[14px] font-medium hover:text-red-800 transition mt-3';
                removeBtn.textContent = '✕ Remove ' + sectionName;
                removeBtn.addEventListener('click', function() {
                    clone.remove();
                });
                clone.appendChild(removeBtn);
            }
        });
    </script>
    <?php $this->load->view('layouts/includes/footer'); ?>


</body>

</html>