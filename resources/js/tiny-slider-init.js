import { tns } from "tiny-slider/src/tiny-slider";

document.addEventListener("DOMContentLoaded", function () {
    // Homepage Carousel
    const homepageElement = document.querySelector(".HomepageCarousel");
    if (homepageElement) {
        const slider = tns({
            container: ".HomepageCarousel",
            items: 1,
            slideBy: "page",
            autoplay: true,
            controls: false,
            nav: false,
            autoplayButtonOutput: false,
        });

        document
            .querySelector(".HomepageCarouselWrapper .homepage-prev")
            ?.addEventListener("click", () => slider.goTo("prev"));

        document
            .querySelector(".HomepageCarouselWrapper .homepage-next")
            ?.addEventListener("click", () => slider.goTo("next"));
    }

    // Testimoni Carousel
    const testimoniElement = document.querySelector(".TestimoniCarousel");
    if (testimoniElement) {
        const sliderTestimoni = tns({
            container: ".TestimoniCarousel",
            items: 1,
            slideBy: "page",
            autoplay: true,
            controls: false,
            nav: false,
            autoplayButtonOutput: false,
        });

        document
            .querySelector(".TestimoniCarouselWrapper .testimoni-prev")
            ?.addEventListener("click", () => sliderTestimoni.goTo("prev"));

        document
            .querySelector(".TestimoniCarouselWrapper .testimoni-next")
            ?.addEventListener("click", () => sliderTestimoni.goTo("next"));
    }

    // Car Detail Carousel
    const carDetailElement = document.querySelector(".CarDetailCarousel");
    if (carDetailElement) {
        const sliderCarDetail = tns({
            container: ".CarDetailCarousel",
            items: 1,
            slideBy: "page",
            autoplay: true,
            controls: false,
            nav: false,
            autoplayButtonOutput: false,
        });

        document
            .querySelector(".CarDetailWrapper .car-detail-prev")
            ?.addEventListener("click", () => sliderCarDetail.goTo("prev"));

        document
            .querySelector(".CarDetailWrapper .car-detail-next")
            ?.addEventListener("click", () => sliderCarDetail.goTo("next"));
    }
});
