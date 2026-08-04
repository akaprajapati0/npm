<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($article['metaTitle'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </title>

    <meta name="description" content="<?= htmlspecialchars($article['metaDescription'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <meta name="keywords" content="<?= htmlspecialchars($article['metaKeywords'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <link rel="canonical" href="<?= htmlspecialchars($article['metaCanonical'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <meta name="author" content="Ikris Pharma Network">
    <meta name="language" content="English">
    <meta name="geo.region" content="IN-UP">
    <meta name="geo.placename" content="Noida, Uttar Pradesh, India">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Named Patient Program – Ikris Pharma Network">

    <meta property="og:title" content="<?= htmlspecialchars($article['ogMetaTitle'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <meta property="og:description"
        content="<?= htmlspecialchars($article['ogMetaDescription'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <meta property="og:url" content="<?= htmlspecialchars($article['ogMetaUrl'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <meta property="og:image" content="https://namedpatientprogram.com/assets/images/home/hero_img.jpg">

    <meta property="og:image:alt" content="Named Patient Program – Global Medicine Access">

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="Named Patient Program | Global Access to Medicines">

    <meta name="twitter:description"
        content="Access life-saving therapies through global Named Patient Programs. Supporting patients, physicians, and pharmaceutical companies worldwide.">

    <meta name="twitter:image" content="https://namedpatientprogram.com/assets/images/home/hero_img.jpg">

    <meta name="twitter:image:alt" content="Named Patient Program – Global Medicine Access">

    <?php $this->load->view('layouts/includes/head-links'); ?>

    <?php if (!empty($article['metaSchema'])): ?>
        <script type="application/ld+json">
        <?= $article['metaSchema']; ?>
            </script>
    <?php endif; ?>

</head>

<body>

    <?php $this->load->view('layouts/includes/header'); ?>

    <!-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css" /> -->
    <?php
    $articles = [
        [
            'title' => 'The Sunset In the East',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            'image' => base_url('assets/img/blog-hero.svg'),
            'slug' => 'the-sunset-in-the-east',
        ],
        [
            'title' => 'Exploring New Horizons',
            'description' => 'Discover amazing destinations around the world. Lorem ipsum dolor sit amet consectetur adipisicing elit.',
            'image' => base_url('assets/img/blog-hero.svg'),
            'slug' => 'exploring-new-horizons',
        ],
        [
            'title' => 'Healthcare Innovation',
            'description' => 'How technology is changing patient care.',
            'image' => base_url('assets/img/blog-hero.svg'),
            'slug' => 'healthcare-innovation',
        ],
    ];
    ?>
    <!-- Hero section -->
    <section>
        <div class="w-full">
            <!-- <img src="<?= base_url('assets/img/blog-detail-hero.svg'); ?>" alt="Named Patient Program"
            class="w-full h-[400px] md:h-[500px] lg:h-[600px] object-cover" /> -->
            <?php if (!empty($article['image'])): ?>
                <img src="<?= base_url('assets/images/news/' . $article['image']) ?>"
                    alt="<?= htmlspecialchars($article['title']) ?>"
                    class="w-full h-[220px] sm:h-[300px] md:h-[420px] lg:h-[520px] object-cover">
            <?php else: ?>
                <div
                    class="relative h-[220px] sm:h-[300px] md:h-[420px] lg:h-[520px] bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-newspaper text-6xl md:text-8xl text-white opacity-50"></i>
                </div>
            <?php endif; ?>

            <!-- Content Card -->
            <div
                class="bg-[#F8FAFC] -mt-10 sm:-mt-16 md:-mt-20 lg:-mt-[90px] z-10 inset-0 flex items-center justify-center px-2 sm:px-8">
                <div
                    class="bg-white shadow-md text-black p-5 md:p-8 rounded-sm w-full sm:w-[90%] sm:px-6 lg:px-[100px] max-w-7xl mx-auto space-y-4 overflow-hidden">
                    <!-- <span class="text-base underline font-medium">
                    Article
                </span> -->
                    <span class="text-base underline font-medium">
                        <?= htmlspecialchars($article['category_name'] ?? 'News') ?>
                    </span>

                    <h1 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-bold mb-2 sm:mb-4 leading-snug">
                        <?= htmlspecialchars($article['title']) ?>
                    </h1>

                    <div
                        class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-2 text-base sm:text-xl font-normal">
                        <div class="flex justify-between sm:justify-start sm:gap-4 w-full sm:w-auto order-2 sm:order-1">
                            <span
                                class="text-sm text-gray-400"><?= htmlspecialchars($article['author'] ?? 'Admin') ?></span>
                            <span
                                class="text-sm text-gray-400"><?= !empty($article['created_at']) ? date('F j, Y', strtotime($article['created_at'])) : '' ?></span>
                        </div>
                        <ul class="flex items-center flex-wrap gap-2 order-1 sm:order-2">
                            <li><a href="https://facebook.com" class="facebook" target="_blank">
                                    <img src="<?= base_url('assets/images/news-details/facebook.svg') ?>"
                                        class="w-7 sm:w-8" />
                                </a></li>
                            <li><a href="https://wa.me/1234567890" class="whatsapp" target="_blank">
                                    <img src="<?= base_url('assets/images/news-details/whatsapp.svg') ?>"
                                        class="w-6 sm:w-7" />
                                </a></li>
                            <li><a href="https://instagram.com" class="instagram" target="_blank">
                                    <img src="<?= base_url('assets/images/news-details/insta.svg') ?>"
                                        class="w-7 sm:w-8" />
                                </a></li>
                            <li><a href="https://linkedin.com" class="linkedin" target="_blank">
                                    <img src="<?= base_url('assets/images/news-details/linkedin.svg') ?>"
                                        class="w-7 sm:w-8" />
                                </a></li>
                        </ul>
                    </div>

                    <!-- <div class="text-base sm:text-lg md:text-xl font-semibold text-black break-words">
                        <?= $article['description'] ?>
                    </div> -->
                    <div class="prose prose-sm sm:prose-base md:prose-lg max-w-none break-words text-black  [&_ul]:list-disc
                            [&_ul]:pl-6
                            [&_li::marker]:text-black">
                        <?= $article['description'] ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-12 sm:py-20 md:py-28 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 md:gap-12 items-start">

            <!-- LEFT -->
            <div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4 sm:mb-6">
                    Frequently Asked<br class="hidden sm:block">Questions
                </h2>

                <p class="text-gray-600 text-base sm:text-lg mb-6 max-w-md">
                    Here are answers to questions we're often asked.
                </p>

                <a href="#" class="text-purple-600 font-semibold underline hover:text-purple-700 transition">
                    Find your Answers?
                </a>
            </div>

            <!-- RIGHT -->
            <div class="space-y-6 sm:space-y-8">

                <!-- ITEM 1 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(1)"
                        class="w-full flex justify-between items-start sm:items-center gap-3 text-left">
                        <span class="text-base sm:text-lg text-gray-900">
                            1. Is it legal to import medicines into India for personal use?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold shrink-0">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-sm sm:text-base text-gray-600">
                        Yes. Under the Drugs and Cosmetics Act, 1940, and the Drugs and Cosmetics Rules, 1945,
                        individuals may import certain medicines for personal use, subject to applicable regulatory
                        requirements. A valid prescription and the necessary approvals from the competent authorities
                        are generally required before import.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)"
                        class="w-full flex justify-between items-start sm:items-center gap-3 text-left">
                        <span class="text-base sm:text-lg text-gray-900">
                            2. Who can import medicines into India under the Named Patient Import?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold shrink-0">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-sm sm:text-base text-gray-600">
                        A patient, or an authorized family member or caregiver acting on the patient's behalf, may
                        request the import of medicines under the Named Patient Import, provided all regulatory
                        requirements and supporting medical documentation are fulfilled.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)"
                        class="w-full flex justify-between items-start sm:items-center gap-3 text-left">
                        <span class="text-base sm:text-lg text-gray-900">
                            3. How much medicine can I import for personal use?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold shrink-0">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-sm sm:text-base text-gray-600">
                        The quantity permitted for import is generally limited to the amount required for personal
                        treatment, often up to a three-month supply, subject to the prescribing physician's
                        recommendation and the approval of the relevant regulatory authority.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)"
                        class="w-full flex justify-between items-start sm:items-center gap-3 text-left">
                        <span class="text-base sm:text-lg text-gray-900">
                            4. Can imported medicines be sold or shared with others?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold shrink-0">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-sm sm:text-base text-gray-600">
                        No. Medicines imported under the Named Patient Program are intended exclusively for the personal
                        treatment of the named patient. They cannot be sold, transferred, or distributed to any other
                        person.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)"
                        class="w-full flex justify-between items-start sm:items-center gap-3 text-left">
                        <span class="text-base sm:text-lg text-gray-900">
                            5. How can I avoid delays in importing my medicine?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold shrink-0">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-sm sm:text-base text-gray-600">
                        To help ensure a smooth process, submit complete and accurate documentation, including a valid
                        prescription, patient identification, medical records, and any other required documents.
                        Responding promptly to requests for additional information can also help minimize delays.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Get in touch -->
    <!--  -->
    <section class="py-12 sm:py-16 md:py-24 px-4 bg-white">
        <div class="max-w-7xl mx-auto">


            <!-- Content -->
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-start">

                <!-- Left: CONTACT INFO -->
                <div class="px-2 sm:px-6">
                    <span class="text-xs sm:text-sm font-semibold text-gray-500 uppercase">
                        TRUSTED BY HEALTHCARE PROFESSIONALS & HOSPITALS
                    </span>

                    <h3 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2 mb-4 font-playfair">
                        Need Help<br class="hidden sm:block">Accessing Medicines?
                    </h3>

                    <p class="text-gray-600 mb-8 text-sm sm:text-base">
                        Our specialists are here to guide you through every step of the medicine access process.
                    </p>

                    <div class="space-y-6">

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg shrink-0
                                    flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-800 text-2xl"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-black font-bold tracking-wider">Mail Us At:</p>
                                <p class="font-medium text-blue-700 break-all">
                                    info@namedpatientprogram.com
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg shrink-0
                                    flex items-center justify-center">
                                <i class="fas fa-phone text-blue-800 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-black font-bold tracking-wider">Contact Us:</p>
                                <p class="font-medium text-blue-700">
                                    +91 9810469557
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT: FORM -->
                <div id="inquiry-section" class="bg-[#FBFBFB] px-4 sm:px-6 md:px-0 md:pr-8 py-6 md:py-0">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Let's us help!</h3>
                    <p class="text-gray-600 mb-6 text-sm sm:text-base">
                        We get back to you shortly during our working hours.
                    </p>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 sm:px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-xl"></i>
                                <span>
                                    <?= $this->session->flashdata('success'); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 sm:px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <span>
                                   <?= $this->session->flashdata('error'); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form id="inquiryForm" action="<?= base_url('news_details_query'); ?>" method="post"
                        class="space-y-4">
                        <input type="hidden" name="return_url" value="<?= current_url(); ?>">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>
                                <input id="first_name" type="text" name="first_name" placeholder="First Name"
                                    class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                                <small class="text-red-500 text-sm mt-1 hidden" id="firstnameError"></small>
                            </div>
                            <div>
                                <input id="last_name" type="text" name="l_name" placeholder="Last Name"
                                    class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                                <small class="text-red-500 text-sm mt-1 hidden" id="lastnameError"></small>
                            </div>

                        </div>

                        <input id="email" type="email" name="email" placeholder="Email"
                            class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">
                        <small class="text-red-500 text-sm mt-1 hidden" id="emailError"></small>

                        <input id="phone" type="tel" name="phone" placeholder="Phone Number"
                            class="w-full pl-16 sm:pl-20 pr-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none">

                        <small class="text-red-500 text-sm mt-1 hidden" id="phoneError"></small>
                        <textarea id="message" name="message" rows="4" placeholder="Message"
                            class="w-full px-4 py-3 rounded-lg bg-[#1D1D1D0D] border border-gray-300 focus:border-purple-600 focus:outline-none"></textarea>
                        <small class="text-red-500 text-sm mt-1 hidden" id="messageError"></small>

                        <div class="flex justify-center">
                            <button type="submit" class="w-full sm:w-[70%] md:w-[60%] py-3 rounded-lg
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
    <!-- Form Submission Handling JavaScript -->
    <script>
        document.getElementById('contactForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            var submitBtn = document.getElementById('submitBtn');
            var formStatus = document.getElementById('formStatus');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i>Sending...';

            // Get form data
            var formData = new FormData(this);

            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        formStatus.className =
                            'text-center text-sm mt-3 text-green-600 bg-green-50 p-2 rounded';
                        formStatus.innerHTML =
                            '<i class="fa fa-check-circle mr-1"></i> Thank you! We\'ll contact you soon.';
                        this.reset();
                    } else {
                        formStatus.className = 'text-center text-sm mt-3 text-red-600 bg-red-50 p-2 rounded';
                        formStatus.innerHTML =
                            '<i class="fa fa-exclamation-circle mr-1"></i> Something went wrong. Please try again.';
                    }
                    formStatus.classList.remove('hidden');

                    // Hide success message after 5 seconds
                    setTimeout(function () {
                        formStatus.classList.add('hidden');
                    }, 5000);
                })
                .catch(error => {
                    formStatus.className = 'text-center text-sm mt-3 text-red-600 bg-red-50 p-2 rounded';
                    formStatus.innerHTML =
                        '<i class="fa fa-exclamation-circle mr-1"></i> Network error. Please try again.';
                    formStatus.classList.remove('hidden');
                })
                .finally(() => {
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa fa-paper-plane mr-2"></i> Inquire Now';
                });
        });
    </script>

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