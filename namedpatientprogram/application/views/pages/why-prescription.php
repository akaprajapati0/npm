<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Prescription Guidelines for Named Patient Medicines | NPP</title>
    <meta name="description"
        content="Review prescription guidelines for accessing unapproved and specialty medicines through Named Patient Programs with regulatory compliance.">
    <meta name="keywords"
        content="Prescription Guidelines, Named Patient Program Prescription, Specialty Medicine Prescription, Unapproved Medicine Access, Prescription Requirements, Regulatory Compliance, Patient Access Program, Import Medicine Prescription, Physician Prescription Guidelines, Named Patient Medicines">
    <link rel="canonical" href="<?= current_url(); ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Ikris Pharma Network">
    <meta name="language" content="English">
    <meta name="geo.region" content="IN-UP">
    <meta name="geo.placename" content="Noida, Uttar Pradesh, India">

    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
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
    $data['title'] = "Prescription<br/>Guidelines";
    $data['backgroundImage'] = "assets/images/why_prescription/banner.png";

    $this->load->view('components/banner', $data);
    ?>


    <!-- Why Prescription Required -->
    <?php
    $title = 'Why Is a <span class="text-blue-600">Prescription</span> Required?';
    $description = "Medicines under the Named Patient Program are supplied on a patient-specific basis and require a valid prescription from the treating physician. This ensures clinical appropriateness and supports regulatory compliance. All prescriptions and supporting documents are reviewed, and where necessary, the prescribing healthcare professional may be contacted for verification or clarification.";
    $image_src = base_url('assets/images/why_prescription/section_img.png');
    $image_alt = "Prescription required for Named Patient Program";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <section class="py-16 lg:py-24 bg-[#f0f2f8]">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                <!-- Left Image -->
                <div class="flex justify-center">
                    <img src="<?= base_url('assets/images/why_prescription/section_img1.png'); ?>"
                        alt="Doctor with Patient" class="w-full max-w-md lg:max-w-lg rounded-md object-cover">
                </div>

                <!-- Right Content -->
                <div>

                    <h2 class="text-3xl lg:text-5xl font-playfair leading-tight text-gray-900">
                        What Should Your <br>
                        Prescription
                        <span class="text-[#3568E8]">Include?</span>
                    </h2>

                    <p class="mt-6 text-gray-600 leading-8 font-inter">
                        To help ensure timely processing, the prescription should
                        contain the following information:
                    </p>

                    <div class="mt-8 space-y-7">

                        <!-- Item -->
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                • Treating Physician Information
                            </h4>

                            <p class="mt-2 text-gray-600 leading-7">
                                The prescribing physician's full name, contact details,
                                professional registration number, and official clinic,
                                hospital, or healthcare institution letterhead.
                            </p>
                        </div>

                        <!-- Item -->
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                • Patient Information
                            </h4>

                            <p class="mt-2 text-gray-600 leading-7">
                                The patient's full name, date of birth, diagnosis,
                                and other identifying information required for
                                patient-specific access and regulatory review.
                            </p>
                        </div>

                        <!-- Item -->
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                • Medicine & Treatment Details
                            </h4>

                            <p class="mt-2 text-gray-600 leading-7">
                                The prescribed medicine name, strength, dosage form,
                                prescribed dose, treatment duration, quantity required,
                                and relevant treatment instructions, where applicable.
                            </p>
                        </div>

                        <!-- Item -->
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                • Prescription Authentication
                            </h4>

                            <p class="mt-2 text-gray-600 leading-7">
                                The date of issue, physician's signature, and official
                                stamp or seal, where applicable.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

                <!-- Left Content -->
                <div class="order-2 lg:order-1">

                    <h2 class="text-3xl lg:text-5xl font-playfair leading-tight text-gray-900">
                        <span class="text-[#3568E8]">Patient-Specific</span> Import
                        <br>
                        Compliance
                    </h2>

                    <div class="mt-8 space-y-6">

                        <p class="text-gray-600 leading-8 font-inter">
                            Medicines supplied through the Named Patient Program are
                            imported on a patient-specific basis and may require
                            supporting documentation in accordance with applicable
                            regulatory requirements. The prescribing physician may
                            be requested to provide clinical justification confirming
                            the medical need for the requested treatment and its
                            intended use for the patient.
                        </p>

                        <p class="text-gray-600 leading-8 font-inter">
                            Additional documentation may include a medical summary,
                            diagnosis details, treatment history, and confirmation
                            of the prescribed dosage and treatment duration.
                            Accurate and complete documentation helps facilitate
                            regulatory review, supports import authorization
                            procedures, and ensures compliance with patient-specific
                            access requirements.
                        </p>

                        <p class="text-gray-600 leading-8 font-inter">
                            In India, patient-specific imports are governed by the
                            applicable provisions of the Drugs and Cosmetics Act,
                            1940 and related regulatory requirements administered by
                            the Central Drugs Standard Control Organization (CDSCO).
                            Depending on the medicine and patient circumstances,
                            additional documentation or approvals may be required to
                            support the lawful import of medicines that are not
                            otherwise commercially available in the country.
                        </p>

                    </div>

                </div>

                <!-- Right Image -->
                <div class="flex justify-center lg:justify-end order-1 lg:order-2">
                    <img src="<?= base_url('assets/images/why_prescription/section_img2.png'); ?>"
                        alt="Patient Import Compliance"
                        class="w-full max-w-md lg:max-w-xl object-cover rounded-md shadow-sm">
                </div>

            </div>

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

                <a href="<?= base_url('faqs'); ?>" class="text-[#2563EB] font-semibold transition tracking-wider">
                    Find your Answers?
                </a>
            </div>

            <!-- RIGHT -->
            <div class="space-y-8">

                <!-- ITEM 1 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(1)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Why is a prescription required to import medicines in India?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        To import medicines not available in India, a valid doctor's prescription is required as per
                        regulatory guidelines. The prescription helps verify patient eligibility, ensure safety, and
                        comply with legal import requirements. All submitted prescriptions are kept strictly
                        confidential and used only for verification and approval purposes.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What information should be included in the prescription?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600 space-y-2">
                        <p>The prescription should include:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Complete patient details to confirm the identity of the individual for whom the medicine
                                is prescribed.</li>
                            <li>Clear mention of the prescribed medicine along with the correct dose, strength, and
                                duration of treatment to ensure safe and accurate use.</li>
                            <li>The stamp and full details of the prescribing doctor, confirming that it has been issued
                                by a registered medical practitioner.</li>
                        </ul>
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What happens if my prescription is incomplete?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        If any required information is missing or unclear, our compliance team will review the
                        prescription and may contact you or your treating physician for clarification. Completing the
                        required details helps avoid delays in processing your medicine request.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Can I request a medicine without a prescription if I have my medical reports?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        No. Medical reports alone are not sufficient. A valid prescription from your treating physician
                        is required to initiate the medicine request under the Named Patient Program and comply with
                        applicable regulatory requirements.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Can someone else submit the prescription on behalf of the patient?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        Yes. A family member, caregiver, or authorized representative may submit the prescription and
                        supporting documents on behalf of the patient, provided they have the patient's consent where
                        required.
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- JavaScript - Place this RIGHT AFTER the section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get all FAQ question buttons
            var faqQuestions = document.querySelectorAll('.faq-question');

            // Loop through each button and add click event
            for (var i = 0; i < faqQuestions.length; i++) {
                faqQuestions[i].addEventListener('click', function () {
                    // Get the answer div (next element after button)
                    var answer = this.nextElementSibling;

                    // Get the icon inside this button
                    var icon = this.querySelector('.fa');

                    // Toggle the answer visibility
                    if (answer.style.display === 'none') {
                        // Open the answer
                        answer.style.display = 'block';
                        // Change icon from plus to minus
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus');
                    } else {
                        // Close the answer
                        answer.style.display = 'none';
                        // Change icon from minus to plus
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                    }
                });
            }
        });
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>
</body>

</html>