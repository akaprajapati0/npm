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

    <?php $this->load->view('layouts/includes/navbar'); ?>

    <div class="min-h-screen bg-gray-50 py-8 px-4 md:px-8 mt-16">
        <div class="max-w-7xl mx-auto">
            <!-- Search Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Search Results for: <span class="text-blue-600">"<?= htmlspecialchars($search_term) ?>"</span>
                </h1>
                <p class="text-gray-600">Found <?= $total_count ?> medicine(s)</p>
            </div>

            <!-- Search Bar -->
            <div
                class="flex items-center bg-white border <?= $this->session->flashdata('show_error_in_input') ? 'border-red-500 border-2' : 'border-none' ?> rounded-full shadow-xl w-full max-w-8xl mx-auto overflow-hidden mb-6 sm:mb-8">
                <form action="<?= site_url('medicine/search') ?>" method="GET" class="w-full flex" id="searchForm">
                    <input type="text" name="q" id="medicine-search"
                        placeholder="<?= $this->session->flashdata('show_error_in_input') ? 'Field cannot be empty!' : 'Enter medicine name, active ingredient, or therapeutic area' ?>"
                        class="flex-grow px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base focus:outline-none text-gray-700 <?= $this->session->flashdata('show_error_in_input') ? 'placeholder-red-500 text-red-600' : '' ?>"
                        autocomplete="off" />
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition-all text-white rounded-full px-5 sm:px-8 py-2 sm:py-3 font-semibold search-icon-btn m-1 text-sm sm:text-base flex-shrink-0">
                        Search <i class="fa-solid fa-magnifying-glass ml-1 sm:ml-2"></i>
                    </button>
                </form>
            </div>
            <div id="search-results-preview"
                style="display: none; margin-top: 20px; background: white; border-radius: 10px; padding: 15px; max-width: 600px; width: 100%;">
            </div>
            <?php if (empty($medicines)): ?>
                <!-- No Results -->
                <div class="text-center py-16">
                    <div class="mb-6">
                        <i class="fas fa-search text-gray-400 text-6xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-700 mb-2">No medicines found</h2>
                    <p class="text-gray-600 mb-6">
                        Try searching with different keywords or check spelling
                    </p>
                    <a href="<?= site_url('medicines/all') ?>"
                        class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Browse All Medicines
                    </a>
                </div>
            <?php else: ?>
                <!-- Results Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($medicines as $medicine): ?>
                        <a href="<?= site_url('medicine/detail/' . $medicine->id) ?>"
                            class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden group">
                            <!-- Medicine Image -->
                            <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                                <img src="<?= base_url('assets/images/medicine-placeholder.png') ?>"
                                    alt="<?= htmlspecialchars($medicine->name) ?>"
                                    class="w-40 h-50 object-cover group-hover:scale-110 transition duration-300">
                            </div>

                            <!-- Medicine Info -->
                            <div class="p-4">
                                <!-- Category Badge -->
                                <?php if (!empty($medicine->category_name)): ?>
                                    <span
                                        class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold mb-2">
                                        <?= htmlspecialchars($medicine->category_name) ?>
                                    </span>
                                <?php endif; ?>
                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                    <?= htmlspecialchars($medicine->name) ?>
                                </h3>

                                <div class="space-y-2 text-sm text-gray-600 mb-4">

                                    <p>
                                        <!-- <i class="fas fa-pills text-red-600 w-5"></i> -->
                                        <span class="font-medium">Storage:</span>
                                        <?= htmlspecialchars($medicine->storage ?? 'N/A') ?>
                                    </p>
                                    <!-- <p>
                            <i class="fas fa-flask text-blue-600 w-5"></i>
                            <span class="font-medium">Active:</span>
                            <?= htmlspecialchars($medicine->active_ingredient ?? 'N/A') ?>
                        </p> -->
                                    <p>
                                        <!-- <i class="fa-solid fa-capsule"></i> -->
                                        <span class="font-medium">Strength:</span>
                                        <?= htmlspecialchars($medicine->strength ?? 'N/A') ?>
                                    <p>
                                        <!-- <i class="fas fa-building text-green-600 w-5"></i> -->
                                        <span class="font-medium">Company:</span>
                                        <?= htmlspecialchars($medicine->company_name ?? 'N/A') ?>
                                    </p>
                                    <p>
                                        <!-- <i class="fas fa-globe text-purple-600 w-5"></i> -->
                                        <span class="font-medium">Origin:</span>
                                        <?= htmlspecialchars($medicine->origin ?? 'India') ?>
                                    </p>
                                </div>

                                <!-- Price -->
                                <!-- <div class="mb-4">
                        <?php if ($medicine->price && $medicine->price > 0): ?>
                        <span class="text-2xl font-bold text-blue-600">
                            €<?= number_format($medicine->price, 2) ?>
                        </span>
                        <?php else: ?>
                        <span class="text-lg font-semibold text-orange-600">
                            On Request
                        </span>
                        <?php endif; ?>
                    </div> -->

                                <!-- View Details Button -->
                                <!-- <a href="<?= site_url('medicine/detail/' . $medicine->id) ?>"
                                class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                View Details
                            </a> -->
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Back Button -->
            <!-- <div class="mt-8 text-center">
            <a href="<?= site_url('/') ?>"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left"></i>
                Back to Home
            </a>
        </div> -->
        </div>
        <!-- Pagination -->
        <?php if (!empty($pagination)): ?>
            <div class="mt-10 flex justify-center">
                <?= $pagination ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- jQuery UI Autocomplete -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        /* Custom autocomplete styling */
        .ui-autocomplete {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 1000 !important;
        }

        .ui-menu-item {
            list-style: none;
        }

        .ui-menu-item-wrapper {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .ui-menu-item-wrapper:hover {
            background-color: #f9fafb;
        }

        .ui-state-active {
            background-color: #3b82f6 !important;
            color: white !important;
            border: none !important;
            margin: 0 !important;
        }

        .ui-state-active .medicine-name,
        .ui-state-active .medicine-ingredient,
        .ui-state-active .medicine-company {
            color: white !important;
        }

        .medicine-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .medicine-ingredient {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .medicine-company {
            font-size: 11px;
            color: #9ca3af;
        }
    </style>

    <script>
        $(document).ready(function () {

            /* --------------------------------------------
               FORM VALIDATION (Works same as Home Page)
            -------------------------------------------- */
            $("#searchForm").on("submit", function (e) {
                const searchValue = $("#medicine-search").val().trim();

                if (searchValue === "" || searchValue.length < 2) {
                    e.preventDefault();

                    $("#medicine-search")
                        .addClass("placeholder-red-500 text-red-600")
                        .attr("placeholder", "Field cannot be empty!")
                        .val("")
                        .focus();

                    const errorMsg = $("<div>")
                        .addClass("fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50 animate-bounce")
                        .html('<strong class="font-bold">Error!</strong> <span class="block sm:inline">Please enter at least 2 characters to search</span>')
                        .appendTo("body");

                    setTimeout(() => {
                        errorMsg.fadeOut(400, function () {
                            $(this).remove();
                        });
                    }, 3000);

                    return false;
                }
            });

            /* --------------------------------------------
               RESET ERROR ON INPUT
            -------------------------------------------- */
            $("#medicine-search").on("input", function () {
                if ($(this).val().length > 0) {
                    $(this)
                        .removeClass("placeholder-red-500 text-red-600")
                        .attr("placeholder", "Enter medicine name, active ingredient, or therapeutic area");
                }
            });

            /* --------------------------------------------
               AUTOCOMPLETE FIXED
            -------------------------------------------- */
            $("#medicine-search").autocomplete({
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
                        window.location.href = "<?= site_url('medicine/detail/') ?>" + ui.item.id;
                    }
                    return false;
                },
                focus: function (event, ui) {
                    if (ui.item.name) {
                        $("#medicine-search").val(ui.item.name);
                    }
                    return false;
                }
            }).data("ui-autocomplete")._renderItem = function (ul, item) {

                if (!item.id) {
                    return $("<li>")
                        .append("<div class='ui-menu-item-wrapper text-center text-gray-400'>" + item.label + "</div>")
                        .appendTo(ul);
                }

                return $("<li>")
                    .append(
                        "<div class='ui-menu-item-wrapper h-32 flex items-start gap-4 hover:bg-blue-600 hover:text-white group'>" +
                        "<div class='flex-shrink-0'>" +
                        "<img src='<?= base_url('assets/images/medicine-placeholder.png') ?>' class='w-20 h-24 object-cover rounded-lg shadow-sm border border-gray-200'>" +
                        "</div>" +
                        "<div class='flex-1 min-w-0'>" +
                        "<div class='font-semibold text-gray-900 text-base mb-1 group-hover:text-white'>" + item.name + "</div>" +
                        "<div class='text-xs mb-1'><span class='font-medium'>Storage:</span> " + (item.storage || 'N/A') + "</div>" +
                        "<div class='text-xs mb-1'><span class='font-medium'>Strength:</span> " + (item.strength || 'N/A') + "</div>" +
                        "<div class='text-xs mb-1'><span class='font-medium'>Company:</span> " + (item.company_name || 'N/A') + "</div>" +
                        "<div class='text-xs'><span class='font-medium'>Origin:</span> " + (item.origin || 'N/A') + "</div>" +
                        "</div>" +
                        "</div>"
                    )
                    .appendTo(ul);
            };

        });
    </script>



    <?php $this->load->view('layouts/includes/footer'); ?>
</body>

</html>