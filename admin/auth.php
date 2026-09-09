<?php
/** Shared admin authentication guard. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

require_once __DIR__ . '/../includes/db.php';

function adminIsAuthenticated(): bool
{
    return !empty($_SESSION['admin_logged_in']) && !empty($_SESSION['admin_authenticated']);
}

function requireAdminAuth(bool $json = false): void
{
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');

    if (adminIsAuthenticated()) {
        return;
    }

    if ($json) {
        http_response_code(401);
        header('Content-Type: application/json');
        exit(json_encode(['success' => false, 'message' => 'Admin authentication required.']));
    }

    $requestedPath = $_SERVER['REQUEST_URI'] ?? '/admin/dashboard.php';
    header('Location: login.php?redirect=' . rawurlencode($requestedPath));
    exit;
}

function adminFindByUsername(string $username): ?array
{
    global $pdo;

    $username = trim($username);
    if ($username === '') {
        return null;
    }

    $stmt = $pdo->prepare('SELECT id, username, password FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    return $admin ?: null;
}

function adminCredentialsAreValid(string $username, string $password): int|false
{
    global $pdo;

    $username = trim($username);
    if ($username === '' || $password === '') {
        return false;
    }

    $admin = adminFindByUsername($username);
    if (!$admin || !isset($admin['password'])) {
        return false;
    }

    if (!is_string($admin['password']) || !password_verify($password, $admin['password'])) {
        return false;
    }

    return (int) $admin['id'];
}

function adminDebugLookup(string $username): array
{
    $admin = adminFindByUsername($username);

    return [
        'username' => $username,
        'found' => $admin !== null,
        'admin' => $admin,
    ];
}
