<?php
/**
 * API: Delete / Remove a Banner Slide
 * ─────────────────────────────────────────────────
 * POST /admin/api/banner_delete.php
 *
 * Accepted form fields or JSON:
 *   id  (required) — banner_images.id to delete
 *
 * Behavior:
 *   - Deletes the physical image file from disk
 *   - Deletes the DB record
 *
 * Returns JSON: { success, message }
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

require_once __DIR__ . '/../../includes/db.php';

/* ── Accept JSON or form-encoded ─────────── */
$input = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (str_contains($contentType, 'application/json')) {
    $raw   = file_get_contents('php://input');
    $input = json_decode($raw, true) ?? [];
} else {
    $input = $_POST;
}

$id = isset($input['id']) ? (int) $input['id'] : 0;

if ($id < 1) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid or missing banner id.']));
}

try {
    /* Fetch the record first so we can delete the file */
    $stmt = $pdo->prepare('SELECT image FROM banner_images WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $record = $stmt->fetch();

    if (!$record) {
        http_response_code(404);
        exit(json_encode(['success' => false, 'message' => 'Banner record not found.']));
    }

    /* Delete physical file */
    $filePath = __DIR__ . '/../../' . $record['image'];
    if (is_file($filePath)) {
        @unlink($filePath);
    }

    /* Delete DB record */
    $stmt = $pdo->prepare('DELETE FROM banner_images WHERE id = ?');
    $stmt->execute([$id]);

    exit(json_encode(['success' => true, 'message' => 'Slide removed successfully.']));

} catch (PDOException $e) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
