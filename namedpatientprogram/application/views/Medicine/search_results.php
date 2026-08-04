<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php $this->load->view('layouts/includes/head-links'); ?>
</head>

<body>
    <?php $this->load->view('layouts/includes/header'); ?>

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        /* jQuery UI Autocomplete styling */
        .ui-autocomplete {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 2000 !important;
            font-size: 0.875rem;
        }

        .ui-menu-item {
            list-style: none;
        }

        .ui-menu-item-wrapper {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f3f5;
            cursor: pointer;
            transition: background-color 0.15s ease;
            display: flex;
            align-items: flex-start;
            gap: .75rem;
        }

        .ui-menu-item-wrapper:last-child {
            border-bottom: none;
        }

        .ui-menu-item-wrapper:hover {
            background-color: #f8f9fa;
        }

        .ui-state-active {
            background-color: #0d6efd !important;
            color: #fff !important;
            border: none !important;
            margin: 0 !important;
        }

        .ui-state-active .med-ac-name,
        .ui-state-active .med-ac-meta {
            color: #fff !important;
        }

        .med-ac-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 2px;
        }

        .med-ac-meta {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .letter-section {
            scroll-margin-top: 100px;
        }

        .filter-badge {
            transition: all 0.2s ease;
        }

        .filter-badge:hover {
            transform: scale(1.05);
        }
    </style>

    <main class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">

            <!-- Header with Title and Active Filters -->
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                    <?= htmlspecialchars($title) ?>
                </h1>

                <!-- Active Filters Display -->
                <?php if (isset($filter_type) && $filter_type === 'filtered'): ?>
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="text-sm font-medium text-gray-600">Active Filters:</span>

                        <?php if (!empty($selected_letter)): ?>
                            <a href="<?= site_url('medicine/search' . (isset($selected_category_id) ? '?category=' . $selected_category_id : '')) ?>"
                                class="filter-badge inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold hover:bg-blue-200">
                                Letter: <?= $selected_letter ?>
                                <i class="fas fa-times text-xs"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($selected_category_id)): ?>
                            <?php
                            $cat = $this->db->get_where('med_categories', ['id' => $selected_category_id])->row();
                            if ($cat):
                                ?>
                                <a href="<?= site_url('medicine/search' . (!empty($selected_letter) ? '?letter=' . $selected_letter : '')) ?>"
                                    class="filter-badge inline-flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold hover:bg-purple-200">
                                    Category: <?= htmlspecialchars($cat->name) ?>
                                    <i class="fas fa-times text-xs"></i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <a href="<?= site_url('medicine/all') ?>"
                            class="text-sm text-gray-600 hover:text-blue-600 font-medium">
                            Clear All Filters
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Results Count -->
                <?php if (isset($total_count)): ?>
                    <p class="text-sm md:text-base text-gray-600">
                        <?= (int) $total_count ?> medicine<?= $total_count == 1 ? '' : 's' ?> found
                    </p>
                <?php endif; ?>
            </div>

            <!-- Quick Alphabet Navigation (for filtered results) -->
            <?php if (isset($filter_type) && $filter_type === 'filtered' && !empty($grouped_medicines)): ?>
                <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-600 mr-2">Jump to:</span>
                        <?php foreach (array_keys($grouped_medicines) as $letter): ?>
                            <a href="#section-<?= $letter ?>"
                                class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-semibold">
                                <?= $letter ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Results Display -->
            <?php if (isset($filter_type) && $filter_type === 'text_search'): ?>
                <!-- TEXT SEARCH RESULTS (Grid Format) -->
                <?php if (!empty($medicines)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        <?php foreach ($medicines as $medicine): ?>
                            <?php
                            $card_image_url = base_url('assets/images/medicine-placeholder.png');
                            if (!empty($medicine->image) && file_exists(FCPATH . 'assets/images/medicines/' . $medicine->image)) {
                                $card_image_url = base_url('assets/images/medicines/' . $medicine->image);
                            }
                            ?>
                            <!-- <a href="<?= site_url('medicine/detail/' . $medicine->id) ?>"
                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group block transform hover:-translate-y-1"> -->
                            <a href="<?= site_url('m/' . $medicine->category_name . '/' . $medicine->name) ?>"
                                class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group block transform hover:-translate-y-1">

                                <!-- Image -->
                                <div class="h-40 md:h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                    <img src="<?= $card_image_url ?>" alt="<?= htmlspecialchars($medicine->name) ?>"
                                        class="w-32 md:w-40 h-36 md:h-44 object-cover group-hover:scale-110 transition duration-300">
                                </div>

                                <!-- Info -->
                                <div class="p-4">
                                    <h3 class="text-base md:text-lg font-bold text-gray-800 mb-3 line-clamp-2 min-h-[3rem]">
                                        <?= htmlspecialchars($medicine->name) ?>
                                    </h3>

                                    <div class="space-y-2 text-xs md:text-sm text-gray-600">
                                        <p class="flex items-start">
                                            <span class="font-medium min-w-[70px]">Storage:</span>
                                            <span class="flex-1"><?= htmlspecialchars($medicine->storage ?? 'N/A') ?></span>
                                        </p>
                                        <p class="flex items-start">
                                            <span class="font-medium min-w-[70px]">Strength:</span>
                                            <span class="flex-1"><?= htmlspecialchars($medicine->strength ?? 'N/A') ?></span>
                                        </p>
                                        <p class="flex items-start">
                                            <span class="font-medium min-w-[70px]">Company:</span>
                                            <span class="flex-1"><?= htmlspecialchars($medicine->company_name ?? 'N/A') ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                        <div class="mb-4">
                            <i class="fas fa-search text-gray-300" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">No medicines found</h2>
                        <p class="text-gray-600 mb-6">
                            Try searching with different keywords or check the spelling.
                        </p>
                        <a href="<?= site_url('medicine/all') ?>"
                            class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Browse All Medicines
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Pagination for Text Search -->
                <?php if (!empty($pagination)): ?>
                    <div class="flex justify-center mt-8">
                        <div class="inline-flex items-center gap-2">
                            <?= $pagination ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- GROUPED RESULTS (Alphabetical Sections) -->
                <?php if (!empty($grouped_medicines)): ?>
                    <?php foreach ($grouped_medicines as $letter => $medicines): ?>
                        <div class="mb-8 letter-section" id="section-<?= $letter ?>">
                            <!-- Letter Header -->
                            <div class="bg-white rounded-t-2xl shadow-sm p-4 border-b-2 border-blue-600">
                                <h2 class="text-2xl md:text-3xl font-bold text-blue-600 flex items-center gap-3">
                                    <span class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <?= $letter ?>
                                    </span>
                                    <span><?= count($medicines) ?> Medicine<?= count($medicines) > 1 ? 's' : '' ?></span>
                                </h2>
                            </div>

                            <!-- Medicines Grid -->
                            <div class="bg-white rounded-b-2xl shadow-lg p-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                                    <?php foreach ($medicines as $medicine): ?>
                                        <?php
                                        $card_image_url = base_url('assets/images/medicine-placeholder.png');
                                        if (!empty($medicine->image) && file_exists(FCPATH . 'assets/images/medicines/' . $medicine->image)) {
                                            $card_image_url = base_url('assets/images/medicines/' . $medicine->image);
                                        }
                                        ?>
                                        <!-- <a href="<?= site_url('medicine/detail/' . $medicine->id) ?>"
                        class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 group"> -->


                                        <a href="<?= site_url('m/' . $medicine->category_name . '/' . $medicine->name) ?>"
                                            class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 group">

                                            <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                                                <img src="<?= $card_image_url ?>" alt="<?= htmlspecialchars($medicine->name) ?>"
                                                    class="w-32 h-36 object-contain group-hover:scale-110 transition duration-300">
                                            </div>

                                            <div class="p-4">
                                                <?php if (!empty($medicine->category_name)): ?>
                                                    <span
                                                        class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold mb-2 uppercase">
                                                        <?= htmlspecialchars($medicine->category_name) ?>
                                                    </span>
                                                <?php endif; ?>

                                                <h4 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 min-h-[2.5rem]">
                                                    <?= htmlspecialchars($medicine->name) ?>
                                                </h4>

                                                <div class="space-y-1 text-xs text-gray-600">
                                                    <p><span class="font-medium">Strength:</span>
                                                        <?= htmlspecialchars($medicine->strength ?? 'N/A') ?></p>
                                                    <p><span class="font-medium">Company:</span>
                                                        <?= htmlspecialchars($medicine->company_name ?? 'N/A') ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-white rounded-2xl shadow-md">
                        <div class="mb-4">
                            <i class="fas fa-pills text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">No medicines found</h3>
                        <p class="text-gray-600 mb-6">Try selecting a different letter or category.</p>
                        <a href="<?= site_url('medicine/all') ?>"
                            class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                            Browse All Medicines
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </main>

    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function () {

            /* Autocomplete for search input if present */
            const searchInput = $("#medicine-search");
            if (searchInput.length) {
                searchInput.autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?= site_url('medicine/liveSearch') ?>",
                            dataType: "json",
                            data: {
                                term: request.term
                            },
                            success: function (data) {
                                if (data.length === 0) {
                                    response([{
                                        label: 'No medicines found',
                                        value: '',
                                        id: null
                                    }]);
                                } else {
                                    response(data);
                                }
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        if (ui.item.id) {
                            // window.location.href = "<?= site_url('medicine/detail/') ?>" + ui.item.id;

                            window.location.href =
                                "<?= site_url('m/' . $medicine->category_name . '/' . $medicine->name) ?>" +
                                ui.item.id;
                        }
                        return false;
                    }
                });
            }

            /* Smooth scroll to letter sections */
            $('a[href^="#section-"]').on('click', function (e) {
                e.preventDefault();
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            });
        });
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>
</body>

</html>