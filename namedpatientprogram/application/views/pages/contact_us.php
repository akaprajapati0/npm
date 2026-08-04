<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact Named Patient Program | Patient Access Support</title>
    <meta name="description"
        content="Contact our Named Patient Program team for assistance with accessing unapproved medicines, rare disease treatments, and global patient support.">
    <meta name="keywords"
        content="Named Patient Program Support, Patient Access Services, Unapproved Medicine Access, Rare Disease Treatment Access, Global Patient Assistance, Contact Patient Access Experts, Compassionate Use Program Support">
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


    <div class="min-h-screen bg-white py-12 px-4">
        <div class="max-w-7xl mx-auto">

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Contact Us
                </h1>
                <p class="text-base md:text-lg text-gray-600 max-w-3xl mx-auto">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <!-- Flash Messages -->
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

            <div class="grid lg:grid-cols-2 gap-8">

                <!-- Contact Information -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-md p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>

                        <div class="space-y-6">
                            <!-- Phone -->
                            <div class="contact-card bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-phone text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2">Phone</h3>
                                        <a href="tel:<?= $settings->contact ?? '18001200365'; ?>"
                                            class="text-blue-600 hover:text-blue-800">
                                            <?= $settings->contact ?? '18001200365'; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="contact-card bg-gradient-to-br from-purple-50 to-white p-6 rounded-xl">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2">Email</h3>
                                        <a href="mailto:<?= $settings->system_email ?? 'info@example.com'; ?>"
                                            class="text-purple-600 hover:text-purple-800 break-all">
                                            <?= $settings->system_email ?? 'info@example.com'; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="contact-card bg-gradient-to-br from-green-50 to-white p-6 rounded-xl">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 mb-2">Address</h3>
                                        <p class="text-gray-700">
                                            <?= nl2br(htmlspecialchars($settings->address ?? 'Address not available')); ?>
                                        </p>
                                        <?php if (!empty($settings->address2)): ?>
                                            <p class="text-gray-700 mt-2">
                                                <?= nl2br(htmlspecialchars($settings->address2)); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <!-- <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Business Hours</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Monday - Friday</span>
                                <span class="text-gray-900">9:00 AM - 6:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Saturday</span>
                                <span class="text-gray-900">10:00 AM - 4:00 PM</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-700">Sunday</span>
                                <span class="text-gray-900">Closed</span>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>

                    <form action="<?= base_url('contact-us/submit'); ?>" method="post" class="space-y-6" novalidate
                        id="contactForm">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                                placeholder="Name" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '')">
                            <p class="text-red-500 text-sm mt-1 hidden" id="nameError"></p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                                placeholder="Email" oninput="this.value = this.value.replace(/[^a-zA-Z0-9@._+-]/g, '')">
                            <p class="text-red-500 text-sm mt-1 hidden" id="emailError"></p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>

                            <!-- <input type="tel" id="phone" name="phone"
                                class="form-input w-full py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                                placeholder="Enter your number"> -->
                            <input type="hidden" name="full_phone" id="full_phone">
                            <input type="tel" id="phone" name="phone" maxlength="16" inputmode="tel"
                                class="form-input w-full py-3 border border-gray-300 rounded-lg focus:outline-none transition"
                                placeholder="Phone Number" oninput="this.value=this.value.replace(/\D/g,'')">
                            <p class="text-red-500 text-sm mt-1 hidden" id="phoneError"></p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="message" name="message" rows="5" maxlength="500"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none transition resize-none"
                                placeholder="Message"></textarea>
                            <p class="text-red-500 text-sm mt-1 hidden" id="messageError"></p>
                            <small class="text-gray-500 text-xs">Maximum 500 characters</small>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full px-6 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-lg transition shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

            </div>

            <!-- Map Section (Optional) -->
            <!-- <div class="mt-12 bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="h-96 bg-gray-200 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-6xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">Map integration can be added here</p>
                </div>
            </div>
        </div> -->

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>


    <script>
        const input = document.querySelector("#phone");

        const iti = window.intlTelInput(input, {
            initialCountry: "in",
            separateDialCode: true,
            preferredCountries: ["in", "us", "gb", "ae"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        document.getElementById("contactForm").addEventListener("submit", function () {
            document.getElementById("full_phone").value = iti.getNumber();
        });
    </script>




    <script>
        document.getElementById("contactForm").addEventListener("submit", function (e) {

            let isValid = true;

            // regex
            const nameRegex = /^[A-Za-z\s]{2,40}$/;
            const phoneRegex = /^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // inputs
            const name = document.getElementById("name");
            const email = document.getElementById("email");
            const phone = document.getElementById("phone");
            const message = document.getElementById("message");

            // error elements
            const nameError = document.getElementById("nameError");
            const emailError = document.getElementById("emailError");
            const phoneError = document.getElementById("phoneError");
            const messageError = document.getElementById("messageError");

            // reset
            document.querySelectorAll(".text-red-500").forEach(el => el.classList.add("hidden"));
            document.querySelectorAll(".form-input").forEach(el => el.classList.remove("border-red-500"));

            var iti = window.intlTelInputGlobals.getInstance(document.querySelector("#phone"));
            document.querySelector("#phone").value = iti.getNumber();

            // name
            if (name.value.trim() === "") {
                showError(name, nameError, "Name is required");
                isValid = false;
            } else if (!nameRegex.test(name.value.trim())) {
                showError(name, nameError, "Only letters allowed (2-40 characters)");
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

    <?php $this->load->view('layouts/includes/footer'); ?>

</body>

</html>