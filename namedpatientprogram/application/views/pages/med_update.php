<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication Catalog - iKris Pharma Network</title>
    <meta name="keywords" content="pharmaceutical solutions">
    <meta name="description" content="Discover the latest breakthroughs in our pharmaceutical offerings">
    <link rel="canonical" href="<?= base_url(); ?>med_update">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon.ico">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Category slider custom styles */
        .category-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .category-slider::-webkit-scrollbar {
            display: none;
        }

        .category-slider .nav-item {
            flex: 0 0 auto;
        }

        /* Card hover effects */
        .medicine-card {
            transition: all 0.35s ease;
        }

        .medicine-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .medicine-card img {
            transition: all 0.35s ease;
        }

        .medicine-card:hover img {
            transform: scale(1.05);
        }

        /* Pagination Styles */
        .pagination-wrapper ul {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
        }

        .pagination-wrapper li {
            display: inline-block;
        }

        .pagination-wrapper li.page-item-active {
            font-weight: 700;
            display: inline-block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            background-color: #3b82f6;
            color: #ffffff;
            border: 1px solid #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .pagination-wrapper a,
        .pagination-wrapper strong {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .pagination-wrapper a {
            background-color: #ffffff;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .pagination-wrapper a:hover {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .pagination-wrapper strong {
            background-color: #3b82f6;
            color: #ffffff;
            border: 1px solid #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* First/Last page arrows */
        .pagination-wrapper li:first-child a,
        .pagination-wrapper li:last-child a {
            font-weight: 700;
        }
    </style>
</head>

<body class="bg-gray-50">
    <?php $this->load->view('layouts/includes/header'); ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-50 to-white py-12  px-4 ">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Medication Catalog
            </h1>
            <p class="text-base md:text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Discover the latest breakthroughs in our pharmaceutical offerings—from new formulations to global
                availability updates—keeping healthcare professionals and patients informed every step of the way.
            </p>
        </div>
    </section>

    <!-- Category Filter Section -->
    <section class="bg-white py-6 px-4 shadow-sm sticky top-16 lg:top-20 z-40">
        <div class="max-w-7xl mx-auto">
            <div class="relative flex items-center">

                <!-- Left Arrow -->
                <button onclick="slidePrev()" id="catLeft"
                    class="absolute left-0 z-10 w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg flex items-center justify-center">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Category Pills -->
                <div class="overflow-hidden mx-12 md:mx-14">
                    <ul class="category-slider flex gap-3" id="catSlider">
                        <li class="nav-item">
                            <a class="block px-4 py-2 rounded-full font-semibold text-sm whitespace-nowrap transition <?= ($selected_category == 'all') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>"
                                href="<?= base_url('med_update') ?>">
                                All
                            </a>
                        </li>

                        <?php foreach ($categories as $cat): ?>
                            <li class="nav-item">
                                <a class="block px-4 py-2 rounded-full font-semibold text-sm whitespace-nowrap transition <?= ($selected_category == $cat->name) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>"
                                    href="<?= base_url('med_update/category/' . strtolower(str_replace(' ', '-', $cat->name))) ?>">
                                    <?= ucfirst($cat->name) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Right Arrow -->
                <button onclick="slideNext()" id="catRight"
                    class="absolute right-0 z-10 w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg flex items-center justify-center">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Medicines Grid Section -->
    <section class="py-12 md:py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <?php if (!empty($medicines)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($medicines as $article): ?>
                        <div class="medicine-card bg-white rounded-2xl shadow-md overflow-hidden">
                            <a href="<?= base_url('m/' . $article->category_name . '/' . $article->name) ?>" class="block">

                                <!-- Image -->
                                <div class="h-56 bg-gray-100 overflow-hidden flex items-center justify-center">
                                    <img src="<?= base_url('assets/images/medicines/' . $article->image); ?>"
                                        alt="<?= $article->name ?>"
                                        onerror="this.onerror=null;this.src='<?= base_url('assets/images/medicines/default.jpg') ?>';"
                                        class="w-full h-full object-cover">
                                </div>

                                <!-- Content -->
                                <div class="p-5 text-center">
                                    <!-- Category Badge -->
                                    <span
                                        class="inline-block px-3 py-1 bg-purple-600 text-white rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                                        <?= strtoupper($article->category_name) ?>
                                    </span>

                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem]">
                                        <?= $article->name ?>
                                    </h3>

                                    <!-- Description -->
                                    <p class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-2 min-h-[2.5rem]">
                                        <?= word_limiter(strip_tags($article->detail), 20) ?>
                                    </p>

                                    <!-- Read More Link -->
                                    <span
                                        class="inline-flex items-center gap-2 font-semibold text-purple-600 hover:text-purple-700 transition">
                                        Read more
                                        <i class="fas fa-arrow-right text-sm"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mb-4">
                        <i class="fas fa-pills text-gray-300 text-6xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No medicines found</h3>
                    <p class="text-gray-600">Try selecting a different category or check back later.</p>
                </div>
            <?php endif; ?>

            <!-- Pagination -->
            <?php if (!empty($medicines)): ?>
                <div class="flex justify-center mt-12">
                    <div class="pagination-wrapper">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php $this->load->view('layouts/includes/footer'); ?>

    <script>
        // Global slider reference
        var slider = null;
        var btnLeft = null;
        var btnRight = null;

        // Initialize slider
        document.addEventListener('DOMContentLoaded', function() {
            slider = document.getElementById('catSlider');
            btnLeft = document.getElementById('catLeft');
            btnRight = document.getElementById('catRight');

            if (slider && btnLeft && btnRight) {
                btnRight.addEventListener('click', function(e) {
                    e.preventDefault();
                    slideNext();
                });

                btnLeft.addEventListener('click', function(e) {
                    e.preventDefault();
                    slidePrev();
                });
            }
        });

        function slideNext() {
            if (!slider) slider = document.getElementById('catSlider');
            if (!slider) return;

            const scrollAmount = Math.max(200, Math.round(slider.clientWidth * 0.7));

            if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                slider.scrollTo({
                    left: 0,
                    behavior: 'smooth'
                });
            } else {
                slider.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        }

        function slidePrev() {
            if (!slider) slider = document.getElementById('catSlider');
            if (!slider) return;

            const scrollAmount = Math.max(200, Math.round(slider.clientWidth * 0.7));

            if (slider.scrollLeft <= 0) {
                slider.scrollTo({
                    left: slider.scrollWidth,
                    behavior: 'smooth'
                });
            } else {
                slider.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>
</body>

</html>