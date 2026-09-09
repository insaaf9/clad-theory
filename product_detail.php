<?php
$pageTitle = 'Product Details | Clad Theory';
$bodyClass = 'product-detail-page';
$currentPage = 'shop';

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/products.php';

$requestedId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$product = null;
foreach (getProducts($pdo) as $candidate) {
    if ((int) $candidate['id'] === (int) $requestedId) {
        $product = $candidate;
        break;
    }
}

if (!$product) {
    http_response_code(404);
    $pageTitle = 'Product Not Found | Clad Theory';
}

$fallbackImage = 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=800&q=80';
$productImage = $product && !empty($product['image']) ? $product['image'] : $fallbackImage;
$reviewCount  = $product && isset($product['review_count']) ? (int) $product['review_count'] : ($product ? (int) $product['rating'] * 6 + 4 : 0);

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<main class="product-detail">
    <?php if ($product): ?>

    <nav class="product-detail__breadcrumb" aria-label="Breadcrumb">
        <a href="index.php">Home</a>
        <span>/</span>
        <a href="shop.php">Shop</a>
        <span>/</span>
        <a href="shop.php?category=<?php echo urlencode($product['category']); ?>"><?php echo htmlspecialchars($product['category']); ?></a>
        <span>/</span>
        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
    </nav>

    <section class="product-detail__grid">

        <!-- Gallery -->
        <div class="product-detail__gallery">
            <div class="product-detail__image-wrap">
                <?php if (!$product['in_stock']): ?>
                    <span class="product-detail__badge product-detail__badge--out">Out of Stock</span>
                <?php elseif (!empty($product['badge'])): ?>
                    <span class="product-detail__badge"><?php echo htmlspecialchars($product['badge']); ?></span>
                <?php endif; ?>

                <img id="pdMainImage"
                     src="<?php echo htmlspecialchars($productImage); ?>"
                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                     class="product-detail__image"
                     onerror="this.onerror=null;this.src='<?php echo htmlspecialchars($fallbackImage, ENT_QUOTES); ?>';">
            </div>

            <div class="product-detail__thumbs">
                <button type="button" class="product-detail__thumb is-active" data-src="<?php echo htmlspecialchars($productImage); ?>">
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="View 1">
                </button>
                <button type="button" class="product-detail__thumb" data-src="<?php echo htmlspecialchars($productImage); ?>">
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="View 2">
                </button>
                <button type="button" class="product-detail__thumb" data-src="<?php echo htmlspecialchars($productImage); ?>">
                    <img src="<?php echo htmlspecialchars($productImage); ?>" alt="View 3">
                </button>
            </div>
        </div>

        <!-- Info -->
        <div class="product-detail__content">
            <div class="product-detail__top-row">
                <a href="shop.php?category=<?php echo urlencode($product['category']); ?>" class="product-detail__category"><?php echo htmlspecialchars($product['category']); ?></a>
                <span class="product-detail__stock-pill <?php echo $product['in_stock'] ? 'is-in' : 'is-out'; ?>">
                    <span class="dot"></span><?php echo $product['in_stock'] ? 'In Stock' : 'Out of Stock'; ?>
                </span>
            </div>

            <h1><?php echo htmlspecialchars($product['name']); ?></h1>

            <div class="product-detail__rating" aria-label="Rated <?php echo (int) $product['rating']; ?> out of 5">
                <?php for ($star = 1; $star <= 5; $star++): ?><span class="<?php echo $star <= $product['rating'] ? 'is-filled' : ''; ?>">★</span><?php endfor; ?>
                <span class="product-detail__reviews"><?php echo $reviewCount; ?> reviews</span>
            </div>

            <div class="product-detail__price">$<?php echo number_format((float) $product['price'], 2); ?></div>

            <p class="product-detail__description"><?php echo htmlspecialchars($product['desc']); ?></p>

            <div class="product-detail__purchase">
                <div class="detail-quantity" aria-label="Quantity selector">
                    <button type="button" data-quantity-decrease aria-label="Decrease quantity">−</button>
                    <input type="number" id="detailQuantity" value="1" min="1" max="99" aria-label="Quantity">
                    <button type="button" data-quantity-increase aria-label="Increase quantity">+</button>
                </div>
                <button type="button" class="detail-button detail-button--cart" data-product-action="cart" <?php echo !$product['in_stock'] ? 'disabled' : ''; ?>>ADD TO CART</button>
                <button type="button" class="detail-button detail-button--wishlist" data-product-action="wishlist" aria-label="Add to wishlist">♡</button>
            </div>

            <button type="button" class="detail-button detail-button--buy detail-button--buy-full" data-product-action="buy" <?php echo !$product['in_stock'] ? 'disabled' : ''; ?>>BUY NOW</button>

            <div class="product-detail__perks">
                <div class="perk">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Free delivery on orders over $50</span>
                </div>
                <div class="perk">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                    <span>30-day hassle-free returns</span>
                </div>
                <div class="perk">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span>100% secure encrypted checkout</span>
                </div>
            </div>

            <div class="product-detail__meta">
                <div><span>SKU</span>CT-<?php echo str_pad((string) $product['id'], 4, '0', STR_PAD_LEFT); ?></div>
                <div><span>Category</span><a href="shop.php?category=<?php echo urlencode($product['category']); ?>"><?php echo htmlspecialchars($product['category']); ?></a></div>
                <div><span>Tags</span>Fashion, Minimalist, <?php echo htmlspecialchars($product['category']); ?></div>
            </div>
        </div>
    </section>

    <!-- Tabs -->
    <section class="product-detail__tabs">
        <div class="pd-tabs-nav" role="tablist">
            <button type="button" class="pd-tab-btn is-active" data-tab="desc" role="tab" aria-selected="true">Description</button>
            <button type="button" class="pd-tab-btn" data-tab="info" role="tab" aria-selected="false">Additional Info</button>
            <button type="button" class="pd-tab-btn" data-tab="reviews" role="tab" aria-selected="false">Reviews (<?php echo $reviewCount; ?>)</button>
        </div>

        <div class="pd-tab-pane is-active" id="tab-desc" role="tabpanel">
            <h3>Product Overview</h3>
            <p><?php echo htmlspecialchars($product['desc']); ?></p>
            <p>Designed with meticulous attention to detail and modern tailoring, this piece embodies the minimalist aesthetic of Clad Theory — made from premium, sustainably sourced materials chosen for longevity, comfort, and timeless versatility.</p>
            <ul>
                <li>Crafted from high-grade, resilient materials</li>
                <li>Clean lines with subtle ergonomic detailing</li>
                <li>Versatile design ideal for casual outings or elevated ensembles</li>
                <li>Eco-conscious, low-impact manufacturing process</li>
            </ul>
        </div>

        <div class="pd-tab-pane" id="tab-info" role="tabpanel">
            <table class="pd-info-table">
                <tbody>
                    <tr><th>Weight</th><td>0.45 kg</td></tr>
                    <tr><th>Dimensions</th><td>30 × 20 × 5 cm</td></tr>
                    <tr><th>Category</th><td><?php echo htmlspecialchars($product['category']); ?></td></tr>
                    <tr><th>Care Instructions</th><td>Machine wash cold, gentle cycle. Do not bleach. Tumble dry low or line dry in shade.</td></tr>
                </tbody>
            </table>
        </div>

        <div class="pd-tab-pane" id="tab-reviews" role="tabpanel">
            <div class="pd-reviews-summary">
                <div class="pd-score"><?php echo number_format($product['rating'], 1); ?></div>
                <div class="product-detail__rating">
                    <?php for ($star = 1; $star <= 5; $star++): ?><span class="<?php echo $star <= $product['rating'] ? 'is-filled' : ''; ?>">★</span><?php endfor; ?>
                </div>
                <p>Based on <?php echo $reviewCount; ?> verified customer reviews</p>
            </div>
            <div class="pd-reviews-list">
                <div class="pd-review-card">
                    <div class="pd-review-head"><span>Alexander M.</span><span>Verified Buyer · 2 weeks ago</span></div>
                    <div class="product-detail__rating"><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span></div>
                    <p>Exceptional quality and fits exactly as expected. The material has a premium feel and looks even better in person!</p>
                </div>
                <div class="pd-review-card">
                    <div class="pd-review-head"><span>Sophia L.</span><span>Verified Buyer · 1 month ago</span></div>
                    <div class="product-detail__rating"><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span><span class="is-filled">★</span></div>
                    <p>Super fast shipping and elegant packaging. Clad Theory never disappoints with their minimalist designs.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="toast-container" id="toastContainer"></div>

    <?php else: ?>
    <section class="product-detail__missing"><h1>Product not found</h1><a href="shop.php">Return to Shop</a></section>
    <?php endif; ?>
</main>

<?php if ($product): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantity = document.getElementById('detailQuantity');
    const toastContainer = document.getElementById('toastContainer');
    const badge = document.querySelector('.cart-badge');
    const wishlistBadge = document.querySelector('.wishlist-badge');
    const productName = <?php echo json_encode($product['name']); ?>;

    function showMessage(message) {
        const toast = document.createElement('div');
        toast.className = 'toast toast--success';
        toast.textContent = message;
        toastContainer.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('is-show'));
        setTimeout(() => toast.remove(), 3000);
    }

    document.querySelector('[data-quantity-decrease]').addEventListener('click', () => {
        quantity.value = Math.max(1, (parseInt(quantity.value, 10) || 1) - 1);
    });
    document.querySelector('[data-quantity-increase]').addEventListener('click', () => {
        quantity.value = Math.min(99, (parseInt(quantity.value, 10) || 1) + 1);
    });

    document.querySelectorAll('[data-product-action]').forEach(button => button.addEventListener('click', () => {
        const count = Math.max(1, parseInt(quantity.value, 10) || 1);
        if (button.dataset.productAction === 'wishlist') {
            button.classList.toggle('is-filled');
            if (button.classList.contains('is-filled') && wishlistBadge) {
                wishlistBadge.textContent = (parseInt(wishlistBadge.textContent, 10) || 0) + 1;
            }
            showMessage('Added "' + productName + '" to your wishlist.');
        } else if (button.dataset.productAction === 'buy') {
            showMessage('Ready to buy ' + count + ' item(s) of "' + productName + '".');
        } else {
            if (badge) badge.textContent = (parseInt(badge.textContent, 10) || 0) + count;
            showMessage('Added ' + count + ' item(s) of "' + productName + '" to your cart.');
        }
    }));

    // Gallery thumbnails
    const mainImg = document.getElementById('pdMainImage');
    document.querySelectorAll('.product-detail__thumb').forEach(thumb => {
        thumb.addEventListener('click', function () {
            document.querySelectorAll('.product-detail__thumb').forEach(t => t.classList.remove('is-active'));
            this.classList.add('is-active');
            if (mainImg) mainImg.src = this.dataset.src;
        });
    });

    // Tabs
    const tabBtns = document.querySelectorAll('.pd-tab-btn');
    const tabPanes = document.querySelectorAll('.pd-tab-pane');
    tabBtns.forEach(btn => btn.addEventListener('click', function () {
        tabBtns.forEach(b => { b.classList.remove('is-active'); b.setAttribute('aria-selected', 'false'); });
        tabPanes.forEach(p => p.classList.remove('is-active'));
        this.classList.add('is-active');
        this.setAttribute('aria-selected', 'true');
        const pane = document.getElementById('tab-' + this.dataset.tab);
        if (pane) pane.classList.add('is-active');
    }));
});
</script>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>