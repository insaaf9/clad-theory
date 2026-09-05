document.addEventListener('DOMContentLoaded', function () {
    // DOM Elements
    const productsGrid = document.getElementById('productsGrid');
    const productCards = Array.from(document.querySelectorAll('.product-card'));
    const categoryLinks = document.querySelectorAll('.category-link');
    const priceRange = document.getElementById('priceRange');
    const priceMinDisplay = document.getElementById('priceMinDisplay');
    const priceMaxDisplay = document.getElementById('priceMaxDisplay');
    const productCount = document.getElementById('productCount');
    const sortSelect = document.getElementById('sortSelect');
    const viewBtns = document.querySelectorAll('.view-btn');
    const noProductsMsg = document.getElementById('noProductsMsg');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');
    const topbarSearchInput = document.getElementById('topbarSearchInput');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const backToTopBtn = document.getElementById('backToTopBtn');
    const cartBadge = document.querySelector('.cart-badge');
    const wishlistBadge = document.querySelector('.wishlist-badge');
    const toastContainer = document.getElementById('toastContainer');

    // Quick View Elements
    const quickViewModal = document.getElementById('quickViewModal');
    const quickViewOverlay = document.getElementById('quickViewOverlay');
    const quickViewClose = document.getElementById('quickViewClose');
    const qvImage = document.getElementById('qvImage');
    const qvCategory = document.getElementById('qvCategory');
    const qvTitle = document.getElementById('qvTitle');
    const qvPrice = document.getElementById('qvPrice');
    const qvDesc = document.getElementById('qvDesc');
    const qvRating = document.getElementById('qvRating');
    const qvAddToCart = document.getElementById('qvAddToCart');
    const qvAddWishlist = document.getElementById('qvAddWishlist');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    const qtyInput = document.getElementById('qtyInput');

    // State Variables
    let currentCategory = 'all';
    let currentMaxPrice = parseFloat(priceRange ? priceRange.value : 180);
    let currentSort = 'default';
    let searchQuery = '';
    let cartCount = 0;
    let wishlistCount = 0;

    // --- Dynamic Slider Track Fill Update ---
    function updatePriceSliderBackground() {
        if (!priceRange) return;
        const min = parseFloat(priceRange.min || 0);
        const max = parseFloat(priceRange.max || 180);
        const val = parseFloat(priceRange.value);
        const percentage = ((val - min) / (max - min)) * 100;
        priceRange.style.background = `linear-gradient(to right, #f15623 0%, #f15623 ${percentage}%, #e0e0e0 ${percentage}%, #e0e0e0 100%)`;
    }

    // --- Toast Notification Helper ---
    function showToast(message, type = 'success') {
        if (!toastContainer) return;
        const toast = document.createElement('div');
        toast.className = `toast toast--${type}`;
        toast.innerHTML = `
            <span class="toast-icon">${type === 'success' ? '✓' : '♥'}</span>
            <span class="toast-message">${message}</span>
        `;
        toastContainer.appendChild(toast);
        
        setTimeout(() => toast.classList.add('is-show'), 10);
        setTimeout(() => {
            toast.classList.remove('is-show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // --- Main Filter & Sort Engine ---
    function filterAndSortProducts() {
        let visibleCount = 0;

        productCards.forEach(card => {
            const cat = card.dataset.category || '';
            const price = parseFloat(card.dataset.price || 0);
            const name = (card.dataset.name || '').toLowerCase();

            const matchesCat = (currentCategory === 'all') || (cat.toLowerCase() === currentCategory.toLowerCase());
            const matchesPrice = price <= currentMaxPrice;
            const matchesSearch = searchQuery === '' || name.includes(searchQuery.toLowerCase());

            if (matchesCat && matchesPrice && matchesSearch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update Counter
        if (productCount) {
            productCount.textContent = visibleCount;
        }

        // Toggle No Products Message
        if (noProductsMsg) {
            noProductsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Sort Visible Product Cards
        const sortedCards = productCards.slice().sort((a, b) => {
            if (a.style.display === 'none') return 1;
            if (b.style.display === 'none') return -1;

            if (currentSort === 'price-low') {
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            } else if (currentSort === 'price-high') {
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            } else if (currentSort === 'rating') {
                return parseInt(b.dataset.rating) - parseInt(a.dataset.rating);
            } else if (currentSort === 'name') {
                return a.dataset.name.localeCompare(b.dataset.name);
            }
            return parseInt(a.dataset.id) - parseInt(b.dataset.id);
        });

        sortedCards.forEach(card => productsGrid.appendChild(card));
    }

    // --- Price Slider Event Listener ---
    if (priceRange) {
        priceRange.addEventListener('input', function () {
            currentMaxPrice = parseFloat(this.value);
            if (priceMaxDisplay) {
                priceMaxDisplay.textContent = `$${currentMaxPrice}`;
            }
            updatePriceSliderBackground();
            filterAndSortProducts();
        });
        
        // Initial setup
        updatePriceSliderBackground();
    }

    // --- Category Filter Click Listener ---
    categoryLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            categoryLinks.forEach(l => l.classList.remove('is-active'));
            this.classList.add('is-active');
            currentCategory = this.dataset.category || 'all';
            filterAndSortProducts();
        });
    });

    // --- Sort Selection Listener ---
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            currentSort = this.value;
            filterAndSortProducts();
        });
    }

    // --- Topbar Live Search ---
    if (topbarSearchInput) {
        topbarSearchInput.addEventListener('input', function () {
            searchQuery = this.value.trim();
            filterAndSortProducts();
        });
    }

    // --- View Mode Toggles (Grid / List) ---
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            viewBtns.forEach(b => b.classList.remove('is-active'));
            this.classList.add('is-active');
            const viewMode = this.dataset.view;

            if (viewMode === 'list') {
                productsGrid.classList.add('products-list-view');
            } else {
                productsGrid.classList.remove('products-list-view');
            }
        });
    });

    // --- Reset Filters ---
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function () {
            currentCategory = 'all';
            currentMaxPrice = 180;
            currentSort = 'default';
            searchQuery = '';

            if (priceRange) priceRange.value = 180;
            if (priceMaxDisplay) priceMaxDisplay.textContent = '$180';
            if (sortSelect) sortSelect.value = 'default';
            if (topbarSearchInput) topbarSearchInput.value = '';

            categoryLinks.forEach(l => {
                l.classList.toggle('is-active', l.dataset.category === 'all');
            });

            updatePriceSliderBackground();
            filterAndSortProducts();
        });
    }

    // --- Add to Cart & Wishlist Click Handlers ---
    document.addEventListener('click', function (e) {
        const cartBtn = e.target.closest('.add-cart-btn');
        if (cartBtn) {
            e.preventDefault();
            cartCount++;
            if (cartBadge) cartBadge.textContent = cartCount;
            const card = cartBtn.closest('.product-card');
            const name = card ? card.dataset.name : 'Item';
            showToast(`Added "${name}" to your cart!`, 'success');
        }

        const wishlistBtn = e.target.closest('.add-wishlist-btn');
        if (wishlistBtn) {
            e.preventDefault();
            wishlistCount++;
            if (wishlistBadge) wishlistBadge.textContent = wishlistCount;
            wishlistBtn.classList.toggle('is-filled');
            const card = wishlistBtn.closest('.product-card');
            const name = card ? card.dataset.name : 'Item';
            showToast(`Added "${name}" to your wishlist!`, 'wishlist');
        }
    });

    // --- Quick View Modal Engine ---
    function openQuickView(card) {
        if (!card) return;
        const name = card.dataset.name;
        const category = card.dataset.category;
        const price = card.dataset.price;
        const rating = parseInt(card.dataset.rating || 5);
        const img = card.querySelector('.product-card__img')?.src || '';
        const desc = card.querySelector('.product-card__desc')?.textContent || 'High quality fashion apparel.';

        if (qvTitle) qvTitle.textContent = name;
        if (qvCategory) qvCategory.textContent = category;
        if (qvPrice) qvPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
        if (qvDesc) qvDesc.textContent = desc;
        if (qvImage) qvImage.src = img;
        if (qtyInput) qtyInput.value = 1;

        if (qvRating) {
            qvRating.innerHTML = '';
            for (let i = 0; i < 5; i++) {
                const star = document.createElement('span');
                star.className = `star ${i < rating ? 'filled' : ''}`;
                star.textContent = '★';
                qvRating.appendChild(star);
            }
        }

        if (quickViewModal) {
            quickViewModal.classList.add('is-open');
            quickViewModal.setAttribute('aria-hidden', 'false');
        }
    }

    function closeQuickView() {
        if (quickViewModal) {
            quickViewModal.classList.remove('is-open');
            quickViewModal.setAttribute('aria-hidden', 'true');
        }
    }

    document.addEventListener('click', function (e) {
        const qvBtn = e.target.closest('.quick-view-btn') || e.target.closest('.quick-view-trigger');
        if (qvBtn) {
            e.preventDefault();
            const card = qvBtn.closest('.product-card');
            openQuickView(card);
        }
    });

    if (quickViewClose) quickViewClose.addEventListener('click', closeQuickView);
    if (quickViewOverlay) quickViewOverlay.addEventListener('click', closeQuickView);

    // Quantity Picker
    if (qtyMinus) {
        qtyMinus.addEventListener('click', () => {
            let v = parseInt(qtyInput.value) || 1;
            if (v > 1) qtyInput.value = v - 1;
        });
    }
    if (qtyPlus) {
        qtyPlus.addEventListener('click', () => {
            let v = parseInt(qtyInput.value) || 1;
            qtyInput.value = v + 1;
        });
    }

    // Size Selector Buttons
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            sizeBtns.forEach(b => b.classList.remove('is-active'));
            this.classList.add('is-active');
        });
    });

    if (qvAddToCart) {
        qvAddToCart.addEventListener('click', () => {
            const qty = parseInt(qtyInput.value) || 1;
            cartCount += qty;
            if (cartBadge) cartBadge.textContent = cartCount;
            showToast(`Added ${qty} item(s) to your shopping cart!`, 'success');
            closeQuickView();
        });
    }

    if (qvAddWishlist) {
        qvAddWishlist.addEventListener('click', () => {
            wishlistCount++;
            if (wishlistBadge) wishlistBadge.textContent = wishlistCount;
            showToast('Added item to your wishlist!', 'wishlist');
        });
    }

    // --- Load More / Discover More Button ---
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            this.textContent = 'LOADING PRODUCTS...';
            this.disabled = true;

            setTimeout(() => {
                showToast('All 15 catalog products are currently loaded.', 'success');
                this.textContent = 'ALL PRODUCTS LOADED';
                this.style.opacity = '0.6';
            }, 700);
        });
    }

    // --- Smooth Scroll to Top ---
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Initial Filter Run
    filterAndSortProducts();
});
