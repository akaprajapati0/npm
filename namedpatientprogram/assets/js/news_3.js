(function ($) {
    "use strict";
/*--
    Menu Sticky
-----------------------------------*/
  
/*-- 
    Breaking News Ticker
--------------------------------------------*/
$('.breaking-news-ticker').newsTicker({
    row_height: 40,
    max_rows: 1,
    speed: 600,
    duration: 6000, 
    prevButton:  $('.news-ticker-prev'),
    nextButton:  $('.news-ticker-next'),

    
});


jQuery(document).ready(function ($) {
    let count = $(".ticker-count li").length;
    $(".tickerTotal").text(count);
    
});

jQuery(document).ready(function ($) {
    let count = $(".ticker-count li").length;
    $(".tickerTotal").text(count);

    let currentNumber = parseInt($("#startN").text());

    $(".news-ticker-prev").on("click", function () {
        if (currentNumber > 1) {
            currentNumber--;
            updateNumber();
        }
    });

    $(".news-ticker-next").on("click", function () {
        if (currentNumber < count) {
            currentNumber++;
            updateNumber();
        }else{
            currentNumber=0
        }
    });

    function updateNumber() {
        $("#startN").text(currentNumber);
    }
});

jQuery(document).ready(function ($) {
    let count = $(".ticker-count li").length;
    $(".tickerTotal").text(count);

    let currentNumber = parseInt($("#startN").text());

    
    setInterval(function () {
        if (currentNumber < count) {
            currentNumber++;
        } else {
            currentNumber = 1; // Reset to the first number when reaching the end
        }
        updateNumber();
    }, 6000); // Change every 3 seconds, you can adjust this interval

    function updateNumber() {
        $("#startN").text(currentNumber);
    }
});


// jQuery(document).ready(function ($) {
//     let count = $(".ticker-count li").length;
//     $(".tickerTotal").text(count);

//     let currentNumber = parseInt($("#startN").text());
//     let interval;

    
//     interval = setInterval(function () {
//         if (currentNumber < count) {
//             currentNumber++;
//         } else {
//             currentNumber = 1; // Reset to the first number when reaching the end
//         }
//         updateNumber();
//     }, 5000); 
//     $(".news-ticker-prev").on("click", function () {
//         clearInterval(interval); // Stop automatic changes when manual click
//         if (currentNumber > 1) {
//             currentNumber--;
//             updateNumber();
//         }
//     });

//     $(".news-ticker-next").on("click", function () {
//         clearInterval(interval); // Stop automatic changes when manual click
//         if (currentNumber < count) {
//             currentNumber++;
            
//             updateNumber();
//         }
//     });

//     function updateNumber() {
//         $("#startN").text(currentNumber);
//     }
// });

    
/*--
    Slick Slider
-----------------------------------*/
    
})(jQuery);	