<?php
/**
 * Admin Shared Sidebar Component
 * Include this at the top of every admin page.
 * Set $adminPage variable before including to highlight active nav item.
 * e.g. $adminPage = 'dashboard'; or $adminPage = 'banner';
 */
$adminPage = isset($adminPage) ? $adminPage : 'dashboard';
$adminTitle = isset($adminTitle) ? $adminTitle : 'Admin Panel';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($adminTitle); ?> — Clad Theory Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<!-- ========== SIDEBAR ========== -->
<aside class="admin-sidebar" id="adminSidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="sidebar-brand__icon">CT</div>
        <div class="sidebar-brand__text">
            <span class="sidebar-brand__name">Clad Theory</span>
            <span class="sidebar-brand__sub">Admin Panel</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav" aria-label="Admin navigation">
        <p class="sidebar-nav__label">Main Menu</p>
        <ul class="sidebar-nav__list">

            <!-- Dashboard -->
            <li class="sidebar-nav__item">
                <a href="dashboard.php"
                   id="nav-dashboard"
                   class="<?php echo $adminPage === 'dashboard' ? 'active' : ''; ?>"
                   aria-current="<?php echo $adminPage === 'dashboard' ? 'page' : 'false'; ?>">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
            </li>

            <!-- Banner Image -->
            <li class="sidebar-nav__item">
                <a href="banner.php"
                   id="nav-banner"
                   class="<?php echo $adminPage === 'banner' ? 'active' : ''; ?>"
                   aria-current="<?php echo $adminPage === 'banner' ? 'page' : 'false'; ?>">
                    <span class="nav-icon">🖼️</span>
                    Banner Image
                    <span class="nav-badge">4</span>
                </a>
            </li>

            <!-- Categories -->
            <li class="sidebar-nav__item">
                <a href="categories.php"
                   id="nav-categories"
                   class="<?php echo $adminPage === 'categories' ? 'active' : ''; ?>"
                   aria-current="<?php echo $adminPage === 'categories' ? 'page' : 'false'; ?>">
                    <span class="nav-icon">🏷️</span>
                    Categories
                </a>
            </li>

        </ul>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <div class="sidebar-footer__info">
            <div class="sidebar-footer__avatar">A</div>
            <div>
                <p class="sidebar-footer__name">Admin</p>
                <p class="sidebar-footer__role">Super Administrator</p>
            </div>
        </div>
    </div>

</aside>
<!-- ========== END SIDEBAR ========== -->

<!-- ========== MAIN CONTENT WRAPPER ========== -->
<main class="admin-main">

    <!-- Top Bar -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <nav class="topbar-breadcrumb" aria-label="Breadcrumb">
                <span>Admin</span>
                <span class="topbar-breadcrumb__sep">›</span>
                <span class="topbar-breadcrumb__current"><?php echo htmlspecialchars($adminTitle); ?></span>
            </nav>
        </div>
        <div class="topbar-right">
            <a href="../index.php" class="topbar-btn" title="View website" target="_blank">🌐</a>
            <button class="topbar-btn" title="Settings" id="settingsBtn">⚙️</button>
        </div>
    </header>
