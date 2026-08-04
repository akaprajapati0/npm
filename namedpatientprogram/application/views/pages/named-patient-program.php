<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Named Patient Program | Access Unapproved Medicines Globally</title>
    <meta name="description"
        content="Access unapproved and unavailable medicines through a compliant Named Patient Program. Trusted global sourcing, regulatory support, and secure delivery.">
    <meta name="keywords"
        content="Named Patient Program, Named Patient Program India, Named Patient Access Program, Access Unapproved Medicines, Import Unavailable Medicines, Global Medicine Access, Unregistered Medicines India, Early Access Medicines, Patient Access Program">
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

    <!-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" /> -->

    <?php $this->load->view('layouts/includes/head-links'); ?>

</head>

<body>
    <?php $this->load->view('layouts/includes/header'); ?>


    <?php
    $data['title'] = "Named Patient<br/>Program";
    $data['backgroundImage'] = "assets/images/report_adverse/report_adverse_banner.png";

    $this->load->view('components/banner', $data);
    ?>
    <!-- Named Patient Program Section -->
    <section class="bg-[#F8FAFC] py-16 lg:py-24">
        <div class="max-w-7xl mx-auto">

            <!-- Heading -->
            <h2 class="font-playfair text-3xl sm:text-4xl lg:text-5xl font-medium leading-tight text-black mb-8">
                What is
                <span class="text-[#2F63E9]">Named Patient Program</span>
                <span class="text-black">( NPP )</span>
            </h2>

            <!-- Content -->
            <div class="max-w-5xl">
                <p class="text-gray-700 text-base lg:text-lg leading-8 mb-8">
                    A Named Patient Program (NPP), also referred to as a Managed Access Program,
                    enables access to medicines for individual patients when a treating physician
                    determines that a specific treatment is medically appropriate and not readily
                    accessible through conventional local channels.
                </p>

                <p class="text-gray-700 text-base lg:text-lg leading-8">
                    The program is intended to support patients with unmet medical needs by
                    facilitating access to medicines on a patient-specific basis while adhering to
                    applicable regulatory and ethical requirements.
                </p>
            </div>

        </div>
    </section>
    <!-- Inpotance of temp -->
    <?php
    $title = '<span class="text-blue-600">Why</span>Named Patient<br/>Programs Matter';
    $description = "Timely access to treatment can play an important role in patient care. Named Patient Programs help bridge access gaps by facilitating the supply of medicines that may not yet be available through standard commercial pathways.";
    $image_src = base_url('assets/images/npp/section_img1.png');
    $image_alt = "Temperature-controlled medicine storage and transport";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- Temperature Monitoring -->
    <section class="py-20 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 md:px-10">

            <!-- Heading -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-normal mb-4 font-playfair">
                    How Patient
                    <span class="text-blue-600">Access Programs Work</span>
                </h2>

                <p class="text-gray-600 max-w-3xl mx-auto font-inter">
                    A structured process that supports treatment access through medical evaluation,
                    documentation review, regulatory coordination, and medicine supply.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <div class="bg-[#2563EB] p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00] ">01</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Physician assesses the patient's condition and treatment requirements.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">02</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Prescriptions and supporting medical records are collected and reviewed.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">03</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Documentation is processed in line with applicable access and regulatory requirements.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">04</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Medicines sourced through authorized channels with ongoing patient support.
                    </p>
                </div>

            </div>

        </div>
    </section>
    <?php
    $title = 'Global Access, <span class="text-blue-600"> Local Expertise</span>';
    $description = "Facilitating medicine access requires coordination across sourcing, regulatory, quality, and logistics functions. Through an international network of manufacturers, pharmaceutical partners, and logistics providers, we support access for patients with unmet medical needs. Our team collaborates with healthcare professionals and global stakeholders to manage patient-specific access while ensuring compliance and patient-centered care.";
    $image_src = base_url('assets/images/npp/section_img2.png');
    $image_alt = "Temperature-controlled medicine storage and transport";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- Therapeutic Areas we cover -->
    <section class="pb-6 max-w-7xl mx-auto md:mt-[80px]">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-4xl font-normal font-playfair">Trusted Expertise In
                    Compliant<br class="hidden sm:block" /><span class="text-[#0040C6]">Global Medicine Access</span>
                </h1>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

                <!-- Step 1 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">
                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Oncology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Access to targeted therapies, immunotherapies, and other innovative cancer treatments.
                    </p>
                </div>

                <!-- Step 2 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">
                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Hematology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Support for blood disorders, including leukemia, anemia, and rare hematological conditions.
                    </p>
                </div>

                <!-- Step 3 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">

                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Neurology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Access to therapies for neurological and neurodegenerative disorders.
                    </p>
                </div>

                <!-- Step 4 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">

                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Immunology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Innovative treatments for autoimmune and inflammatory diseases.
                    </p>
                </div>

                <!-- Step 5 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">
                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Nephrology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Specialized therapies for kidney diseases and renal complications.
                    </p>
                </div>

                <!-- Step 6 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">

                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Heapatology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Access to treatments for digestive, liver, and inflammatory bowel disorders.
                    </p>
                </div>

                <!-- Step 7 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">

                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Cariology
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Global therapies for cardiovascular diseases and heart-related conditions.
                    </p>
                </div>

                <!-- Step 8 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">
                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Rare Diseases
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Access to orphan drugs and treatments for rare genetic and metabolic disorders.
                    </p>
                </div>

                <!-- Step 9 -->
                <div
                    class="group relative rounded-xl hover:shadow-xl transition-all duration-300 p-6 text-start md:text-left">

                    <!-- Step Title -->
                    <h3 class="text-lg md:text-3xl font-semibold text-gray-800 py-2">
                        Miscellaneous
                    </h3>

                    <!-- Step Description -->
                    <p class="text-gray-500 leading-relaxed text-sm md:text-base">
                        Support for complex and highly specialized treatment requirements across multiple therapeutic
                        fields.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <?php
    $title = '<span class="text-blue-600">Patient Centric<br/></span>Compliance Focus';
    $description = "The Named Patient Program is designed with a strong focus on patient safety, regulatory compliance, and ethical responsibility. Every request is managed on a patient-specific basis, ensuring proper documentation, quality assurance, and traceability while maintaining high standards of care throughout the medicine access process for safe treatment outcomes.";
    $image_src = base_url('assets/images/npp/section_img3.png');
    $image_alt = "Temperature-controlled medicine storage and transport";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <div class="w-full">
        <img src="<?= base_url('assets/images/npp/frame.png'); ?>" alt="Named Patient Program"
            class="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] xl:h-[650px] object-cover object-center">
    </div>
    <!-- GET IN TOUCH -->
    <section class="py-8 max-w-7xl mx-auto md:py-12 bg-white mt-5">
        <div class="max-w-7xl mx-auto">

            <!-- Content -->
            <div class="grid md:grid-cols-2 gap-6 items-start">


                <!-- Left: CONTACT INFO -->
                <div>
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
                                <a href="tel:+919810469557" class="font-medium text-blue-700 hover:underline">
                                    +91 9810469557
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Right: FORM -->
                <div id="npp-query-section" class="bg-[#FBFBFB] pr-8">
                    <h3 class="text-[30px] font-semibold text-gray-900 mb-1">Let's us help!</h3>
                    <p class="text-gray-600 mb-4">
                        We get back to you shortly during our working hours.
                    </p>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-xl"></i>
                                <span><?= $this->session->flashdata('success'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <span><?= $this->session->flashdata('error'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form id="npp-inquiry-form" action="<?= base_url('npp_query'); ?>" method="post" class="space-y-4">

                        <div class="grid sm:grid-cols-2 gap-4">

                            <div>
                                <input id="first_name" type="text" name="first_name" placeholder="First Name"
                                    class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')">
                                <small class="text-red-500 text-sm mt-1 hidden" id="firstnameError"></small>
                            </div>
                            <div>
                                <input id="last_name" type="text" name="l_name" placeholder="Last Name"
                                    class="w-full px-2 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')">
                                <small class="text-red-500 text-sm mt-1 hidden" id="lastnameError"></small>
                            </div>

                        </div>

                        <input id="email" type="email" name="email" placeholder="Email"
                            class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9@._+-]/g, '')">
                        <small class="text-red-500 text-sm mt-1 hidden" id="emailError"></small>

                        <input id="phone" type="tel" name="phone" placeholder="Phone Number"
                            class="w-full pl-20 pr-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"
                            oninput="this.value=this.value.replace(/\D/g,'')">

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

                    </form>
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
                            What is the Named Patient Program also known as?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        The Named Patient Program (NPP) is also known as a Managed Access Program (MAP), Compassionate
                        Use, Early Access Program (EAP), or Expanded Access Program in different countries. While the
                        terminology varies, these programs all aim to provide eligible patients with access to medicines
                        that are not yet commercially available when there is a genuine medical need. However, the
                        eligibility criteria, regulatory requirements, and approval process differ across countries.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Can you help me import a medicine that is already approved in my country?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600">
                        Our service can only help you import medicines that are either unapproved or unavailable in your
                        country. Sometimes, a medicine is approved but not (yet) available. In those cases, we can help
                        you access the medicines. But when a medicine is available in your country, we cannot supply it.
                        If the medicine you are looking for is not available, please get in touch with our Patient
                        Support Team to discuss further.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Who is eligible to import medicines under the Named Patient Program?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        Patients who have been diagnosed with a serious or life-threatening medical condition and
                        require a medicine that is unavailable in India may be eligible to import it through the Named
                        Patient Program. A registered medical practitioner must prescribe the medicine and confirm that
                        it is medically necessary. Each request is reviewed based on the applicable regulatory
                        requirements.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What if the medicine I'm looking for isn't on your website?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        Please contact us. If your doctor has recommended a specific medicine and it's been approved
                        somewhere in the world, we'll usually be able to find it for you.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            What types of medicines can be supplied under the Named Patient Program?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        The Named Patient Program may help patients access medicines that are not readily available in
                        their country. These can include medicines for rare diseases, cancer, and other serious health
                        conditions, orphan drugs, medicines facing local shortages, discontinued medicines that are
                        still available in other countries, certain biologic therapies, and other specialty medicines.
                        The availability of any medicine depends on regulatory requirements, a valid prescription, and
                        product availability.
                    </div>
                </div>

            </div>
        </div>
    </section>



    <?php $this->load->view('layouts/includes/footer'); ?>
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
            phoneInput.parentElement.style.width = "100%";

        });
    </script>

    <script>
        document.getElementById("npp-inquiry-form").addEventListener("submit", function (e) {

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

    <!-- JavaScript - Place this RIGHT AFTER the section -->
    <!-- <script>
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
    </script> -->

    <!-- Optional: Smooth animation CSS -->
    <!-- <style>
        .faq-answer {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .faq-question .fa {
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .faq-question:hover .fa {
            transform: scale(1.15);
        }

        .faq-question {
            cursor: pointer;
        }
    </style> -->

</body>