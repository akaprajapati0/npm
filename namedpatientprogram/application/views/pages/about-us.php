<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Named Patient Program | Global Access to Essential Medicines</title>
    <meta name="description"
        content="How Named Patient Program helps patients access essential medicines worldwide through compliant, ethical, and patient-focused solutions.">
    <meta name="keywords"
        content="Named Patient Program, Patient Access to Medicines,Life-Saving Therapies,Medicine Import in India,Global Patient Access Programs">
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
    $data['title'] = "About Us";
    $data['backgroundImage'] = "assets/images/report_adverse/report_adverse_banner.png";

    $this->load->view('components/banner', $data);
    ?>

    <!-- About Us Section -->
    <section class="bg-[#f8f9fc] py-20 px-6 md:px-12 lg:py-[90px]">
        <div class="max-w-7xl mx-auto">

            <h2 class="font-playfair text-4xl md:text-5xl font-normal text-[#1a1a1a] mb-8">
                About Us
            </h2>

            <p class="text-[16px] leading-8 text-[#4B5563] mb-8 font-inter">
                As a trusted access partner for the Named Patient Program (NPP), we facilitate
                patient-specific access to innovative, specialty, and life-saving medicines
                through established regulatory pathways. Backed by a robust global
                pharmaceutical network, regulatory expertise, and quality-assured operations,
                we help ensure timely, compliant, and responsible access to treatment while
                maintaining the highest standards of patient safety, product integrity, and
                regulatory compliance.
            </p>

            <p class="text-[16px] leading-8 text-[#4B5563] font-inter">
                We are dedicated to helping patients and healthcare professionals overcome
                the challenges of accessing prescribed medicines that are not commercially
                available, not yet approved, or otherwise inaccessible through conventional
                supply channels in their country.
            </p>


        </div>
    </section>
    <!-- Safety Monitoring & Reporting Support Section -->
    <?php
    $title = 'Who<span class="text-blue-600"> We</span> Are ';
    $description = "We are a healthcare organization dedicated to helping patients gain timely access to prescribed treatments through trusted, patient-centered solutions. Backed by expertise in regulatory affairs, pharmaceutical quality, international operations, and patient support, we work with integrity, transparency, and operational excellence to simplify complex access pathways while ensuring compliance, quality, and a better treatment experience.";
    $image_src = base_url('assets/images/about_us/section_img1.png');
    $image_alt = "We we are";
    $layout = 'text-left';
    $bg = 'bg-[#ffff]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- information list -->
    <section class="bg-[#2563EB]  py-12 my-8">
        <div class="max-w-7xl mx-auto px-4 md:px-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 ">

                <!-- Item -->
                <div class="text-center px-4 ">
                    <p class="text-3xl md:text-4xl font-bold text-white">
                        OVER
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-white">
                        10+ YEARS
                    </h2>

                    <p class="mt-3 text-sm md:text-base leading-relaxed text-white">
                        of NPP leadership powering global patient access
                    </p>
                </div>

                <!-- Item -->
                <div class="text-white text-center px-4">
                    <h2 class="text-3xl md:text-4xl font-bold text-white">
                        10,000+
                    </h2>

                    <p class="mt-1 text-lg font-semibold text-white">
                        PATIENTS
                    </p>

                    <p class="mt-3 text-sm md:text-base leading-relaxed text-white/90">
                        supported with timely access to life-saving therapies
                    </p>
                </div>

                <!-- Item -->
                <div class="text-white text-center px-4">
                    <h2 class="text-3xl md:text-4xl font-bold text-white">
                        1.5M+
                    </h2>

                    <p class="mt-1 text-lg font-semibold text-white">
                        PRODUCT
                    </p>

                    <p class="mt-3 text-sm md:text-base leading-relaxed text-white">
                        lines bringing the world’s therapies within reach
                    </p>
                </div>

                <!-- Item -->
                <div class=" text-center px-4">
                    <h2 class="text-3xl md:text-4xl font-bold text-white">
                        EU-GDP
                    </h2>

                    <p class="mt-1 text-lg font-semibold text-white">
                        CERTIFIED
                    </p>

                    <p class="mt-3 text-sm md:text-base leading-relaxed text-white/90">
                        WAREHOUSES in Belgium & Bulgaria for fully compliant storage
                    </p>
                </div>

            </div>

        </div>
    </section>
    <?php
    $title = 'Why <span class="text-blue-600">Healthcare Professionals</span> <br/>Trust Us';
    $description = "Healthcare professionals trust us for our expertise in facilitating compliant, patient-specific access to medicines through established regulatory pathways. By combining global pharmaceutical sourcing, regulatory coordination, and secure logistics, we help physicians and healthcare institutions obtain specialty, orphan, and life-saving medicines with efficiency, transparency, and an unwavering commitment to quality and patient safety.";
    $image_src = base_url('assets/images/about_us/section_img2.png');
    $image_alt = "Healthcare professionals trusting us";
    $layout = 'text-right';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <?php
    $title = 'What Set Us <span class="text-blue-600">Apart</span>';
    $description = "Our approach combines regulatory expertise, stringent quality standards, and a patient-first philosophy to facilitate responsible access to innovative, specialty, orphan, and life-saving medicines. Through a trusted global pharmaceutical network, EU-GDP compliant logistics, and adherence to CDSCO requirements and internationally recognized Good Distribution Practices (GDP), we deliver reliable, transparent, and compliant patient access solutions while ensuring product integrity and supply chain security.";
    $image_src = base_url('assets/images/about_us/section_img3.png');
    $image_alt = "Healthcare professionals trusting us";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- sHIPMENT MONITERING -->



    <!-- BG image -->

    <div class="w-full lg:mb-10">
        <img src="<?= base_url('assets/images/about_us/frame.png'); ?>" alt="Named Patient Program"
            class="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] xl:h-[650px] object-cover object-center">
    </div>
    <!-- Our Mission -->
    <?php
    $title = 'Our<br/><span class="text-blue-600">Vision</span>';
    $description = "We envision a world where access to essential and innovative medicines is guided by medical need rather than geographical limitations. By connecting patients with life-changing therapies through trusted global partnerships and responsible access pathways, we strive to create healthier futures, inspire hope, and improve lives—one patient, one treatment, and one journey at a time.";
    $image_src = base_url('assets/images/about_us/section_img4.png');
    $image_alt = "Healthcare professionals trusting us";
    $layout = 'text-right';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- Our Vision -->
    <?php
    $title = 'Our<br/><span class="text-blue-600">Mission</span>';
    $description = "We improve lives by enabling responsible access to essential medicines through trusted global partnerships, quality-driven processes, and regulatory excellence. With a patient-centered approach, we help healthcare professionals and patients navigate complex access pathways while ensuring compliance, product integrity, and safe access to innovative therapies.";
    $image_src = base_url('assets/images/about_us/section_img3.png');
    $image_alt = "Healthcare professionals trusting us";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>




    <!-- FAQ SECTION -->
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
                            How can I contact you?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        <p class="mb-2">There are a few ways you can reach us:</p>

                        <ul class="list-disc pl-6 space-y-2">
                            <li>
                                Complete the enquiry form on our
                                <a href="/contact-us" class="text-blue-600 hover:underline">
                                    Contact Us
                                </a>
                                page
                            </li>

                            <li>
                                Send an email:
                                <a href="mailto:info@namedpatientprogram.com" class="text-blue-600 hover:underline">
                                    info@namedpatientprogram.com
                                </a>
                            </li>

                            <li>
                                Call us on:
                                <ul class="list-circle pl-8 mt-2 space-y-1">
                                    <li>+91 96548 60915</li>
                                    <li>1800 1200 365 (Toll-Free)</li>
                                </ul>
                            </li>

                            <li>
                                We are also on WhatsApp. You can find us by adding this number:
                                +91 98104 69557.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Who is the NamedPatientProgram.com team?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600">
                        Our team comprises legal, logistical, and patient support professionals ready to help you access
                        the latest approved medicines through the Named Patient Import. Click here to meet the team.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What type of medicines do you have in your offering?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        At the moment, our main focus is on oncological, neurological, cardiovascular, endocrinological,
                        hematological, hepatological, immunological, nephrological, pulmonary, and rare disease
                        therapies. However, if you are looking for a medicine that is not currently in our offering,
                        please get in touch, and we’ll do our best to help.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Can you provide medical advice?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        No. We do not provide medical advice. Only your treating doctor can recommend the right
                        treatment and prescribe the appropriate medicine for your condition. Our role is to help
                        facilitate access to the prescribed medicine when it is unavailable in India, subject to
                        applicable regulatory requirements.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Where are you located and what are your contact hours?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        We are based in Noida, Sector 62, and our office hours are from 9:00 AM – 6:00 PM (IST) from
                        Monday to Friday.
                    </div>
                </div>

            </div>
        </div>
    </section>


    <?php $this->load->view('layouts/includes/footer'); ?>


</body>

</html>