<!-- Breadcrumb Navigation -->
<?php if (!empty($breadcrumb)): ?>
<nav class="bg-gray-50 border-b border-gray-200 py-4 px-4">
    <div class="max-w-7xl mx-auto">
        <ol class="flex flex-wrap items-center gap-2 text-sm">
            <li>
                <a href="<?= base_url(); ?>" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
            </li>
            
            <?php foreach ($breadcrumb as $index => $crumb): ?>
           
            <li class="flex items-center gap-2">
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <?php if ($index === count($breadcrumb) - 1): ?>
                <span class="text-gray-900 font-medium">
                    <?= htmlspecialchars($crumb->page_name) ?>
                </span>
                <?php else: ?>
                <?php if (!empty($crumb->slug) && $crumb->node_type === 'page'): ?>
                <a href="<?= site_url($crumb->slug) ?>"
                    class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <?= htmlspecialchars($crumb->page_name) ?>
                </a>
                <?php else: ?>
                <span class="text-gray-600"><a href="<?= site_url($crumb->slug) ?>"
                    class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    <?= htmlspecialchars($crumb->page_name) ?></a>
                </span>
                <?php endif; ?>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
<?php endif; ?>

<!-- Hero Section -->
<section class="py-12 md:py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

            <!-- Text Content -->
            <div class="space-y-6 order-2 lg:order-1">
                <?php if (!empty($page->hero_title)): ?>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    <?= htmlspecialchars($page->hero_title); ?>
                </h1>
                <?php else: ?>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    <?= htmlspecialchars($page->page_name); ?>
                </h1>
                <?php endif; ?>

                <?php if (!empty($page->hero_description)): ?>
                <div class="text-lg text-gray-600 leading-relaxed prose max-w-none"
                style="font-family: 'Merriweather', serif; font-size: 10pt;"
                >
                    <?= $page->hero_description; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($page->cta_text) && !empty($page->cta_url)): ?>
                <div class="pt-4">
                    <a href="<?= base_url().'#inquiry-section'; ?>"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors duration-200 shadow-sm hover:shadow-md">
                        <?= htmlspecialchars($page->cta_text); ?>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <?php if (!empty($page->hero_image)): ?>
            <div class="order-1 lg:order-2">
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <img src="<?= base_url('assets/images/cms/' . $page->hero_image); ?>"
                        alt="<?= htmlspecialchars($page->page_name); ?>" class="w-full h-auto object-cover">
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Main Content -->
<?php if (!empty($page->content_description)): ?>
<section class="py-6 md:py-6 px-4 bg-gray-50">
    <div class="max-w-8xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm p-8 md:p-12 border border-gray-100">
            <div class="cms-content prose prose-lg max-w-none">
                <?= $page->content_description; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Child Pages Section -->
<?php if (!empty($child_pages)): ?>
<section class="py-16 md:py-24 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Related Content</h2>
            <p class="text-lg text-gray-600">Explore more topics and resources</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($child_pages as $child): ?>
            <?php if ($child->node_type === 'page'): ?>
            <a href="<?= site_url('page/' . $child->slug); ?>"
                class="group bg-white rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-200 overflow-hidden">

                <?php if (!empty($child->hero_image)): ?>
                <div class="h-48 overflow-hidden bg-gray-100">
                    <img src="<?= base_url('assets/images/cms/' . $child->hero_image); ?>"
                        alt="<?= htmlspecialchars($child->page_name); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <?php else: ?>
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-file-alt text-5xl text-gray-300"></i>
                </div>
                <?php endif; ?>

                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                        <?= htmlspecialchars($child->page_name); ?>
                    </h3>

                    <?php if (!empty($child->hero_description)): ?>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?= strip_tags($child->hero_description); ?>
                    </p>
                    <?php endif; ?>

                    <div class="flex items-center gap-2 text-blue-600 font-medium text-sm">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


 <?php if (!empty($medicines)): ?>
<section class="bg-gray-50 py-16 md:py-24 px-4">
<div class="max-w-7xl mx-auto">

   
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            <?= $medicines[0]->category_name ?? '' ?>
        </h2>
    </div>

   
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        <?php if (!empty($medicines)): ?>
            <?php foreach ($medicines as $med): ?>

            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-6 text-center">

               
                <div class="w-full h-44 bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">

                    <?php if (!empty($med->image)): ?>
                        <img src="<?= base_url('assets/images/medicines/'.$med->image); ?>"
                             class="max-w-full max-h-full object-contain">
                    <?php else: ?>
                        <img src="<?= base_url('assets/images/medicine-placeholder.png'); ?>"
                             class="max-w-full max-h-full object-contain">
                    <?php endif; ?>

                </div>

                
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                     <a href="<?= base_url('m/' . strtolower($medicines[0]->category_name) . '/' . strtolower($med->name)); ?>"
                    class="text-blue-600 hover:text-blue-800 font-medium">
                   <?= htmlspecialchars($med->name); ?>
                    </a>
                    
                </h4>

               
               

            </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>

   
    <div class="mt-10 flex justify-center">
        <?= $pagination ?>
    </div>

</div>
</section>
<?php endif; ?> 


<style>

     #sliderWrapper {
            overflow: hidden;
            width: 100%;
        }

        #medicineSlider {
            display: flex;
            gap: 24px;
            transition: transform 0.4s ease;
            will-change: transform;
        }

        #medicineSlider .slide-card {
            flex: 0 0 256px;
            /* w-64 = 16rem = 256px */
            width: 256px;
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 500px;
            }

            .modal-content {
                margin: 10px;
            }

            #medicineSlider .slide-card {
                flex: 0 0 220px;
                width: 220px;
            }
        }
/* CMS Content Styling */
.cms-content {
    color: #374151;
    line-height: 1.75;
}

.cms-content h1,
.cms-content h2,
.cms-content h3,
.cms-content h4,
.cms-content h5,
.cms-content h6 {
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #111827;
}

.cms-content h1 {
    font-size: 2.25rem;
    line-height: 1.2;
}

.cms-content h2 {
    font-size: 1.875rem;
    line-height: 1.3;
}

.cms-content h3 {
    font-size: 1.5rem;
    line-height: 1.4;
}

.cms-content h4 {
    font-size: 1.25rem;
}

.cms-content p {
    margin-bottom: 1.25rem;
}

.cms-content ul,
.cms-content ol {
    margin-left: 1.5rem;
    margin-bottom: 1.25rem;
    padding-left: 0.5rem;
}

.cms-content li {
    margin-bottom: 0.5rem;
}

.cms-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.cms-content a {
    color: #2563eb;
    text-decoration: underline;
    transition: color 0.2s;
}

.cms-content a:hover {
    color: #1d4ed8;
}

.cms-content blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1.25rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    font-style: italic;
    color: #4b5563;
    margin: 1.5rem 0;
    background: #f9fafb;
    border-radius: 0 0.375rem 0.375rem 0;
}

.cms-content code {
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: monospace;
    font-size: 0.875rem;
    color: #dc2626;
}

.cms-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    overflow: hidden;
}

.cms-content th {
    background: #f9fafb;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
}

.cms-content td {
    padding: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
}

.cms-content tr:last-child td {
    border-bottom: none;
}

.cms-content strong {
    font-weight: 700;
}

.cms-content hr {
    border: none;
    height: 1px;
    background: #e5e7eb;
    margin: 2rem 0;
}

/* Line clamp utility */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cms-content h1 {
        font-size: 1.875rem;
    }

    .cms-content h2 {
        font-size: 1.5rem;
    }

    .cms-content h3 {
        font-size: 1.25rem;
    }
}
</style>





<script>
      (function() {
            const slider = document.getElementById('medicineSlider');
            const wrapper = document.getElementById('sliderWrapper');
            const CARD_W = 256; // matches CSS flex-basis (w-64)
            const GAP = 24;
            const STEP = CARD_W + GAP;

            let currentIndex = 0;

            function getVisibleCount() {
                return Math.floor(wrapper.offsetWidth / STEP) || 1;
            }

            function getTotalCards() {
                return slider.querySelectorAll('.slide-card').length;
            }

            function goTo(index) {
                const total = getTotalCards();
                const visible = getVisibleCount();
                const maxIndex = Math.max(0, total - visible);

                currentIndex = Math.max(0, Math.min(index, maxIndex));
                slider.style.transform = 'translateX(-' + (currentIndex * STEP) + 'px)';

                // Button states
                document.getElementById('btnPrev').style.opacity = currentIndex === 0 ? '0.4' : '1';
                document.getElementById('btnNext').style.opacity = currentIndex >= maxIndex ? '0.4' : '1';
            }

            window.slideNext = function() {
                goTo(currentIndex + 1);
            };
            window.slidePrev = function() {
                goTo(currentIndex - 1);
            };

            // Recalculate on resize
            window.addEventListener('resize', function() {
                goTo(currentIndex);
            });

            // Init
            goTo(0);
        })();
</script>