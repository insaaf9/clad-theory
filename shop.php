<?php
$pageTitle = 'Shop | Supro Minimalist E-Commerce';
$bodyClass = 'shop-page';
$currentPage = 'shop';

// Product Catalog Data Array
$products = [
    [
        'id' => 1,
        'name' => 'Aviator Sunglasses',
        'category' => 'More Accessories',
        'price' => 9.90,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Classic unisex aviator sunglasses with UV400 protection and lightweight metal frame.',
        'in_stock' => true
    ],
    [
        'id' => 2,
        'name' => 'Contrast Backpack',
        'category' => 'Bags',
        'price' => 69.90,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Durable canvas backpack featuring rich leather trims and spacious multi-compartment storage.',
        'in_stock' => true
    ],
    [
        'id' => 3,
        'name' => 'Contrasting Design T-Shirt',
        'category' => 'T-shirt',
        'price' => 95.90,
        'rating' => 5,
        'badge' => 'Hot',
        'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Vibrant floral printed quarter-sleeve blouse made from premium soft viscose fabric.',
        'in_stock' => true
    ],
    [
        'id' => 4,
        'name' => 'Contrasting Design T-Shirt',
        'category' => 'T-shirt',
        'price' => 95.90,
        'rating' => 4,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Minimalist relaxed fit cotton t-shirt with subtle chest graphic typography.',
        'in_stock' => true
    ],
    [
        'id' => 5,
        'name' => 'Cotton Sweater',
        'category' => 'Men',
        'price' => 19.90,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Cozy crewneck cotton knit sweater in dark denim blue for crisp autumn layering.',
        'in_stock' => true
    ],
    [
        'id' => 6,
        'name' => 'Cropped Denim Jumpsuit',
        'category' => 'Women',
        'price' => 89.59,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Stylish wide-leg denim jumpsuit with adjustable cami shoulder straps and side pockets.',
        'in_stock' => true
    ],
    [
        'id' => 7,
        'name' => 'Embroidered Flowy Jacket',
        'category' => 'Women',
        'price' => 56.89,
        'rating' => 4,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Lightweight boho embroidered jacket with delicate lace details and open front design.',
        'in_stock' => true
    ],
    [
        'id' => 8,
        'name' => 'Floral Short Jumpsuit',
        'category' => 'Women',
        'price' => 97.99,
        'rating' => 5,
        'badge' => 'Hot',
        'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Playful short floral romper with wrap front V-neckline and elastic waist cinching.',
        'in_stock' => true
    ],
    [
        'id' => 9,
        'name' => 'Furry Hooded Parka',
        'category' => 'Clothing',
        'price' => 77.98,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Warm winter parka with faux-fur lined detachable hood and water-resistant outer shell.',
        'in_stock' => true
    ],
    [
        'id' => 10,
        'name' => 'Glitter Decorated Shoes',
        'category' => 'Shoes',
        'price' => 56.90,
        'rating' => 4,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Elegant low block-heel pumps adorned with subtle glitter finish for evening wear.',
        'in_stock' => true
    ],
    [
        'id' => 11,
        'name' => 'Leather Shop Bag',
        'category' => 'Bags',
        'price' => 59.90,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Handcrafted cognac leather bucket bag with top drawstring closure and shoulder strap.',
        'in_stock' => true
    ],
    [
        'id' => 12,
        'name' => "Mango Women's Bag",
        'category' => 'Bags',
        'price' => 79.90,
        'rating' => 5,
        'badge' => 'Out Of Stock',
        'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Structured nude pink tote handbag with dual top handles and magnetic clasp.',
        'in_stock' => false
    ],
    [
        'id' => 13,
        'name' => 'Metallic Frame Glasses',
        'category' => 'More Accessories',
        'price' => 29.90,
        'rating' => 5,
        'badge' => 'Sale',
        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Sleek silver metallic optical frames with blue light blocking clear lenses.',
        'in_stock' => true
    ],
    [
        'id' => 14,
        'name' => 'Wool Knit Beanie',
        'category' => 'Hats & Gloves',
        'price' => 18.50,
        'rating' => 4,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Warm ribbed wool beanie hat with fold-over cuff in neutral oat beige.',
        'in_stock' => true
    ],
    [
        'id' => 15,
        'name' => 'Classic Leather Belt',
        'category' => 'Wallets & Cases',
        'price' => 24.90,
        'rating' => 5,
        'badge' => '',
        'image' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
        'desc' => 'Full-grain Italian leather belt featuring brushed brass roller buckle.',
        'in_stock' => true
    ]
];

$categories = [
    'Bags' => 12,
    'Clothing' => 48,
    'Hats & Gloves' => 9,
    'Men' => 24,
    'More Accessories' => 15,
    'Shoes' => 18,
    'T-shirt' => 31,
    'Wallets & Cases' => 11,
    'Women' => 52
];

$featuredProducts = [
    [
        'name' => 'Contrast Backpack',
        'price' => 69.90,
        'rating' => 5,
        'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=300&q=80'
    ],
    [
        'name' => 'Metallic Frame Glasses',
        'price' => 29.90,
        'rating' => 5,
        'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=300&q=80'
    ],
    [
        'name' => 'Glitter Decorated Shoes',
        'price' => 56.90,
        'rating' => 5,
        'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=300&q=80'
    ]
];

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<!-- Shop Page Container -->
<div class="shop-wrapper">
    <!-- Breadcrumb & Header Section -->
    <header class="shop-header">
        <div class="shop-header__container">
            <h1 class="shop-title">Shop</h1>
            <nav class="shop-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php">Home</a>
                <span class="sep">•</span>
                <span class="current">Shop</span>
            </nav>
        </div>
    </header>

    <!-- Main Content Layout -->
    <div class="shop-main-container">
        <!-- Shop Control Bar (Product count, Sorting, View toggles) -->
        <div class="shop-toolbar">
            <div class="shop-toolbar__count">
                <span id="productCount"><?php echo count($products); ?></span> Products Found
            </div>
            
            <div class="shop-toolbar__actions">
                <div class="shop-sort">
                    <label for="sortSelect">Sort by</label>
                    <select id="sortSelect" aria-label="Sort products">
                        <option value="default" selected>Default</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Rating</option>
                        <option value="name">Name: A - Z</option>
                    </select>
                </div>
                <div class="shop-view-modes">
                    <button type="button" class="view-btn is-active" data-view="grid" aria-label="Grid View">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                        </svg>
                    </button>
                    <button type="button" class="view-btn" data-view="list" aria-label="List View">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6"></line>
                            <line x1="8" y1="12" x2="21" y2="12"></line>
                            <line x1="8" y1="18" x2="21" y2="18"></line>
                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Layout Grid: Sidebar + Products -->
        <div class="shop-layout">
            <!-- Left Sidebar -->
            <aside class="shop-sidebar" aria-label="Shop filters">
                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="category-list">
                        <li>
                            <a href="#" class="category-link is-active" data-category="all">
                                <span>All Categories</span>
                            </a>
                        </li>
                        <?php foreach ($categories as $catName => $catCount): ?>
                        <li>
                            <a href="#" class="category-link" data-category="<?php echo htmlspecialchars($catName); ?>">
                                <span><?php echo htmlspecialchars($catName); ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Price Filter Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Price</h3>
                    <div class="price-filter">
                        <div class="price-slider-wrap">
                            <input type="range" id="priceRange" min="0" max="180" value="180" step="5" aria-label="Filter by maximum price">
                            <div class="price-bar"></div>
                        </div>
                        <div class="price-display">
                            PRICE: <span id="priceMinDisplay">$0</span> — <span id="priceMaxDisplay">$180</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Products Widget -->
                <div class="sidebar-widget widget-featured">
                    <h3 class="widget-title">Products</h3>
                    <div class="widget-products-list">
                        <?php foreach ($featuredProducts as $fp): ?>
                        <div class="widget-product-card">
                            <div class="widget-product-img">
                                <img src="<?php echo htmlspecialchars($fp['image']); ?>" alt="<?php echo htmlspecialchars($fp['name']); ?>" loading="lazy">
                            </div>
                            <div class="widget-product-info">
                                <h4 class="widget-product-name"><?php echo htmlspecialchars($fp['name']); ?></h4>
                                <!-- <div class="rating-stars">
                                    <?php for ($i = 0; $i < $fp['rating']; $i++): ?>
                                    <span class="star">★</span>
                                    <?php endfor; ?>
                                </div> -->
                                <div class="widget-product-price">$<?php echo number_format($fp['price'], 2); ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>

            <!-- Main Product Catalog Area -->
            <main class="shop-catalog">
                <div class="products-grid" id="productsGrid">
                    <?php foreach ($products as $p): ?>
                    <article class="product-card" 
                             data-id="<?php echo $p['id']; ?>"
                             data-category="<?php echo htmlspecialchars($p['category']); ?>"
                             data-price="<?php echo $p['price']; ?>"
                             data-rating="<?php echo $p['rating']; ?>"
                             data-name="<?php echo htmlspecialchars($p['name']); ?>">
                        
                        <div class="product-card__image-wrap">
                            <?php if (!empty($p['badge'])): ?>
                            <span class="product-badge <?php echo strtolower(str_replace(' ', '-', $p['badge'])); ?>">
                                <?php echo htmlspecialchars($p['badge']); ?>
                            </span>
                            <?php endif; ?>
                            
                            <img src="<?php echo htmlspecialchars($p['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($p['name']); ?>" 
                                 class="product-card__img"
                                 loading="lazy">
                            
                            <div class="product-card__actions">
                                <button type="button" class="btn-action quick-view-btn" data-id="<?php echo $p['id']; ?>" aria-label="Quick View" title="Quick View">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>
                                <button type="button" class="btn-action add-wishlist-btn" data-id="<?php echo $p['id']; ?>" aria-label="Add to Wishlist" title="Add to Wishlist">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                                <?php if ($p['in_stock']): ?>
                                <button type="button" class="btn-action add-cart-btn" data-id="<?php echo $p['id']; ?>" aria-label="Add to Cart" title="Add to Cart">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="product-card__content">
                            <h3 class="product-card__title">
                                <a href="#" class="quick-view-trigger" data-id="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a>
                            </h3>
                            <!-- <div class="rating-stars"> -->
                                <!-- <?php for ($i = 0; $i < 5; $i++): ?> -->
                                <!-- <span class="star <?php echo $i < $p['rating'] ? 'filled' : ''; ?>">★</span> -->
                                <!-- <?php endfor; ?> -->
                            <!-- </div> -->
                            <div class="product-card__price">$<?php echo number_format($p['price'], 2); ?></div>
                            <p class="product-card__desc"><?php echo htmlspecialchars($p['desc']); ?></p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <div class="no-products-msg" id="noProductsMsg" style="display: none;">
                    <p>No products match your selected filter criteria.</p>
                    <button type="button" id="resetFiltersBtn" class="reset-btn">Reset Filters</button>
                </div>

                <!-- Load More Button -->
                <div class="discover-more-wrap">
                    <button type="button" class="discover-more-btn" id="loadMoreBtn">DISCOVER MORE</button>
                </div>
            </main>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div class="quickview-modal" id="quickViewModal" aria-hidden="true" role="dialog">
    <div class="quickview-overlay" id="quickViewOverlay"></div>
    <div class="quickview-content">
        <button type="button" class="quickview-close" id="quickViewClose" aria-label="Close modal">×</button>
        <div class="quickview-grid">
            <div class="quickview-image">
                <img id="qvImage" src="" alt="Product Quick View">
            </div>
            <div class="quickview-details">
                <span class="quickview-cat" id="qvCategory">Category</span>
                <h2 class="quickview-title" id="qvTitle">Product Name</h2>
                <!-- <div class="rating-stars" id="qvRating">
                    <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span>
                </div> -->
                <div class="quickview-price" id="qvPrice">$0.00</div>
                <p class="quickview-desc" id="qvDesc">Product description text...</p>
                
                <div class="quickview-options">
                    <div class="option-row">
                        <label>Size:</label>
                        <div class="size-options">
                            <button type="button" class="size-btn is-active">S</button>
                            <button type="button" class="size-btn">M</button>
                            <button type="button" class="size-btn">L</button>
                            <button type="button" class="size-btn">XL</button>
                        </div>
                    </div>
                    <div class="option-row">
                        <label>Qty:</label>
                        <div class="qty-picker">
                            <button type="button" class="qty-btn" id="qtyMinus">-</button>
                            <input type="number" id="qtyInput" value="1" min="1" max="99">
                            <button type="button" class="qty-btn" id="qtyPlus">+</button>
                        </div>
                    </div>
                </div>

                <div class="quickview-actions">
                    <button type="button" class="qv-add-cart-btn" id="qvAddToCart">ADD TO CART</button>
                    <button type="button" class="qv-wishlist-btn" id="qvAddWishlist" aria-label="Add to wishlist">♡</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div class="toast-container" id="toastContainer"></div>

<!-- Custom Shop Footer -->
<footer class="shop-footer">
    <div class="shop-footer__inner">
        <div class="shop-footer__grid">
            <div class="footer-col">
                <h4>HELP &amp; INFORMATION</h4>
                <ul>
                    <li><a href="#">Track Order</a></li>
                    <li><a href="#">Delivery &amp; Returns</a></li>
                    <li><a href="#">Premier Delivery</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>ABOUT SUPRO</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Corporate</a></li>
                    <li><a href="#">Investors</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>ONLINE SHOP</h4>
                <ul>
                    <li><a href="#">Shoes</a></li>
                    <li><a href="#">Bags</a></li>
                    <li><a href="#">Wallets</a></li>
                    <li><a href="#">Belts</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>LANGUAGE</h4>
                <div class="select-dropdown">
                    <select aria-label="Select language">
                        <option selected>English</option>
                        <option>Spanish</option>
                        <option>French</option>
                    </select>
                </div>
            </div>
            <div class="footer-col">
                <h4>CURRENCY</h4>
                <div class="select-dropdown">
                    <select aria-label="Select currency">
                        <option selected>USD</option>
                        <option>EUR</option>
                        <option>GBP</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="shop-footer__bottom">
        <div class="shop-footer__bottom-inner">
            <div class="copyright-text">
                © 2018 <strong>Supro</strong>. All rights reserved.
            </div>

            <div class="footer-socials">
                <a href="#" aria-label="Facebook">f</a>
                <a href="#" aria-label="Twitter">t</a>
                <a href="#" aria-label="Google Plus">g+</a>
                <a href="#" aria-label="LinkedIn">in</a>
                <a href="#" aria-label="Pinterest">p</a>
            </div>

            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Use</a>
            </div>

            <button type="button" class="back-to-top" id="backToTopBtn" aria-label="Scroll to top">
                ↑
            </button>
        </div>
    </div>
</footer>

<script src="assets/js/shop.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
