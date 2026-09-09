<?php
/**
 * API: Delete Category
 * ─────────────────────────────────────────────────
 * POST /admin/api/category_delete.php
 *
 * Accepted form fields:
 *   id  (required) — categories.id to delete
 *
 * Returns JSON: { success, message }
 *
 * Behaviour:
 *   - Deletes the DB row
 *   - Removes the thumbnail image from disk (if any)
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

require_once __DIR__ . '/../../includes/db.php';

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id < 1) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid or missing category id.']));
}

try {
    /* Fetch the row first so we can delete the image file */
    $stmt = $pdo->prepare('SELECT name, image FROM categories WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $cat = $stmt->fetch();

    if (!$cat) {
        http_response_code(404);
        exit(json_encode(['success' => false, 'message' => 'Category not found.']));
    }

    /* Delete DB row */
    $del = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $del->execute([$id]);

    /* Delete thumbnail from disk if it exists */
    if (!empty($cat['image'])) {
        $filePath = __DIR__ . '/../../' . $cat['image'];
        if (is_file($filePath)) {
            @unlink($filePath);
        }
    }

    exit(json_encode([
        'success' => true,
        'message' => 'Category "' . $cat['name'] . '" deleted successfully.',
    ]));

} catch (PDOException $e) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
