<?php
$pageTitle = 'Clad Theory';
$bodyClass = 'home-page';
$currentPage = 'home';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<main class="hero" aria-label="Hero section">
    <div class="hero__slides">

       
            <!-- Slide 1 -->
        <article class="hero__slide"
            data-number="01"
            data-total="04"
            data-eyebrow="Graphic Design"
            data-title="Wind in the Storms"
            style="background-image: url('assets/images/photo-2291026-7eec264c27ff (1).jpg');">
        </article>


        <!-- Slide 01 -->
        <article class="hero__slide"
            data-number="02"
            data-total="04"
            data-eyebrow="Trend"
            data-title="Legacy of Rainbow"
            style="background-image: url('assets/images/photo-1477140765885-9469f102a270.jpg');">
        </article>

        <!-- Slide 02 -->
        <article class="hero__slide"
            data-number="03"
            data-total="04"
            data-eyebrow="Design"
            data-title="Dance and Night Club"
            style="background-image: url('assets/images/photo-1542291026-7eec264c27wer.jpg');">
        </article>

    
           <!-- Slide 04 -->
        <article class="hero__slide is-active"
            data-number="04"
            data-total="04"
            data-eyebrow="Trend"
            data-title="Emerald in the Children"
            style="background-image: url('assets/images/8fd90090585953.5e1b9aea1d32f.jpg');">
        </article>

    </div>

    <div class="hero__content">
        <div class="hero__copy">

            <p class="hero__eyebrow">Trend</p>

            <div class="hero__meta">
                <span class="hero__number">04</span>
                <span class="hero__divider">/</span>
                <span class="hero__count">04</span>
            </div>

            <h1 class="hero__title">Emerald in the Children</h1>

            <a href="#" class="hero__link">
                <span class="hero__link-text">View Case</span>
                <span class="hero__link-line"></span>
                <span class="hero__link-dot"></span>
            </a>
        </div>
    </div>

    <div class="hero__controls" aria-label="Slide controls">

        <button type="button"
            class="hero__arrow"
            data-direction="prev"
            aria-label="Previous slide">⌃</button>

        <button type="button"
            class="hero__arrow"
            data-direction="next"
            aria-label="Next slide">⌄</button>

    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>