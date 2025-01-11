const sliderContainer = document.querySelector('.testimonial-slider-container'); 
const dots = document.querySelectorAll('.pagination-dots .dot');
let currentIndex = 0;

document.querySelector('.slider-btn-next').addEventListener('click', () => {
  if (currentIndex < dots.length - 1) currentIndex++;
  updateSlider();
});

document.querySelector('.slider-btn-prev').addEventListener('click', () => {
  if (currentIndex > 0) currentIndex--;
  updateSlider();
});

dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    currentIndex = index;
    updateSlider();
  });
});

function updateSlider() {
  sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
  dots.forEach(dot => dot.classList.remove('active'));
  dots[currentIndex].classList.add('active');
}