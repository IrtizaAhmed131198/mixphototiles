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

// var swiper2 = new Swiper(".AboutSliderwel", {
//     slidesPerView: 4,
//     // slidesPerView: 'auto',
//     spaceBetween: 2,
//     breakpoints: {
//         300: {
//             slidesPerView: 2,
//         },
//         550: {
//             slidesPerView: 3,
//         },
//         768: {
//             slidesPerView: 4,
//         },
//         900: {
//             slidesPerView: 3,
//         },
//         1100: {
//             slidesPerView: 4,
//         },
//     }
// });

//  <!-- Initialize Swiper -->

// <!-- Initialize Swiper -->
// var swiper4 = new Swiper(".swiper-horizontal-2", {
//     slidesPerView: 1,
//     spaceBetween: 200,
//     pagination: {
//         el: ".swiper-pagination",
//         clickable: true,
//     },
//     navigation: {
//         nextEl: ".swiper-button-next",
//         prevEl: ".swiper-button-prev",
//     },
// });

// $(document).ready(function () {
//     $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
//         disableOn: 700,
//         type: "iframe",
//         mainClass: "mfp-fade",
//         removalDelay: 160,
//         preloader: false,
//         fixedContentPos: false,
//     });

//     $(".open-popup").on("click", function () {
//         $.magnificPopup.open({
//             items: {
//                 src: "https://youtu.be/uZM7m3XbuPw?si=rDgidUvd-moOxZIX",
//             },
//             type: "iframe",
//         });
//     });
// });

const header = document.querySelector(".scrollheader");
const toggleClass = "is-sticky";

window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;
    if (currentScroll > 150) {
        header.classList.add(toggleClass);
    } else {
        header.classList.remove(toggleClass);
    }
});

window.csrfToken = function () {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute("content") : "";
};

window.safeJson = async function (response) {
    const text = await response.text();
    try {
        return JSON.parse(text);
    } catch (e) {
        console.error("Non-JSON response:", text);
        throw e;
    }
};
