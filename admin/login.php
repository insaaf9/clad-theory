<?php
require_once __DIR__ . '/auth.php';

if (adminIsAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$redirect = $_POST['redirect'] ?? $_GET['redirect'] ?? 'dashboard.php';
if (!is_string($redirect) || ($redirect !== 'dashboard.php' && !str_starts_with($redirect, '/'))) {
    $redirect = 'dashboard.php';
}

$debugInfo = null;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if (isset($_GET['debug']) || isset($_POST['debug'])) {
        $debugInfo = adminDebugLookup($username);
        error_log('ADMIN_DEBUG: ' . json_encode($debugInfo));
    }

    $adminId = adminCredentialsAreValid($username, $password);
    if ($adminId !== false) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_authenticated'] = true;
        $_SESSION['admin_id'] = $adminId;
        $_SESSION['admin_username'] = $username;

        $target = 'dashboard.php';
        if ($redirect === 'dashboard.php' || $redirect === '/admin/dashboard.php') {
            $target = 'dashboard.php';
        } elseif (is_string($redirect) && $redirect !== '') {
            $target = $redirect;
        }

        header('Location: ' . $target);
        exit;
    }

    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Clad Theory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <style>
        .admin-login-page { display: grid; place-items: center; min-height: 100vh; padding: 1.5rem; background: var(--admin-bg); }
        .admin-login-card { width: min(420px, 100%); padding: 2.5rem; background: var(--admin-surface); border: 1px solid var(--admin-border); border-radius: 16px; box-shadow: 0 18px 50px rgba(24, 21, 31, .1); }
        .admin-login-brand { display: flex; align-items: center; gap: .8rem; margin-bottom: 2rem; }
        .admin-login-brand__icon { display: grid; place-items: center; width: 44px; height: 44px; border-radius: 11px; background: linear-gradient(135deg, var(--brand-pink), var(--brand-pink-deep)); color: #fff; font-weight: 800; }
.admin-login-brand strong {
    display: block;
    color: var(--admin-text);
    text-transform: none;
    letter-spacing: .04em;
}

.admin-login-brand small {
    color: var(--brand-pink);
    text-transform: none;
    letter-spacing: .12em;
}        
        .admin-login-brand small { color: var(--brand-pink);  theory
         letter-spacing: .12em; }
        .admin-login-card h1 { margin: 0 0 .45rem; color: var(--admin-text); font-size: 1.55rem; }
        .admin-login-card > p { margin: 0 0 1.7rem; color: var(--admin-muted); }
        .admin-login-field { display: grid; gap: .45rem; margin-bottom: 1rem; }
        .admin-login-field label { color: var(--admin-text); font-size: .8rem; font-weight: 700; }
        .admin-login-field input { width: 100%; padding: .8rem .9rem; border: 1px solid var(--admin-border-2); border-radius: 8px; background: #fff; color: var(--admin-text); font: inherit; outline: none; }
        .admin-login-field input:focus { border-color: var(--brand-pink); box-shadow: 0 0 0 3px var(--brand-pink-glow); }
        .admin-login-submit { width: 100%; margin-top: .6rem; padding: .85rem 1rem; border: 0; border-radius: 8px; background: var(--brand-pink); color: #fff; cursor: pointer; font: inherit; font-weight: 700; }
        .admin-login-submit:hover { background: var(--brand-pink-deep); }
        .admin-login-error { margin-bottom: 1rem; padding: .7rem .8rem; border-radius: 7px; background: #fff0f3; color: #b6084c; font-size: .85rem; }
    </style>
</head>
<body class="admin-login-page">
    <main class="admin-login-card">
        <div class="admin-login-brand">
            <div class="admin-login-brand__icon">CT</div>
            <div><strong>CladTheory</strong><small>Admin Panel</small></div>
        </div>
        <h1>Welcome back</h1>
        <p>Sign in to continue to the admin panel.</p>
        <?php if ($error): ?><div class="admin-login-error" role="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post" autocomplete="on">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <div class="admin-login-field"><label for="username">Username</label><input id="username" name="username" type="text" required autocomplete="username"></div>
            <div class="admin-login-field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
            <button class="admin-login-submit" type="submit">Sign In</button>
        </form>
    </main>
</body>
</html>
