<?php
/**
 * API: Toggle Category Featured State
 * ─────────────────────────────────────────────────
 * POST /admin/api/category_toggle_featured.php
 *
 * Form fields:
 *   id          (int, required)
 *   is_featured (0 or 1, required)
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

require_once __DIR__ . '/../../includes/db.php';

$id         = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$isFeatured = isset($_POST['is_featured']) && (string)$_POST['is_featured'] === '1' ? 1 : 0;

if ($id < 1) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid category ID.']));
}

try {
    $stmt = $pdo->prepare('UPDATE categories SET is_featured = ? WHERE id = ?');
    $stmt->execute([$isFeatured, $id]);

    exit(json_encode([
        'success'     => true,
        'message'     => $isFeatured ? 'Category marked as featured.' : 'Category removed from featured.',
        'is_featured' => $isFeatured,
    ]));
} catch (PDOException $e) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
