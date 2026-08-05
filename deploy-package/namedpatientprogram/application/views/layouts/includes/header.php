<?php
$currentHost = $_SERVER['HTTP_HOST'] ?? '';
$appLoginUrl = in_array($currentHost, ['namedpatientprogram.local', 'localhost'], true)
    ? 'http://localhost/'
    : 'https://app.namedpatientprogram.com';
?>

<!-- TOP BAR -->
<div class="bg-[#0B1739] text-white text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center gap-3 lg:flex-row lg:justify-between py-3">

            <!-- Row 1 -->
            <div class="flex items-center justify-center gap-4 flex-nowrap">
                <div class="flex flex-col sm:flex-row items-center sm:gap-1">
                    <p class="text-white text-xs sm:text-base">Call Us for Support</p>
                    <a href="tel:+919654860915" class="font-semibold text-sm sm:text-base">+91 9654860915</a>
                </div>

                <a href="https://share.google/IogJB1ez3YFkGtVAw" target="_blank"
                    class="flex items-center gap-2 text-white whitespace-nowrap">
                    <img src="<?= base_url('assets/images/home/google.png') ?>" alt="Google" class="w-7 h-7">
                    <div class="leading-tight">
                        <div class="text-xs underline">Google Reviews</div>
                        <div class="flex items-center gap-1">
                            <span class="text-xs font-semibold">4.8</span>
                            <div class="flex text-yellow-400 text-xs gap-0.5">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Row 2: hidden on mobile/tablet, visible only from lg (desktop) up -->
            <div class="hidden lg:flex items-center justify-center gap-3">
                <a href="<?= base_url('for-know-more-about-npp'); ?>"
                    class="text-sm text-white underline whitespace-nowrap">
                    For Know More about NPP
                </a>
                <a href="<?= $appLoginUrl ?>" target="_blank"
                    class="bg-[#2563EB] px-4 py-2 rounded text-sm whitespace-nowrap hover:text-white transition">
                    Log In
                </a>
            </div>

        </div>
    </div>
</div>

<header class="sticky top-0 bg-white shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between" style="height: 80px;">

            <!-- LOGO -->
            <a href="<?= base_url(); ?>" class="flex-shrink-0">
                <img src="<?= base_url('assets/img/logo.svg'); ?>" class="h-11 w-auto" alt="Ikris Pharma">
            </a>

            <!-- DESKTOP NAV -->
            <nav class="hidden lg:flex items-center gap-4 flex-1 justify-center">
                <!-- <a href="<?= base_url(); ?>" class="font-medium text-gray-800 hover:text-blue-600">Home</a> -->
                <a href="<?= base_url('about-us'); ?>" class="font-medium text-gray-800 hover:text-blue-600">About
                    Us</a>
                <a href="<?= base_url('named-patient-program'); ?>"
                    class="font-medium text-gray-800 hover:text-blue-600">Named Patient Program</a>

                <!-- Therapeutics Area -->
                <div class="nav-item">
                    <button class="flex items-center gap-1 font-medium text-gray-800 hover:text-blue-600">
                        Therapeutics Area <i class="fa fa-chevron-down text-xs"></i>
                    </button>
                    <div class="nav-dropdown">
                        <?php foreach ($therapeutic_categories as $cat): ?>
                            <a href="<?= base_url('therapeutic-area/' . url_title($cat->name, '-', TRUE)) ?>"
                                class="bg-blur-50">
                                <?= htmlspecialchars($cat->name) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Compliance & Safety -->
                <div class="nav-item">
                    <button class="flex items-center gap-1 font-medium text-gray-800 hover:text-blue-600">
                        Compliance & Safety <i class="fa fa-chevron-down text-xs"></i>
                    </button>
                    <div class="nav-dropdown">
                        <a href="<?= base_url('compliance-and-safety/prescription-guidelines') ?>"
                            class="bg-blur-50">Prescription Guidelines</a>
                        <a href="<?= base_url('compliance-and-safety/indian-import-regulations') ?>"
                            class="bg-blur-50">Indian Import
                            Regulations</a>
                        <a href="<?= base_url('compliance-and-safety/temperature-controlled-shipping') ?>"
                            class="bg-blur-50">Temperature-Controlled Shipping</a>
                        <a href="<?= base_url('compliance-and-safety/product-safety-standards') ?>"
                            class="bg-blur-50">Product
                            Safety Standards</a>
                        <a href="<?= base_url('compliance-and-safety/report-adverse') ?>" class="bg-blur-50">Report
                            Adverse Event</a>

                    </div>
                </div>

                <!-- Resources -->
                <div class="nav-item">
                    <button class="flex items-center gap-1 font-medium text-gray-800 hover:text-blue-600">
                        Resources <i class="fa fa-chevron-down text-xs"></i>
                    </button>
                    <div class="nav-dropdown">
                        <?php if (!empty($news_categories)): ?>
                            <?php foreach (array_slice($news_categories, 0, 5) as $cat): ?>
                                <a href="<?= base_url('news/category/' . urlencode($cat->name)); ?>">
                                    <?= ucfirst(htmlspecialchars($cat->name)); ?>
                                </a>
                            <?php endforeach; ?>
                            <?php if (count($news_categories) > 5): ?>
                                <a href="<?= base_url('news-and-updates'); ?>" class="bg-blue-50">View All Categories</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <a href="<?= base_url('contact-us'); ?>" class="font-medium text-gray-800 hover:text-blue-600">Contact
                    Us</a>

                <!-- INLINE SEARCH BOX (desktop only) -->
                <form action="<?= site_url('medicine/search'); ?>" method="get" class="relative ml-2">
                    <input id="searchInput" name="q" autocomplete="off" placeholder="Search for Medicine" class="w-56 xl:w-64 bg-gray-50 border border-gray-200 rounded-full
                   pl-4 pr-9 py-2 text-sm text-gray-700 placeholder-gray-400
                   outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center
                   text-gray-500 hover:text-blue-600 transition">
                        <i class="fa fa-search text-sm"></i>
                    </button>

                    <!-- live results dropdown -->
                    <div id="searchResults" class="hidden absolute left-0 top-full mt-2 w-full bg-white border border-gray-200
                   rounded-xl shadow-lg max-h-80 overflow-y-auto z-50">
                    </div>
                </form>

            </nav>

            <!-- RIGHT ICONS -->
            <div class="flex items-center gap-4 sm:gap-5">

                <!-- Mobile-only search toggle (hidden on desktop since search box is inline in nav) -->
                <button id="searchToggle" class="lg:hidden text-[15px] text-gray-600 hover:text-gray-800 transition">
                    <i class="fa fa-search"></i>
                </button>

                <div id="google_translate_element" class="hidden"></div>

                <!-- Globe + Translate Dropdown -->
                <div class="relative inline-block  " id="translateWrapper">
                    <button id="translateBtn" onclick="toggleTranslateDropdown(event)"
                        class="text-[15px] text-gray-600 hover:text-gray-800 transition">
                        <i class="fa fa-globe"></i>
                    </button>
                    <div id="translateDropdown" class="hidden
                                    fixed sm:absolute
                                    left-0 sm:left-auto
                                    right-0 sm:right-0
                                    top-[70px] sm:top-full
                                    sm:mt-2
                                    z-50
                                    bg-white rounded-t-2xl sm:rounded-2xl
                                    p-3 sm:p-4
                                    w-full sm:w-[420px]
                                    border-t sm:border border-gray-200
                                    shadow-2xl
                                    max-h-[75vh] overflow-y-auto">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-1">
                            <?php
                            $countries = [
                                ['name' => 'Australia', 'code' => 'au', 'lang' => 'en'],
                                ['name' => 'Austria', 'code' => 'at', 'lang' => 'de'],
                                ['name' => 'Brazil', 'code' => 'br', 'lang' => 'pt'],
                                ['name' => 'Canada', 'code' => 'ca', 'lang' => 'en'],
                                ['name' => 'Chile', 'code' => 'cl', 'lang' => 'es'],
                                ['name' => 'China', 'code' => 'cn', 'lang' => 'zh-CN'],
                                ['name' => 'Colombia', 'code' => 'co', 'lang' => 'es'],
                                ['name' => 'Czech Republic', 'code' => 'cz', 'lang' => 'cs'],
                                ['name' => 'Denmark', 'code' => 'dk', 'lang' => 'da'],
                                ['name' => 'Finland', 'code' => 'fi', 'lang' => 'fi'],
                                ['name' => 'France', 'code' => 'fr', 'lang' => 'fr'],
                                ['name' => 'Germany', 'code' => 'de', 'lang' => 'de'],
                                ['name' => 'India', 'code' => 'in', 'lang' => 'hi'],
                                ['name' => 'Netherlands', 'code' => 'nl', 'lang' => 'nl'],
                                ['name' => 'New Zealand', 'code' => 'nz', 'lang' => 'en'],
                                ['name' => 'Norway', 'code' => 'no', 'lang' => 'no'],
                                ['name' => 'Poland', 'code' => 'pl', 'lang' => 'pl'],
                                ['name' => 'Portugal', 'code' => 'pt', 'lang' => 'pt'],
                                ['name' => 'Romania', 'code' => 'ro', 'lang' => 'ro'],
                                ['name' => 'Russia', 'code' => 'ru', 'lang' => 'ru'],
                                ['name' => 'Slovakia', 'code' => 'sk', 'lang' => 'sk'],
                                ['name' => 'South Africa', 'code' => 'za', 'lang' => 'en'],
                                ['name' => 'Spain', 'code' => 'es', 'lang' => 'es'],
                                ['name' => 'Sweden', 'code' => 'se', 'lang' => 'sv'],
                                ['name' => 'Switzerland', 'code' => 'ch', 'lang' => 'de'],
                                ['name' => 'UK', 'code' => 'gb', 'lang' => 'en'],
                                ['name' => 'Ukraine', 'code' => 'ua', 'lang' => 'uk'],
                                ['name' => 'US', 'code' => 'us', 'lang' => 'en'],
                            ];
                            foreach ($countries as $c):
                                ?>
                                <button onclick="selectLanguage('<?= $c['lang'] ?>')"
                                    class="flex items-center gap-2 px-2.5 py-2 rounded-lg text-[13px] font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all text-left group">
                                    <span class="fi fi-<?= $c['code'] ?> rounded-sm flex-shrink-0"
                                        style="width:22px; height:16px; background-size:cover;"></span>
                                    <span class="truncate">
                                        <?= $c['name'] ?>
                                    </span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- MOBILE HAMBURGER -->
                <button id="mobileBtn" class="lg:hidden text-2xl text-gray-700">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- SEARCH BAR (mobile only, toggled by #searchToggle) -->
            <div id="headerSearch" class="header-search">
                <div class="max-w-2xl mx-auto px-3 sm:px-4 py-3 sm:py-5">
                    <form action="<?= site_url('medicine/search'); ?>" method="get"
                        class="flex items-center w-full bg-white border border-gray-200 rounded-full shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 transition">
                        <span class="pl-3 sm:pl-4 text-gray-400 text-sm sm:text-base">
                            <i class="fa fa-search"></i>
                        </span>
                        <input id="searchInputMobile" name="q" autocomplete="off"
                            class="flex-1 min-w-0 px-2 py-2.5 outline-none text-sm text-gray-700 placeholder-gray-400"
                            placeholder="Search medicines">
                        <button type="submit"
                            class="bg-blue-600 text-white px-3 sm:px-5 py-2.5 sm:py-3 text-sm sm:text-base rounded-full hover:bg-blue-700 transition font-medium whitespace-nowrap">
                            Search
                        </button>
                    </form>

                    <!-- results container: separate element, own id, sibling of the form -->
                    <div id="searchResultsMobile"
                        class="mt-3 bg-white border border-gray-200 rounded-xl shadow-lg hidden max-h-80 overflow-y-auto">
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>

<!-- MOBILE MENU OVERLAY -->
<div id="mobileMenuOverlay"
    class="fixed inset-0 bg-black/50 z-[9999] opacity-0 invisible transition-opacity duration-300 lg:hidden">
</div>

<!-- MOBILE MENU DRAWER -->
<div id="mobileMenu" class="fixed top-0 right-0 h-full w-[88%] max-w-[400px] bg-white z-[10000]
           translate-x-full transition-transform duration-300 ease-in-out
           overflow-y-auto lg:hidden">

    <!-- TABS -->
    <div class="flex sticky top-0 bg-white z-10">
        <button type="button" data-tab="menu" onclick="switchMobileTab('menu')"
            class="mobile-tab-btn flex-1 py-[18px] text-center text-[15px] font-semibold text-gray-900 bg-white border-b-2 border-[#2F336E]">
            Menu
        </button>
        <button type="button" data-tab="account" onclick="switchMobileTab('account')"
            class="mobile-tab-btn flex-1 py-[18px] text-center text-[15px] font-medium text-gray-400 bg-gray-100 border-b border-gray-200">
            Account
        </button>
    </div>

    <button id="closeMobile" class="absolute top-4 right-4 text-gray-500 text-lg">
        <i class="fa fa-times"></i>
    </button>

    <!-- ================= MENU TAB ================= -->
    <div id="mobileTabMenu" class="mobile-tab-panel block px-4 pt-3 pb-8">

        <!-- <a href="<?= base_url() ?>"
            class="flex items-center justify-between py-4 border-b border-gray-200 text-gray-800 text-base font-medium hover:text-blue-600">
            Home
        </a> -->

        <a href="<?= base_url('about-us') ?>"
            class="flex items-center justify-between py-4 border-b border-gray-200 text-gray-800 text-base font-medium hover:text-blue-600">
            About Us
        </a>

        <a href="<?= base_url('named-patient-program') ?>"
            class="flex items-center justify-between py-4 border-b border-gray-200 text-gray-800 text-base font-medium hover:text-blue-600">
            Named Patient Program
        </a>

        <!-- Therapeutics Area -->
        <div>
            <button onclick="toggleMobileSub(this)"
                class="mobile-toggle flex justify-between items-center w-full py-4 border-b border-gray-200 text-base font-medium text-gray-800 text-left">
                Therapeutics Area
                <i class="fa fa-chevron-down text-[13px] text-gray-500 transition-transform duration-300"></i>
            </button>
            <div class="mobile-sub hidden pl-3 pt-1 pb-2">
                <?php foreach ($therapeutic_categories as $cat): ?>
                    <a href="<?= base_url('therapeutic-area/' . url_title($cat->name, '-', TRUE)) ?>"
                        class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">
                        <?= htmlspecialchars($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Compliance & Safety -->
        <div>
            <button onclick="toggleMobileSub(this)"
                class="mobile-toggle flex justify-between items-center w-full py-4 border-b border-gray-200 text-base font-medium text-gray-800 text-left">
                Compliance & Safety
                <i class="fa fa-chevron-down text-[13px] text-gray-500 transition-transform duration-300"></i>
            </button>
            <div class="mobile-sub hidden pl-3 pt-1 pb-2">
                <a href="<?= base_url('compliance-and-safety/why-prescription') ?>"
                    class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">Prescription Guidelines</a>
                <a href="<?= base_url('compliance-and-safety/indian-import-regulations') ?>"
                    class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">Indian Import
                    Regulations</a>
                <a href="<?= base_url('compliance-and-safety/temp-and-logistics') ?>"
                    class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">Temperature-Controlled
                    Shipping</a>
                <a href="<?= base_url('compliance-and-safety/medicine-safety') ?>"
                    class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">Product
                    Safety Standards</a>
                <a href="<?= base_url('compliance-and-safety/report-adverse') ?>"
                    class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">Report
                    Adverse Event</a>
            </div>
        </div>

        <!-- Resources -->
        <div>
            <button onclick="toggleMobileSub(this)"
                class="mobile-toggle flex justify-between items-center w-full py-4 border-b border-gray-200 text-base font-medium text-gray-800 text-left">
                Resources
                <i class="fa fa-chevron-down text-[13px] text-gray-500 transition-transform duration-300"></i>
            </button>
            <div class="mobile-sub hidden pl-3 pt-1 pb-2">
                <?php if (!empty($news_categories)): ?>
                    <?php foreach (array_slice($news_categories, 0, 5) as $cat): ?>
                        <a href="<?= base_url('news/category/' . urlencode($cat->name)); ?>"
                            class="block py-2.5 text-[15px] text-gray-600 hover:text-blue-600">
                            <?= ucfirst(htmlspecialchars($cat->name)); ?>
                        </a>
                    <?php endforeach; ?>
                    <?php if (count($news_categories) > 5): ?>
                        <a href="<?= base_url('news-and-updates'); ?>"
                            class="block py-2.5 text-[15px] text-blue-600 font-medium">
                            View All Categories
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('contact-us') ?>"
            class="flex items-center justify-between py-4 border-b border-gray-200 text-gray-800 text-base font-medium hover:text-blue-600">
            Contact Us
        </a>

    </div>

    <!-- ================= ACCOUNT TAB ================= -->
    <div id="mobileTabAccount" class="mobile-tab-panel hidden px-5 pt-6 pb-8">

        <h3 class="text-[17px] font-semibold text-gray-900">For Healthcare Professionals</h3>
        <p class="text-sm text-gray-500 mt-1.5 mb-5 pb-4 border-b border-gray-200">
            Sign in to access your account
        </p>

        <a href="<?= $appLoginUrl ?>" target="_blank"
            class="block text-center bg-[#2F336E] text-white py-3.5 rounded-lg font-semibold hover:bg-[#23265a] transition">
            Log In
        </a>

        <!-- <div class="mt-7 text-sm text-gray-700">
            <p class="mb-2">
                <strong class="text-gray-900">Call Us at Support</strong><br>
                <a href="tel:+919856458785" class="text-blue-600 font-medium">+91 9856 4587 85</a>
            </p>

            <a href="#" target="_blank" class="flex items-center gap-2 mt-3">
                <img src="<?= base_url('assets/images/home/google.png') ?>" alt="Google" class="w-6 h-6">
                <span class="text-sm text-gray-700">
                    Google Reviews <strong class="text-gray-900">4.8</strong>
                    <span class="text-yellow-400 ml-1">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </span>
                </span>
            </a>
        </div> -->

    </div>

</div>
