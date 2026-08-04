function Util() {}
Util.hasClass = function (el, className) {
  if (el.classList) return el.classList.contains(className);
  else
    return !!el.className.match(new RegExp("(\\s|^)" + className + "(\\s|$)"));
};
Util.addClass = function (el, className) {
  var classList = className.split(" ");
  if (el.classList) el.classList.add(classList[0]);
  else if (!Util.hasClass(el, classList[0])) el.className += " " + classList[0];
  if (classList.length > 1) Util.addClass(el, classList.slice(1).join(" "));
};
Util.removeClass = function (el, className) {
  var classList = className.split(" ");
  if (el.classList) el.classList.remove(classList[0]);
  else if (Util.hasClass(el, classList[0])) {
    var reg = new RegExp("(\\s|^)" + classList[0] + "(\\s|$)");
    el.className = el.className.replace(reg, " ");
  }
  if (classList.length > 1) Util.removeClass(el, classList.slice(1).join(" "));
};
Util.toggleClass = function (el, className, bool) {
  if (bool) Util.addClass(el, className);
  else Util.removeClass(el, className);
};
Util.setAttributes = function (el, attrs) {
  for (var key in attrs) {
    el.setAttribute(key, attrs[key]);
  }
};
Util.getChildrenByClassName = function (el, className) {
  var children = el.children,
    childrenByClass = [];
  for (var i = 0; i < el.children.length; i++) {
    if (Util.hasClass(el.children[i], className))
      childrenByClass.push(el.children[i]);
  }
  return childrenByClass;
};
Util.is = function (elem, selector) {
  if (selector.nodeType) {
    return elem === selector;
  }
  var qa =
      typeof selector === "string"
        ? document.querySelectorAll(selector)
        : selector,
    length = qa.length,
    returnArr = [];
  while (length--) {
    if (qa[length] === elem) {
      return true;
    }
  }
  return false;
};
Util.setHeight = function (start, to, element, duration, cb) {
  var change = to - start,
    currentTime = null;
  var animateHeight = function (timestamp) {
    if (!currentTime) currentTime = timestamp;
    var progress = timestamp - currentTime;
    var val = parseInt((progress / duration) * change + start);
    element.style.height = val + "px";
    if (progress < duration) {
      window.requestAnimationFrame(animateHeight);
    } else {
      cb();
    }
  };
  element.style.height = start + "px";
  window.requestAnimationFrame(animateHeight);
};
Util.scrollTo = function (final, duration, cb) {
  var start = window.scrollY || document.documentElement.scrollTop,
    currentTime = null;
  var animateScroll = function (timestamp) {
    if (!currentTime) currentTime = timestamp;
    var progress = timestamp - currentTime;
    if (progress > duration) progress = duration;
    var val = Math.easeInOutQuad(progress, start, final - start, duration);
    window.scrollTo(0, val);
    if (progress < duration) {
      window.requestAnimationFrame(animateScroll);
    } else {
      cb && cb();
    }
  };
  window.requestAnimationFrame(animateScroll);
};
Util.moveFocus = function (element) {
  if (!element) element = document.getElementsByTagName("body")[0];
  element.focus();
  if (document.activeElement !== element) {
    element.setAttribute("tabindex", "-1");
    element.focus();
  }
};
Util.getIndexInArray = function (array, el) {
  return Array.prototype.indexOf.call(array, el);
};
Util.cssSupports = function (property, value) {
  if ("CSS" in window) {
    return CSS.supports(property, value);
  } else {
    var jsProperty = property.replace(/-([a-z])/g, function (g) {
      return g[1].toUpperCase();
    });
    return jsProperty in document.body.style;
  }
};
Util.extend = function () {
  var extended = {};
  var deep = false;
  var i = 0;
  var length = arguments.length;
  if (Object.prototype.toString.call(arguments[0]) === "[object Boolean]") {
    deep = arguments[0];
    i++;
  }
  var merge = function (obj) {
    for (var prop in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, prop)) {
        if (
          deep &&
          Object.prototype.toString.call(obj[prop]) === "[object Object]"
        ) {
          extended[prop] = extend(true, extended[prop], obj[prop]);
        } else {
          extended[prop] = obj[prop];
        }
      }
    }
  };
  for (; i < length; i++) {
    var obj = arguments[i];
    merge(obj);
  }
  return extended;
};
if (!Element.prototype.matches) {
  Element.prototype.matches =
    Element.prototype.msMatchesSelector ||
    Element.prototype.webkitMatchesSelector;
}
if (!Element.prototype.closest) {
  Element.prototype.closest = function (s) {
    var el = this;
    if (!document.documentElement.contains(el)) return null;
    do {
      if (el.matches(s)) return el;
      el = el.parentElement || el.parentNode;
    } while (el !== null && el.nodeType === 1);
    return null;
  };
}
if (typeof window.CustomEvent !== "function") {
  function CustomEvent(event, params) {
    params = params || {
      bubbles: false,
      cancelable: false,
      detail: undefined,
    };
    var evt = document.createEvent("CustomEvent");
    evt.initCustomEvent(
      event,
      params.bubbles,
      params.cancelable,
      params.detail,
    );
    return evt;
  }
  CustomEvent.prototype = window.Event.prototype;
  window.CustomEvent = CustomEvent;
}
Math.easeInOutQuad = function (t, b, c, d) {
  t /= d / 2;
  if (t < 1) return (c / 2) * t * t + b;
  t--;
  return (-c / 2) * (t * (t - 2) - 1) + b;
};
/**/
(function () {
  var LanguagePicker = function (element) {
    this.element = element;
    this.select = this.element.getElementsByTagName("select")[0];
    this.options = this.select.getElementsByTagName("option");
    this.selectedOption = getSelectedOptionText(this);
    this.pickerId = this.select.getAttribute("id");
    this.trigger = false;
    this.dropdown = false;
    this.firstLanguage = false;
    // dropdown arrow inside the button element
    this.svgPath =
      '<svg viewBox="0 0 16 16"><polygon points="3,5 8,11 13,5 "></polygon></svg>';
    initLanguagePicker(this);
    initLanguagePickerEvents(this);
  };

  function initLanguagePicker(picker) {
    // create the HTML for the custom dropdown element
    picker.element.insertAdjacentHTML(
      "beforeend",
      initButtonPicker(picker) + initListPicker(picker),
    );

    // save picker elements
    picker.dropdown = picker.element.getElementsByClassName(
      "language-picker__dropdown",
    )[0];
    picker.firstLanguage = picker.dropdown.getElementsByClassName(
      "language-picker__item",
    )[0];
    picker.trigger = picker.element.getElementsByClassName(
      "language-picker__button",
    )[0];
  }

  function initLanguagePickerEvents(picker) {
    // make sure to add the icon class to the arrow dropdown inside the button element
    Util.addClass(picker.trigger.getElementsByTagName("svg")[0], "icon");
    // language selection in dropdown
    // ⚠️ Important: you need to modify this function in production
    initLanguageSelection(picker);

    // click events
    picker.trigger.addEventListener("click", function () {
      toggleLanguagePicker(picker, false);
    });
  }

  function toggleLanguagePicker(picker, bool) {
    var ariaExpanded;
    if (bool) {
      ariaExpanded = bool;
    } else {
      ariaExpanded =
        picker.trigger.getAttribute("aria-expanded") == "true"
          ? "false"
          : "true";
    }
    picker.trigger.setAttribute("aria-expanded", ariaExpanded);
    if (ariaExpanded == "true") {
      picker.firstLanguage.focus(); // fallback if transition is not supported
      picker.dropdown.addEventListener("transitionend", function cb() {
        picker.firstLanguage.focus();
        picker.dropdown.removeEventListener("transitionend", cb);
      });
    }
  }

  function checkLanguagePickerClick(picker, target) {
    // if user clicks outside the language picker -> close it
    if (!picker.element.contains(target)) toggleLanguagePicker(picker, "false");
  }

  function moveFocusToPickerTrigger(picker) {
    if (picker.trigger.getAttribute("aria-expanded") == "false") return;
    if (
      document.activeElement.closest(".language-picker__dropdown") ==
      picker.dropdown
    )
      picker.trigger.focus();
  }

  function initButtonPicker(picker) {
    // create the button element -> picker trigger
    // check if we need to add custom classes to the button trigger
    var customClasses = picker.element.getAttribute("data-trigger-class")
      ? " " + picker.element.getAttribute("data-trigger-class")
      : "";

    var button =
      '<button class="language-picker__button' +
      customClasses +
      '" aria-label="' +
      picker.select.value +
      " " +
      picker.element.getElementsByTagName("label")[0].innerText +
      '" aria-expanded="false" aria-contols="' +
      picker.pickerId +
      '-dropdown">';
    button =
      button +
      '<span aria-hidden="true" class="language-picker__label language-picker__flag language-picker__flag--' +
      picker.select.value +
      '"> ' +
      picker.selectedOption +
      " ";
    button = button + picker.svgPath + "</span>";
    return button + "</button>";
  }

  function initListPicker(picker) {
    // create language picker dropdown
    var list =
      '<div class="language-picker__dropdown" aria-describedby="' +
      picker.pickerId +
      '-description" id="' +
      picker.pickerId +
      '-dropdown">';
    list =
      list +
      '<p class="sr-only" id="' +
      picker.pickerId +
      '-description">' +
      picker.element.getElementsByTagName("label")[0].innerText +
      "</p>";
    list = list + '<ul class="language-picker__list" role="listbox">';
    for (var i = 0; i < picker.options.length; i++) {
      var selected = picker.options[i].hasAttribute("selected")
          ? ' aria-selected="true"'
          : "",
        language = picker.options[i].getAttribute("lang");
      list =
        list +
        '<li><a lang="' +
        language +
        '" hreflang="' +
        language +
        '" href="' +
        getLanguageUrl(picker.options[i]) +
        '"' +
        selected +
        ' role="option" data-value="' +
        picker.options[i].value +
        '" class="language-picker__item language-picker__flag language-picker__flag--' +
        picker.options[i].value +
        '"><span>' +
        picker.options[i].text +
        "</span></a></li>";
    }
    return list;
  }

  function getSelectedOptionText(picker) {
    // used to initialize the label of the picker trigger button
    var label = "";
    if ("selectedIndex" in picker.select) {
      label = picker.options[picker.select.selectedIndex].text;
    } else {
      label = picker.select.querySelector("option[selected]").text;
    }
    return label;
  }

  function getLanguageUrl(option) {
    // ⚠️ Important: You should replace this return value with the real link to your website in the selected language
    // option.value gives you the value of the language that you can use to create your real url (e.g, 'english' or 'italiano')
    return "#";
  }

  function initLanguageSelection(picker) {
    picker.element
      .getElementsByClassName("language-picker__list")[0]
      .addEventListener("click", function (event) {
        var language = event.target.closest(".language-picker__item");
        if (!language) return;

        if (
          language.hasAttribute("aria-selected") &&
          language.getAttribute("aria-selected") == "true"
        ) {
          // selecting the same language
          event.preventDefault();
          picker.trigger.setAttribute("aria-expanded", "false"); // hide dropdown
        } else {
          // ⚠️ Important: this 'else' code needs to be removed in production.
          // The user has to be redirected to the new url -> nothing to do here
          event.preventDefault();
          picker.element
            .getElementsByClassName("language-picker__list")[0]
            .querySelector('[aria-selected="true"]')
            .removeAttribute("aria-selected");
          language.setAttribute("aria-selected", "true");
          picker.trigger
            .getElementsByClassName("language-picker__label")[0]
            .setAttribute(
              "class",
              "language-picker__label language-picker__flag language-picker__flag--" +
                language.getAttribute("data-value"),
            );
          picker.trigger
            .getElementsByClassName("language-picker__label")[0]
            .getElementsByTagName("em")[0].innerText = language.innerText;
          picker.trigger.setAttribute("aria-expanded", "false");
        }
      });
  }

  //initialize the LanguagePicker objects
  var languagePicker = document.getElementsByClassName("js-language-picker");
  if (languagePicker.length > 0) {
    var pickerArray = [];
    for (var i = 0; i < languagePicker.length; i++) {
      (function (i) {
        pickerArray.push(new LanguagePicker(languagePicker[i]));
      })(i);
    }

    // listen for key events
    window.addEventListener("keyup", function (event) {
      if (
        (event.keyCode && event.keyCode == 27) ||
        (event.key && event.key.toLowerCase() == "escape")
      ) {
        // close language picker on 'Esc'
        pickerArray.forEach(function (element) {
          moveFocusToPickerTrigger(element); // if focus is within dropdown, move it to dropdown trigger
          toggleLanguagePicker(element, "false"); // close dropdown
        });
      }
    });
    // close language picker when clicking outside it
    window.addEventListener("click", function (event) {
      pickerArray.forEach(function (element) {
        checkLanguagePickerClick(element, event.target);
      });
    });
  }
})();

$(document).ready(function () {
  $("#news-slider").owlCarousel({
    items: 3,
    itemsDesktop: [1199, 3],
    itemsDesktopSmall: [980, 2],
    itemsMobile: [600, 1],
    navigation: false,
    navigationText: ["", ""],
    pagination: true,
    autoPlay: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 3,
      },
    },
  });

  $("#team-carousel").owlCarousel({
    items: 2.5,
    itemsDesktop: [1199, 2.5],
    itemsDesktopSmall: [980, 2],
    itemsMobile: [600, 1],
    navigation: true,
    donts: true,
    nav: true,
    loop: true,
    navText: [
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>',
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>',
    ],
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      980: {
        items: 2,
      },
      1000: {
        items: 2.5,
      },
    },
    navigationText: [
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>',
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>',
    ],
    pagination: true,
    autoPlay: false,
    afterInit: function (elem) {
      $(elem).find(".item:first").addClass("active");
    },
  });

  $("#team-carousel").on(
    "changed.owl.carousel initialized.owl.carousel",
    function (event) {
      $(event.target)
        .find(".item")
        .removeClass("first")
        .eq(event.item.index)
        .addClass("first");
    },
  );

  $("#pagination-carousel").owlCarousel({
    items: 6,
    itemsDesktop: [1199, 6],
    itemsDesktopSmall: [980, 5],
    itemsMobile: [600, 4],
    navigation: true,
    nav: true,
    loop: false,
    touchDrag: false,
    mouseDrag: false, // Disable mouse drag
    touchDrag: false, // Disable touch drag
    responsive: {
      0: {
        items: 4,
      },
      600: {
        items: 4,
      },
      980: {
        items: 5,
      },
      1000: {
        items: 6,
      },
    },
    navText: [
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>',
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>',
    ],
    navigationText: [
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>',
      '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>',
    ],
    pagination: true,
    autoPlay: false,
  });
});

// Experience Strip JS

/*
$(".strip1").hover(function () {
  $(this).removeClass("strip1_active");
});

$(".section3").hover(
  function () {
    $(this)
      .find(".strip1:nth-child(2)")
      .removeClass("strip1_active")
      .bind(
        "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
        function () {
          $(this).find(".strip1:nth-child(2)").removeClass("strip1_active");
        }
      );
  },
  function () {
   
    
    $(this)
      .find(".strip1:nth-child(2)")
      .addClass("strip1_active")
      .bind(
        "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
        function () {
          $(this).find(".strip1:nth-child(2)").addClass("strip1_active");
        }
      );
  }
); */

// Home Our Parters
/*
$(".our_partners_wrapper").hover(
    function () {
      $(this)
        .find(".our_partner_second_section:nth(1)")
        .removeClass("partner_active")
        .bind(
          "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
          function () {
            $(this).find(".our_partner_second_section:nth(1)").removeClass("partner_active");
          }
        );
    },
    function () {
     
      
      $(this)
        .find(".our_partner_second_section:nth(1)")
        .addClass("partner_active")
        .bind(
          "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
          function () {
            $(this).find(".our_partner_second_section:nth(1)").addClass("partner_active");
          }
        );
    }
  );
  
  */

// active siebbar about page

$(function () {
  $(window)
    .scroll(function () {
      var windscroll = $(window).scrollTop();
      if (windscroll >= 100) {
        $(".about-page-section").each(function (i) {
          if ($(this).position().top <= windscroll + 140) {
            $(".about-sidebar-ul li.active").removeClass("active");
            $(".about-sidebar-ul li").eq(i).addClass("active");
          }
        });
      } else {
        $(".about-sidebar-ul li.active").removeClass("active");
        $(".about-sidebar-ul li:first").addClass("active");
      }
    })
    .scroll();

  // dddd
  $(window)
    .scroll(function () {
      var windscroll = $(window).scrollTop();
      if (windscroll >= 100) {
        $(".about-page-section").each(function (i) {
          if ($(this).position().top <= windscroll + 140) {
            $(".about-sidebar-ul li").eq(i).addClass("baractive");
          } else {
            $(".about-sidebar-ul li").eq(i).removeClass("baractive");
          }
        });
      } else {
        $(".about-sidebar-ul li").removeClass("baractive");
        $(".about-sidebar-ul li:first").addClass("baractive");
      }
    })
    .scroll();

  // Active Filters
  $(".filterBTnCard").click(function () {
    $(this).toggleClass("active");
  });

  $("#filterBtn").click(function () {
    $(".filtersContainer").toggleClass("showFilter");
  });

  $(".filter-categories-card-btn").click(function () {
    $(".filtersContainer").removeClass("showFilter");
  });

  // Aboutus Go to Top
  $(".scroll-button").click(function () {
    var targetElementId = $(this).data("target-id");
    if (targetElementId) {
      var targetOffset = $("#" + targetElementId).offset().top - 50;

      $("html, body").animate(
        {
          scrollTop: targetOffset,
        },
        "medium",
      );
    }
  });

  // Doc Flip
  var cards = document.querySelectorAll(".card2-wrapper");

  [...cards].forEach((card) => {
    card.addEventListener("click", function (event) {
      event.stopPropagation(); // Prevent click event from propagating to the document body
      card.classList.toggle("is-flipped");
    });
  });

  // Add a click event listener to the document body
  document.body.addEventListener("click", function () {
    cards.forEach((card) => {
      card.classList.remove("is-flipped");
    });
  });

  // Toggle Menu
  $(".menu-opener").on("click", function (event) {
    event.preventDefault();
    $(this).toggleClass("show");
    $(this).parent().find(".submenu-list").first().toggle(300);

    $(this).parent().siblings().find(".submenu-list").hide(200);
  });
  // Team Owl First child Active
  $(document).ready(function () {
    $(".team-carousel").owlCarousel({
      // Owl Carousel options and configurations
      // ...
      onInitialized: function () {
        $(".owl-carousel")
          .find(".item")
          .removeClass("first-child second-child");
        $(".owl-carousel").find(".item:first-child").addClass("first-child");
      },
      onTranslated: function () {
        $(".owl-carousel")
          .find(".item")
          .removeClass("first-child second-child");
        $(".owl-carousel").find(".item.active:first").addClass("first-child");
        $(".owl-carousel").find(".item.active:eq(1)").addClass("second-child");
      },
    });
  });
  // Resources view All
  $(".viewAllRes").click(function () {
    $(".viewAllResCards").slideToggle(500);
  });
  $(".viewAllRes").on("click", function (event) {
    event.preventDefault();
    $(".viewAllResCards").toggleClass("show");
  });

  // Mobiel Download Dropdown
  $(".mappDropDBtn").click(function () {
    $(".menu-download-contnt-list").slideToggle(500);
  });
  $(".mappDropDBtn").on("click", function (event) {
    event.preventDefault();
    $(".mappDropDBtnLink").toggleClass("active");
    $(".menu-download-content").toggleClass("show");
  });

  //   $('.menu-download-content').click(function() {
  //   $('.menu-download-contnt-list').slideToggle(500);
  // });
  // $('.menu-download-content').on('click', function(event){

  //   event.preventDefault();
  //   $('.menu-download-contnt-list').toggleClass('show');

  //   });

  //

  // Parallax Image
  var $images = $(".parallax-content");
  var window_h = $(window).height();

  $(window).scroll(function () {
    var windowScrollTop = $(window).scrollTop();

    if (windowScrollTop == 0) {
      TweenLite.to($images, 1.2, {
        yPercent: 0,
        ease: Power1.easeOut,
        overwrite: 0,
      });
    } else {
      $images.each(function () {
        var elementOffsetTop = $(this).offset().top,
          element_h = $(this).height(),
          velocity = $(this).data("velocity");

        if (
          windowScrollTop + window_h > elementOffsetTop &&
          windowScrollTop < elementOffsetTop + element_h
        ) {
          //if in view:

          TweenLite.to($(this), 1.2, {
            yPercent:
              ((windowScrollTop + window_h - elementOffsetTop) / window_h) *
              velocity,
            ease: Power1.easeOut,
            overwrite: 0,
          });
        }
      });
    }
  });
  // Filter Toggle
  $(document).ready(function () {
    var $btns = $(".NewsFilterBtn").click(function () {
      if (this.id == "NewsShowAll") {
        $("#NewsParent > div").slideToggle(450);
      } else {
        var $el = $("." + this.id);
        $el.slideToggle(450);
        $("#NewsParent > div").not($el).hide();
      }
      $btns.removeClass("active");
      $(this).addClass("active");
    });
  });
  //  Swiper

  $(document).ready(function () {
    var mySwiper = new Swiper(".swiper", {
      autoHeight: true,
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 20,
        },
        1024: {
          slidesPerView: 2.5,
          spaceBetween: 20,
        },
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      speed: 500,
      direction: "horizontal",
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
      },
      loop: false,
      effect: "slide",
      spaceBetween: 30,
      on: {
        init: function () {
          $(".swiper-pagination-custom .swiper-pagination-switch").removeClass(
            "active",
          );
          $(".swiper-pagination-custom .swiper-pagination-switch")
            .eq(0)
            .addClass("active");
        },
        slideChangeTransitionStart: function () {
          $(".swiper-pagination-custom .swiper-pagination-switch").removeClass(
            "active",
          );
          $(".swiper-pagination-custom .swiper-pagination-switch")
            .eq(mySwiper.realIndex)
            .addClass("active");
        },
      },
    });
    $(".swiper-pagination-custom .swiper-pagination-switch").click(function () {
      mySwiper.slideTo($(this).index());
      $(".swiper-pagination-custom .swiper-pagination-switch").removeClass(
        "active",
      );
      $(this).addClass("active");
    });
  });

  $(".swiper-button-next").hover(function () {
    $(this).removeClass("active");
  });
});

window.addEventListener("load", function () {
  var pageWrapper = document.querySelector("#loader-wrapper");
  if (pageWrapper) {
    pageWrapper.style.display = "none";
  }

  //  $('body').on('click touchstart', function () {
  //       const videoElement = document.getElementsByClassName('exp-video');
  //       if (videoElement.playing) {

  //       }
  //       else {

  //           videoElement.play();
  //       }
  //   });

  //   $('body').on('click touchstart', function () {
  //       const videoElement = document.getElementsByClassName('global-video');
  //       if (videoElement.playing) {

  //       }
  //       else {

  //           videoElement.play();
  //       }
  //   });

  // Language

  $(".language-picker-alignment").click(function () {
    $(this).toggleClass("button-anim");
  });
});
