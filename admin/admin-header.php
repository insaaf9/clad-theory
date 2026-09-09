<?php
require_once __DIR__ . '/auth.php';
requireAdminAuth();

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
            <span class="sidebar-brand__name">CladTheory</span>
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

        </ul>
    </nav>

    <!-- Footer -->
  <div class="sidebar-footer">
    <div class="sidebar-footer__content">
        <button type="button" class="sidebar-profile-trigger" id="adminProfileTrigger" aria-expanded="false" aria-controls="adminProfileCard">
            <span class="sidebar-footer__avatar">A</span>
            <span class="sidebar-footer__meta">
                <span class="sidebar-footer__name">Admin</span>
                <span class="sidebar-footer__role">Super Administrator</span>
            </span>
        </button>

        <div class="profile-float-card" id="adminProfileCard" role="dialog" aria-hidden="true">
            <button type="button" class="profile-float-item" id="profileSettingsBtn">
                <span>⚙</span>
                <span>Settings</span>
            </button>
            <a href="logout.php" class="profile-float-item">
                <span>↪</span>
                <span>Logout</span>
            </a>
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
            <a href="logout.php" class="topbar-btn" title="Sign out">↪</a>
        </div>
    </header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trigger = document.getElementById('adminProfileTrigger');
        const card = document.getElementById('adminProfileCard');
        const settingsBtn = document.getElementById('profileSettingsBtn');

        if (!trigger || !card) {
            return;
        }

        const closeCard = function () {
            card.classList.remove('is-visible');
            trigger.setAttribute('aria-expanded', 'false');
            card.setAttribute('aria-hidden', 'true');
        };

        const openCard = function () {
            card.classList.add('is-visible');
            trigger.setAttribute('aria-expanded', 'true');
            card.setAttribute('aria-hidden', 'false');
        };

        trigger.addEventListener('click', function (event) {
            event.stopPropagation();

            if (card.classList.contains('is-visible')) {
                closeCard();
                return;
            }

            openCard();
        });

        card.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        if (settingsBtn) {
            settingsBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                closeCard();
            });
        }

        document.addEventListener('click', function (event) {
            const clickedInsideTrigger = trigger.contains(event.target);
            const clickedInsideCard = card.contains(event.target);

            if (!clickedInsideTrigger && !clickedInsideCard) {
                closeCard();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeCard();
            }
        });
    });
</script>
