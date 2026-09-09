<?php
/**
 * API: Save Banner Metadata (eyebrow text + slide title)
 * ─────────────────────────────────────────────────
 * POST /admin/api/banner_save.php
 *
 * Accepted JSON body OR form fields:
 *   id       (required) — banner_images.id
 *   eyebrow  (optional) — eyebrow text
 *   title    (required) — slide title
 *
 * Returns JSON: { success, message }
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../auth.php';
requireAdminAuth(true);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

require_once __DIR__ . '/../../includes/db.php';

/* ── Accept both JSON body and form-encoded ── */
$input = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (str_contains($contentType, 'application/json')) {
    $raw   = file_get_contents('php://input');
    $input = json_decode($raw, true) ?? [];
} else {
    $input = $_POST;
}

$id      = isset($input['id'])      ? (int)   $input['id']      : 0;
$eyebrow = isset($input['eyebrow']) ? trim($input['eyebrow'])    : '';
$title   = isset($input['title'])   ? trim($input['title'])      : '';

if ($id < 1) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid or missing banner id.']));
}

if ($title === '') {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Slide title cannot be empty.']));
}

try {
    $stmt = $pdo->prepare(
        'UPDATE banner_images
            SET eyebrow_text = ?, slide_title = ?, updated_at = NOW()
          WHERE id = ?'
    );
    $stmt->execute([$eyebrow, $title, $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        exit(json_encode(['success' => false, 'message' => 'No record found with that id.']));
    }

    exit(json_encode(['success' => true, 'message' => 'Slide metadata saved successfully.']));

} catch (PDOException $e) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
