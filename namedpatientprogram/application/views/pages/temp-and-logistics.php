<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Temperature-Controlled Shipping for Medicines | NPP</title>
    <meta name="description"
        content="Secure temperature-controlled shipping for specialty medicines worldwide. GDP-compliant cold chain logistics ensuring product integrity.">
    <meta name="keywords"
        content="Temperature-Controlled Shipping, Cold Chain Logistics, Pharmaceutical Shipping, Medicine Cold Chain, Specialty Drug Transportation, GDP-Compliant Shipping, Temperature-Sensitive Medicines, Global Medicine Logistics, Pharmaceutical Cold Chain, Healthcare Logistics">
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
    $data['backgroundImage'] = "assets/images/temp_and_logistic/temp_banner.png";

    $this->load->view('components/banner', $data);
    ?>

    <!-- Importanse of temperature -->
    <?php
    $title = 'Importance of <span class="text-blue-600"> Temperature<br/>Control</span> in Named Patient Supply';
    $description = "At NPP, temperature management is integrated into every stage of the supply process. From sourcing and international transportation to customs clearance and final delivery, medicines are handled in accordance with validated storage and transport conditions, including refrigerated, controlled room temperature, and other product-specific requirements. Through specialized packaging, continuous monitoring, and qualified logistics partners, we help maintain product integrity and support safe, reliable patient access to treatment.";
    $image_src = base_url('assets/images/temp_and_logistic/section_img1.png');
    $image_alt = "Temperature-controlled medicine storage and transport";
    $layout = 'text-left';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- GDP-Compliant Logistic -->
    <?php
    $title = '<span class="text-blue-600">GDP-Compliant</span> Logistic Operations';
    $description = "All storage, transportation, and distribution activities are conducted in accordance with Good Distribution Practices (GDP) and product-specific handling requirements. From collection and international shipment to final delivery, validated procedures and trained personnel help ensure that medicines are managed appropriately throughout the supply journey, supporting product integrity, regulatory compliance, and patient safety.";
    $image_src = base_url('assets/images/temp_and_logistic/section_img2.png');
    $image_alt = "Temperature-controlled storage and transport facilities";
    $layout = 'text-right';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <!-- Temp Monitering -->
    <section class="py-20 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 md:px-10">

            <!-- Heading -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-normal mb-4 font-playfair">
                    Temperature Monitoring<br />
                    and <span class="text-blue-600">Data Logging</span>
                </h2>

                <p class="text-gray-600 max-w-3xl mx-auto font-inter">
                    Continuous temperature monitoring is maintained during storage and transport, with calibrated data loggers ensuring accurate records for quality and compliance.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <div class="bg-[#2563EB] p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00] ">01</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Packaging systems are selected based on temperature needs and transit conditions.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">02</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Temperature-monitoring devices ensure visibility and compliance during transit.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">03</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Qualified logistics partners maintain product quality during transportation.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">04</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Shipment records are reviewed upon delivery to confirm compliance.
                    </p>
                </div>

            </div>

        </div>
    </section>
    <!-- GDP Compliant Logistic -->
    <?php
    $title = 'GDP-Compliant <br/><span class="text-blue-600"> Storage & Distribution</span> ';
    $description = "Access to medicines via the Named Patient Program requires logistics. Our EU-GDP–certified warehouse in Bulgaria supports compliant storage and distribution under validated, temperature-controlled conditions. Facilities enable storage, consolidation, and quality oversight, using monitoring systems, controlled access, and GDP-aligned processes to maintain product integrity, ensure regulatory compliance, and support global patient access.";
    $image_src = base_url('assets/images/temp_and_logistic/section_img3.png');
    $image_alt = "Temperature-controlled storage and transport facilities";
    $layout = 'text-left';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- sHIPMENT MONITERING -->
    <?php
    $title = 'Shipment Monitoring<br/><span class="text-blue-600">& Coordination</span> ';
    $description = "Access to medicines through the Named Patient Program involves complex international supply pathways. To ensure uninterrupted access, we implement structured planning and coordination across the supply process. This includes proactive shipment monitoring, partner collaboration, contingency planning, and continuous communication to address challenges while maintaining product quality, temperature compliance, and reliable delivery.";
    $image_src = base_url('assets/images/temp_and_logistic/section_img4.png');
    $image_alt = "Temperature-controlled storage and transport facilities";
    $layout = 'text-right';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

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
                            What is a cold chain shipment?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        Some medicines need to be stored within a defined range — most commonly 2–8°C. These are called
                        "temperature-controlled medicines". This means that their shipment needs to be via an unbroken
                        cold chain. When delivering these medicines, we ensure the medicines are packed properly, in a
                        special transport box which regulates the temperature for sufficient time to arrive safely at
                        the destination.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What is GDP-compliant pharmaceutical logistics?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600">
                        GDP-compliant logistics follows Good Distribution Practice — the quality standards governing how
                        medicines are stored, transported, and delivered so their integrity is maintained. It covers
                        documented procedures for storage, packing, dispatch, transit, and delivery, handled by trained
                        personnel, to meet regulatory expectations and protect patient safety.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Why is temperature control important for Named Patient Medicines?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        Many specialty, orphan, and critical medicines supplied under Named Patient Import are sensitive
                        to temperature changes, and even short excursions can affect stability, efficacy, or safety.
                        NamedPatientProgram.com treats temperature control as a patient-safety requirement, handling
                        every medicine according to manufacturer-defined storage and transport conditions.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How do you monitor temperature during shipment?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        NamedPatientProgram.com monitors temperature continuously across storage and transport using
                        validated, insulated, temperature-controlled packaging and electronic data loggers that record
                        trip-based or real-time data. Packaging is verified before dispatch, and temperature records are
                        reviewed and documented after delivery, providing an auditable trail confirming the product
                        stayed within range.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Where do you store temperature-sensitive medicines before international shipment?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        We store temperature-sensitive medicines in WHO-GDP-certified warehouse facilities in Bulgaria
                        and India, providing validated environments for both 2–8°C cold chain and controlled room
                        temperature storage. These hubs operate under documented GDP procedures, including environmental
                        monitoring, deviation management, and access control.
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- JavaScript - Place this RIGHT AFTER the section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all FAQ question buttons
            var faqQuestions = document.querySelectorAll('.faq-question');

            // Loop through each button and add click event
            for (var i = 0; i < faqQuestions.length; i++) {
                faqQuestions[i].addEventListener('click', function() {
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