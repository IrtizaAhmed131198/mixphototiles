

var swiper1 = new Swiper(".swiper-horizontal", {
    cssMode: true,
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        375: {
            slidesPerView: 1,
        },
        400: {
            slidesPerView: 1,
        },
        500: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 2,
        },
        900: {
            slidesPerView: 3,
        },
    }
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

var swiper2 = new Swiper(".AboutSliderwel", {
    slidesPerView: 4,
    // slidesPerView: 'auto',
    spaceBetween: 2,
    breakpoints: {
        300: {
            slidesPerView: 2,
        },
        550: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 4,
        },
        900: {
            slidesPerView: 3,
        },
        1100: {
            slidesPerView: 4,
        },
    }
});

//  <!-- Initialize Swiper -->
var swiper3 = new Swiper(".mySwiper-grid", {
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
var swiper4 = new Swiper(".swiper-horizontal-2", {
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



var swiper5 = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
        delay: 1200,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
        },
        576: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 3,
        },
        1400: {
            slidesPerView: 4,
        },
    },
});


var swiper6 = new Swiper(".main-banner-slider", {
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
        slidesPerView: 5,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
        // clickable: true,
        dynamicBullets: true, // Enables dynamic bullet pagination
    },
    // breakpoints: {
    //     320: {
    //         slidesPerView: 1,
    //     },
    //     576: {
    //         slidesPerView: 1,
    //     },
    //     576: {
    //         slidesPerView: 1,
    //     },
    //     768: {
    //         slidesPerView: 5,
    //         spaceBetween: 35,
    //     },
    //     1024: {
    //         slidesPerView: 5,
    //         spaceBetween: 55,
    //     },
    //     1400: {
    //         slidesPerView: 5,
    //         spaceBetween: 55,
    //     },
    // },
    breakpoints: {

        500: {
            slidesPerView: 1,
            spaceBetween: 0,
        },
        650: {
            slidesPerView: 4,
            spaceBetween: 40,
        },
        900: {
            slidesPerView: 5,
            spaceBetween: 45,
        },
        1100: {
            slidesPerView: 5,
            spaceBetween: 55,
        },
        1400: {
            slidesPerView: 5,
            spaceBetween: 55,
        },
    }

});


var swiper7 = new Swiper(".frame-layout-slider", {
    slidesPerView: 1,
    spaceBetween: 40,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});


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
