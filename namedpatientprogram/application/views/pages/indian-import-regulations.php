<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Import Regulations</title>


    <?php $this->load->view('layouts/includes/head-links'); ?>
</head>

<body class="bg-white text-gray-800">
    <?php $this->load->view('layouts/includes/header'); ?>

    <?php
    $data['title'] = "Indian Import <br>Regulations";
    $data['backgroundImage'] = "assets/images/indian_import_regulations/cover.jpg";

    $this->load->view('components/banner', $data);
    ?>

    <!-- ===== S1: Importing Medicines ===== -->

    <?php
    $title = "Importing<span class='text-[#2563EB]'> Medicines in to India</span><br>Through the Named Patient<br>Program";
    $description = "Access to certain medicines may require patient-specific import arrangements when not available through conventional channels in India. The Named Patient Program supports lawful import based on valid physician prescriptions, medical need, and regulatory requirements. Each request is handled with compliance, quality assurance, traceability, and patient safety for the identified patient only.";
    $image_src = base_url('assets/images/indian_import_regulations/img1.jpg');
    $image_alt = "Pharmacist handling temperature-controlled medicines";
    $layout = 'text-left';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <!-- ===== S2: Regulatory Framework ===== -->
    <?php
    $title = "<span class='text-[#2563EB]'>Regulatory</span> Framework";
    $description = "Medicine import into India is regulated under the Drugs and Cosmetics Act, 1940, Drugs and Cosmetics Rules, 1945, and CDSCO guidelines. Patient-specific access programs operate within this framework, requiring medical documentation and regulatory review. The Named Patient Program ensures compliant medicine access with strong focus on quality, safety, and compliance.";
    $image_src = base_url('assets/images/indian_import_regulations/img2.jpg');
    $image_alt = "Regulatory compliance team at work";
    $layout = 'text-right';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <!-- ===== S3: Required Documents ===== -->
    <section class="py-20 bg-[#F8FAFC]">
        <div class="max-w-7xl mx-auto px-4 md:px-10">

            <!-- Heading -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-normal mb-4 font-playfair">
                    Required Documents for <span class="text-[#2563EB]">Treatment Access</span>
                </h2>

                <p class="text-gray-600 max-w-3xl mx-auto font-inter">
                    Providing complete and accurate documentation helps facilitate regulatory review and<br>
                    patient-specific access requests.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                <div class="bg-[#2563EB] p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00] ">01</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Prescription from the treating physician for the requested treatment.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">02</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Relevant diagnosis details, treatment history, and supporting clinical information.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">03</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Additional documents may be required based on the medicine and patient circumstances.
                    </p>
                </div>

                <div class="bg-[#2563EB]  p-10 px-16 rounded-2xl min-h-[250px] ">
                    <span class="text-4xl font-bold text-[#FFFF00]">04</span>

                    <p class="mt-6 text-lg font-medium text-white font-inter">
                        Complete and accurate information supports regulatory review and import requirements.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- ===== S4: Regulatory Approvals ===== -->

    <?php
    $title = "Regulatory <span class='text-[#2563EB]'>Approvals</span>";
    $description = "Certain patient-specific medicine access requests may require regulatory review, authorization, or supporting documentation based on product, indication, and intended use. Requirements may vary by case. Our team collaborates with healthcare professionals, manufacturers, and regulatory stakeholders to support documentation and help facilitate a compliant and efficient medicine access process.";
    $image_src = base_url('assets/images/indian_import_regulations/img3.jpg');
    $image_alt = "Pharmacist handling temperature-controlled medicines";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <!-- ===== S2: Regulatory Framework ===== -->
    <?php
    $title = "Scope of <span class='text-[#2563EB]'>Import</span>";
    $description = "Medicines supplied under the Named Patient Program are intended solely for an identified patient based on a physician’s prescription and documented medical need. Quantities align with prescribed dosage, treatment duration, and clinical requirements. Each request is assessed individually to ensure compliance with applicable regulatory requirements and appropriate patient-specific medicine access.";
    $image_src = base_url('assets/images/indian_import_regulations/img4.jpg');
    $image_alt = "Regulatory compliance team at work";
    $layout = 'text-right';
    $bg = 'bg-[#f0f2f8]';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>
    <!-- ===== S1: Importing Medicines ===== -->

    <?php
    $title = "Permitted Use & <span class='text-[#2563EB]'>Restrictions</span>";
    $description = "Medicines supplied under the Named Patient Program are intended exclusively for the personal treatment of the patient identified in the prescription and supporting documents. They are not for resale, commercial distribution, institutional stockholding, or general market supply. This patient-specific approach ensures traceability, regulatory compliance, accountability, and patient safety throughout the supply process.";
    $image_src = base_url('assets/images/indian_import_regulations/img5.jpg');
    $image_alt = "Pharmacist handling temperature-controlled medicines";
    $layout = 'text-left';
    $bg = 'bg-white';
    include APPPATH . 'views/components/left-section.php';
    unset($title, $description, $image_src, $image_alt, $layout, $bg);
    ?>

    <!-- ===== S2: Regulatory Framework ===== -->
    <?php
    $title = "<span class='text-[#2563EB]'>Quality</span>, Traceability\n& Patient Safety";
    $description = "Patient safety is central to every stage of the access process. Medicines under the Named Patient Program are sourced through authorized pharmaceutical channels and managed under strict quality standards. Verification, traceability, and quality assurance are applied across sourcing, storage, transport, and delivery to ensure product authenticity, supply chain integrity, and compliant, safe medicine access.";
    $image_src = base_url('assets/images/indian_import_regulations/img6.jpg');
    $image_alt = "Regulatory compliance team at work";
    $layout = 'text-right';
    $bg = 'bg-[#f0f2f8]';
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
                            Is it legal to import medicines into India for personal use?
                        </span>
                        <span id="icon-1" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-1" class="hidden pt-4 text-gray-600">
                        Yes. Under the Drugs and Cosmetics Act, 1940, and the Drugs and Cosmetics Rules, 1945,
                        individuals may import certain medicines for personal use, subject to applicable regulatory
                        requirements. A valid prescription and the necessary approvals from the competent authorities
                        are generally required before import.
                    </div>
                </div>

                <!-- ITEM 2 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(2)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Who can import medicines into India under the Named Patient Import?
                        </span>
                        <span id="icon-2" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-2" class="hidden pt-4 text-gray-600">
                        A patient, or an authorized family member or caregiver acting on the patient's behalf, may
                        request the import of medicines under the Named Patient Import, provided all regulatory
                        requirements and supporting medical documentation are fulfilled.
                    </div>
                </div>

                <!-- ITEM 3 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(3)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How much medicine can I import for personal use?
                        </span>
                        <span id="icon-3" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-3" class="hidden pt-4 text-gray-600">
                        The quantity permitted for import is generally limited to the amount required for personal
                        treatment, often up to a three-month supply, subject to the prescribing physician's
                        recommendation and the approval of the relevant regulatory authority.
                    </div>
                </div>

                <!-- ITEM 4 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(4)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            Can imported medicines be sold or shared with others?
                        </span>
                        <span id="icon-4" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-4" class="hidden pt-4 text-gray-600">
                        No. Medicines imported under the Named Patient Program are intended exclusively for the personal
                        treatment of the named patient. They cannot be sold, transferred, or distributed to any other
                        person.
                    </div>
                </div>

                <!-- ITEM 5 -->
                <div class="border-b border-gray-300 pb-4">
                    <button onclick="toggleFaq(5)" class="w-full flex justify-between items-center text-left">
                        <span class="text-lg text-gray-900">
                            How can I avoid delays in importing my medicine?
                        </span>
                        <span id="icon-5" class="text-2xl font-bold">+</span>
                    </button>
                    <div id="faq-5" class="hidden pt-4 text-gray-600">
                        To help ensure a smooth process, submit complete and accurate documentation, including a valid
                        prescription, patient identification, medical records, and any other required documents.
                        Responding promptly to requests for additional information can also help minimize delays.
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- <script>
        function toggleFaq(id) {
            const content = document.getElementById(`faq-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            content.classList.toggle('hidden');
            icon.textContent = content.classList.contains('hidden') ? '+' : '−';
        }
    </script> -->

    <?php $this->load->view('layouts/includes/footer'); ?>
</body>

</html>