var swiper = new Swiper(".swiper-horizontal", {
    // slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        576: {
            slidesPerView: 2,
            spaceBetween: 15,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1400: {
            slidesPerView: 4,
            spaceBetween: 30,
        },
    },
});

// var swiper = new Swiper(".Images-frame-slider", {
//     slidesPerView: 1,
//     spaceBetween: 30,
//     // navigation: {
//     //     nextEl: ".swiper-button-next",
//     //     prevEl: ".swiper-button-prev",
//     // },
//     breakpoints: {
//         320: {
//             slidesPerView: 1,
//             spaceBetween: 10,
//         },
//         576: {
//             slidesPerView: 1,
//             spaceBetween: 15,
//         },
//         768: {
//             slidesPerView: 1,
//             spaceBetween: 20,
//         },
//         1024: {
//             slidesPerView: 1,
//             spaceBetween: 30,
//         }
//     }
// });

var swiper = new Swiper(".AboutSlider", {
    slidesPerView: 4,
    // slidesPerView: 'auto',
    spaceBetween: 2,
    // breakpoints: {
    //     320: {
    //         slidesPerView: 2,
    //         spaceBetween: 10,
    //     },
    //     576: {
    //         slidesPerView: 2,
    //         spaceBetween: 15,
    //     },
    //     768: {
    //         slidesPerView: 3,
    //         spaceBetween: 20,
    //     },
    //     1024: {
    //         slidesPerView: 4,
    //         spaceBetween: 30,
    //     }
    // }
});

//  <!-- Initialize Swiper -->
var swiper = new Swiper(".mySwiper-grid", {
    slidesPerView: 6,
    grid: {
        rows: 4,
    },
    spaceBetween: 10,
    loop: true,
    speed: 5000, // Duration for a complete slide transition (adjust as needed)
    autoplay: {
        delay: 0, // No delay between transitions for continuous motion
        disableOnInteraction: false,
    },
    freeMode: true, // Enable free mode for fluid sliding
    freeModeMomentum: false, // Disable momentum to maintain a steady pace
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// <!-- Initialize Swiper -->
var swiper = new Swiper(".swiper-horizontal-2", {
    slidesPerView: 1,
    spaceBetween: 200,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

var swiper = new Swiper(".main-banner-slider", {
    effect: "coverflow",
    speed: 1000, // Transition duration in milliseconds for smooth animations
    loop: true,
    centeredSlides: true,
    spaceBetween: 55,
    grabCursor: true,
    slidesPerView: "auto",
    autoplay: {
        delay: 1200,
        disableOnInteraction: false,
    },
    coverflowEffect: {
        rotate: 0,
        stretch: 0,
        depth: 45,
        modifier: 2,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true, // Enables dynamic bullet pagination
    },
});

$(document).ready(function () {
    $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
    });

    $(".open-popup").on("click", function () {
        $.magnificPopup.open({
            items: {
                src: "https://youtu.be/uZM7m3XbuPw?si=rDgidUvd-moOxZIX",
            },
            type: "iframe",
        });
    });
});
