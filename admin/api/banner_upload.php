<?php
/**
 * API: Banner Image Upload
 * ─────────────────────────────────────────────────
 * POST /admin/api/banner_upload.php
 *
 * Accepted form fields:
 *   file        (required) — the image file
 *   slot_order  (required) — which slide slot (1–4)
 *   eyebrow     (optional) — eyebrow text
 *   title       (optional) — slide title
 *
 * Returns JSON: { success, message, data? }
 *
 * Behavior:
 *   - If a record with slide_order = slot_order already exists → UPDATE it
 *   - Otherwise → INSERT a new record
 *   - Old image file is deleted from disk on update
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../auth.php';
requireAdminAuth(true);

/* ── Only allow POST ───────────────────────── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

/* ── DB connection ─────────────────────────── */
require_once __DIR__ . '/../../includes/db.php';

/* ── Input validation ──────────────────────── */
$slotOrder = isset($_POST['slot_order']) ? (int) $_POST['slot_order'] : 0;
$eyebrow   = trim($_POST['eyebrow'] ?? '');
$title     = trim($_POST['title']   ?? '');

if ($slotOrder < 1 || $slotOrder > 4) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid slot order. Must be 1–4.']));
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $uploadErrors = [
        UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit (upload_max_filesize).',
        UPLOAD_ERR_FORM_SIZE  => 'File exceeds form max size.',
        UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the upload.',
    ];
    $errCode = $_FILES['file']['error'] ?? UPLOAD_ERR_NO_FILE;
    $errMsg  = $uploadErrors[$errCode] ?? 'Unknown upload error.';
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => $errMsg]));
}

/* ── File type & size checks (server-side) ─── */
$file     = $_FILES['file'];
$allowed  = ['image/jpeg', 'image/png', 'image/webp'];
$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowed, true)) {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, WEBP allowed.']));
}


/* ── Save file to disk ─────────────────────── */
$uploadDir = __DIR__ . '/../../assets/images/banners/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext      = match ($mimeType) {
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    default      => 'jpg',
};
$filename    = 'banner_slide_' . $slotOrder . '_' . time() . '.' . $ext;
$destination = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Failed to save uploaded file on server.']));
}

// Web-accessible path (relative to project root, used in <img src>)
$webPath = 'assets/images/banners/' . $filename;

/* ── Insert or Update DB record ────────────── */
try {
    // Check if a record already exists for this slot_order
    $stmt = $pdo->prepare('SELECT id, image FROM banner_images WHERE slide_order = ? LIMIT 1');
    $stmt->execute([$slotOrder]);
    $existing = $stmt->fetch();

    if ($existing) {
        /* UPDATE — also delete the old image file */
        $oldFile = __DIR__ . '/../../' . $existing['image'];
        if (is_file($oldFile)) {
            @unlink($oldFile);
        }

        $stmt = $pdo->prepare(
            'UPDATE banner_images
                SET image = ?, eyebrow_text = ?, slide_title = ?, is_active = 1, updated_at = NOW()
              WHERE id = ?'
        );
        $stmt->execute([$webPath, $eyebrow, $title, $existing['id']]);
        $recordId = $existing['id'];

    } else {
        /* INSERT */
        $stmt = $pdo->prepare(
            'INSERT INTO banner_images (image, eyebrow_text, slide_title, slide_order, is_active)
             VALUES (?, ?, ?, ?, 1)'
        );
        $stmt->execute([$webPath, $eyebrow, $title, $slotOrder]);
        $recordId = $pdo->lastInsertId();
    }

    exit(json_encode([
        'success' => true,
        'message' => 'Slide ' . str_pad($slotOrder, 2, '0', STR_PAD_LEFT) . ' image saved successfully.',
        'data'    => [
            'id'          => (int) $recordId,
            'image_path'  => $webPath,
            'slide_order' => $slotOrder,
        ],
    ]));

} catch (PDOException $e) {
    // Delete the uploaded file so disk is not littered on DB failure
    @unlink($destination);
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
