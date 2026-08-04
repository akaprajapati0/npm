<!-- Reusable Banner -->
<div class="w-full">
    <div class="relative min-h-[240px] bg-cover bg-center bg-right-bottom bg-no-repeat flex items-center"
        style="background-image: url('<?= !empty($backgroundImage) ? base_url($backgroundImage) : base_url('assets/images/default-banner.jpg') ?>'); background-repeat: no-repeat; background-position: center;">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-[#001F60]/50"></div>

        <!-- Content -->
        <div class="relative w-full max-w-7xl mx-auto px-6 sm:px-10 md:px-16 lg:px-24 xl:px-56">
            <h1 class="text-white font-bold text-2xl sm:text-3xl md:text-4xl lg:text-5xl">
                <?= $title ?>
            </h1>
        </div>

    </div>
</div>

<!-- Usages -->
<?php
// $data['title'] = "Home";
// $data['backgroundImage'] = "assets/images/home-banner.jpg";

// $this->load->view('frontend/includes/banner', $data);
?>