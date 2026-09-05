<?php
$adminPage  = 'banner';
$adminTitle = 'Banner Image';
require __DIR__ . '/admin-header.php';

/**
 * BANNER IMAGE MANAGER — Live DB version
 * ─────────────────────────────────────────────────────────────
 * Reads slides from banner_images table ordered by slide_order.
 * Always renders all 4 slots (slot 1–4); empty slots show the
 * upload prompt instead of an image preview.
 */
require_once __DIR__ . '/../includes/db.php';

/* ── Fetch all existing banner records ─── */
$stmt = $pdo->query(
    'SELECT id, image, eyebrow_text, slide_title, slide_order, is_active
       FROM banner_images
      ORDER BY slide_order ASC'
);
$dbRows = $stmt->fetchAll();

/* ── Index by slide_order for quick lookup ─ */
$dbBySlot = [];
foreach ($dbRows as $row) {
    $dbBySlot[(int)$row['slide_order']] = $row;
}

/* ── Build the 4 canonical slot array ───── */
$bannerSlots = [];
for ($i = 1; $i <= 4; $i++) {
    if (isset($dbBySlot[$i])) {
        $r = $dbBySlot[$i];
        $bannerSlots[] = [
            'id'      => (int) $r['id'],
            'order'   => $i,
            'eyebrow' => $r['eyebrow_text'] ?? '',
            'title'   => $r['slide_title']  ?? '',
            'image'   => $r['image']         ?? '',
            'active'  => (bool) $r['is_active'],
        ];
    } else {
        $bannerSlots[] = [
            'id'      => 0,      // 0 = no DB record yet
            'order'   => $i,
            'eyebrow' => '',
            'title'   => '',
            'image'   => '',
            'active'  => false,
        ];
    }
}

$activeCount = count(array_filter($bannerSlots, fn($s) => $s['active']));
?>

<!-- ========== PAGE CONTENT ========== -->
<div class="admin-content fade-in">

    <!-- Page Header -->
    <div class="page-header">
        <p class="page-header__eyebrow">Content Management</p>
        <h1 class="page-header__title">Banner Image Manager</h1>
        <p class="page-header__desc">
            Upload and manage the hero banner images shown on the homepage. Changes are saved to the database and reflect on the site immediately.
        </p>
    </div>

    <!-- Info Strip -->
    <div class="info-strip fade-in fade-in-delay-1">
        <span class="info-strip__icon">🗄️</span>
        <span class="info-strip__text">
            <strong>Live Mode:</strong> Connected to <code>clad_theory → banner_images</code>. Uploads are saved to the server and database in real time.
        </span>
        <a href="../index.php" target="_blank" class="btn btn--sm btn--ghost">Preview Site →</a>
    </div>

    <!-- ── Quick Upload ─────────────────────────── -->
    <div class="card fade-in fade-in-delay-2" style="margin-bottom: 2rem;">
        <div class="card__head">
            <h2 class="card__title">
                <span class="card__title-icon">⚡</span>
                Quick Upload
            </h2>
            <span style="font-size:0.75rem; color:var(--admin-muted);">Any dimension or resolution</span>
        </div>

        <div class="upload-zone" id="quickUploadZone" role="button" tabindex="0" aria-label="Upload banner images">
            <input type="file" id="quickFileInput" accept="image/jpeg,image/png,image/webp" aria-hidden="true">
            <span class="upload-zone__icon">🖼️</span>
            <p class="upload-zone__title">Drop image here or click to browse</p>
            <p class="upload-zone__sub">Drag &amp; drop your banner image. <span>Click to select file.</span></p>
            <div class="upload-zone__formats">
                <span class="format-badge">JPG</span>
                <span class="format-badge">PNG</span>
                <span class="format-badge">WEBP</span>
                <span class="format-badge">Any resolution</span>
                <span class="format-badge">Any size</span>
            </div>
        </div>

        <!-- Upload Progress -->
        <div class="upload-progress" id="uploadProgress" hidden>
            <div class="upload-progress__inner">
                <span class="upload-progress__name" id="uploadFileName">Uploading...</span>
                <span class="upload-progress__pct" id="uploadPct">0%</span>
            </div>
            <div class="upload-progress__bar">
                <div class="upload-progress__fill" id="uploadFill"></div>
            </div>
        </div>
    </div>

    <!-- ── Banner Slots ──────────────────────────── -->
    <div class="card fade-in fade-in-delay-3">
        <div class="card__head">
            <h2 class="card__title">
                <span class="card__title-icon">🎬</span>
                Homepage Slider Slides
            </h2>
            <div style="display:flex;gap:0.5rem;align-items:center;">
                <span class="slot-status slot-status--active" id="activeCountBadge">
                    <?php echo $activeCount; ?> Active
                </span>
                <button class="btn btn--sm btn--secondary" id="saveAllBtn">💾 Save All</button>
            </div>
        </div>

        <div class="banner-grid" id="bannerGrid">

            <?php foreach ($bannerSlots as $index => $slot): ?>
            <div class="banner-slot fade-in"
                 style="animation-delay: <?php echo $index * 0.07; ?>s;"
                 data-slot-order="<?php echo $slot['order']; ?>"
                 data-record-id="<?php echo $slot['id']; ?>">

                <!-- Slot Header -->
                <div class="banner-slot__header">
                    <div class="banner-slot__number">
                        <div class="banner-slot__num-badge"><?php echo str_pad($slot['order'], 2, '0', STR_PAD_LEFT); ?></div>
                        <span class="banner-slot__label">Slide <?php echo $slot['order']; ?></span>
                    </div>
                    <span class="slot-status <?php echo $slot['active'] ? 'slot-status--active' : 'slot-status--empty'; ?>"
                          id="badge-<?php echo $slot['order']; ?>">
                        <?php echo $slot['active'] ? 'Active' : 'Empty'; ?>
                    </span>
                </div>

                <!-- Image Preview -->
                <div class="banner-slot__preview" id="preview-<?php echo $slot['order']; ?>">
                    <?php if ($slot['image']): ?>
                        <img src="<?php echo htmlspecialchars('../' . $slot['image']); ?>"
                             alt="Slide <?php echo $slot['order']; ?> preview"
                             id="previewImg-<?php echo $slot['order']; ?>"
                             onerror="this.style.display='none'; document.getElementById('emptyState-<?php echo $slot['order']; ?>').style.display='flex';">
                        <div class="preview-empty" id="emptyState-<?php echo $slot['order']; ?>" style="display:none;">
                    <?php else: ?>
                        <div class="preview-empty" id="emptyState-<?php echo $slot['order']; ?>">
                    <?php endif; ?>
                            <span class="preview-empty__icon">📷</span>
                            <span class="preview-empty__text">No image uploaded</span>
                        </div>

                    <!-- Hover Overlay -->
                    <div class="preview-overlay">
                        <button class="overlay-btn overlay-btn--primary"
                                onclick="triggerSlotUpload(<?php echo $slot['order']; ?>)">
                            📤 Change
                        </button>
                        <button class="overlay-btn overlay-btn--danger"
                                onclick="removeSlotImage(<?php echo $slot['order']; ?>)">
                            🗑️ Remove
                        </button>
                    </div>
                </div>

                <!-- Hidden file input -->
                <input type="file"
                       id="slotFile-<?php echo $slot['order']; ?>"
                       accept="image/jpeg,image/png,image/webp"
                       style="display:none;"
                       onchange="handleSlotFileChange(event, <?php echo $slot['order']; ?>)">

                <!-- Meta fields -->
                <div class="banner-slot__meta">
                    <div class="slot-meta-grid">
                        <div class="slot-meta__field">
                            <label for="eyebrow-<?php echo $slot['order']; ?>">Eyebrow Text</label>
                            <input type="text"
                                   id="eyebrow-<?php echo $slot['order']; ?>"
                                   value="<?php echo htmlspecialchars($slot['eyebrow']); ?>"
                                   placeholder="e.g. Trend">
                        </div>
                        <div class="slot-meta__field">
                            <label for="title-<?php echo $slot['order']; ?>">Slide Title</label>
                            <input type="text"
                                   id="title-<?php echo $slot['order']; ?>"
                                   value="<?php echo htmlspecialchars($slot['title']); ?>"
                                   placeholder="e.g. Wind in the Storms">
                        </div>
                    </div>
                    <div class="slot-actions">
                        <button class="btn btn--sm btn--primary btn--full"
                                onclick="saveSlot(<?php echo $slot['order']; ?>)"
                                id="saveBtn-<?php echo $slot['order']; ?>"
                                <?php echo $slot['id'] === 0 ? 'disabled title="Upload an image first"' : ''; ?>>
                            💾 Save Slide <?php echo str_pad($slot['order'], 2, '0', STR_PAD_LEFT); ?>
                        </button>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>

        </div><!-- /.banner-grid -->
    </div><!-- /.card -->

</div><!-- /.admin-content -->


<!-- ========== UPLOAD CONFIRM MODAL ========== -->
<div class="modal-backdrop" id="confirmModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal">
        <div class="modal__head">
            <h2 class="modal__title" id="modalTitle">🖼️ Preview Upload</h2>
            <button class="modal__close" onclick="closeModal()" aria-label="Close modal">✕</button>
        </div>

        <div style="margin-bottom:1.25rem; border-radius:10px; overflow:hidden; background:var(--admin-surface-2); max-height:260px;">
            <img id="modalPreviewImg" src="" alt="Preview" style="width:100%; height:260px; object-fit:cover; display:block;">
        </div>

        <!-- Slot selector (shown only on quick-upload) -->
        <div id="slotSelectorWrap" style="margin-bottom:1rem;">
            <label style="font-size:0.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--admin-muted-2);display:block;margin-bottom:4px;">
                Assign to Slide Slot
            </label>
            <select id="modalSlotSelect"
                    style="width:100%;background:var(--admin-surface-2);border:1px solid var(--admin-border);border-radius:8px;
                           padding:0.55rem 0.8rem;font-size:0.85rem;color:var(--admin-text);font-family:inherit;outline:none;">
                <option value="1">Slide 01</option>
                <option value="2">Slide 02</option>
                <option value="3">Slide 03</option>
                <option value="4">Slide 04</option>
            </select>
        </div>

        <p style="font-size:0.82rem; color:var(--admin-muted); margin-bottom:1.25rem;">
            Image ready ✅ — it will be saved to the server and database immediately.
        </p>

        <div style="display:flex;gap:0.75rem;">
            <button class="btn btn--primary btn--full" id="modalConfirmBtn" onclick="confirmUpload()">
                ✅ &nbsp;Upload &amp; Apply
            </button>
            <button class="btn btn--secondary" onclick="closeModal()" style="white-space:nowrap;">Cancel</button>
        </div>
    </div>
</div>


<style>
/* ── Info strip ─────── */
.info-strip {
    background: rgba(213,21,95,0.08);
    border: 1px solid rgba(213,21,95,0.22);
    border-radius: 12px;
    padding: 0.9rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
}
.info-strip__icon { font-size: 1.1rem; flex-shrink: 0; }
.info-strip__text { font-size: 0.82rem; color: var(--admin-muted); flex: 1; min-width: 200px; }
.info-strip__text strong { color: var(--admin-text); }
.info-strip__text code {
    background: var(--admin-surface-2);
    border: 1px solid var(--admin-border);
    border-radius: 4px;
    padding: 1px 6px;
    font-size: 0.78rem;
    color: var(--brand-pink);
}

/* ── Upload Progress ─── */
.upload-progress {
    margin-top: 1.25rem;
    background: var(--admin-surface-2);
    border-radius: 10px;
    padding: 1rem 1.25rem;
}
.upload-progress__inner {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    margin-bottom: 0.6rem;
    color: var(--admin-muted);
}
.upload-progress__name { color: var(--admin-text); font-weight: 600; }
.upload-progress__bar {
    height: 6px;
    background: var(--admin-surface-3);
    border-radius: 99px;
    overflow: hidden;
}
.upload-progress__fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, var(--brand-pink), var(--brand-pink-deep));
    border-radius: 99px;
    transition: width 0.15s ease;
}

/* Disabled save btn */
button:disabled {
    opacity: 0.45;
    cursor: not-allowed;
}

/* Modal select */
#modalSlotSelect { cursor: pointer; }
#modalSlotSelect option { background: var(--admin-surface); }
</style>


<script>
/* ======================================================
   BANNER IMAGE MANAGER — Live DB mode
   API endpoints in admin/api/
   ====================================================== */

const API = {
    upload : 'api/banner_upload.php',
    save   : 'api/banner_save.php',
    delete : 'api/banner_delete.php',
};

let pendingFile    = null;
let pendingDataUrl = null;
let pendingSlot    = null; // null = use dropdown, number = specific slot

/* ─────────────────────────────────────────────────────
   QUICK UPLOAD ZONE
   ───────────────────────────────────────────────────── */
const quickZone  = document.getElementById('quickUploadZone');
const quickInput = document.getElementById('quickFileInput');

quickZone.addEventListener('dragover', e => {
    e.preventDefault();
    quickZone.classList.add('drag-over');
});
quickZone.addEventListener('dragleave', () => quickZone.classList.remove('drag-over'));
quickZone.addEventListener('drop', e => {
    e.preventDefault();
    quickZone.classList.remove('drag-over');
    if (e.dataTransfer.files.length) handleFile(e.dataTransfer.files[0], null);
});
quickZone.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') quickInput.click();
});
quickInput.addEventListener('change', e => {
    if (e.target.files.length) handleFile(e.target.files[0], null);
    e.target.value = '';
});

/* ─────────────────────────────────────────────────────
   PER-SLOT TRIGGER
   ───────────────────────────────────────────────────── */
function triggerSlotUpload(slotOrder) {
    document.getElementById('slotFile-' + slotOrder).click();
}

function handleSlotFileChange(event, slotOrder) {
    const file = event.target.files[0];
    if (file) handleFile(file, slotOrder);
    event.target.value = '';
}

/* ─────────────────────────────────────────────────────
   CENTRAL FILE HANDLER
   ───────────────────────────────────────────────────── */
function handleFile(file, slotOrder) {
    if (!validateFileMeta(file)) return;

    showProgress(file.name);

    readFileAsDataUrl(file, dataUrl => {
        hideProgress();

        pendingFile    = file;
        pendingDataUrl = dataUrl;
        pendingSlot    = slotOrder;

        // Show/hide slot selector based on whether a slot was pre-chosen
        document.getElementById('slotSelectorWrap').style.display =
            slotOrder ? 'none' : 'block';
        if (slotOrder) {
            document.getElementById('modalSlotSelect').value = slotOrder;
        }

        openModal(dataUrl);
    });
}

/* ─────────────────────────────────────────────────────
   REMOVE SLIDE IMAGE (calls delete API)
   ───────────────────────────────────────────────────── */
function removeSlotImage(slotOrder) {
    const slotEl  = document.querySelector(`[data-slot-order="${slotOrder}"]`);
    const recordId = parseInt(slotEl.dataset.recordId);

    if (!recordId) {
        showToast('This slot has no image to remove.', 'info');
        return;
    }

    if (!confirm(`Remove the image from Slide ${String(slotOrder).padStart(2,'0')}?\nThis will permanently delete the file.`)) return;

    setSlotLoading(slotOrder, true);

    fetch(API.delete, {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json' },
        body    : JSON.stringify({ id: recordId }),
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            // Clear preview
            const img   = document.getElementById('previewImg-' + slotOrder);
            const empty = document.getElementById('emptyState-'  + slotOrder);
            if (img)   { img.src = ''; img.style.display = 'none'; }
            if (empty) { empty.style.display = 'flex'; }

            // Reset record id, disable save btn
            slotEl.dataset.recordId = '0';
            const saveBtn = document.getElementById('saveBtn-' + slotOrder);
            if (saveBtn) { saveBtn.disabled = true; saveBtn.title = 'Upload an image first'; }

            updateBadge(slotOrder, false);
            showToast('Slide ' + String(slotOrder).padStart(2,'0') + ' removed.', 'info');
        } else {
            showToast('Error: ' + res.message, 'error');
        }
    })
    .catch(() => showToast('Network error. Could not delete slide.', 'error'))
    .finally(() => setSlotLoading(slotOrder, false));
}

/* ─────────────────────────────────────────────────────
   MODAL
   ───────────────────────────────────────────────────── */
function openModal(dataUrl) {
    document.getElementById('modalPreviewImg').src = dataUrl;
    document.getElementById('confirmModal').classList.add('open');
}
function closeModal() {
    document.getElementById('confirmModal').classList.remove('open');
    pendingFile = pendingDataUrl = pendingSlot = null;
}

async function dataUrlToFile(dataUrl, filename) {
    const res = await fetch(dataUrl);
    const blob = await res.blob();
    return new File([blob], filename, { type: blob.type || 'image/jpeg' });
}

async function confirmUpload() {
    const fileToUpload = pendingFile;
    const dataUrl      = pendingDataUrl;
    const slotOrder    = pendingSlot
        ? parseInt(pendingSlot)
        : parseInt(document.getElementById('modalSlotSelect').value);

    if (!fileToUpload && !dataUrl) return;

    closeModal();
    showProgress(fileToUpload ? fileToUpload.name : 'banner.jpg');

    const eyebrow = document.getElementById('eyebrow-' + slotOrder).value.trim();
    const title   = document.getElementById('title-'   + slotOrder).value.trim();

    const actualFile = fileToUpload || await dataUrlToFile(dataUrl, 'banner.jpg');

    const formData = new FormData();
    formData.append('file',       actualFile);
    formData.append('slot_order', slotOrder);
    formData.append('eyebrow',    eyebrow);
    formData.append('title',      title);

    // Use XHR for real upload progress
    const xhr = new XMLHttpRequest();
    xhr.open('POST', API.upload);

    xhr.upload.addEventListener('progress', e => {
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 100);
            document.getElementById('uploadFill').style.width = pct + '%';
            document.getElementById('uploadPct').textContent  = pct + '%';
        }
    });

    xhr.addEventListener('load', () => {
        hideProgress();
        let res;
        try { res = JSON.parse(xhr.responseText); }
        catch (e) { showToast('Server returned an invalid response.', 'error'); return; }

        if (res.success) {
            // Update the preview card with the new image
            applyImageToSlot(slotOrder, res.data.image_path, res.data.id);
            showToast(res.message, 'success');
        } else {
            showToast('Upload failed: ' + res.message, 'error');
        }
    });

    xhr.addEventListener('error', () => {
        hideProgress();
        showToast('Network error. Upload failed.', 'error');
    });

    xhr.send(formData);
}

/* ─────────────────────────────────────────────────────
   APPLY IMAGE TO SLOT CARD (after successful upload)
   ───────────────────────────────────────────────────── */
function applyImageToSlot(slotOrder, webPath, newId) {
    let img = document.getElementById('previewImg-' + slotOrder);
    const empty = document.getElementById('emptyState-' + slotOrder);
    const slotEl = document.querySelector(`[data-slot-order="${slotOrder}"]`);

    if (!img) {
        img    = document.createElement('img');
        img.id  = 'previewImg-' + slotOrder;
        img.alt = 'Slide ' + slotOrder + ' preview';
        document.getElementById('preview-' + slotOrder).prepend(img);
    }

    // Add cache-buster so the browser reloads the new image
    img.src = '../' + webPath + '?t=' + Date.now();
    img.style.display = 'block';
    if (empty) empty.style.display = 'none';

    // Update record id on the slot element
    if (slotEl && newId) {
        slotEl.dataset.recordId = newId;
        const saveBtn = document.getElementById('saveBtn-' + slotOrder);
        if (saveBtn) { saveBtn.disabled = false; saveBtn.removeAttribute('title'); }
    }

    updateBadge(slotOrder, true);
}

/* ─────────────────────────────────────────────────────
   SAVE METADATA (eyebrow + title) via AJAX
   ───────────────────────────────────────────────────── */
function saveSlot(slotOrder) {
    const slotEl   = document.querySelector(`[data-slot-order="${slotOrder}"]`);
    const recordId = parseInt(slotEl.dataset.recordId);

    if (!recordId) {
        showToast('Upload an image for this slot first.', 'error');
        return;
    }

    const eyebrow = document.getElementById('eyebrow-' + slotOrder).value.trim();
    const title   = document.getElementById('title-'   + slotOrder).value.trim();

    if (!title) {
        showToast('Slide title cannot be empty.', 'error');
        document.getElementById('title-' + slotOrder).focus();
        return;
    }

    setSlotLoading(slotOrder, true);

    fetch(API.save, {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json' },
        body    : JSON.stringify({ id: recordId, eyebrow, title }),
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast('Slide ' + String(slotOrder).padStart(2,'0') + ' — "' + title + '" saved ✅', 'success');
        } else {
            showToast('Save failed: ' + res.message, 'error');
        }
    })
    .catch(() => showToast('Network error. Could not save metadata.', 'error'))
    .finally(() => setSlotLoading(slotOrder, false));
}

document.getElementById('saveAllBtn').addEventListener('click', () => {
    for (let i = 1; i <= 4; i++) {
        const slotEl = document.querySelector(`[data-slot-order="${i}"]`);
        if (slotEl && parseInt(slotEl.dataset.recordId) > 0) saveSlot(i);
    }
});

/* ─────────────────────────────────────────────────────
   HELPERS
   ───────────────────────────────────────────────────── */
function updateBadge(slotOrder, active) {
    const badge = document.getElementById('badge-' + slotOrder);
    if (!badge) return;
    badge.className = 'slot-status ' + (active ? 'slot-status--active' : 'slot-status--empty');
    badge.textContent = active ? 'Active' : 'Empty';

    // Recalculate global active count
    const allBadges = document.querySelectorAll('.slot-status.slot-status--active');
    const countBadge = document.getElementById('activeCountBadge');
    // Subtract 1 for the header badge itself
    const count = [...allBadges].filter(b => b.id !== 'activeCountBadge').length;
    if (countBadge) countBadge.textContent = count + ' Active';
}

function setSlotLoading(slotOrder, loading) {
    const btn = document.getElementById('saveBtn-' + slotOrder);
    if (!btn) return;
    if (loading) {
        btn.dataset.origText = btn.textContent;
        btn.textContent = '⏳ Saving...';
        btn.disabled = true;
    } else {
        btn.textContent = btn.dataset.origText || ('💾 Save Slide ' + String(slotOrder).padStart(2,'0'));
        btn.disabled = false;
    }
}

/* ── Progress UI ──────────────────────────────── */
function showProgress(filename) {
    const el = document.getElementById('uploadProgress');
    el.hidden = false;
    document.getElementById('uploadFileName').textContent = filename;
    document.getElementById('uploadFill').style.width = '0%';
    document.getElementById('uploadPct').textContent  = '0%';
}
function hideProgress() {
    document.getElementById('uploadFill').style.width = '100%';
    document.getElementById('uploadPct').textContent  = '100%';
    setTimeout(() => {
        document.getElementById('uploadProgress').hidden = true;
        document.getElementById('uploadFill').style.width = '0%';
    }, 600);
}

/* ── File validation (meta) ───────────────────── */
function validateFileMeta(file) {
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    if (!allowed.includes(file.type)) {
        showToast('Invalid file type. Please use JPG, PNG, or WEBP.', 'error');
        return false;
    }
    return true;
}

/* ── Read file to base64 data URL ─────────────── */
function readFileAsDataUrl(file, callback) {
    const reader = new FileReader();
    reader.onload = e => callback(e.target.result);
    reader.readAsDataURL(file);
}

/* ── Close modal on backdrop click ────────────── */
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<?php require __DIR__ . '/admin-footer.php'; ?>
