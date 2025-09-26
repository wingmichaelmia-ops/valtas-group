// /assets/js/swiper-init.js

document.addEventListener("DOMContentLoaded", function () {
    const sliders = document.querySelectorAll(".swiper");

    sliders.forEach((slider) => {
        new Swiper(slider, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            grabCursor: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                576: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                },
                1440: {
                    slidesPerView: 4
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    });
});
