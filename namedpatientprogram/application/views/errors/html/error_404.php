<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
</head>

<body>
	<section class="relative min-h-screen overflow-hidden">

		<!-- Background -->
		<div class="absolute inset-0">
			<img src="<?= base_url('assets/images/404.png'); ?>" alt="404 Background"
				class="w-full h-full object-cover">

			<!-- Overlay -->
			<div class="absolute inset-0 bg-black/70"></div>
		</div>

		<!-- Content -->
		<div class="relative z-10 flex min-h-screen items-start lg:items-center py-10 lg:py-0">

			<div class="max-w-7xl mx-auto w-full px-6 lg:px-12">

				<!-- Logo -->
				<a href="<?= base_url() ?>">
					<img src="<?= base_url('assets/images/home/npp_logo.png'); ?>" alt="NPP Logo"
						class="w-28 sm:w-32 lg:w-40 mb-8 lg:mb-12">
				</a>

				<div class="max-w-2xl">

					<!-- Error -->
					<p class="uppercase tracking-[3px] text-white/90 text-xs sm:text-sm mb-4 font-inter">
						ERROR 404 : PAGE NOT FOUND
					</p>

					<!-- Heading -->
					<h1 class="font-playfair text-white text-4xl lg:text-5xl leading-tight mb-6">
						Transforming Patients's Lives
						<br class="hidden sm:block">
						Through Networking
					</h1>

					<!-- Description -->
					<p class="text-white/90 text-xl leading-7 lg:leading-8 font-inter mb-5">
						Return to the homepage or contact our team if you need
						further assistance. It appears that the page you are
						looking for has been moved or no longer exists.
					</p>

					<p class="text-white/90 text-xl leading-7 lg:leading-8 font-inter">
						If you require immediate help or have specific inquiries,
						please feel free to reach out to us:
					</p>

					<!-- Contact -->
					<div class="mt-8 space-y-4 text-white">

						<div class="flex items-start gap-3">
							<span class="mt-1">•</span>
							<span class="break-all text-lg lg:break-normal">
								Email: info@namedpatientprogram.com
							</span>
						</div>

						<div class="flex items-start gap-3">
							<span class="mt-1">•</span>
							<span class="text-lg">
								Phone: +91 79824 46645
							</span>
						</div>

					</div>

					<!-- Button -->
					<div class="mt-10 lg:mt-12">
						<a href="<?= base_url(); ?>"
							class="inline-flex w-full sm:w-auto justify-center items-center rounded-lg bg-[#3568E8] px-8 py-4 text-white font-semibold hover:bg-[#2956cb] transition duration-300">

							Back to Home

						</a>
					</div>

				</div>

			</div>

		</div>

	</section>

</body>

</html>