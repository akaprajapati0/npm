<?php
$ci_cookie = $this->input->cookie('cookie_consent');
if (!$ci_cookie):
?>

<div id="cookie-popup" class="fixed bottom-0 left-0 right-0
    backdrop-blur-md bg-gray-800
    px-4 sm:px-6 lg:px-8 py-4
    w-full z-[9999] text-white shadow-lg">

    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- TEXT -->
        <p class="text-sm sm:text-base leading-relaxed text-gray-200">
            Cookies are small text files stored on your device when you visit a website.
            They help websites function smoothly, improve performance, and provide
            insights into how users interact with digital services.
        </p>

        <!-- BUTTONS -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 sm:justify-end">
            <button id="acceptCookies" class="accept-cookie-btn">Accept</button>
            <button id="rejectCookies" class="reject-cookie-btn">Reject</button>
        </div>

    </div>
</div>

<?php endif; ?>

<script>
const cookiePopup = document.getElementById('cookie-popup');
const acceptBtn = document.getElementById('acceptCookies');
const rejectBtn = document.getElementById('rejectCookies');

const userCookieChoice = localStorage.getItem('cookie_consent');

if (!userCookieChoice) {
    cookiePopup.style.display = "block";
}

function hidePopup() {
    cookiePopup.style.opacity = "0";
    setTimeout(() => cookiePopup.style.display = "none", 300);
}

acceptBtn.addEventListener('click', () => {
    fetch("<?= site_url('cookies/accept') ?>")
        .then(() => {
            localStorage.setItem('cookie_consent', 'accepted');
            hidePopup();
        });
});

rejectBtn.addEventListener('click', () => {
    window.location.href = "<?= site_url('privacy-policy') ?>";
});
</script>