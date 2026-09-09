<header class="topbar <?php echo isset($currentPage) && $currentPage === 'shop' ? 'topbar--shop' : ''; ?>">
    <div class="brand-wrap">
        <a href="index.php" class="brand" aria-label="Clad Theory home">CladTheory.</a>
    </div>

    <nav class="main-nav" aria-label="Main navigation">
        <ul>
            <li><a href="index.php" class="<?php echo ($currentPage ?? '') === 'home' ? 'is-active' : ''; ?>">Home</a></li>
            <li><a href="shop.php" class="<?php echo ($currentPage ?? '') === 'shop' ? 'is-active' : ''; ?>">Shop</a></li>
            <li><a href="about.php" class="<?php echo ($currentPage ?? '') === 'about' ? 'is-active' : ''; ?>">About</a></li>
            <li><a href="contact.php" class="<?php echo ($currentPage ?? '') === 'contact' ? 'is-active' : ''; ?>">Contact Us</a></li>
        </ul>
    </nav>

    <?php if (isset($currentPage) && $currentPage === 'shop'): ?>
    <div class="topbar-actions">
        <div class="topbar-search">
            <input type="text" id="topbarSearchInput" placeholder="Start Searching..." aria-label="Start Searching">
            <button type="button" class="search-btn" aria-label="Search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>
        <div class="topbar-icons">
            <a href="#" class="icon-link wishlist-toggle" aria-label="Wishlist">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="badge wishlist-badge">0</span>
            </a>
            <a href="#" class="icon-link cart-toggle" aria-label="Cart">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                <span class="badge cart-badge">0</span>
            </a>
        </div>
    </div>
    <?php endif; ?>
</header>
