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
        .letter-btn {
            transition: all 0.3s ease;
        }

        .letter-btn:hover:not(.disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .letter-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            font-weight: 700;
        }

        .letter-btn.disabled {
            cursor: not-allowed;
            opacity: 0.4;
        }

        .category-card {
            transition: all 0.35s ease;
        }

        .category-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .medicine-card {
            transition: all 0.3s ease;
        }

        .medicine-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        /* Remove any container max-width restrictions */
        body {
            margin: 0;
            padding: 0;
        }
    </style>

    <!-- Full-width wrapper -->
    <div class="w-full">
        <!-- Main Content -->
        <div class="min-h-screen bg-gray-50 py-8 px-4 pt-20 lg:pt-24">
            <div class="max-w-7xl mx-auto">

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Browse Medicines</h1>
                    <p class="text-gray-600">Explore our comprehensive medicine catalog by alphabet or category</p>
                </div>

                <!-- Section 1: Browse A to Z -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        Browse Medicines A to Z
                    </h2>

                    <div class="grid grid-cols-6 sm:grid-cols-9 md:grid-cols-13 gap-2 md:gap-3">
                        <?php
                        $alphabet = range('A', 'Z');
                        foreach ($alphabet as $letter):
                            $count = isset($alphabet_stats[$letter]) ? $alphabet_stats[$letter] : 0;
                            $is_active = ($letter === $selected_letter);
                            $disabled = ($count === 0);
                            ?>
                            <?php if ($disabled): ?>
                                <div
                                    class="letter-btn disabled bg-gray-100 text-gray-400 rounded-lg px-3 py-3 md:px-4 md:py-4 text-center font-semibold text-sm md:text-base">
                                    <?= $letter ?>
                                    <div class="text-xs text-gray-400 mt-1">(0)</div>
                                </div>
                            <?php else: ?>
                                <a href="<?= site_url('medicine/search?letter=' . $letter) ?>"
                                    class="letter-btn <?= $is_active ? 'active' : 'bg-gray-100 hover:bg-blue-50' ?> rounded-lg px-3 py-3 md:px-4 md:py-4 text-center font-semibold text-sm md:text-base block">
                                    <?= $letter ?>
                                    <div class="text-xs <?= $is_active ? 'text-white' : 'text-gray-500' ?> mt-1">
                                        (<?= $count ?>)
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Section 2: Browse by Categories -->
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        Browse by Categories
                    </h2>

                    <?php if (!empty($med_categories)): ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <?php foreach ($med_categories as $cat): ?>
                                <a href="<?= site_url('medicine/search?category=' . $cat->slug) ?>"
                                    class="category-card bg-gradient-to-br from-blue-50 to-white rounded-xl p-5 border border-gray-200 block">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-capsules text-blue-600 text-xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 mb-1 text-sm md:text-base">
                                                <?= htmlspecialchars($cat->name) ?>
                                            </h3>
                                            <?php if (!empty($cat->description)): ?>
                                                <p class="text-xs text-gray-600 line-clamp-2">
                                                    <?= htmlspecialchars(word_limiter($cat->description, 8)) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600 text-center py-8">No categories available.</p>
                    <?php endif; ?>
                </div>

                <!-- Section 3: No Results Message -->
                <?php if (empty($grouped_medicines)): ?>
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <div class="mb-4">
                            <i class="fas fa-search text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No medicines found</h3>
                        <p class="text-gray-600">No medicines starting with "<?= $selected_letter ?>" are currently
                            available.
                        </p>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Footer (Full Width) -->
        <?php $this->load->view('layouts/includes/footer'); ?>
    </div>

    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>