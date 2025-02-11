document.addEventListener('DOMContentLoaded', function () {
    const site2Sliders = document.querySelectorAll('.ydfj43Hfdh347_profile-top-side');
    site2Sliders.forEach((sliderContainer) => {
        const controlsContainer = sliderContainer
            .closest('.ydfj43Hfdh347_profile-grid-item')
            .querySelector('.ydfj43Hfdh347_tns-controls');
        tns({
            container: sliderContainer,
            items: 1,
            slideBy: 'page',
            controls: true,
            controlsContainer: controlsContainer,
            nav: false,
            loop: false,
            autoplay: false,
        });
    });

    const sliders = document.querySelectorAll('.yfg6Ghh54ffj48_profile-top-side');
    sliders.forEach((sliderContainer) => {
        const controlsContainer = sliderContainer
            .closest('.yfg6Ghh54ffj48_profile-grid-item')
            .querySelector('.yfg6Ghh54ffj48_tns-controls');
        tns({
            container: sliderContainer,
            items: 1,
            slideBy: 'page',
            controls: true,
            controlsContainer: controlsContainer,
            nav: false,
            loop: false,
            autoplay: false,
        });
    });
});