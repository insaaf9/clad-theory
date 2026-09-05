document.addEventListener('DOMContentLoaded', function () {
    const slides = Array.from(document.querySelectorAll('.hero__slide'));
    const prevButton = document.querySelector('[data-direction="prev"]');
    const nextButton = document.querySelector('[data-direction="next"]');
    const numberEl = document.querySelector('.hero__number');
    const eyebrowEl = document.querySelector('.hero__eyebrow');
    const titleEl = document.querySelector('.hero__title');
    const countEl = document.querySelector('.hero__count');
    const linkEl = document.querySelector('.hero__link');
    const linkTextEl = document.querySelector('.hero__link-text');
    const hero = document.querySelector('.hero');

    if (!slides.length) return;

    let currentIndex = 0;
    let wheelLocked = false;

    function showSlide(index) {
        currentIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle('is-active', slideIndex === currentIndex);
        });

        const activeSlide = slides[currentIndex];
        const number = activeSlide.dataset.number || currentIndex + 1;
        const count = activeSlide.dataset.total || slides.length;

        if (numberEl) {
            numberEl.textContent = number;
        }

        if (countEl) {
            countEl.textContent = '/' + count;
        }

        if (eyebrowEl) {
            eyebrowEl.textContent = activeSlide.dataset.eyebrow || 'Design';
        }

        if (titleEl) {
            titleEl.textContent = activeSlide.dataset.title || 'Project';
        }

        if (linkEl && activeSlide.dataset.link) {
            linkEl.setAttribute('href', activeSlide.dataset.link);
        }

        if (linkTextEl && activeSlide.dataset.linkText) {
            linkTextEl.textContent = activeSlide.dataset.linkText;
        }
    }

    prevButton?.addEventListener('click', function () {
        showSlide(currentIndex - 1);
    });

    nextButton?.addEventListener('click', function () {
        showSlide(currentIndex + 1);
    });

    hero?.addEventListener('wheel', function (event) {
        const delta = event.deltaY || event.wheelDelta || 0;

        if (wheelLocked) {
            return;
        }

        if (Math.abs(delta) < 1) {
            return;
        }

        event.preventDefault();
        wheelLocked = true;

        if (delta > 0) {
            showSlide(currentIndex + 1);
        } else {
            showSlide(currentIndex - 1);
        }

        setTimeout(function () {
            wheelLocked = false;
        }, 700);
    }, { passive: false });

    setInterval(function () {
        showSlide(currentIndex + 1);
    }, 5000);

    showSlide(0);
});
