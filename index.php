<?php
$pageTitle   = 'Clad Theory';
$bodyClass   = 'home-page';
$currentPage = 'home';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';

/* ── Load banner slides from DB ──────────────────────────────────────────
   Falls back gracefully to an empty array if the DB is unavailable.
   Only slides where is_active = 1 are shown, ordered by slide_order ASC.
   ─────────────────────────────────────────────────────────────────────── */
$slides = [];
try {
    require_once __DIR__ . '/includes/db.php';
    $stmt   = $pdo->query(
        'SELECT image, eyebrow_text, slide_title, slide_order
           FROM banner_images
          WHERE is_active = 1
          ORDER BY slide_order ASC'
    );
    $slides = $stmt->fetchAll();
} catch (Exception $e) {
    // Silently fall back — the hero section will render with no slides
    $slides = [];
}

$totalSlides = count($slides);
?>

<main class="hero" aria-label="Hero section">
    <div class="hero__slides">

        <?php if ($totalSlides > 0): ?>
            <?php foreach ($slides as $i => $slide):
                $isLast    = ($i === $totalSlides - 1);
                $num       = str_pad($slide['slide_order'], 2, '0', STR_PAD_LEFT);
                $total     = str_pad($totalSlides, 2, '0', STR_PAD_LEFT);
                $eyebrow   = htmlspecialchars($slide['eyebrow_text'] ?? '');
                $title     = htmlspecialchars($slide['slide_title']  ?? '');
                $imagePath = htmlspecialchars($slide['image']        ?? '');
            ?>
            <article class="hero__slide<?php echo $isLast ? ' is-active' : ''; ?>"
                data-number="<?php echo $num; ?>"
                data-total="<?php echo $total; ?>"
                data-eyebrow="<?php echo $eyebrow; ?>"
                data-title="<?php echo $title; ?>"
                style="background-image: url('<?php echo $imagePath; ?>');">
            </article>
            <?php endforeach; ?>

        <?php else: ?>
            <!-- Fallback slide shown when no DB records exist yet -->
            <article class="hero__slide is-active"
                data-number="01"
                data-total="01"
                data-eyebrow="Clad Theory"
                data-title="Welcome"
                style="background: var(--page-dark);">
            </article>
        <?php endif; ?>

    </div>

    <div class="hero__content">
        <div class="hero__copy">

            <p class="hero__eyebrow">
                <?php echo $totalSlides > 0 ? htmlspecialchars($slides[$totalSlides - 1]['eyebrow_text'] ?? '') : 'Clad Theory'; ?>
            </p>

            <div class="hero__meta">
                <span class="hero__number"><?php echo str_pad($totalSlides > 0 ? $totalSlides : 1, 2, '0', STR_PAD_LEFT); ?></span>
                <span class="hero__divider">/</span>
                <span class="hero__count"><?php echo str_pad($totalSlides > 0 ? $totalSlides : 1, 2, '0', STR_PAD_LEFT); ?></span>
            </div>

            <h1 class="hero__title">
                <?php echo $totalSlides > 0 ? htmlspecialchars($slides[$totalSlides - 1]['slide_title'] ?? '') : 'Welcome'; ?>
            </h1>

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