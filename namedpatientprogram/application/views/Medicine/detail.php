<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Details</title>
    <?php $this->load->view('layouts/includes/head-links'); ?>

</head>

<body>

    <?php $this->load->view('layouts/includes/header'); ?>

    <?php
    // Build share URLs
    $share_url = current_url();
    $share_title = $medicine->name;
    $share_text = $medicine->name . ' | ' . ($medicine->company_name ?? '');
    $linkedin_share = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($share_url);
    $twitter_share = 'https://twitter.com/intent/tweet?text=' . urlencode($share_text) . '&url=' . urlencode($share_url);
    ?>

    <style>
        .tab-button {
            background: transparent;
            border: none;
            color: #ffff;
            font-size: 16px;
            font-weight: 500;
            position: relative;
            white-space: nowrap;
        }

        .tab-button.active {
            color: #FFFF00;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 100%;
            height: 2px;
            background: #FFFF00;
        }



        .tab-content {
            display: none;
            padding: 10px;
            background: white;
            border-top: none;
            min-height: 200px;
        }

        .tab-content.active {
            display: block;
        }

        .worldwide-section p,
        .worldwide-section div {
            font-size: 14px;
            line-height: 1.8;
        }

        .worldwide-section h2 {
            font-size: 36px;
            font-weight: 700;
        }

        .worldwide-section h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .iti {
            width: 100% !important;
            display: block;
        }

        .iti__tel-input {
            width: 100% !important;
        }

        .iti input {
            width: 100% !important;
        }

        @media (max-width: 768px) {
            .tab-button {
                padding: 10px 16px;
                font-size: 14px;
            }
        }
    </style>
    <!-- <div class="w-full px-0">

        <div class="bg-[#0E4664] h-[205px] flex items-center justify-center text-center px-4 md:px-6">

            <h1 class="text-white max-w-4xl mx-auto font-semibold leading-tight text-lg md:text-xl lg:text-2xl">
                Not Finding Righ Medicine? we Redy
            </h1>

        </div>

    </div> -->
    <section>
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-8 md:py-12 grid lg:grid-cols-2 gap-8 lg:gap-10 items-start">

            <!-- Left Side -->
            <div class="flex flex-col items-center justify-center text-center lg:text-start order-1">
                <?php
                $image_url = base_url('assets/images/medicine-placeholder.png');

                if (!empty($medicine->image) && file_exists(FCPATH . 'assets/images/medicines/' . $medicine->image)) {
                    $image_url = base_url('assets/images/medicines/' . $medicine->image);
                }
                ?>

                <img src="<?= $image_url; ?>" alt="<?= htmlspecialchars($medicine->name ?? ''); ?>"
                    class="w-full max-w-[260px] sm:max-w-[300px] max-h-[300px] object-contain mx-auto">

                <div class="w-full mt-4">
                    <p class="text-sm sm:text-base bg-[#F8FAFC] text-black px-4 py-3 rounded-lg mb-4 text-left">
                        Sourced directly from the authorized manufacturer network to ensure authenticity and quality.
                    </p>
                    <p class="text-sm sm:text-base bg-[#F8FAFC] text-black px-4 py-3 rounded-lg text-left">
                        You can also access detailed information by clicking
                        <a href="#" class="text-blue-600 hover:underline">Login</a> in the website header.
                    </p>
                </div>
            </div>

            <!-- Right side -->
            <div class="space-y-4 sm:space-y-5 order-2">
                <h1
                    class="text-start font-normal text-2xl sm:text-3xl md:text-5xl font-serif px-0 sm:px-3 leading-tight">
                    <?= htmlspecialchars($medicine->name ?? '_') ?>
                </h1>

                <p class="font-inter leading-relaxed font-base px-0 sm:px-3 text-sm sm:text-base">
                    Supplied with complete CDSCO-approved import and customs documentation, including Form 12A & 12B,
                    CDEC, GST Bill of Entry, Commercial Invoice, and Packing List.
                </p>

                <!-- Spec rows: label / value, matches Figma table layout -->
                <div class="px-0 sm:px-3">
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4 border-b border-gray-300 py-3">
                        <span class="font-bold text-sm sm:text-base w-full sm:w-1/3">Medicine Name:</span>
                        <span
                            class="text-sm sm:text-base w-full sm:w-2/3 sm:text-left"><?= htmlspecialchars($medicine->name ?? '_') ?></span>
                    </div>
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4 border-b border-gray-300 py-3">
                        <span class="font-bold text-sm sm:text-base w-full sm:w-1/3">Generic Name (API):</span>
                        <span
                            class="text-sm sm:text-base w-full sm:w-2/3 sm:text-left"><?= htmlspecialchars($medicine->active_ingredient ?? 'N/A') ?></span>
                    </div>
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4 border-b border-gray-300 py-3">
                        <span class="font-bold text-sm sm:text-base w-full sm:w-1/3">Dosage Form & Strength:</span>
                        <span class="text-sm sm:text-base w-full sm:w-2/3 sm:text-left">Injection:
                            <?= htmlspecialchars($medicine->strength ?? 'N/A') ?></span>
                    </div>
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4 border-b border-gray-300 py-3">
                        <span class="font-bold text-sm sm:text-base w-full sm:w-1/3">Route:</span>
                        <span
                            class="text-sm sm:text-base w-full sm:w-2/3 sm:text-left"><?= htmlspecialchars($medicine->routes ?? 'N/A') ?></span>
                    </div>
                    <div
                        class="flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4 border-b border-gray-300 py-3">
                        <span class="font-semibold text-sm sm:text-base w-full sm:w-1/3">Drug Class:</span>
                        <span
                            class="text-sm sm:text-base w-full sm:w-2/3 sm:text-left"><?= htmlspecialchars($medicine->drug_class ?? 'N/A') ?></span>
                    </div>
                </div>

                <!-- Manufacturer / Regulatory Approval -->
                <div class="flex flex-col sm:flex-row gap-8">
                    <div>
                        <p class="font-bold text-sm sm:text-base mb-1">Manufacturer / Innovator:</p>
                        <p class="text-sm sm:text-base">
                            <?= htmlspecialchars($medicine->origin ?? 'N/A') ?>
                        </p>
                    </div>
                    <!-- <div class="hidden sm:block w-px bg-gray-300"></div> -->
                    <!-- Vertical Divider -->
                    <div class="hidden sm:flex justify-center">
                        <div class="h-full border-l-2 border-gray-900"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sm sm:text-base mb-1">Regulatory Approval:</p>
                        <?php
                        $approvals = !empty($medicine->regulatory_approval)
                            ? explode(',', $medicine->regulatory_approval)
                            : [];
                        ?>
                        <?php if (!empty($approvals)): ?>
                            <ul class="list-disc list-inside text-sm sm:text-base space-y-1">
                                <?php foreach ($approvals as $approval): ?>
                                    <li><?= htmlspecialchars(trim($approval)) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-sm sm:text-base">N/A</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- 
                <p class="font-normal text-sm sm:text-base px-0 sm:px-3">
                    We do not prescribe medications; we solely assist in providing access to them.
                </p>
                <p class="font-normal text-sm sm:text-base bg-[#F2F2F2] p-4 sm:p-6">
                    Note: We can help you to import the medicine if it is not available or unapproved in your home country.
                </p> -->

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 px-0 sm:px-3">
                    <button
                        class="bg-[#0040C6] px-5 py-2.5 text-white rounded-md text-sm sm:text-base w-full sm:w-auto hover:bg-[#0033a0] transition"
                        onclick="window.location.href='<?= base_url('contact-us'); ?>'">
                        Inquire Now
                    </button>
                    <button
                        class="bg-[#0040C6] px-5 py-2.5 text-white rounded-md text-sm sm:text-base w-full sm:w-auto hover:bg-[#0033a0] transition">
                        Track Your Medicine
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#F8FAFC] px-6 sm:px-10 lg:px-[140px] py-12 lg:py-0 lg:min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center w-full">

            <!-- Image: first on mobile, second column on desktop -->
            <div class="order-1 lg:order-2">
                <img src="<?= base_url('assets/images/medicine_details/section_img.png'); ?>"
                    alt="Family enjoying life with Named Patient Program access"
                    class="w-full h-[280px] sm:h-[360px] lg:h-[500px] object-cover rounded-lg">
            </div>

            <!-- Text content: second on mobile, first column on desktop -->
            <div class="order-2 lg:order-1">
                <p class="text-2xl sm:text-3xl lg:text-4xl text-black font-inter font-bold leading-snug mb-8">
                    Your <span class="text-[#2563EB]">Trustedworthy</span> Partner
                    For Named Patient Program
                </p>

                <ul class="space-y-6">
                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-6 h-6 mt-1">
                            <img src="<?= base_url('assets/images/medicine_details/hand.png') ?>" class="h-350 w-350"
                                alt="">
                        </span>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed pr-6">
                            Over a decade of trusted expertise in Named Patient Access to innovative and life-saving
                            medicines.
                        </p>
                    </li>

                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-6 h-6 mt-1">
                            <img src="<?= base_url('assets/images/medicine_details/person.png') ?>" class="h-350 w-350"
                                alt="">
                        </span>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            100% CDSCO-compliant processes ensuring safe, ethical, and responsible medicine access.
                        </p>
                    </li>

                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-6 h-6 mt-1">
                            <img src="<?= base_url('assets/images/medicine_details/cap.png') ?>" class="h-350 w-350"
                                alt="">

                        </span>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed pr-8">
                            Medicines sourced from authorized manufacturers with full batch traceability.
                        </p>
                    </li>

                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-6 h-6 mt-1">
                            <img src="<?= base_url('assets/images/medicine_details/home.png') ?>" class="h-350 w-350"
                                alt="">

                        </span>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            EU-GDP compliant warehousing for secure, quality-controlled global distribution.
                        </p>
                    </li>

                    <li class="flex gap-4">
                        <span class="flex-shrink-0 w-6 h-6 mt-1">
                            <img src="<?= base_url('assets/images/medicine_details/tab.png') ?>" class="h-350 w-350"
                                alt="">

                        </span>
                        <p class="text-sm sm:text-base text-gray-800 leading-relaxed">
                            Temperature-controlled logistics ensuring safe, reliable, and timely medicine delivery.
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="w-full px-0">

        <div class="bg-[#2563EB] h-[150px] lg:h-[80px] grid grid-cols-1 md:grid-cols-2 gap-4 px-4 md:px-6">

            <div class="flex items-center gap-4 mx-auto">
                <span class="text-white font-normal text-base">GDP Compliant</span>
                <button class="text-[#FFFF00] font-normal text-base">View Certificate</button>
            </div>
            <div class="flex items-center gap-4 mx-auto">
                <span class="text-white font-normal text-base">Licensed Wholesale distributor</span>
                <button class="text-[#FFFF00] font-normal text-base">View Certificate</button>
            </div>

        </div>

    </div>
    <?php if (!empty($medicine->medical_uses) || !empty($medicine->warning_precautions) || !empty($medicine->our_process) || !empty($medicine->documentation_availability) || !empty($medicine->sourcing_delivery) || !empty($medicine->treatment_access) || !empty($medicine->faq)): ?>
        <section class="bg-[#F8FAFC] w-full ">
            <!-- Content Card -->

            <div class="inset-0 flex items-center justify-center py-6 lg:px-16">
                <div
                    class="bg-white text-black pt-4 md:p-8 rounded-sm w-[90%] px-6 lg:px-10 space-y-4 overflow-hidden shadow-md">


                    <div class="bg-[#2563EB] px-6 py-4 overflow-x-auto">
                        <div class="flex items-center gap-10 whitespace-nowrap">

                            <?php if (!empty($medicine->medical_uses)): ?>
                                <button class="tab-button active" data-tab="medical-uses">
                                    Medical uses
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($medicine->warning_precautions)): ?>
                                <button class="tab-button <?= empty($medicine->medical_uses) ? 'active' : '' ?>"
                                    data-tab="warnings">
                                    Warning & Precautions
                                </button>
                            <?php endif; ?>
                            <?php if (!empty($medicine->our_process)): ?>
                                <button
                                    class="tab-button <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) ? 'active' : '' ?>"
                                    data-tab="process">
                                    Our Process
                                </button>
                            <?php endif; ?>
                            <?php if (!empty($medicine->documentation_availability)): ?>
                                <button
                                    class="tab-button <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) ? 'active' : '' ?>"
                                    data-tab="documentation">
                                    Documentation & Availability
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($medicine->sourcing_delivery)): ?>
                                <button
                                    class="tab-button <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) ? 'active' : '' ?>"
                                    data-tab="sourcing">
                                    Sourcing & Delivery
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($medicine->treatment_access)): ?>
                                <button
                                    class="tab-button <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) && empty($medicine->sourcing_delivery) ? 'active' : '' ?>"
                                    data-tab="treatment_access">
                                    Treatment Access
                                </button>
                            <?php endif; ?>
                            <?php if (!empty($medicine->faq)): ?>
                                <button
                                    class="tab-button <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) && empty($medicine->sourcing_delivery) && empty($medicine->treatment_access) ? 'active' : '' ?>"
                                    data-tab="faq">
                                    FAQ
                                </button>
                            <?php endif; ?>


                        </div>
                    </div>
                    <!-- Tab Contents -->
                    <?php if (!empty($medicine->medical_uses)): ?>
                        <div class="tab-content active" id="medical-uses">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none px-1">
                                <!-- <?= nl2br(htmlspecialchars($medicine->medical_uses)); ?> -->
                                <?= $medicine->medical_uses; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($medicine->warning_precautions)): ?>
                        <div class="tab-content <?= empty($medicine->medical_uses) ? 'active' : '' ?>" id="warnings">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none">
                                <!-- <?= nl2br(htmlspecialchars($medicine->warning_precautions)); ?> -->
                                <?= $medicine->warning_precautions; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($medicine->our_process)): ?>
                        <div class="tab-content <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) ? 'active' : '' ?>"
                            id="process">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none">
                                <!-- <?= nl2br(htmlspecialchars($medicine->our_process)); ?> -->
                                <?= $medicine->our_process; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($medicine->documentation_availability)): ?>
                        <div class="tab-content <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) ? 'active' : '' ?>"
                            id="documentation">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none">
                                <!-- <?= nl2br(htmlspecialchars($medicine->documentation_availability)); ?> -->
                                <?= $medicine->documentation_availability; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($medicine->sourcing_delivery)): ?>
                        <div class="tab-content <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) ? 'active' : '' ?>"
                            id="sourcing">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none">
                                <!-- <?= nl2br(htmlspecialchars($medicine->sourcing_delivery)); ?> -->
                                <?= $medicine->sourcing_delivery; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($medicine->treatment_access)): ?>
                        <div class="tab-content <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) && empty($medicine->sourcing_delivery) ? 'active' : '' ?>"
                            id="treatment_access">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed prose max-w-none">
                                <!-- <?= nl2br(htmlspecialchars($medicine->treatment_access)); ?> -->
                                <?= $medicine->treatment_access; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($medicine->faq)): ?>

                        <div class="tab-content <?= empty($medicine->medical_uses) && empty($medicine->warning_precautions) && empty($medicine->our_process) && empty($medicine->documentation_availability) && empty($medicine->sourcing_delivery) && empty($medicine->treatment_access) ? 'active' : '' ?>"
                            id="faq">

                            <?php

                            $faq = $medicine->faq;

                            // Remove wrapper tags
                            $faq = str_replace(['<p>', '</p>'], '', $faq);

                            // Normalize different <br> formats
                            $faq = str_ireplace([
                                '<br></b>',
                                '<br /></b>',
                                '<br/></b>'
                            ], '</b><br>', $faq);

                            // Split by every question
                            $parts = explode('<b>', $faq);

                            $faqs = [];

                            foreach ($parts as $part) {

                                if (trim($part) == '')
                                    continue;

                                $item = explode('</b>', $part, 2);

                                if (count($item) < 2)
                                    continue;

                                $question = trim(strip_tags($item[0]));

                                $answer = trim($item[1]);

                                // Remove leading <br>
                                while (stripos($answer, '<br>') === 0) {
                                    $answer = substr($answer, 4);
                                }

                                while (stripos($answer, '<br/>') === 0) {
                                    $answer = substr($answer, 5);
                                }

                                while (stripos($answer, '<br />') === 0) {
                                    $answer = substr($answer, 6);
                                }

                                $faqs[] = [
                                    'question' => $question,
                                    'answer' => $answer
                                ];
                            }
                            ?>

                            <div class="space-y-8">

                                <?php foreach ($faqs as $index => $item): ?>

                                    <div class="border-b border-gray-300 pb-4">

                                        <button onclick="toggleFaq(<?= $index ?>)"
                                            class="w-full flex justify-between items-center text-left">

                                            <span class="text-lg font-medium">
                                                <?= $item['question']; ?>
                                            </span>


                                            <span id="icon-<?= $index ?>" class="text-2xl font-bold">+</span>
                                        </button>

                                        <div id="faq-<?= $index ?>" class="hidden pt-4 text-gray-600">
                                            <?= $item['answer']; ?>
                                        </div>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    <?php endif; ?>


                </div>
            </div>

        </section>
    <?php endif; ?>
    <section class="bg-white py-10">
        <div class="max-w-6xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 relative">

                <!-- Center Divider -->
                <div class="hidden md:block absolute left-1/2 top-0 -translate-x-1/2 h-full border-l border-black">
                </div>

                <!-- Written By -->
                <div class="md:pr-16 pb-8 md:pb-0">
                    <h4 class="text-[18px] font-semibold text-black mb-2">
                        Written By:
                    </h4>

                    <p class="text-[15px] text-[#333333] leading-5">
                        Nitin Goswami
                    </p>

                    <p class="text-[15px] text-[#333333] leading-5">
                        Senior Medical Content Writer
                    </p>

                    <p class="text-[15px] text-[#333333] leading-5 mt-1">
                        Last Updated: 26 June 2026
                    </p>

                    <p class="text-[15px] text-[#333333] leading-5">
                        Sources: FDA • EMA • PMDA • CDSCO
                    </p>

                    <a href="#"
                        class="inline-flex items-center gap-3 mt-5 text-[#2563EB] font-semibold text-[14px] group tracking-wider">
                        Learn More
                        <svg class="w-[120px] h-3 transition-transform duration-300 group-hover:translate-x-1"
                            viewBox="0 0 120 12" fill="none" xmlns="http://www.w3.org/2000/svg">

                            <path d="M1 6H116" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />

                            <path d="M111 1L119 6L111 11" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

                <!-- Medically Reviewed -->
                <div class="md:pl-16 border-t md:border-0 pt-8 md:pt-0 border-gray-200">
                    <h4 class="text-[18px] font-semibold text-black mb-2">
                        Medically Reviewed By:
                    </h4>

                    <p class="text-[15px] text-[#333333] leading-5">
                        Shilpi Banerjee
                    </p>

                    <p class="text-[15px] text-[#333333] leading-5">
                        Registered Pharmacist (M.Pharm)
                    </p>

                    <p class="text-[15px] text-[#333333] leading-5 mt-1">
                        Last Updated: 26 June 2026
                    </p>

                    <a href="#"
                        class="inline-flex items-center gap-3 mt-5 text-[#2563EB] font-semibold text-[14px] group tracking-wider">
                        Learn More

                        <svg class="w-[120px] h-3 transition-transform duration-300 group-hover:translate-x-1"
                            viewBox="0 0 120 12" fill="none" xmlns="http://www.w3.org/2000/svg">

                            <path d="M1 6H116" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />

                            <path d="M111 1L119 6L111 11" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

            </div>

        </div>
    </section>
    <!-- GET IN TOUCH -->
    <section class="py-16 md:py-24 px-4 bg-white">
        <div class="max-w-7xl mx-auto">

            <!-- Heading -->
            <!-- <div class="text-center mb-14">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900">
                    Get in <span class="text-purple-600">touch</span>
                </h2>
                <p class="text-gray-600 mt-3 text-base md:text-lg">
                    Reach out, and let's create a universe of possibilities together!
                </p>
            </div> -->

            <!-- Content -->
            <div class="grid md:grid-cols-2 gap-12 items-start p-3">
                <!-- Left: CONTACT INFO -->
                <div class="px-6">
                    <span class="text-sm font-semibold text-gray-500 uppercase">
                        TRUSTED BY HEALTHCARE PROFESSIONALS & HOSPITALS
                    </span>

                    <h3 class="text-4xl font-bold text-gray-900 mt-2 mb-4 font-playfair">
                        Need Help<br>Accessing Medicines?
                    </h3>

                    <p class="text-gray-600 mb-8">
                        Our specialists are here to guide you through every step of the medicine access process.
                    </p>

                    <div class="space-y-6">

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg
                                    flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-800 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-black font-bold tracking-wider">Mail Us At:</p>
                                <a href="mailto:info@namedpatientprogram.com"
                                    class="font-medium text-blue-700 hover:underline">
                                    info@namedpatientprogram.com
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg 
                                    flex items-center justify-center">
                                <i class="fas fa-phone text-blue-800 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-black font-bold tracking-wider">Contact Us:</p>
                                <a href="tel:+919654860915" class="font-medium text-blue-700 hover:underline">
                                    +91 9654860915
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right: FORM -->
                <div id="medicine-details-section" class="bg-[#FBFBFB]">
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Let's us help!</h3>
                    <p class="text-gray-600 mb-12">
                        Send us a message
                    </p>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-xl"></i>
                                <span>
                                    <?= $this->session->flashdata('success'); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <span>
                                    <?= $this->session->flashdata('error'); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- <form id="inquiryForm" action="<?= base_url('medicine_details_query'); ?>" method="post"
                    class="space-y-4"> -->
                    <form id="inquiryForm" class="space-y-4" method="post"
                        action="<?= base_url('medicine_details_query'); ?>">
                        <input type="hidden" name="return_url" value="<?= current_url(); ?>">

                        <div class="grid sm:grid-cols-2 gap-4">

                            <div>
                                <input id="first_name" type="text" name="first_name" placeholder="First Name"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')"
                                    class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                                <small class="text-red-500 text-sm mt-1 hidden" id="firstnameError"></small>
                            </div>
                            <div>
                                <input id="last_name" type="text" name="l_name" placeholder="Last Name"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')"
                                    class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                                <small class="text-red-500 text-sm mt-1 hidden" id="lastnameError"></small>
                            </div>

                        </div>

                        <input id="email" type="email" name="email" placeholder="Email"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9@._+-]/g, '')"
                            class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                        <small class="text-red-500 text-sm mt-1 hidden" id="emailError"></small>

                        <input id="phone" type="tel" name="phone" placeholder="Phone Number"
                            oninput="this.value=this.value.replace(/\D/g,'')"
                            class="w-full pl-20 pr-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">

                        <small class="text-red-500 text-sm mt-1 hidden" id="phoneError"></small>
                        <textarea id="message" name="message" rows="4" placeholder="Message"
                            class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"></textarea>
                        <small class="text-red-500 text-sm mt-1 hidden" id="messageError"></small>

                        <div class="flex justify-center">
                            <button type="submit" class="w-[60%] py-3 rounded-lg
               bg-blue-600 hover:bg-blue-700
               text-white font-medium transition">
                                Submit Your Enquiry
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#355ED8] py-10">
        <div class="max-w-6xl mx-auto px-6 lg:px-12">

            <div class="flex flex-col md:flex-row justify-between items-start">

                <!-- Left Content -->
                <div class="max-w-[250px]">

                    <h2 class="text-white text-[24px] leading-[36px] font-semibold">
                        Learn how to access medicines
                    </h2>

                    <a href="<?= base_url('compliance-and-safety/prescription-guidelines'); ?>" class="inline-flex items-center gap-3 mt-6
          text-[#FFFF00] hover:text-[#FFFF00]
          text-[16px] font-semibold
          tracking-widest transition-colors duration-300 group">

                        Learn More

                        <!-- <svg
                            class="w-[90px] h-3 transition-transform duration-300 group-hover:translate-x-1"
                            viewBox="0 0 90 12"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M1 6H84"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round" />

                            <path
                                d="M79 1L89 6L79 11"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg> -->
                        <img class="transition-transform duration-300 group-hover:translate-x-1"
                            src="<?= base_url('assets/images/home/arrow2.png') ?>" alt="">
                    </a>

                </div>

                <!-- Right Content -->
                <div class="max-w-[240px] mt-10 md:mt-0">

                    <h2 class="text-white text-[24px] leading-[36px] font-semibold">
                        Frequently Asked<br>
                        Questions
                    </h2>

                    <a href="<?= base_url('faqs') ?>" class="inline-flex items-center gap-3 mt-6
          text-[#FFFF00] hover:text-[#FFFF00]
          text-[16px] font-semibold
          tracking-widest transition-colors duration-300 group">

                        Learn More

                        <img class="transition-transform duration-300 group-hover:translate-x-1"
                            src="<?= base_url('assets/images/home/arrow2.png') ?>" alt="">

                    </a>
                </div>

            </div>

        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // Inquiry form
            const input2 = document.querySelector("#phone");
            window.intlTelInput(input2, {
                initialCountry: "in",
                separateDialCode: true,
                preferredCountries: ["in", "us", "gb", "ae"],
                dropdownContainer: document.body,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
            });


        });
    </script>
    <script>
        document.getElementById("inquiryForm").addEventListener("submit", function (e) {

            let isValid = true;

            // regex
            const nameRegex = /^[A-Za-z\s]{2,40}$/;
            const phoneRegex = /^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // inputs
            const lastName = document.getElementById("last_name");
            const firstName = document.getElementById("first_name");
            const email = document.getElementById("email");
            const phone = document.getElementById("phone");
            const message = document.getElementById("message");

            // error elements
            const lastNameError = document.getElementById("lastnameError");
            const firstNameError = document.getElementById("firstnameError");
            const emailError = document.getElementById("emailError");
            const phoneError = document.getElementById("phoneError");
            const messageError = document.getElementById("messageError");


            // reset
            document.querySelectorAll(".text-red-500").forEach(el => el.classList.add("hidden"));
            document.querySelectorAll(".form-input").forEach(el => el.classList.remove("border-red-500"));

            // name
            if (lastName.value.trim() === "") {
                showError(lastName, lastNameError, "Last name is required");
                isValid = false;
            } else if (!nameRegex.test(lastName.value.trim())) {
                showError(lastName, lastNameError, "Only letters allowed (2-40 characters)");
                isValid = false;
            }

            if (firstName.value.trim() === "") {
                showError(firstName, firstNameError, "First name is required");
                isValid = false;
            } else if (!nameRegex.test(firstName.value.trim())) {
                showError(firstName, firstNameError, "Only letters allowed (2-40 characters)");
                isValid = false;
            }

            // email
            if (email.value.trim() === "") {
                showError(email, emailError, "Email is required");
                isValid = false;
            } else if (!emailRegex.test(email.value.trim())) {
                showError(email, emailError, "Enter valid email address");
                isValid = false;
            }

            // phone
            if (phone.value.trim() === "") {
                showError(phone, phoneError, "Phone number is required");
                isValid = false;
            } else if (!phoneRegex.test(phone.value.trim())) {
                showError(phone, phoneError, "Enter valid phone number");
                isValid = false;
            }

            // message
            if (message.value.trim() === "") {
                showError(message, messageError, "Message is required");
                isValid = false;
            } else if (message.value.trim().length < 10) {
                showError(message, messageError, "Message must be at least 10 characters");
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }

            function showError(input, errorEl, message) {
                input.classList.add("border-red-500");
                errorEl.textContent = message;
                errorEl.classList.remove("hidden");
            }

        });
    </script>
    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });

        // Medicine data

        const medicineData = {

            name: "<?= addslashes($medicine->name ?? '_') ?>",
            company: "<?= addslashes($medicine->company_name ?? 'N/A') ?>",
            activeIngredient: "<?= addslashes($medicine->active_ingredient ?? 'N/A') ?>",
            strength: "<?= addslashes($medicine->strength ?? 'N/A') ?>",
            storage: "<?= addslashes($medicine->storage ?? 'N/A') ?>",
            origin: "<?= addslashes($medicine->origin ?? 'N/A') ?>",
            url: "<?= site_url('m/' . $medicine->category_name . '/' . $medicine->name) ?>"
        };

        // Share Medicine Function
        function shareMedicine() {
            const shareText = `${medicineData.name}

Company: ${medicineData.company}
Active Ingredient: ${medicineData.activeIngredient}
Strength: ${medicineData.strength}
Storage: ${medicineData.storage}
Origin: ${medicineData.origin}

View Details: ${medicineData.url}`;

            if (navigator.share) {
                navigator.share({
                    text: shareText
                })
                    .then(() => {
                        showToast('Medicine details shared successfully!', 'success');
                    })
                    .catch((err) => {
                        if (err && err.name !== 'AbortError') {
                            fallbackCopy(shareText);
                        }
                    });
            } else {
                fallbackCopy(shareText);
            }
        }

        // Fallback copy function
        function fallbackCopy(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => {
                        showToast('Medicine details copied to clipboard!', 'success');
                    })
                    .catch((err) => {
                        console.error('Clipboard failed:', err);
                        textareaCopy(text);
                    });
            } else {
                textareaCopy(text);
            }
        }

        // Legacy textarea copy
        function textareaCopy(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();

            try {
                document.execCommand('copy');
                showToast('Medicine details copied to clipboard!', 'success');
            } catch (err) {
                console.error('Copy failed:', err);
                showToast('Failed to copy. Please try manually.', 'error');
            }

            document.body.removeChild(textarea);
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            toast.className =
                `fixed bottom-4 right-4 z-[60] px-6 py-4 rounded-lg shadow-2xl ${bgColor} text-white font-semibold flex items-center gap-3 animate-slideIn`;

            const icon = type === 'success' ?
                `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>` :
                `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>`;

            toast.innerHTML = `${icon}<span>${message}</span>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('animate-slideOut');
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
        
        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }
        
        .animate-slideOut {
            animation: slideOut 0.3s ease-out;
        }
    `;
        document.head.appendChild(style);
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>


</body>

</html>