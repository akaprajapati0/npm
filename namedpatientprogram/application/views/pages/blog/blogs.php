<?php $this->load->view('layouts/includes/header'); ?>

<?php
$articles = [
    [
        'title' => 'The Sunset In the East',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
        'image' => base_url('assets/images/news/0bb907963ba2b98c01227ef94d203433.png'),
        'slug' => 'the-sunset-in-the-east',
    ],
    [
        'title' => 'Exploring New Horizons',
        'description' => 'Discover amazing destinations around the world. Lorem ipsum dolor sit amet consectetur adipisicing elit.',
        'image' => base_url('assets/img/blog-hero.svg'),
        'slug' => 'exploring-new-horizons',
    ],
    [
        'title' => 'Healthcare Innovation',
        'description' => 'How technology is changing patient care.',
        'image' => base_url('assets/img/blog-hero.svg'),
        'slug' => 'healthcare-innovation',
    ],
];
?>

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
                    <a href="/blog" class="font-normal hover:text-blue-600">
                        Blog
                    </a>
                    <a href="/blog" class="font-normal hover:text-blue-600">
                        News
                    </a>
                    <a href="/blog" class="font-normal hover:text-blue-600">
                        Articles
                    </a>
                </div>

                <h1 class="text-xl md:text-3xl font-semibold mb-4">
                    At daybreak of the fifteenth day of my birth
                </h1>

                <p class="text-sm md:text-base text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Cum est natus qui molestiae. Perspiciatis facere sit amet
                    quod, accusantium placeat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Article section -->
<section class="py-12 px-4">

    <h2 class="text-3xl font-bold mb-8">
        Latest Articles
    </h2>

    <div class="container mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 ">

            <?php foreach ($articles as $article): ?>
                <article class="group max-w-md">

                    <div class="overflow-hidden">
                        <img src="<?= $article['image']; ?>" alt="<?= htmlspecialchars($article['title']); ?>"
                            class="w-full h-64 object-cover">
                    </div>

                    <div class="">
                        <div class="bg-white shadow-lg p-3 -mt-12 relative z-10 w-[90%] space-y-3 h-52 overflow-hidden">

                            <h3 class="text-xl font-semibold">
                                <?= htmlspecialchars($article['title']); ?>
                            </h3>

                            <p class="text-sm font-normal line-clamp-3">
                                <?= htmlspecialchars($article['description']); ?>
                            </p>
                            <!-- <?= $article['slug']; ?> -->

                            <a href="blog-detail" class="inline-block text-[#2B00FF] underline">
                                Read More
                            </a>

                        </div>
                    </div>

                </article>
            <?php endforeach; ?>

        </div>
    </div>
    <div class="flex justify-end items-center gap-2 mt-10">
        <?php
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $totalPages = 4; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="w-10 h-10 flex items-center justify-center border rounded-md
                <?= $currentPage == $i
                    ? 'bg-blue-600 text-white border-blue-600'
                    : 'border-gray-300 hover:bg-gray-100' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>"
                class="px-4 h-10 flex items-center justify-center border border-gray-300 rounded-md hover:bg-gray-100">Next
            </a>
        <?php endif; ?>
    </div>
</section>



<?php $this->load->view('layouts/includes/footer'); ?>