<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Safety Standards | Quality & Compliance Assurance</title>
    <meta name="description"
        content="Learn about our product safety standards, quality controls, GDP-compliant sourcing, cold-chain logistics, and medicine authenticity assurance.">
    <meta name="keywords"
        content="Product Safety Standards, Product Safety Standards, Medicine Safety Standards, Pharmaceutical Quality Assurance, GDP Compliance, Medicine Authenticity, Safe Medicine Supply, Pharmaceutical Safety, Cold Chain Logistics, Quality Control in Pharmaceuticals, Regulatory Compliance">
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
    $data['title'] = "Medicine Safety";
    $data['backgroundImage'] = "assets/images/report_adverse/report_adverse_banner.png";

    $this->load->view('components/banner', $data);
    ?>
    <!-- Importanse of temperature -->
    <?php
    $title = 'Quality Assured<br/><span class="text-blue-600">Medicine Sourcing</span>';
    $description = "Medicines supplied through the Named Patient Program are sourced via authorized channels to ensure authenticity, traceability, and regulatory compliance. Verification processes are applied throughout sourcing to confirm approved origins. Our framework maintains product integrity from procurement to delivery, supporting consistent quality and reliability of treatments provided to patients.";
    $image_src = base_url('assets/images/medicine_safety/section_img1.png');
    $image_alt = "Quality assured medicine sourcing";
    $layout = 'text-left';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- GDP-Compliant Logistic -->
    <?php
    $title = 'Product Integrity,<br/>Traceability & <span class="text-blue-600">FMD Alignmen</span>';
    $description = "Maintaining authenticity, integrity, and traceability is essential for patient safety. We apply verification and tracking measures across the supply chain to ensure secure handling of medicines. Our processes align with EU Falsified Medicines Directive principles, supporting serialization and verification, enhancing transparency, accountability, and safeguarding product authenticity throughout distribution pathways.";
    $image_src = base_url('assets/images/medicine_safety/section_img2.png');
    $image_alt = "Product integrity and traceability";
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
                    Ensuring
                    <span class="text-blue-600"> Quality, Safety & Traceability</span><br />
                    in Pharmaceutical Supply
                </h2>

                <p class="text-gray-600 max-w-3xl mx-auto font-inter">
                    A comprehensive approach to sourcing, verification, monitoring, and patient-focused care
                    across the medicine supply chain.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <div class="bg-[#2563EB] p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00] ">01</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Medicines procured through authorized and qualified supply channels.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">02</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        End-to-end verification and tracking ensure supply chain transparency.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">03</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Continuous pharmacovigilance supports medicine safety and regulatory compliance.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">04</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Commitment to delivering safe, reliable, and responsible access to medicines.
                    </p>
                </div>

            </div>

        </div>
    </section>
    <!-- Importanse of temperature -->
    <?php
    $title = 'Safety Monitoring & <span class="text-blue-600">Pharmacovigilance</span>';
    $description = "Ongoing medicine safety monitoring is essential in responsible patient access programs. We support the collection, documentation, and reporting of adverse events, product complaints, and safety information in line with pharmacovigilance requirements. This ensures continuous evaluation of product safety and fosters collaboration among healthcare professionals, manufacturers, and regulatory authorities.";
    $image_src = base_url('assets/images/medicine_safety/section_img3.png');
    $image_alt = "Safety monitoring and pharmacovigilance";
    $layout = 'text-left';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- GDP-Compliant Logistic -->
    <?php
    $title = 'Commitment to<span class="text-blue-600"> Patient Safety</span>';
    $description = "Patient wellbeing is central to every aspect of the Named Patient Program. Our operational, quality, and compliance processes support safe and responsible medicine access while maintaining high standards of care. Through collaboration with healthcare providers, manufacturers, and qualified supply chain partners, we help ensure patient safety throughout the entire treatment journey.";
    $image_src = base_url('assets/images/medicine_safety/section_img4.png');
    $image_alt = "Commitment to patient safety";
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
                            Why is temperature control important for medicine safety?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        Many specialty, rare disease, oncology, and biologic medicines are temperature-sensitive and can
                        lose effectiveness or become unsafe if exposed to conditions outside the manufacturer's
                        specifications. Maintaining the correct range — controlled room temperature (15–25°C) or cold
                        chain (2–8°C) as applicable — throughout storage and transport protects their quality, efficacy,
                        and safety for patients.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What is a temperature data logger and how does it protect medicines?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600">
                        A temperature data logger is a validated electronic device that continuously records
                        time-stamped temperature data during storage and transport. It allows any temperature excursion
                        to be identified, documented, and assessed on receipt, so medicines are supplied to patients
                        only when temperature integrity and product quality are confirmed.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How can patients reduce the risk of receiving counterfeit medicine?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        Patients should obtain medicines only through authorized and regulated supply channels that
                        require a valid prescription, rather than uncertified online sellers. Buying from legitimate,
                        traceable sources, checking packaging integrity, and reporting any suspected quality concerns or
                        adverse events to a doctor all help reduce the risk.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How does NamedPatientProgram.com ensure supply chain integrity?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        NamedPatientProgram.com works exclusively with authorized manufacturers, licensed stockists, and
                        regulated logistics partners. Medicines are procured from legitimate, traceable sources,
                        supplied in original manufacturer packaging, distributed only against valid prescriptions for
                        named patients, and handled under documented quality procedures — reducing risks from diversion,
                        counterfeiting, and improper handling.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How can patients store medicines safely at home?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        Store medicines exactly as advised by your doctor or pharmacist, protected from heat, direct
                        sunlight, and moisture — especially important in India's high-temperature climate. Follow
                        specific storage conditions for refrigerated medicines, check packaging integrity before use,
                        and never use medicines past their expiry date or prescribed duration.
                    </div>
                </div>

            </div>
        </div>
    </section>

    </script>

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