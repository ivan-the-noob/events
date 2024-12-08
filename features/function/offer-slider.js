document.addEventListener('DOMContentLoaded', function () {
    const sliderWrapper = document.querySelector('.slider-wrapper');
    const sliderItems = document.querySelectorAll('.review-item');
    const prevButton = document.querySelector('.slider-btn-prev');
    const nextButton = document.querySelector('.slider-btn-next');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = sliderItems.length;

    let currentIndex = 0;

    function updateSlider() {
        // Adjust the translation percentage for each item width (100% in this case)
        sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;

        sliderItems.forEach(item => item.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        sliderItems[currentIndex].classList.add('active');
        dots[currentIndex].classList.add('active');
    }

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalSlides; 
        updateSlider();
    });

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; 
        updateSlider();
    });

    // Update dots based on the current index
    updateSlider();
});
