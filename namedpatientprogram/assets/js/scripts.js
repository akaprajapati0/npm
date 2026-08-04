/* =========================================================
   Ikris Pharma Network – Header Scripts (fixed)
   ========================================================= */
//  FAQ Js
function toggleFaq(id) {
  const content = document.getElementById(`faq-${id}`);
  const icon = document.getElementById(`icon-${id}`);
  content.classList.toggle("hidden");
  icon.textContent = content.classList.contains("hidden") ? "+" : "−";
}

document.addEventListener("DOMContentLoaded", function () {
  /* ============================================================
       SEARCH BAR TOGGLE (mobile dropdown panel)
       NOTE: This is the ONLY place searchToggle is wired up.
       Do not add a second `.onclick =` assignment anywhere else,
       or clicks will fire twice and cancel each other out.
    ============================================================ */
  const searchToggle = document.getElementById("searchToggle");
  const headerSearch = document.getElementById("headerSearch");
  const translateDropdown = document.getElementById("translateDropdown");

  searchToggle?.addEventListener("click", function (e) {
    e.stopPropagation();
    translateDropdown?.classList.add("hidden"); // close translate if open
    headerSearch?.classList.toggle("active");
  });

  document.addEventListener("click", function (e) {
    if (
      headerSearch?.classList.contains("active") &&
      !headerSearch.contains(e.target) &&
      e.target !== searchToggle
    ) {
      headerSearch.classList.remove("active");
    }
  });

  /* ============================================================
       TRANSLATE DROPDOWN
       NOTE: Only defined once, here. toggleTranslateDropdown and
       selectLanguage are exposed on window since they're called
       via inline onclick="" in the HTML.
    ============================================================ */
  window.toggleTranslateDropdown = function (e) {
    e.stopPropagation();
    headerSearch?.classList.remove("active"); // close search if open
    translateDropdown?.classList.toggle("hidden");
  };

  document.addEventListener("click", function (e) {
    const wrapper = document.getElementById("translateWrapper");
    if (
      wrapper &&
      !wrapper.contains(e.target) &&
      !translateDropdown.classList.contains("hidden")
    ) {
      translateDropdown.classList.add("hidden");
    }
  });

  window.selectLanguage = function (lang) {
    const combo = document.querySelector(".goog-te-combo");
    if (combo) {
      combo.value = lang;
      combo.dispatchEvent(new Event("change"));
    }
    translateDropdown?.classList.add("hidden");
  };

  /* ============================================================
       MOBILE MENU OPEN / CLOSE
    ============================================================ */
  const mobileBtn = document.getElementById("mobileBtn");
  const closeMobile = document.getElementById("closeMobile");
  const mobileMenu = document.getElementById("mobileMenu");
  const mobileMenuOverlay = document.getElementById("mobileMenuOverlay");

  function openMobileMenu() {
    mobileMenu.classList.remove("translate-x-full");
    mobileMenu.classList.add("translate-x-0");
    mobileMenuOverlay.classList.remove("opacity-0", "invisible");
    mobileMenuOverlay.classList.add("opacity-100", "visible");
    document.body.style.overflow = "hidden";
  }

  function closeMobileMenuFn() {
    mobileMenu.classList.add("translate-x-full");
    mobileMenu.classList.remove("translate-x-0");
    mobileMenuOverlay.classList.add("opacity-0", "invisible");
    mobileMenuOverlay.classList.remove("opacity-100", "visible");
    document.body.style.overflow = "";
  }

  mobileBtn?.addEventListener("click", openMobileMenu);
  closeMobile?.addEventListener("click", closeMobileMenuFn);
  mobileMenuOverlay?.addEventListener("click", closeMobileMenuFn);

  /* ============================================================
       MOBILE MENU TAB SWITCH (Menu / Account)
    ============================================================ */
  window.switchMobileTab = function (tab) {
    const tabButtons = document.querySelectorAll(".mobile-tab-btn");
    const menuPanel = document.getElementById("mobileTabMenu");
    const accountPanel = document.getElementById("mobileTabAccount");

    tabButtons.forEach((btn) => {
      const isActive = btn.dataset.tab === tab;
      btn.classList.toggle("bg-white", isActive);
      btn.classList.toggle("bg-gray-100", !isActive);
      btn.classList.toggle("text-gray-900", isActive);
      btn.classList.toggle("font-semibold", isActive);
      btn.classList.toggle("text-gray-400", !isActive);
      btn.classList.toggle("font-medium", !isActive);
      btn.classList.toggle("border-b-2", isActive);
      btn.classList.toggle("border-[#2F336E]", isActive);
      btn.classList.toggle("border-b", !isActive);
      btn.classList.toggle("border-gray-200", !isActive);
    });

    menuPanel.classList.toggle("hidden", tab !== "menu");
    menuPanel.classList.toggle("block", tab === "menu");
    accountPanel.classList.toggle("hidden", tab !== "account");
    accountPanel.classList.toggle("block", tab === "account");
  };

  /* ============================================================
       MOBILE ACCORDION (Therapeutics / Compliance / Resources)
    ============================================================ */
  window.toggleMobileSub = function (btn) {
    const sub = btn.nextElementSibling;
    const icon = btn.querySelector(".fa-chevron-down");
    const isOpen = !sub.classList.contains("hidden");

    const panel = btn.closest(".mobile-tab-panel");
    panel.querySelectorAll(".mobile-sub").forEach((s) => {
      if (s !== sub) s.classList.add("hidden");
    });
    panel.querySelectorAll(".mobile-toggle .fa-chevron-down").forEach((i) => {
      if (i !== icon) i.classList.remove("rotate-180");
    });

    sub.classList.toggle("hidden", isOpen);
    icon.classList.toggle("rotate-180", !isOpen);
  };

  // ============================================================ */
  const LIVE_SEARCH_URL = "<?= site_url('medicine/live-search') ?>"; // adjust if needed
  let searchDebounce;

  function wireLiveSearch(inputId, resultsId) {
    const input = document.getElementById(inputId);
    const results = document.getElementById(resultsId);
    if (!input || !results) return;

    input.addEventListener("input", function () {
      const query = this.value.trim();

      clearTimeout(searchDebounce);

      if (query.length < 2) {
        results.classList.add("hidden");
        results.innerHTML = "";
        return;
      }

      searchDebounce = setTimeout(() => {
        fetch(`${LIVE_SEARCH_URL}?q=${encodeURIComponent(query)}`, {
          headers: { "X-Requested-With": "XMLHttpRequest" },
        })
          .then((res) => res.json())
          .then((data) => {
            if (!Array.isArray(data) || data.length === 0) {
              results.innerHTML = `<div class="px-4 py-3 text-sm text-gray-500">No medicines found</div>`;
              results.classList.remove("hidden");
              return;
            }

            results.innerHTML = data
              .map(
                (item) => `
                  <a href="${item.url}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 border-b border-gray-100 last:border-b-0">
                    ${item.name}
                  </a>`,
              )
              .join("");

            results.classList.remove("hidden");
          })
          .catch((err) => {
            console.error("Live search error:", err);
            results.classList.add("hidden");
          });
      }, 300); // debounce delay
    });
  }

  // Wire both search boxes to the same live-search logic
  wireLiveSearch("searchInput", "searchResults"); // Desktop dropdown panel
  wireLiveSearch("searchInputMobile", "searchResultsMobile"); // mobile dropdown panel

  // Close any open results dropdown when clicking outside it
  document.addEventListener("click", function (e) {
    const searchResults = document.getElementById("searchResults");
    const searchResultsMobile = document.getElementById("searchResultsMobile");

    if (
      searchResults &&
      !searchResults.contains(e.target) &&
      e.target.id !== "searchInput"
    ) {
      searchResults.classList.add("hidden");
    }
    if (
      searchResults &&
      !searchResults.contains(e.target) &&
      e.target.id !== "searchInput"
    ) {
      searchResults.classList.add("hidden");
    }
    if (
      searchResultsMobile &&
      !searchResultsMobile.contains(e.target) &&
      e.target.id !== "searchInputMobile"
    ) {
      searchResultsMobile.classList.add("hidden");
    }
  });
});

/* ── Google Translate init (called by Google's script tag) ─────────── */
function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    { pageLanguage: "en", autoDisplay: false },
    "google_translate_element",
  );
}
