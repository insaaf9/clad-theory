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

function ensureDefaultAdminExists(): void
{
    global $pdo;

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $hash = password_hash('admin123', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        'INSERT INTO admins (username, password) VALUES (?, ?) 
         ON DUPLICATE KEY UPDATE password = VALUES(password)'
    );

    $stmt->execute(['admin', $hash]);
}

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

    ensureDefaultAdminExists();

} catch (PDOException $e) {
    // Do NOT expose the raw exception in production.
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed. Check config/db.php credentials.',
    ]));
}
