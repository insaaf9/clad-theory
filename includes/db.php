<?php
/**
 * Database Configuration
 * ─────────────────────────────────────────────────
 * Shared PDO connection for the entire application.
 * Include this file wherever DB access is needed.
 *
 * Usage:
 *   require_once __DIR__ . '/db.php';
 *   // $pdo is now available
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'clad_theory');
define('DB_USER', 'root');       // ← change if your MySQL user differs
define('DB_PASS', '');           // ← change if your MySQL password differs
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
    );

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

} catch (PDOException $e) {
    // Do NOT expose the raw exception in production.
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed. Check config/db.php credentials.',
    ]));
}
