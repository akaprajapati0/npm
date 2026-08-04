<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.ico'); ?>">
    <?php
    switch (strtolower(trim($category->name ?? ''))) {

        case 'cardiology':
            $metaTitle = 'Cardiology Medicines via Named Patient Program | NPP India';
            $metaDescription = 'Access innovative cardiology medicines through the Named Patient Program. Helping patients and healthcare providers obtain critical heart therapies.';
            $metaKeywords = 'Named Patient Program Cardiology, Named Patient Program, Cardiology Medicines, Cardiovascular Therapies, Heart Disease Treatment, Unapproved Cardiology Drugs, Access to Cardiology Medicines, Cardiovascular Drug Import India, Global Cardiology Treatments, Specialty Cardiology Drugs, Advanced Heart Therapies';
            break;

        case 'endocrinology':
            $metaTitle = 'Endocrinology Named Patient Program | Global Access Care';
            $metaDescription = 'Access endocrinology treatments worldwide through our Named Patient Program. Supporting patients with diabetes, thyroid, and rare endocrine disorders.';
            $metaKeywords = 'Endocrinology Named Patient Program, Endocrinology Treatments, Endocrine Disorders Treatment, Diabetes Treatment Access, Thyroid Disease Medication Access, Access Endocrinology Treatments Through Named Patient Programs, Global Access To Endocrine Disorder Therapies, Named Patient Program For Diabetes Medications';
            break;

        case 'hematology':
            $metaTitle = 'Hematology Named Patient Program | Global Treatment Access';
            $metaDescription = 'Access innovative hematology treatments through our Named Patient Program. Supporting healthcare providers and patients worldwide.';
            $metaKeywords = 'Hematology Treatments, Named Patient Program, Early Access Program, Unlicensed Medicines, Hematology Therapies, Rare Blood Disorders, Global Patient Access, Specialty Pharmaceuticals, Compassionate Use Program, Blood Cancer Treatment Access';
            break;

        case 'hepatology':
            $metaTitle = 'Hepatology Medicines Access | Named Patient Program India';
            $metaDescription = 'Access innovative hepatology medicines for hepatitis, cirrhosis, fatty liver, and liver disorders through a compliant Named Patient Program.';
            $metaKeywords = 'Hepatology Medicines, Named Patient Program Hepatology, Liver Disease Treatment Access, Hepatitis Medicines India, Unapproved Liver Disease Medicines, Cirrhosis Treatment Medicines, Fatty Liver Disease Treatment, Import Hepatology Medicines, Global Access Liver Therapies, Special Access Hepatology Drugs';
            break;

        case 'immunology':
            $metaTitle = 'Immunology Medicines Access | Named Patient Program India';
            $metaDescription = 'Access innovative immunology medicines through the Named Patient Program in India. Compliant pathways for patients and healthcare providers.';
            $metaKeywords = 'Immunology Medicines India, Named Patient Program Immunology, Immunology Drugs Access India, Unapproved Immunology Medicines, Import Immunology Medicines India, Immunology Treatment Access';
            break;

        case 'miscellaneous':
            $metaTitle = 'Miscellaneous Therapeutics | Named Patient Program Access';
            $metaDescription = 'Access unapproved and hard-to-source therapies through Named Patient Programs. Supporting healthcare providers and patients worldwide.';
            $metaKeywords = 'Miscellaneous Therapeutics, Named Patient Program, Access To Medicines, Unapproved Medicines, Global Patient Access, Special Access Programs';
            break;

        case 'nephrology':
            $metaTitle = 'Nephrology Named Patient Program | Access Kidney Treatments';
            $metaDescription = 'Access innovative nephrology treatments and kidney disease medications through our Named Patient Program for patients needing specialized therapies.';
            $metaKeywords = 'Nephrology Named Patient Program, Nephrology Treatments, Kidney Disease Medications, Access Kidney Treatments, Kidney Therapy Access, Specialized Nephrology Medicines';
            break;

        case 'neurology':
            $metaTitle = 'Neurology Named Patient Program | Access Neurological Treatments';
            $metaDescription = 'Access innovative neurology treatments for MS, epilepsy, Parkinson\'s, and other neurological disorders through our Named Patient Program.';
            $metaKeywords = 'Neurology Named Patient Program, Neurology Treatments, Multiple Sclerosis Treatment, Epilepsy Medications, Parkinson\'s Disease Access, Neurological Disorder Medicines, Global Neurology Therapies';
            break;

        case 'oncology':
            $metaTitle = 'Oncology Named Patient Program | Global Cancer Treatment';
            $metaDescription = 'Access innovative oncology treatments through our Named Patient Program. Supporting healthcare providers and patients with global cancer therapy access.';
            $metaKeywords = 'Access To Oncology Medicines, Cancer Treatment Access Program, Named Patient Access, Oncology Therapeutics, Unapproved Cancer Treatments, Oncology Medicines, Global Cancer Therapy Access';
            break;

        case 'pulmonology':
            $metaTitle = 'Pulmonology Treatments Access | Named Patient Program';
            $metaDescription = 'Access innovative pulmonology treatments and respiratory medicines through our Named Patient Program for patients seeking global therapy options.';
            $metaKeywords = 'Pulmonology Treatments, Named Patient Program, Pulmonary Disease Treatment, Access To Pulmonology Medicines, Global Pulmonology Therapies, Rare Lung Disease Treatment, Import Pulmonology Medicines, Respiratory Disease Medications';
            break;

        case 'rare disease':
            $metaTitle = 'Rare Disease Treatment Access | Named Patient Program';
            $metaDescription = 'Access innovative rare disease treatments through our Named Patient Program. Helping patients obtain unapproved or hard-to-access therapies worldwide.';
            $metaKeywords = 'Rare Disease Treatment Access, Named Patient Program, Rare Disease Therapies, Orphan Drugs, Rare Disease Treatment, Early Access Program, Compassionate Use Program, Access To Rare Disease Medicines, Unapproved Medicines For Rare Diseases, Global Patient Access, Rare Disease Drug Access';
            break;

        default:
            $metaTitle = ($category->name ?? 'Therapeutic Area') . ' | Named Patient Program';
            $metaDescription = 'Access innovative medicines through our Named Patient Program.';
            $metaKeywords = 'Named Patient Program, Access To Medicines';
    }
    ?>
    <title>
        <?= htmlspecialchars($metaTitle) ?>
    </title>

    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">

    <meta name="keywords" content="<?= htmlspecialchars($metaKeywords) ?>">

    <link rel="canonical" href="<?= current_url() ?>">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="author" content="Ikris Pharma Network">
    <meta name="language" content="English">
    <meta name="geo.region" content="IN-UP">
    <meta name="geo.placename" content="Noida, Uttar Pradesh, India">

    <!-- ===== OPEN GRAPH (Facebook, LinkedIn, WhatsApp) ===== -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Named Patient Program – Ikris Pharma Network">
    <meta property="og:title" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:image" content="https://namedpatientprogram.com/assets/images/home/hero_img.jpg">
    <meta property="og:image:alt" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="en_IN">


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
    // $data['title'] = "Indian Import <br>Regulations";
    $data['title'] = $category->name ?? 'Category';
    // echo htmlspecialchars($category->name ?? 'Category');
    $data['backgroundImage'] = "assets/images/medicines/category_page.png";

    $this->load->view('components/banner', $data);
    ?>


    <section style="background:#fff;">
        <div class="page-wrap">

            <!-- Mobile category pills -->
            <div class="sidebar-mobile scrollbar-hide"
                style="display:flex; gap:8px; overflow-x:auto; padding-bottom:14px; margin-bottom:20px;">
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= base_url('therapeutic-area/' . $cat->slug) ?>"
                        style="flex-shrink:0; white-space:nowrap; padding:7px 18px; border-radius:999px; background:#fff; border:1px solid #ddd; font-size:13px; font-weight:500; text-decoration:none; color:#333; <?= (isset($category->id) && $cat->id == $category->id) ? 'border-color:#1a56db;color:#1a56db;' : '' ?>">
                        <?= htmlspecialchars($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="page-grid">

                <!-- Desktop sidebar -->
                <aside class="sidebar-desktop" style="position:sticky; top:24px;">
                    <?php foreach ($categories as $cat): ?>
                        <?php $active = isset($category->id) && $cat->id == $category->id; ?>
                        <a href="<?= base_url('therapeutic-area/' . $cat->slug) ?>"
                            class="cat-item <?= $active ? 'active' : '' ?>">
                            <span>
                                <?= htmlspecialchars($cat->name) ?>
                            </span>
                            <!-- <span class="chk">&#10003;</span> -->
                            <i class="fa-solid fa-chevron-down" style="color:#bbb; font-size:11px;"></i>
                        </a>
                    <?php endforeach; ?>
                </aside>

                <!-- Main content -->
                <div>
                    <!-- Heading -->
                    <div style="margin-bottom:28px;">
                        <h1 class="font-playfair"
                            style="font-size:clamp(22px,3vw,32px); font-weight:700; color:#111; margin-bottom:12px; line-height:1.3; ">
                            <?= htmlspecialchars(mb_strtoupper($category->name ?? '')) ?> TREATMENTS FROM <br>
                            AROUND THE WORLD
                        </h1>
                        <p class="font-inter" style="font-size:14px; color:#666; line-height:1.85; max-width:700px;">
                            <?= htmlspecialchars($category->name ?? '') ?> is the field of medicine that focuses on the
                            diagnosis and treatment of diseases
                            related to the heart and blood vessels. Cardiovascular diseases include conditions such as
                            heart
                            failure, arrhythmias, coronary artery disease, and other heart-related disorders.
                            <br><br>
                            Modern
                            <?= htmlspecialchars($category->name ?? '') ?> treatments include innovative
                            medicines
                            and therapies that help manage
                            symptoms, improve heart function, and reduce the risk of complications. With a valid
                            prescription from your doctor, we may be able to source and supply the medicine through
                            responsible access pathways.
                        </p>
                    </div>

                    <!-- Medicine grid -->
                    <div id="medicineGrid" class="med-grid">
                        <?php foreach ($medicines as $medicine): ?>
                            <a href="<?= site_url('m/' . $medicine->category_name . '/' . $medicine->name) ?>"
                                class="med-card" data-category="<?= $medicine->category_id ?>">

                                <div class="img-wrap">

                                    <img src="<?= base_url('assets/images/medicines/' . $medicine->image) ?>"
                                        alt="<?= htmlspecialchars($medicine->name) ?>"
                                        onerror="this.onerror=null;this.src='<?= base_url('assets/images/medicines/default.png') ?>';"
                                        class="w-full h-full object-cover">
                                </div>
                                <span class="med-name">
                                    <?= htmlspecialchars($medicine->name) ?>
                                </span>
                            </a>

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div style="margin-top:30px; ">
        <?= $pagination ?>
    </div>


    <!-- FAQ -->
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

                <?php
                // Define category-specific FAQs
                $categoryName = strtolower(trim($category->name ?? ''));

                $faqData = [
                    'cardiology' => [
                        ['question' => 'What conditions are treated under cardiology?', 'answer' => 'Cardiology focuses on the diagnosis, treatment, and management of diseases affecting the heart and blood vessels. Common cardiovascular conditions include heart failure, coronary artery disease, hypertension, arrhythmias, pulmonary arterial hypertension (PAH), cardiomyopathy, congenital heart disease, and other heart-related disorders. Treatment options may include medications, minimally invasive procedures, implantable devices, or surgery, depending on the patient\'s diagnosis and clinical needs.'],
                        ['question' => 'Can I access cardiology medicines that are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may access cardiology medicines that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are cardiology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable cardiology medicine?', 'answer' => 'If your prescribed cardiology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted cardiology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to cardiology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and stockists to help import cardiology medicines in India for eligible patients.']
                    ],
                    'endocrinology' => [
                        ['question' => 'What conditions are treated under endocrinology?', 'answer' => 'Endocrinology focuses on the diagnosis, treatment, and management of disorders affecting the endocrine system and hormone-producing glands. Common conditions include diabetes, thyroid disorders, adrenal gland disorders, growth hormone deficiencies, osteoporosis, pituitary disorders, and other hormonal imbalances. Treatment may involve medications, hormone replacement therapy, lifestyle modifications, or other specialized therapies based on the patient\'s condition.'],
                        ['question' => 'Can I access endocrinology medicines that are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients can access endocrinology medicines that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are endocrinology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable endocrinology medicine?', 'answer' => 'If your prescribed endocrinology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted endocrinology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to endocrinology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and stockists to help source and supply endocrinology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'hematology' => [
                        ['question' => 'What conditions are treated under hematology?', 'answer' => 'Hematology focuses on the diagnosis, treatment, and management of disorders affecting the blood, bone marrow, and lymphatic system. Common hematological conditions include anemia, hemophilia, leukemia, lymphoma, multiple myeloma, sickle cell disease, thalassemia, myelodysplastic syndromes (MDS), and other bleeding or clotting disorders. Treatment may involve medications, blood transfusions, targeted therapies, immunotherapy, stem cell transplantation, or other specialized treatments based on the patient\'s condition.'],
                        ['question' => 'Can I access hematology medicines that are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may access hematology medicines that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are hematology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable hematology medicine?', 'answer' => 'If your prescribed hematology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted hematology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to hematology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply hematology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'hepatology' => [
                        ['question' => 'What conditions are treated under hepatology?', 'answer' => 'Hepatology focuses on the diagnosis, treatment, and management of diseases affecting the liver, gallbladder, bile ducts, and pancreas. Common conditions include hepatitis B, hepatitis C, liver cirrhosis, non-alcoholic fatty liver disease (NAFLD), primary biliary cholangitis (PBC), primary sclerosing cholangitis (PSC), autoimmune hepatitis, and liver cancer. Treatment may involve medications, antiviral therapies, lifestyle modifications, or liver transplantation depending on the patient\'s condition.'],
                        ['question' => 'Can I access hepatology medicines for liver diseases if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may access hepatology medicines for conditions such as hepatitis, liver cirrhosis, PBC, PSC, and other liver disorders that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are hepatology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable hepatology medicine?', 'answer' => 'If your prescribed hepatology medicine for liver disease is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted hepatology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to hepatology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply hepatology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'immunology' => [
                        ['question' => 'What conditions are treated under immunology?', 'answer' => 'Immunology focuses on the diagnosis, treatment, and management of disorders affecting the immune system. Common conditions include primary immunodeficiency disorders, autoimmune diseases, hereditary angioedema (HAE), chronic inflammatory diseases, vasculitis, and other immune-mediated disorders. Treatment may involve immunoglobulins, biologics, immunosuppressants, enzyme replacement therapies, or targeted therapies depending on the patient\'s condition.'],
                        ['question' => 'Can I access immunology medicines for immune disorders if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may import immunology medicines for autoimmune diseases, hereditary angioedema, primary immunodeficiency disorders, and other immune-related conditions that are not yet approved, commercially available, or currently in shortage in their country.'],
                        ['question' => 'Are immunology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable immunology medicine?', 'answer' => 'If your prescribed immunology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted immunology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to immunology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply immunology medicines for eligible patients in India.']
                    ],
                    'miscellaneous' => [
                        ['question' => 'What conditions are covered under the miscellaneous specialty?', 'answer' => 'The miscellaneous category includes specialized medicines for conditions that do not fall under a single therapeutic area. These may include infectious diseases, metabolic disorders, dermatological conditions, genetic disorders, and other complex or uncommon medical conditions requiring specialized treatment.'],
                        ['question' => 'Can I access specialty medicines that are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients can access specialty medicines that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are specialty medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable specialty medicine?', 'answer' => 'If your prescribed specialty medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted specialty medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to specialty medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply specialty medicines for eligible patients in India as per applicable regulatory requirements.']
                    ],
                    'nephrology' => [
                        ['question' => 'What conditions are treated under nephrology?', 'answer' => 'Nephrology focuses on the diagnosis, treatment, and management of kidney-related diseases. Common conditions include chronic kidney disease (CKD), acute kidney injury (AKI), nephrotic syndrome, IgA nephropathy, focal segmental glomerulosclerosis (FSGS), lupus nephritis, polycystic kidney disease (PKD), and kidney failure. Treatment may involve medications, dialysis, or kidney transplantation depending on the patient\'s condition.'],
                        ['question' => 'Can I access nephrology medicines for kidney diseases if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may access nephrology medicines for chronic kidney disease, IgA nephropathy, FSGS, lupus nephritis, and other kidney disorders that are not yet approved, commercially available, or currently in shortage in their country.'],
                        ['question' => 'Are nephrology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable nephrology medicine?', 'answer' => 'If your prescribed nephrology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted nephrology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to nephrology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply nephrology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'neurology' => [
                        ['question' => 'What conditions are treated under neurology?', 'answer' => 'Neurology focuses on the diagnosis, treatment, and management of disorders affecting the brain, spinal cord, and nervous system. Common neurological conditions include multiple sclerosis (MS), epilepsy, Parkinson\'s disease, Alzheimer\'s disease, amyotrophic lateral sclerosis (ALS), spinal muscular atrophy (SMA), Duchenne muscular dystrophy (DMD), and migraine disorders. Treatment may involve medications, biologics, gene therapies, rehabilitation, or supportive care depending on the patient\'s condition.'],
                        ['question' => 'Can I access neurology medicines for neurological disorders if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may gain access to neurology medicines for multiple sclerosis, SMA, DMD, ALS, epilepsy, and other neurological disorders that are not yet approved, commercially available, or currently in shortage in their country.'],
                        ['question' => 'Are neurology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable neurology medicine?', 'answer' => 'If your prescribed neurology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted neurology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to neurology medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply neurology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'oncology' => [
                        ['question' => 'What conditions are treated under oncology?', 'answer' => 'Oncology focuses on the diagnosis, treatment, and management of cancers affecting different parts of the body. Common cancers include breast cancer, lung cancer, colorectal cancer, prostate cancer, ovarian cancer, leukemia, lymphoma, multiple myeloma, melanoma, and other solid tumors and hematological malignancies. Treatment may involve chemotherapy, targeted therapy, immunotherapy, hormone therapy, radiation therapy, or precision medicine based on the patient\'s diagnosis.'],
                        ['question' => 'Can I access oncology medicines for cancer treatment if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Import, eligible patients may gain access to oncology medicines for breast cancer, lung cancer, leukemia, lymphoma, rare cancers, and other malignancies that are not yet approved, commercially available, or currently in shortage in their country.'],
                        ['question' => 'Are oncology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable oncology medicine?', 'answer' => 'If your prescribed oncology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted oncology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to oncology medicines through the Named Patient Supply. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply oncology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'pulmonology' => [
                        ['question' => 'What conditions are treated under pulmonology?', 'answer' => 'Pulmonology focuses on the diagnosis, treatment, and management of diseases affecting the lungs and respiratory system. Common conditions include pulmonary arterial hypertension (PAH), idiopathic pulmonary fibrosis (IPF), chronic obstructive pulmonary disease (COPD), severe asthma, cystic fibrosis, interstitial lung disease (ILD), and other chronic respiratory disorders. Treatment may involve medications, biologics, oxygen therapy, pulmonary rehabilitation, or lung transplantation depending on the patient\'s condition.'],
                        ['question' => 'Can I access pulmonology medicines for lung diseases if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Supply, eligible patients may gain access to pulmonology medicines for pulmonary arterial hypertension, idiopathic pulmonary fibrosis, cystic fibrosis, severe asthma, and other respiratory disorders that are not yet approved, commercially available, or currently in shortage in their country.'],
                        ['question' => 'Are pulmonology medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable pulmonology medicine?', 'answer' => 'If your prescribed pulmonology medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted pulmonology medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to pulmonology medicines through the Named Patient Supply. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply pulmonology medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ],
                    'rare disease' => [
                        ['question' => 'What conditions are treated under rare disease?', 'answer' => 'Rare disease treatment focuses on the diagnosis and management of uncommon and often life-threatening or life-limiting conditions that affect a small percentage of the population. These include spinal muscular atrophy (SMA), Duchenne muscular dystrophy (DMD), Fabry disease, Gaucher disease, Wilson disease, Pompe disease, hereditary angioedema (HAE), cystinosis, and many other rare genetic and metabolic disorders. Treatment may involve orphan drugs, enzyme replacement therapy, gene therapy, or other specialized medicines.'],
                        ['question' => 'Can I access rare disease medicines if they are unavailable in my country?', 'answer' => 'Yes. Through the Named Patient Program, eligible patients may access orphan drugs and rare disease medicines that are not yet approved, commercially available, or currently in shortage in their country. Access is arranged upon a physician\'s request and is subject to the regulatory requirements of the importing country.'],
                        ['question' => 'Are rare disease medicines supplied through the Named Patient Program authentic and safe?', 'answer' => 'Yes. Medicines supplied through our global access network are sourced from authorized manufacturers and licensed stockists. Every shipment follows strict quality assurance procedures, temperature-controlled logistics where required, and applicable regulatory standards to help maintain product integrity throughout the supply process.'],
                        ['question' => 'How can I request an unavailable rare disease medicine?', 'answer' => 'If your prescribed orphan drug or rare disease medicine is unavailable locally, you or your treating physician can contact our team with the required medical documents. We assist healthcare professionals throughout the Named Patient Program process, including medicine sourcing, regulatory documentation, international shipping, and delivery, in accordance with local regulations.'],
                        ['question' => 'Who is a trusted rare disease medicine supplier in India?', 'answer' => 'NamedPatientProgram.com (NPP) supports patients, healthcare providers, and hospitals by facilitating access to orphan drugs and rare disease medicines through the Named Patient Import. We work with authorized pharmaceutical manufacturers and licensed stockists to help source and supply rare disease medicines for eligible patients in accordance with applicable regulatory requirements.']
                    ]
                ];

                // Default FAQs if category not found
                $defaultFaqs = [
                    ['question' => 'Why is a prescription required to import medicines in India?', 'answer' => 'To import medicines not available in India, a valid doctor\'s prescription is required as per regulatory guidelines. The prescription helps verify patient eligibility, ensure safety, and comply with legal import requirements. All submitted prescriptions are kept strictly confidential and used only for verification and approval purposes.'],
                    ['question' => 'What information should be included in the prescription?', 'answer' => 'The prescription should include complete patient details, clear mention of the prescribed medicine with dose and duration, and the stamp and full details of the prescribing doctor.'],
                    ['question' => 'What happens if my prescription is incomplete?', 'answer' => 'If any required information is missing or unclear, our compliance team will review the prescription and may contact you or your treating physician for clarification.'],
                    ['question' => 'Can I request a medicine without a prescription if I have my medical reports?', 'answer' => 'No. Medical reports alone are not sufficient. A valid prescription from your treating physician is required to initiate the medicine request.'],
                    ['question' => 'Can someone else submit the prescription on behalf of the patient?', 'answer' => 'Yes. A family member, caregiver, or authorized representative may submit the prescription and supporting documents on behalf of the patient, provided they have the patient\'s consent where required.']
                ];

                // Select FAQs based on category, fallback to default
                $faqs = $faqData[$categoryName] ?? $defaultFaqs;

                $faqCounter = 1;
                foreach ($faqs as $faq):
                    ?>
                    <!-- ITEM -->
                    <div class="border-b border-gray-300 pb-4">
                        <button onclick="toggleFaq(<?= $faqCounter ?>)"
                            class="w-full flex justify-between items-center text-left">
                            <span class="text-lg text-gray-900">
                                <?= htmlspecialchars($faq['question']) ?>
                            </span>
                            <span id="icon-<?= $faqCounter ?>" class="text-2xl font-bold">+</span>
                        </button>
                        <div id="faq-<?= $faqCounter ?>" class="hidden pt-4 text-gray-600">
                            <?= htmlspecialchars($faq['answer']) ?>
                        </div>
                    </div>
                    <?php
                    $faqCounter++;
                endforeach;
                ?>

            </div>
        </div>
    </section>

    <style>
        @media (max-width: 768px) {
            .max-w-7xl.mx-auto.grid.md\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <script>
        // function toggleFaq(id) {
        //     const content = document.getElementById(`faq-${id}`);
        //     const icon = document.getElementById(`icon-${id}`);
        //     content.classList.toggle('hidden');
        //     icon.textContent = content.classList.contains('hidden') ? '+' : '−';
        // }

        // Also keep the existing FAQ toggle for other sections if needed
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.faq-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var ans = this.nextElementSibling;
                    var icon = this.querySelector('.fa');
                    var open = ans.style.display === 'block';
                    document.querySelectorAll('.faq-ans').forEach(a => a.style.display = 'none');
                    document.querySelectorAll('.faq-btn .fa').forEach(i => {
                        i.classList.remove('fa-minus');
                        i.classList.add('fa-plus');
                    });
                    if (!open) {
                        ans.style.display = 'block';
                        icon.classList.replace('fa-plus', 'fa-minus');
                    }
                });
            });
        });
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>

</body>

</html>