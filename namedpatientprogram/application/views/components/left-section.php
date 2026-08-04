<?php

/**
 * Reusable Text + Image Section Component
 *
 * @param string $title        Section heading
 * @param string $description  Body paragraph text
 * @param string $image_src    Image URL — use base_url('assets/images/...')
 * @param string $image_alt    Alt text for the image
 * @param string $layout       'text-left' (default) | 'text-right'
 * @param string $bg           Tailwind bg class — default 'bg-[#f0f2f8]'
 */

$layout = $layout ?? 'text-left';
$bg = $bg ?? 'bg-[#f0f2f8]';
$image_alt = $image_alt ?? '';
?>

<section class="<?= $bg ?> py-16 px-6">
    <div
        class="max-w-7xl mx-auto flex <?= $layout === 'text-right' ? 'flex-col md:flex-row-reverse' : 'flex-col md:flex-row' ?> items-center gap-8 md:gap-16">

        <!-- Text -->
        <div class="order-2 md:order-1 flex-1 flex flex-col">

            <?php if (!empty($title)): ?>
                <h2 class="order-2 md:order-1 font-playfair text-[2rem] leading-[1.3] font-normal text-[#1a1a2e] mb-6">
                    <?= nl2br($title) ?>
                </h2>
            <?php endif; ?>

            <?php if (!empty($description)): ?>
                <p class="order-3 text-[0.97rem] leading-[1.8] text-[#4a5568]">
                    <?= htmlspecialchars($description) ?>
                </p>
            <?php endif; ?>

        </div>

        <!-- Image -->
        <?php if (!empty($image_src)): ?>
            <div class="order-1 md:order-2 flex-1 w-full overflow-hidden">
                <img src="<?= htmlspecialchars($image_src) ?>" alt="<?= htmlspecialchars($image_alt) ?>"
                    class="w-full h-full object-cover" loading="lazy">
            </div>
        <?php endif; ?>

    </div>
</section>