/* =========================================================
   Ikris Pharma Network – Home Page Scripts
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  /* ── intl-tel-input : Prescription Form ─────────────── */
  var input1 = document.querySelector("#pphone");
  if (input1) {
    window.itiPrescription = window.intlTelInput(input1, {
      initialCountry: "in",
      separateDialCode: true,
      preferredCountries: ["in", "us", "gb", "ae"],
      dropdownContainer: document.body,
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });
  }

  /* ── intl-tel-input : Inquiry Form ──────────────────── */
  var input2 = document.querySelector("#phone");
  if (input2) {
    window.itiInquiry = window.intlTelInput(input2, {
      initialCountry: "in",
      separateDialCode: true,
      preferredCountries: ["in", "us", "gb", "ae"],
      dropdownContainer: document.body,
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });
  }

  /* ── Tracking Form ───────────────────────────────────── */
  var trackingForm = document.getElementById("trackingForm");
  if (trackingForm) {
    trackingForm.addEventListener("submit", function (e) {
      var input = document.getElementById("trackingInput");
      if (!input.value.trim()) {
        e.preventDefault();
        alert("Please enter a tracking number");
        return false;
      }

      var btn = this.querySelector('button[type="submit"]');
      var originalContent = btn.innerHTML;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
      btn.disabled = true;

      setTimeout(function () {
        btn.innerHTML = originalContent;
        btn.disabled = false;
      }, 5000);
    });
  }

  /* ── Prescription Modal ──────────────────────────────── */

  document.addEventListener("keydown", function (e) {
    if (
      e.key === "Escape" &&
      prescriptionModal &&
      prescriptionModal.classList.contains("active")
    ) {
      prescriptionModal.classList.remove("active");
      document.body.style.overflow = "";
    }
  });

  /* ── Medicine Slider ─────────────────────────────────── */
  (function () {
    var slider = document.getElementById("medicineSlider");
    var wrapper = document.getElementById("sliderWrapper");

    if (!slider || !wrapper) return;

    var CARD_W = 256;
    var GAP = 24;
    var STEP = CARD_W + GAP;
    var currentIndex = 0;

    function getVisibleCount() {
      return Math.floor(wrapper.offsetWidth / STEP) || 1;
    }

    function getTotalCards() {
      return slider.querySelectorAll(".slide-card").length;
    }

    function goTo(index) {
      var total = getTotalCards();
      var visible = getVisibleCount();
      var maxIndex = Math.max(0, total - visible);

      currentIndex = Math.max(0, Math.min(index, maxIndex));
      slider.style.transform = "translateX(-" + currentIndex * STEP + "px)";

      var btnPrev = document.getElementById("btnPrev");
      var btnNext = document.getElementById("btnNext");

      if (btnPrev) btnPrev.style.opacity = currentIndex === 0 ? "0.4" : "1";
      if (btnNext)
        btnNext.style.opacity = currentIndex >= maxIndex ? "0.4" : "1";
    }

    window.slideNext = function () {
      goTo(currentIndex + 1);
    };
    window.slidePrev = function () {
      goTo(currentIndex - 1);
    };

    window.addEventListener("resize", function () {
      goTo(currentIndex);
    });

    goTo(0);
  })();

  /* ── Category Slider ─────────────────────────────────── */
  (function () {
    var slider = document.getElementById("categorySlider");
    var wrapper = document.getElementById("categoryWrapper");

    if (!slider || !wrapper) return;

    var CARD_W = 256;
    var GAP = 24;
    var STEP = CARD_W + GAP;
    var currentIndex = 0;

    function getVisibleCount() {
      return Math.floor(wrapper.offsetWidth / STEP) || 1;
    }

    function getTotalCards() {
      return slider.querySelectorAll(".category-card").length;
    }

    function goTo(index) {
      var total = getTotalCards();
      var visible = getVisibleCount();
      var maxIndex = Math.max(0, total - visible);

      currentIndex = Math.max(0, Math.min(index, maxIndex));
      slider.style.transform = "translateX(-" + currentIndex * STEP + "px)";

      var btnPrev = document.getElementById("catBtnPrev");
      var btnNext = document.getElementById("catBtnNext");

      if (btnPrev) btnPrev.style.opacity = currentIndex === 0 ? "0.4" : "1";
      if (btnNext)
        btnNext.style.opacity = currentIndex >= maxIndex ? "0.4" : "1";
    }

    window.slideCatNext = function () {
      goTo(currentIndex + 1);
    };
    window.slideCatPrev = function () {
      goTo(currentIndex - 1);
    };

    window.addEventListener("resize", function () {
      goTo(currentIndex);
    });

    goTo(0);
  })();

  /* ── Prescription Form Validation ───────────────────── */
  var prescriptionForm = document.getElementById("prescriptionForm");
  if (prescriptionForm) {
    prescriptionForm.addEventListener("submit", function (e) {
      var valid = true;

      var name = document.querySelector("input[name='name']");
      var phone = document.querySelector("#pphone");
      var email = document.querySelector("input[name='email']");
      var message = document.querySelector("textarea[name='message']");
      var file = document.querySelector("input[name='prescription']");

      // Clear all errors first
      document
        .querySelectorAll("#prescriptionForm p[id^='error']")
        .forEach(function (el) {
          el.classList.add("hidden");
          el.innerText = "";
        });

      // Name
      var nameRegex = /^[A-Za-z\s]{2,40}$/;
      if (!nameRegex.test(name.value.trim())) {
        showPrescriptionError("error-name", "Enter valid name (letters only)");
        valid = false;
      }

      // Phone (intl-tel-input)
      var iti = window.itiPrescription;
      if (!phone.value.trim()) {
        showPrescriptionError("error-phone", "Phone is required");
        valid = false;
      } else if (!iti || !iti.isValidNumber()) {
        showPrescriptionError("error-phone", "Enter valid phone");
        valid = false;
      } else {
        phone.value = iti.getNumber();
      }

      // Email
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.value.trim())) {
        showPrescriptionError("error-email", "Enter valid email");
        valid = false;
      }

      // Message
      if (message.value.trim().length < 5) {
        showPrescriptionError(
          "error-message",
          "Message must be at least 5 characters",
        );
        valid = false;
      }

      // File (optional but validated if present)
      if (file && file.files.length > 0) {
        var allowed = ["image/jpeg", "image/png", "application/pdf"];
        var fileType = file.files[0].type;
        var fileSize = file.files[0].size / 1024 / 1024;

        if (!allowed.includes(fileType)) {
          showPrescriptionError(
            "error-prescription",
            "Only JPG, PNG, PDF allowed",
          );
          valid = false;
        } else if (fileSize > 5) {
          showPrescriptionError(
            "error-prescription",
            "File must be less than 5MB",
          );
          valid = false;
        }
      }

      if (!valid) e.preventDefault();
    });
  }

  /* ── Inquiry Form Validation ─────────────────────────── */
  var inquiryForm = document.getElementById("inquiryForm");
  if (inquiryForm) {
    inquiryForm.addEventListener("submit", function (e) {
      var isValid = true;

      var nameRegex = /^[A-Za-z\s]{2,40}$/;
      var phoneRegex = /^(\+91[\-\s]?)?[0]?(91)?[6-9]\d{9}$/;
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      var firstName = document.getElementById("first_name");
      var lastName = document.getElementById("last_name");
      var email = document.getElementById("email");
      var phone = document.getElementById("phone");
      var message = document.getElementById("message");

      // Reset errors
      document.querySelectorAll(".text-red-500").forEach(function (el) {
        el.classList.add("hidden");
      });

      function showInquiryError(input, errorEl, msg) {
        input.classList.add("border-red-500");
        errorEl.textContent = msg;
        errorEl.classList.remove("hidden");
      }

      // First name
      if (!firstName.value.trim()) {
        showInquiryError(
          firstName,
          document.getElementById("firstnameError"),
          "First name is required",
        );
        isValid = false;
      } else if (!nameRegex.test(firstName.value.trim())) {
        showInquiryError(
          firstName,
          document.getElementById("firstnameError"),
          "Only letters allowed (2-40 characters)",
        );
        isValid = false;
      }

      // Last name
      if (!lastName.value.trim()) {
        showInquiryError(
          lastName,
          document.getElementById("lastnameError"),
          "Last name is required",
        );
        isValid = false;
      } else if (!nameRegex.test(lastName.value.trim())) {
        showInquiryError(
          lastName,
          document.getElementById("lastnameError"),
          "Only letters allowed (2-40 characters)",
        );
        isValid = false;
      }

      // Email
      if (!email.value.trim()) {
        showInquiryError(
          email,
          document.getElementById("emailError"),
          "Email is required",
        );
        isValid = false;
      } else if (!emailRegex.test(email.value.trim())) {
        showInquiryError(
          email,
          document.getElementById("emailError"),
          "Enter valid email address",
        );
        isValid = false;
      }

      // Phone
      if (!phone.value.trim()) {
        showInquiryError(
          phone,
          document.getElementById("phoneError"),
          "Phone number is required",
        );
        isValid = false;
      } else if (!phoneRegex.test(phone.value.trim())) {
        showInquiryError(
          phone,
          document.getElementById("phoneError"),
          "Enter valid phone number",
        );
        isValid = false;
      }

      // Message
      if (!message.value.trim()) {
        showInquiryError(
          message,
          document.getElementById("messageError"),
          "Message is required",
        );
        isValid = false;
      } else if (message.value.trim().length < 10) {
        showInquiryError(
          message,
          document.getElementById("messageError"),
          "Message must be at least 10 characters",
        );
        isValid = false;
      }

      if (!isValid) e.preventDefault();
    });
  }
});

/* ── FAQ Toggle (global, called from inline onclick) ─────── */
function toggleFaq(id) {
  for (var i = 1; i <= 5; i++) {
    var faq = document.getElementById("faq-" + i);
    var icon = document.getElementById("icon-" + i);

    if (i === id) {
      faq.classList.toggle("hidden");
      icon.textContent = faq.classList.contains("hidden") ? "+" : "-";
    } else {
      faq.classList.add("hidden");
      icon.textContent = "+";
    }
  }
}

/* ── Prescription error helper (used inside DOMContentLoaded scope too) ── */
function showPrescriptionError(id, message) {
  var el = document.getElementById(id);
  if (!el) return;
  el.innerText = message;
  el.classList.remove("hidden");
}

// Rotate

function rotate() {
  const cards = $(".card2");
  const firstCard = cards.first();
  firstCard.fadeOut(300, "linear", function () {
    $(this).appendTo(".timeline-slider-container").hide().fadeIn(300, "linear");
  });
  // Add zoom-in effect
  firstCard.css("transform", "scale(1.05)");
  setTimeout(function () {
    firstCard.css("transform", "");
  }, 300);
}

function rotate2() {
  const cards = $(".card2");
  const lastCard = cards.last();
  lastCard.fadeOut(300, "linear", function () {
    $(this)
      .prependTo(".timeline-slider-container")
      .hide()
      .fadeIn(300, "linear");
  });
  // Add zoom-in effect
  lastCard.css("transform", "scale(1.05)");
  setTimeout(function () {
    lastCard.css("transform", "");
  }, 300);
}
$(".next").click(function () {
  rotate();
});
$(".prev").click(function () {
  rotate2();
});

// List of announcements
const announcements = [
  "Announcement",
  "Title",
  // Add more announcements as needed
];
let index = 0;

function rotateAnnouncement() {
  $("#announcement")
    .fadeOut("slow", function () {
      $(this).text(announcements[index]);
    })
    .fadeIn("slow");
  index = (index + 1) % announcements.length;
}
catlist;
// Rotate announcement every 3 seconds (adjust as needed)
setInterval(rotateAnnouncement, 6000);
