<?php
$adminPage = 'categories';   // keeps "Categories" active in sidebar
$adminTitle = 'Add Category';
require __DIR__ . '/admin-header.php';

/**
 * ADD CATEGORY
 * ────────────────────────────────────────────────────────────
 * Connected to: admin/api/category_create.php
 * Table: categories
 */
?>

<!-- ========== PAGE CONTENT ========== -->
<div class="admin-content fade-in">

    <!-- Page Header with Back Button -->
    <div class="page-header" style="display:flex;align-items:center;gap:1rem;margin-bottom:1.75rem;">
        <a href="categories.php" class="btn btn--secondary btn--sm" id="backToCategoriesBtn" title="Back to Categories">
            &#8592; Back
        </a>
        <div>
            <p class="page-header__eyebrow">Catalogue</p>
            <h1 class="page-header__title" style="font-size:1.55rem;">Create Category</h1>
        </div>
    </div>

    <!-- ── Two-column layout ── -->
    <div class="addcat-layout">

        <!-- ════════════════════════════
             LEFT — Preview Panel
             ════════════════════════════ -->
        <aside class="addcat-preview-panel">

            <!-- Thumbnail preview -->
            <div class="addcat-preview-thumb" id="previewThumb">
                <div class="preview-featured-badge" id="previewFeaturedBadge">★ Featured</div>
                <img src="" alt="Category thumbnail" id="previewImg">
                <div class="addcat-preview-thumb__placeholder" id="previewPlaceholder">
                    <span class="addcat-preview-thumb__icon">🏷️</span>
                    <span class="addcat-preview-thumb__hint">No image yet</span>
                </div>
            </div>

            <div class="addcat-preview-body">
                <!-- Live name preview -->
                <div class="addcat-preview-name" id="previewName">Category Name</div>

                <!-- Meta grid -->
                <div class="addcat-preview-meta">
                    <div class="addcat-preview-meta__item">
                        <label>Status</label>
                        <span id="previewStatus">Active</span>
                    </div>
                    <div class="addcat-preview-meta__item">
                        <label>Featured</label>
                        <span id="previewFeatured" class="preview-featured-pill">No</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="addcat-preview-actions">
                    <button type="button" class="btn btn--danger-outline btn--sm btn--full" id="deleteCategoryBtn"
                        onclick="resetForm()">
                        Delete Category
                    </button>
                    <a href="categories.php" class="btn btn--orange btn--sm btn--full" id="cancelPreviewBtn">
                        Cancel
                    </a>
                </div>
            </div>
        </aside>

        <!-- ════════════════════════════
             RIGHT — Form Area
             ════════════════════════════ -->
        <div class="addcat-form-area">
            <form id="addCategoryForm" novalidate onsubmit="event.preventDefault(); submitForm();">

                <!-- ── Thumbnail Upload ── -->
                <div class="addcat-section fade-in fade-in-delay-1">
                    <div class="addcat-section__title">Add Thumbnail Photo</div>
                    <div class="addcat-section__body">
                        <div class="addcat-upload-zone" id="uploadZone">
                            <input type="file" id="thumbInput" name="thumbnail" accept="image/png,image/jpeg,image/webp"
                                aria-label="Upload thumbnail image">
                            <span class="addcat-upload-icon">☁️</span>
                            <p class="addcat-upload-text">
                                Drop your images here, or <span>click to browse</span>
                            </p>
                            <p class="addcat-upload-hint">
                                Up to 5 MB recommended. PNG, JPG, WEBP supported.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ── General Information ── -->
                <div class="addcat-section fade-in fade-in-delay-2">
                    <div class="addcat-section__title">General Information</div>
                    <div class="addcat-section__body">
                        <div class="addcat-form-grid">

                            <!-- Category Title -->
                            <div class="addcat-field">
                                <label for="catTitle">Category Title</label>
                                <input type="text" id="catTitle" name="title" placeholder="Enter Title"
                                    autocomplete="off">
                            </div>

                            <!-- Status -->
                            <div class="addcat-field">
                                <label for="catStatus">Status</label>
                                <select id="catStatus" name="status">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Is Featured Toggle -->
                            <div class="addcat-form-grid--full">
                                <div class="cat-toggle-card" id="catFeaturedCard">
                                    <div class="cat-toggle-info">
                                        <div class="cat-toggle-header">
                                            <span class="cat-toggle-icon">⭐</span>
                                            <span class="cat-toggle-title">Feature this category</span>
                                            <span class="cat-toggle-tag" id="catFeaturedTag">Standard</span>
                                        </div>
                                        <p class="cat-toggle-desc">Showcase this category in the top highlight cards on the categories page and storefront.</p>
                                    </div>
                                    <label class="cat-switch" for="catFeatured" aria-label="Feature this category switch">
                                        <input type="checkbox"
                                               id="catFeatured"
                                               name="is_featured"
                                               value="1">
                                        <span class="cat-switch-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="addcat-field addcat-form-grid--full">
                                <label for="catDescription">Description</label>
                                <textarea id="catDescription" name="description" placeholder="Type description…"
                                    rows="4"></textarea>
                            </div>

                        </div><!-- /.addcat-form-grid -->
                    </div>
                </div>

                <!-- ── Meta Options ── -->


            </form><!-- /#addCategoryForm -->
        </div><!-- /.addcat-form-area -->

    </div><!-- /.addcat-layout -->

</div><!-- /.admin-content -->

<!-- ── Sticky footer action bar ── -->
<div class="addcat-footer-bar" id="addcatFooter">
    <button type="button" class="btn btn--secondary" id="resetFormBtn" onclick="resetForm()">
        Reset Changes
    </button>
    <button type="button" class="btn btn--orange" id="submitFormBtn" onclick="submitForm()">
        Submit
    </button>
</div>

<script>
    /* ======================================================
       ADD CATEGORY PAGE — JS
       ====================================================== */

    /* ── Element refs ── */
    const catTitle        = document.getElementById('catTitle');
    const catStatus       = document.getElementById('catStatus');
    const catFeatured     = document.getElementById('catFeatured');
    const catFeaturedCard = document.getElementById('catFeaturedCard');
    const thumbInput      = document.getElementById('thumbInput');
    const previewImg      = document.getElementById('previewImg');
    const previewPlaceholder = document.getElementById('previewPlaceholder');
    const uploadZone      = document.getElementById('uploadZone');

    /* ── Toggle card click anywhere ── */
    if (catFeaturedCard && catFeatured) {
        catFeaturedCard.addEventListener('click', function (e) {
            if (e.target.closest('.cat-switch')) return;
            catFeatured.checked = !catFeatured.checked;
            catFeatured.dispatchEvent(new Event('change'));
        });
    }

    /* ── Live preview sync ── */
    function syncPreview() {
        document.getElementById('previewName').textContent =
            catTitle.value.trim() || 'Category Name';
        document.getElementById('previewStatus').textContent =
            catStatus.value === 'inactive' ? 'Inactive' : 'Active';

        const isFeatured = catFeatured ? catFeatured.checked : false;
        const featuredCard = document.getElementById('catFeaturedCard');
        const featuredTag  = document.getElementById('catFeaturedTag');
        const previewFeat  = document.getElementById('previewFeatured');
        const featBadge    = document.getElementById('previewFeaturedBadge');

        if (featuredCard) {
            featuredCard.classList.toggle('is-active', isFeatured);
        }
        if (featuredTag) {
            featuredTag.textContent = isFeatured ? '★ Featured' : 'Standard';
            featuredTag.classList.toggle('is-featured', isFeatured);
        }
        if (previewFeat) {
            previewFeat.textContent = isFeatured ? '★ Yes' : 'No';
            previewFeat.classList.toggle('is-active', isFeatured);
        }
        if (featBadge) {
            featBadge.style.display = isFeatured ? 'inline-flex' : 'none';
        }
    }

    catTitle.addEventListener('input', syncPreview);
    catStatus.addEventListener('change', syncPreview);
    if (catFeatured) catFeatured.addEventListener('change', syncPreview);

    // Initial sync
    syncPreview();

    /* ── Image preview ── */
    thumbInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            previewImg.src = e.target.result;
            previewImg.classList.add('visible');
            previewPlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    /* Drag & drop */
    uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('drag-over'); });
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            thumbInput.files = e.dataTransfer.files;
            thumbInput.dispatchEvent(new Event('change'));
        }
    });

    /* ── Reset form ── */
    function resetForm() {
        if (!confirm('Reset all fields? Unsaved data will be lost.')) return;
        document.getElementById('addCategoryForm').reset();
        if (catFeatured) catFeatured.checked = false;
        previewImg.src = '';
        previewImg.classList.remove('visible');
        previewPlaceholder.style.display = '';
        syncPreview();
        showToast('Form reset.', 'info');
    }

    /* ── Submit — POST to category_create.php ── */
    async function submitForm() {
        const name = catTitle.value.trim();
        if (!name) {
            showToast('Please enter a Category Title.', 'error');
            catTitle.focus();
            return;
        }

        const submitBtn = document.getElementById('submitFormBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving…';

        const fd = new FormData();
        fd.append('name',        name);
        fd.append('description', document.getElementById('catDescription').value.trim());
        fd.append('status',      catStatus.value);
        fd.append('is_featured', document.getElementById('catFeatured').checked ? '1' : '0');
        if (thumbInput.files[0]) {
            fd.append('thumbnail', thumbInput.files[0]);
        }

        try {
            const res  = await fetch('api/category_create.php', { method: 'POST', body: fd });
            const data = await res.json();

            if (data.success) {
                showToast(data.message, 'success');
                /* Redirect to categories list after a short delay */
                setTimeout(() => { window.location.href = 'categories.php'; }, 1200);
            } else {
                showToast(data.message || 'Something went wrong.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit';
            }
        } catch (err) {
            showToast('Network error — please try again.', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit';
        }
    }
</script>

<?php require __DIR__ . '/admin-footer.php'; ?>