<!-- Your FAQ HTML Here -->
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" data-wf-page="5f775d9aa6e41d02fdcb27b1">

<head>
 <meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FAQs NPP | Patient Access Support</title>
<meta name="description" content="Contact our Named Patient Program team for assistance with accessing unapproved medicines, rare disease treatments, and global patient support.">
<meta name="keywords" content="Named Patient Program Support, Patient Access Services, Unapproved Medicine Access, Rare Disease Treatment Access, Global Patient Assistance, Contact Patient Access Experts, Compassionate Use Program Support">
<link rel="canonical" href="<?= current_url(); ?>">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<meta name="author" content="Ikris Pharma Network">
<meta name="language" content="English">
<meta name="geo.region" content="IN-UP">
<meta name="geo.placename" content="Noida, Uttar Pradesh, India">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5QFX8TJM');</script>
<!-- End Google Tag Manager -->
 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QFX8TJM"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <?php $this->load->view('layouts/includes/head-links'); ?>

</head>

<body>
    <?php $this->load->view('layouts/includes/header'); ?>

    <div class="page-wrapper">

        <!-- FAQ SECTION -->
        <section class="py-20 md:py-28 px-4 bg-gray-50">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-start">

                <!-- LEFT -->
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Frequently Asked<br>Questions
                    </h2>

                    <p class="text-gray-600 text-lg mb-6 max-w-md">
                        Here are answers to questions we're often asked.
                    </p>


                </div>

                <!-- RIGHT -->
                <div class="space-y-6">

                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(1)" class="w-full flex justify-between items-center text-left">
                            <span class="text-lg font-semibold text-gray-900">
                                How do I request a medicine
                            </span>
                            <span id="icon-1" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-1" class="hidden pt-4 text-gray-600">
                            You can request a medicine by searching on our platform and
                            submitting a request along with a valid prescription.
                        </div>
                    </div>

                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                            <span class="text-lg font-semibold text-gray-900">
                                How is cold-chain maintained?
                            </span>
                            <span id="icon-2" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-2" class="hidden pt-4 text-gray-600">
                            All medicines are transported using temperature-controlled
                            packaging with continuous monitoring to ensure safety.
                        </div>
                    </div>

                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                            <span class="text-lg font-semibold text-gray-900">
                                How long does it take to receive a medicine?
                            </span>
                            <span id="icon-3" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-3" class="hidden pt-4 text-gray-600">
                            Delivery timelines usually range between 7–15 days,
                            depending on documentation and logistics.
                        </div>
                    </div>

                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                            <span class="text-lg font-semibold text-gray-900">
                                The medicines are expensive. Who sets the price?
                            </span>
                            <span id="icon-4" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-4" class="hidden pt-4 text-gray-600">
                            Prices are determined by manufacturers, import costs,
                            logistics, regulatory requirements, and currency factors.
                        </div>
                    </div>

                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                            <span class="text-lg font-semibold text-gray-900">
                                Is it legal to buy medicines not approved in India?
                            </span>
                            <span id="icon-5" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-5" class="hidden pt-4 text-gray-600">
                            Yes. Under CDSCO guidelines, medicines can be imported for
                            personal use with a valid prescription.
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <?php $this->load->view('layouts/includes/footer'); ?>
    </div>
    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/form-validator.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/contact-form-script.js"></script>
    <script src="<?= base_url(); ?>assets/js/swiper-min.js"></script>
    <script src="<?= base_url(); ?>assets/js/jquery-magnific-popup.js"></script>
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <script src="<?= base_url(); ?>assets/js/script.js"></script>
    <!-- Main JS -->
    <!-- partial -->
    <script src="<?= base_url(); ?>assets/js/countryList.js"></script>
    <script src="<?= base_url(); ?>assets/js/customeSelect.js"></script>
    <script src='<?= base_url(); ?>assets/js/owl.carousel.min.js'></script>
    <!-- Cursor follow mover -->
    <script src="<?= base_url(); ?>assets/js/cursor-animation.js"></script>
    <!-- parallax -->
    <script src="<?= base_url(); ?>assets/js/TweenMax.min.js"></script>

    <script>
        function toggleFaq(id) {
            for (let i = 1; i <= 5; i++) {
                const faq = document.getElementById('faq-' + i);
                const icon = document.getElementById('icon-' + i);

                if (i === id) {
                    faq.classList.toggle('hidden');
                    icon.textContent = faq.classList.contains('hidden') ? '+' : '−';
                } else {
                    faq.classList.add('hidden');
                    icon.textContent = '+';
                }
            }
        }
    </script>

</body>



</html>