<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ===== PRIMARY META TAGS ===== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>News & Updates | Named Patient Program</title>
    <meta name="description"
        content="Access unapproved and unavailable medicines through a compliant Named Patient Program. Trusted global sourcing, regulatory support, and secure delivery.">
    <meta name="keywords"
        content="Named Patient Program, Named Patient Program India, Named Patient Access Program, Access Unapproved Medicines, Import Unavailable Medicines, Global Medicine Access, Unregistered Medicines India, Early Access Medicines, Patient Access Program">
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

    <!-- Hero section -->
    <section>
        <div class="relative w-full">
            <img src="<?= base_url('assets/images/news/blog.png'); ?>" alt="Named Patient Program"
                class="w-full h-[400px] md:h-[500px] lg:h-[600px] object-cover" />

            <!-- Content Card -->
            <div class="absolute inset-0 flex items-center justify-center md:justify-start md:px-12 lg:px-20">
                <div
                    class="bg-white text-black p-5 md:p-8 rounded-lg shadow-lg w-[90%] max-w-xs h-80 overflow-hidden lg:max-w-lg">
                    <div class="flex flex-wrap items-center gap-3 md:gap-4 mb-4">
                        <a href="#" class="tab active text-blue-600" data-tab="blog">Blog</a>
                        <a href="#" class="tab" data-tab="news">News</a>
                        <a href="#" class="tab" data-tab="articles">Articles</a>
                    </div>

                    <h1 id="hero-title" class="text-xl md:text-3xl font-semibold mb-4">
                        At daybreak of the fifteenth day of my birth
                    </h1>

                    <p id="hero-description" class="text-sm md:text-base text-gray-700">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum est natus qui molestiae.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- All News Section -->
    <section class="py-12 px-4 bg-white">

        <!-- Section Header -->
        <div class="max-w-7xl mx-auto mb-6">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-8">
                Latest Articles
            </h2>

            <!-- Category Filter -->
            <div class="flex flex-wrap gap-3 mb-8">
                <a class="px-4 py-2 rounded-full font-semibold text-sm transition <?= ($selected_category == 'all') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>"
                    href="<?= base_url('news') ?>">
                    All
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a class="px-4 py-2 rounded-full font-semibold text-sm transition <?= ($selected_category == $cat->name) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>"
                        href="<?= base_url('news/category/' . $cat->name) ?>">
                        <?= ucfirst($cat->name) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">

            <?php if (!empty($news)): ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php foreach ($news as $article): ?>

                        <article class="article-card group relative flex flex-col w-[90%] mx-auto">

                            <!-- Image — full width, fixed height -->
                            <div class="h-64 overflow-hidden ">
                                <img src="<?= base_url('assets/images/news/' . $article->image); ?>"
                                    alt="<?= htmlspecialchars($article->name); ?>"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/images/news/default.jpg') ?>';"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>

                            <!-- Overlapping white content box -->
                            <!-- <div class="relative z-10 -mt-10 mx-4 bg-white shadow-md p-5 flex flex-col gap-3 flex-1"> -->
                            <div class="bg-white shadow-lg p-4  -mt-12 relative z-10">

                                <!-- Category -->
                                <!-- <span class="text-xs font-bold uppercase tracking-widest text-blue-600">
                                    <?= htmlspecialchars($article->category_name) ?>
                                </span> -->

                                <!-- Title -->
                                <h3 class="text-lg font-bold text-gray-900 leading-snug line-clamp-2">
                                    <?= htmlspecialchars($article->name); ?>
                                </h3>

                                <!-- Description -->
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-4 flex-1 mb-4">
                                    <?= word_limiter(html_entity_decode(strip_tags($article->description), ENT_QUOTES | ENT_HTML5), 25); ?>
                                </p>

                                <!-- Learn More link -->
                                <a href="<?= base_url(strtolower(str_replace(' ', '-', $article->category_name)) . '/' . $article->slug); ?>"
                                    class="inline-block text-blue-600 underline text-sm font-medium hover:text-blue-800 transition mt-1">
                                    Learn More
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php else: ?>
                <!-- Empty State -->
                <div class="text-center py-20">
                    <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No articles found</h3>
                    <p class="text-gray-500">Check back later for updates in this category.</p>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination -->
        <?php if (!empty($news)): ?>
            <div class="max-w-7xl mx-auto flex justify-end items-center gap-2 mt-12">
                <div class="pagination-wrapper">
                    <?= $this->pagination->create_links(); ?>
                </div>
            </div>
        <?php endif; ?>

    </section>
    <script>
        const tabData = {
            blog: {
                title: "At daybreak of the fifteenth day of my birth",
                description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum est natus qui molestiae. Perspiciatis facere sit amet quod, accusantium placeat."
            },

            news: {
                title: "Latest Healthcare News",
                description: "Stay informed with the latest healthcare updates, medical innovations, and industry news."
            },

            articles: {
                title: "Featured Medical Articles",
                description: "Read expert articles covering healthcare, medicines, and patient care from industry professionals."
            }
        };

        const title = document.getElementById("hero-title");
        const description = document.getElementById("hero-description");
        const tabs = document.querySelectorAll(".tab");

        tabs.forEach(tab => {
            tab.addEventListener("click", function (e) {
                e.preventDefault();

                const data = tabData[this.dataset.tab];

                title.textContent = data.title;
                description.textContent = data.description;

                // Active tab
                tabs.forEach(t => t.classList.remove("text-blue-600", "font-semibold"));
                this.classList.add("text-blue-600", "font-semibold");
            });
        });
    </script>

    <?php $this->load->view('layouts/includes/footer'); ?>
</body>

</html>