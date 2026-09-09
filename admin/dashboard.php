<?php
require_once __DIR__ . '/auth.php';
requireAdminAuth();

$adminPage  = 'dashboard';
$adminTitle = 'Dashboard';
require __DIR__ . '/admin-header.php';
?>

    <!-- ========== DASHBOARD: UNDER CONSTRUCTION ========== -->
    <div class="admin-content">
        <div class="under-construction fade-in">

            <div class="uc-icon">⚙️</div>

            <h1 class="uc-title">Under Construction</h1>

            <p class="uc-sub">
                The Dashboard is being crafted with care.<br>
                Check back soon — something great is coming.
            </p>

            <div class="uc-bar">
                <div class="uc-bar__fill"></div>
            </div>

            <a href="banner.php" class="btn btn--primary" style="margin-top:1rem;">
                🖼️ &nbsp;Go to Banner Manager
            </a>
        </div>
    </div>

<?php require __DIR__ . '/admin-footer.php'; ?>
