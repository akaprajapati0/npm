<footer class="bg-[#0B1739]">

    <div class="max-w-7xl mx-auto  text-white">
        <div class="block lg:flex lg:items-center lg:gap-8 xl:gap-12 p-6 sm:p-8 md:p-10 lg:p-12 space-y-6 lg:space-y-0">

            <!-- Left Section - Brand Area -->
            <div class="flex items-center gap-4 md:gap-5 flex-shrink-0 lg:w-auto justify-start">
                <!-- NPP Big Text -->
                <div class="space-y-0">
                    <img src="<?= base_url('assets/images/home/npp_logo.png') ?>" alt="NPP logo"
                        class="max-w-full h-auto w-[250px]">
                </div>
            </div>

            <!-- Right Section - Description -->
            <div class="flex-1">
                <p
                    class="text-white/90 text-xs sm:text-sm md:text-base leading-none sm:leading-relaxed md:leading-loose">
                    We support access to essential, life-saving medicines that are approved in global markets but
                    may not yet be available in your country. Through regulated Named Patient import pathways, we
                    help patients and healthcare providers access
                    critical therapies when they are needed most.
                </p>
            </div>
        </div>

        <!-- ========= DIVIDER ========= -->
        <div class="border-t border-[#2563EB] my-5"></div>

        <!-- ========= TOP GRID ========= -->

        <?php
        $footer_categories = [
            'quick-links' => 'QUICK LINKS',
            'imported-medicines' => 'IMPORTED MEDICINES',
            'best-treatment' => 'BEST TREATMENT',
            'top-articles' => 'TOP ARTICLES',
            'fda-drug-approvals' => 'FDA DRUG APPROVALS',
            'latest-news' => 'LATEST NEWS',
        ];
        ?>

        <div class="mx-auto px-6 pb-16">

            <!-- DESKTOP -->
            <div class="hidden lg:grid grid-cols-6 gap-7">

                <?php $index = 0; ?>

                <?php foreach ($footer_categories as $key => $heading): ?>

                    <div class="<?= ($index < count($footer_categories) - 1) ? 'border-r border-[#2563EB] pr-2' : ''; ?>">

                        <h4 class="text-white font-semibold uppercase mb-3 text-sm">
                            <?= $heading; ?>
                        </h4>

                        <div class="space-y-2 text-sm text-gray-300">

                            <?php if (!empty($footer_links[$key])): ?>

                                <?php foreach ($footer_links[$key] as $item): ?>

                                    <a href="<?= $item->slug; ?>" class="block hover:text-white transition" target="_blank">
                                        <?= $item->title; ?>
                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    </div>

                    <?php $index++; ?>

                <?php endforeach; ?>

            </div>

            <!-- MOBILE / TABLET -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 lg:hidden">

                <?php foreach ($footer_categories as $key => $heading): ?>

                    <div>

                        <h4 class="text-white font-semibold uppercase mb-4 text-sm">
                            <?= $heading; ?>
                        </h4>

                        <div class="space-y-2 text-sm text-gray-300">

                            <?php if (!empty($footer_links[$key])): ?>

                                <?php foreach ($footer_links[$key] as $item): ?>

                                    <a href="<?= $item->slug ?>" class="block hover:text-white transition" target="_blank">
                                        <?= $item->title; ?>
                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <!-- ========= DIVIDER ========= -->
        <div class="border-t border-[#2563EB]"></div>

        <!-- ======== CONTACT STRIP ======== -->
        <div class="mx-auto px-6 py-14">
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_auto_1fr_auto_1fr] gap-10 text-sm">

                <div class="text-center lg:text-left">
                    <h5 class="text-white font-semibold mb-4 text-base text-left">CORPORATE OFFICE</h5>
                    <p class="text-gray-300 leading-relaxed mb-4 text-left text-base">
                       907, 9th Floor, Tower A, ithum Business Park, Sector 62, Noida, Uttar Pradesh 201309
                    </p>
                    <div class="flex">
                        <img src="<?= base_url('assets/images/home/country1.png') ?>" alt="">
                        <img src="<?= base_url('assets/images/home/country2.png') ?>" class="pl-3" alt="">
                        <img src="<?= base_url('assets/images/home/country3.png') ?>" class="pl-3" alt="">
                    </div>
                </div>

                <div class="hidden lg:block w-px "></div>

                <div class="text-center lg:text-left">
                    <h5 class="text-white font-semibold mb-4 text-base text-left">HELP AND SUPPORT</h5>
                    <p class="text-gray-300 mb-2 text-left text-base"><i class="fa-solid fa-phone text-sm mr-2"></i>
                        <a href="tel:+919654860915" class="font-medium hover:underline hover:text-white">
                            +91 9654860915
                        </a>
                    </p>

                    <!-- <p class="text-gray-300 mb-2 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-sm mr-2"></i>+91 6589536565
                        </p> -->
                    <p class="text-gray-300 mb-2 text-left text-base"><i class="fa-solid fa-phone text-sm mr-2"></i>
                        <a href="tel:18001200365" class="font-medium hover:underline hover:text-white">
                            18001200365
                        </a>
                    </p>
                </div>
                <div class="hidden lg:block w-px"></div>

                <div class="text-center lg:text-left">
                    <h5 class="text-white font-semibold mb-4 text-base text-left">CONTACT US</h5>
                    <p class="mb-2 text-left text-white">
                        <i class="fa-solid fa-envelope text-sm mr-2"></i>
                        <a href="mailto:info@namedpatientprogram.com"
                            class="text-white hover:text-blue-300 hover:underline transition text-base">info@namedpatientprogram.com
                        </a>
                    </p>
                    <!-- <p class="flex items-center justify-center text-white">
                            <i class="fa-solid fa-envelope text-sm mr-2"></i>
                            <a href="mailto:Support@namedpatientprogram.com"
                                class="text-blue-400 hover:text-blue-300 transition">Support@namedpatientprogram.com
                            </a>
                        </p> -->
                </div>

            </div>
        </div>

        <div class="border-t border-[#2563EB]"></div>

        <div class="bg-white p-6 md:p-10 my-4">
            <p class="mx-auto text-black text-base">Medicines facilitated via patient access pathways are made
                available
                solely upon receipt of a valid prescription and in accordance with all applicable regulatory
                frameworks.</p>
        </div>

        <div class="border-t border-[#2563EB]"></div>
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">

                <!-- Links -->
                <div class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 text-gray-300">
                    <a href="<?= base_url('terms-and-conditions') ?>" class="hover:text-white">Terms and
                        Conditions</a>
                    <a href="<?= base_url('privacy-policy') ?>" class="hover:text-white">Privacy Policy</a>
                    <a href="#" class="hover:text-white">Cookies Settings</a>
                    <a href="https://namedpatientprogram.com/sitemap.html" class="hover:text-white">Sitemap</a>
                </div>

                <!-- Social Icons -->
                <div class="flex justify-center md:justify-end gap-5 text-xl text-gray-300 shrink-0">
                    <a href="https://www.facebook.com/profile.php?id=61585116521403" target="_blank"
                        class="hover:text-white">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://wa.me/919810469557" target="_blank" class="hover:text-white">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/namedpatientprogram/" target="_blank" class="hover:text-white">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/namedpatientprogram" target="_blank"
                        class="hover:text-white">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>

            </div>
        </div>

        <!-- ========= DISCLAIMER ========= -->
        <div class="border-t border-[#2563EB]"></div>
        <div class=" mx-auto px-6 py-10 text-xs text-gray-300 leading-relaxed">
            <div class="text-white text-sm leading-relaxed space-y-3">
                <p class="text-white">
                    <strong class="text-white">Disclaimer:</strong> The website namedpatientprogram.com facilitates
                    access to prescribed medicines through regulated sourcing channels, including manufacturers and duly
                    authorized distributors. The company does not manufacture, formulate, or modify any pharmaceutical
                    products. All trademarks, brand names, and product names mentioned are the property of their
                    respective owners. Their use is solely for identification purposes and in accordance with applicable
                    trademark laws, including the Trade Marks Act, 1999, under principles of fair use. The company does
                    not claim ownership of, nor assert any rights over, any patents associated with the products
                    referenced. Responsibility for compliance with applicable patent laws, including the Patents Act,
                    1970, rests solely with the respective patent holders, manufacturers, or marketing authorization
                    holders. The company facilitates access to certain medicines that may not yet be approved or
                    commercially available in a patient’s country, including recently approved or newly introduced
                    therapies, through legally permissible channels such as named patient programs. Such access is
                    strictly subject to a valid prescription from a licensed medical practitioner and full compliance
                    with applicable laws and regulatory requirements. Nothing contained herein shall be construed as an
                    inducement or authorization to infringe any intellectual property rights.
                </p>

            </div>

        </div>

        <!-- ========= BOTTOM STRIP ========= -->
        <div class="border-t border-[#2563EB]"></div>
        <div class="bg-[#0B1739] py-4">
            <p class="text-white text-center text-xs">
                Copyright
                &copy;
                <?php echo date('Y'); ?> Named Patient Program.
            </p>
        </div>
    </div>
</footer>
<script>
    // Mobile Menu
    const mobileMenu = document.getElementById('mobileMenu');
    document.getElementById('mobileBtn').onclick = () => mobileMenu.classList.add('active');
    document.getElementById('closeMobile').onclick = () => mobileMenu.classList.remove('active');


    function toggleMobileSub(btn) {

        const parent = btn.parentElement;
        const currentSub = parent.querySelector(':scope > .mobile-sub');

        if (!currentSub) return;

        const isOpen = currentSub.classList.contains('active');

        // Close ONLY siblings (not entire menu)
        const siblings = parent.parentElement.children;

        Array.from(siblings).forEach(item => {
            const toggle = item.querySelector(':scope > .mobile-toggle');
            const sub = item.querySelector(':scope > .mobile-sub');

            if (toggle && sub) {
                toggle.classList.remove('active');
                sub.classList.remove('active');
            }
        });

        // Toggle current
        if (!isOpen) {
            btn.classList.add('active');
            currentSub.classList.add('active');
        }
    }

    // Live Search
    let searchTimeout;
    //     const searchInput = document.getElementById('searchInput');
    //    let searchTimeout;

    function initSearch(inputId, resultId) {

        const input = document.getElementById(inputId);
        const resultsDiv = document.getElementById(resultId);

        if (!input || !resultsDiv) return;

        input.addEventListener("keyup", function (e) {

            clearTimeout(searchTimeout);

            const value = e.target.value.trim();

            if (value.length < 2) {
                resultsDiv.classList.add("hidden");
                resultsDiv.innerHTML = "";
                return;
            }

            searchTimeout = setTimeout(() => {

                fetch("<?= site_url('medicine/ajaxSearch'); ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "search_term=" + encodeURIComponent(value)
                })
                    .then(r => r.json())
                    .then(data => {

                        if (!data.status || !data.results.length) {

                            resultsDiv.innerHTML =
                                '<div class="p-3 text-gray-500">No results found</div>';

                            resultsDiv.classList.remove("hidden");
                            return;
                        }

                        resultsDiv.innerHTML = data.results.map(m => `
                    <a href="${m.detail_url}"
                       class="block p-3 hover:bg-blue-50 rounded transition">
                        ${m.name}
                    </a>
                `).join("");

                        resultsDiv.classList.remove("hidden");

                    });

            }, 300);

        });

    }
    initSearch("searchInput", "searchResults");
    initSearch("searchInputMobile", "searchResultsMobile");
    // Close search when clicking outside
    document.addEventListener('click', function (e) {
        const searchToggle = document.getElementById('searchToggle');
        const headerSearch = document.getElementById('headerSearch');
        if (!searchToggle.contains(e.target) && !headerSearch.contains(e.target)) {
            headerSearch.classList.remove('active');
        }
    });


    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024) {
            mobileMenu.classList.remove('active');

            // Close all submenus
            document.querySelectorAll('.mobile-sub').forEach(sub => {
                sub.classList.remove('active');
            });

            document.querySelectorAll('.mobile-toggle').forEach(btn => {
                btn.classList.remove('active');
            });
        }
    });
</script>
<script src="<?= base_url('assets/js/scripts.js') ?>"></script>
<?php $this->load->view('layouts/includes/cookie-popup'); ?>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>