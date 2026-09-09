<?php
/**
 * API: Create Category
 * ─────────────────────────────────────────────────
 * POST /admin/api/category_create.php
 *
 * Accepted multipart/form-data fields:
 *   name        (required) — category title
 *   description (optional) — free-text description
 *   status      (optional) — 'active' | 'inactive'  (default: active)
 *   is_featured (optional) — '1' | '0'              (default: 0)
 *   thumbnail   (optional) — image file (PNG/JPG/WEBP, ≤ 5 MB)
 *
 * Returns JSON: { success, message, data? }
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

/* ── Only allow POST ───────────────────────── */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['success' => false, 'message' => 'Method not allowed.']));
}

/* ── DB connection ─────────────────────────── */
require_once __DIR__ . '/../../includes/db.php';

/* ── Sanitise scalar inputs ────────────────── */
$name        = trim($_POST['name']        ?? '');
$description = trim($_POST['description'] ?? '');
$status      = in_array($_POST['status'] ?? '', ['active','inactive'], true)
               ? $_POST['status'] : 'active';
$isFeatured  = isset($_POST['is_featured']) && $_POST['is_featured'] === '1' ? 1 : 0;

if ($name === '') {
    http_response_code(400);
    exit(json_encode(['success' => false, 'message' => 'Category name is required.']));
}

/* ── Handle optional image upload ──────────── */
$imagePath = null;

if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['thumbnail'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit.',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds form max size.',
            UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on server.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the upload.',
        ];
        http_response_code(400);
        exit(json_encode([
            'success' => false,
            'message' => $uploadErrors[$file['error']] ?? 'Unknown upload error.',
        ]));
    }

    /* MIME type check (server-side, not just extension) */
    $allowed  = ['image/jpeg', 'image/png', 'image/webp'];
    $finfo    = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowed, true)) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, WEBP allowed.']));
    }

    /* Size check: max 5 MB */
    if ($file['size'] > 5 * 1024 * 1024) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'message' => 'Image must be ≤ 5 MB.']));
    }

    /* Save to disk */
    $uploadDir = __DIR__ . '/../../assets/images/categories/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext      = match ($mimeType) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        default      => 'jpg',
    };
    $safeName = preg_replace('/[^a-z0-9_-]/', '_', strtolower($name));
    $filename    = 'cat_' . $safeName . '_' . time() . '.' . $ext;
    $destination = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        http_response_code(500);
        exit(json_encode(['success' => false, 'message' => 'Failed to save image on server.']));
    }

    $imagePath = 'assets/images/categories/' . $filename;
}

/* ── Insert into DB ────────────────────────── */
try {
    $stmt = $pdo->prepare(
        'INSERT INTO categories (name, description, image, status, is_featured)
         VALUES (:name, :description, :image, :status, :is_featured)'
    );
    $stmt->execute([
        ':name'        => $name,
        ':description' => $description !== '' ? $description : null,
        ':image'       => $imagePath,
        ':status'      => $status,
        ':is_featured' => $isFeatured,
    ]);

    $newId = (int) $pdo->lastInsertId();

    exit(json_encode([
        'success' => true,
        'message' => 'Category "' . $name . '" created successfully.',
        'data'    => [
            'id'          => $newId,
            'name'        => $name,
            'status'      => $status,
            'is_featured' => $isFeatured,
            'image'       => $imagePath,
        ],
    ]));

} catch (PDOException $e) {
    /* Duplicate name */
    if ($e->getCode() === '23000') {
        http_response_code(409);
        exit(json_encode(['success' => false, 'message' => 'A category with that name already exists.']));
    }
    /* Clean up uploaded file on DB failure */
    if ($imagePath) {
        @unlink(__DIR__ . '/../../' . $imagePath);
    }
    http_response_code(500);
    exit(json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]));
}
