<?php
$adminPage = 'categories';
$adminTitle = 'Categories List';
require __DIR__ . '/admin-header.php';

/**
 * CATEGORIES LIST — Live DB version
 * ────────────────────────────────────────────────────────────
 * Reads from the `categories` table.
 */
require_once __DIR__ . '/../includes/db.php';

$flash = $_GET['msg'] ?? '';

$categories = [];
$featured = [];
$dbError = null;

try {
    $stmt = $pdo->query('SELECT id, name, description, image, status, is_featured, created_at FROM categories ORDER BY id DESC');
    $categories = $stmt->fetchAll();

    $stmtFeat = $pdo->query('SELECT id, name, description, image, status, is_featured FROM categories WHERE is_featured = 1 ORDER BY id DESC LIMIT 4');
    $featured = $stmtFeat->fetchAll();
} catch (PDOException $e) {
    // If the table doesn't exist yet or DB issue, capture error gracefully
    $dbError = $e->getMessage();
}
?>

<!-- ========== PAGE CONTENT ========== -->
<div class="admin-content fade-in">

    <?php if ($flash !== ''): ?>
        <script>document.addEventListener('DOMContentLoaded', () => showToast(<?php echo json_encode(htmlspecialchars_decode($flash)); ?>, 'success'));</script>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <p class="page-header__eyebrow">Catalogue</p>
        <h1 class="page-header__title">Categories List</h1>

    </div>

    <!-- ── Featured Category Cards ── -->
    <div class="cat-featured-grid">
        <?php if (empty($featured)): ?>
            <!-- placeholder cards shown when no featured categories exist yet -->
            <div class="cat-featured-card fade-in fade-in-delay-1">
                <div class="cat-featured-card__thumb cat-featured-card__thumb--fashion">🏷️</div>
                <div class="cat-featured-card__name" style="color:var(--admin-muted)">No featured categories yet</div>
            </div>
        <?php else: ?>
            <?php
            $thumbBgs = ['cat-featured-card__thumb--fashion', 'cat-featured-card__thumb--electronics', 'cat-featured-card__thumb--footwear', 'cat-featured-card__thumb--eyewear'];
            foreach ($featured as $fi => $fc):
                $bgClass = $thumbBgs[$fi % 4];
                ?>
                <div class="cat-featured-card fade-in fade-in-delay-<?php echo $fi + 1; ?>">
                    <div class="cat-featured-card__thumb <?php echo $bgClass; ?>">
                        <?php if (!empty($fc['image'])): ?>
                            <img src="../<?php echo htmlspecialchars($fc['image']); ?>"
                                alt="<?php echo htmlspecialchars($fc['name']); ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            🏷️
                        <?php endif; ?>
                    </div>
                    <div class="cat-featured-card__name"><?php echo htmlspecialchars($fc['name']); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div><!-- /.cat-featured-grid -->

    <!-- ── All Categories Table ── -->
    <div class="cat-table-section fade-in fade-in-delay-2">

        <!-- Table Header -->
        <div class="cat-table-header">
            <span class="cat-table-header__title">All Categories List</span>
            <div class="cat-table-header__actions">
                <a href="add-category.php" class="btn btn--orange btn--sm" id="addCategoryBtn">
                    + Add Category
                </a>
                <select class="cat-filter-select" id="catFilterPeriod" aria-label="Filter by period">
                    <option value="month">This Month</option>
                    <option value="week">This Week</option>
                    <option value="today">Today</option>
                    <option value="all">All Time</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="cat-table-wrap">
            <table class="cat-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="cat-checkbox" id="selectAll" title="Select all"></th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>ID</th>
                        <th>Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($dbError !== null): ?>
                        <tr>
                            <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--admin-muted);">
                                ⚠️ Database table <code>categories</code> not found. Please run <code
                                    style="color:var(--brand-pink);">create_categories_table.sql</code> in your database.
                            </td>
                        </tr>
                    <?php elseif (empty($categories)): ?>
                        <tr>
                            <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--admin-muted);">
                                No categories yet. <a href="add-category.php"
                                    style="color:var(--brand-pink);font-weight:600;">Add the first one &rarr;</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <!-- Checkbox -->
                                <td>
                                    <input type="checkbox" class="cat-checkbox row-check" title="Select row">
                                </td>

                                <!-- Name + thumbnail -->
                                <td>
                                    <div class="cat-name-cell">
                                        <div class="cat-thumb">
                                            <?php if (!empty($cat['image'])): ?>
                                                <img src="../<?php echo htmlspecialchars($cat['image']); ?>"
                                                    alt="<?php echo htmlspecialchars($cat['name']); ?>">
                                            <?php else: ?>
                                                🏷️
                                            <?php endif; ?>
                                        </div>
                                        <span class="cat-name-link" style="color:var(--admin-text);font-weight:600;">
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
                                    <?php if ($cat['status'] === 'active'): ?>
                                        <span class="slot-status slot-status--active">Active</span>
                                    <?php else: ?>
                                        <span class="slot-status slot-status--empty">Inactive</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Featured -->
                                <td>
                                    <button type="button"
                                        class="cat-feat-toggle-btn <?php echo !empty($cat['is_featured']) ? 'is-featured' : ''; ?>"
                                        title="Click to toggle featured status"
                                        onclick="toggleFeatured(<?php echo $cat['id']; ?>, <?php echo !empty($cat['is_featured']) ? 0 : 1; ?>)">
                                        <?php echo !empty($cat['is_featured']) ? '★ Featured' : '☆ Standard'; ?>
                                    </button>
                                </td>

                                <!-- ID -->
                                <td>
                                    <span class="cat-id" style="color:var(--admin-muted);">
                                        #<?php echo $cat['id']; ?>
                                    </span>
                                </td>

                                <!-- Added date -->
                                <td style="font-size:0.78rem;color:var(--admin-muted);">
                                    <?php echo date('d M Y', strtotime($cat['created_at'])); ?>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="cat-actions">
                                        <button class="cat-action-btn" title="View"
                                            onclick="showToast('<?php echo htmlspecialchars($cat['name'], ENT_QUOTES); ?>','info')">
                                            👁️
                                        </button>
                                        <button class="cat-action-btn cat-action-btn--edit" title="Edit"
                                            onclick="showToast('Edit coming soon.','info')">
                                            ✏️
                                        </button>
                                        <button class="cat-action-btn cat-action-btn--danger" title="Delete"
                                            onclick="confirmDelete(<?php echo $cat['id']; ?>, '<?php echo htmlspecialchars($cat['name'], ENT_QUOTES); ?>')">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="cat-pagination" role="navigation" aria-label="Pagination">
            <button class="cat-page-btn" id="pagePrev" disabled>&#8592; Previous</button>
            <button class="cat-page-btn active" id="page1">1</button>
            <button class="cat-page-btn" id="page2">2</button>
            <button class="cat-page-btn" id="page3">3</button>
            <button class="cat-page-btn" id="pageNext">Next &#8594;</button>
        </div>

    </div><!-- /.cat-table-section -->

</div><!-- /.admin-content -->

<script>
    /* ======================================================
       CATEGORIES PAGE — JS
       ====================================================== */

    /* Select-all checkbox */
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.row-check').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }

    /* Delete — calls category_delete.php API */
    async function confirmDelete(id, name) {
        if (!confirm('Delete category "' + name + '"?\n\nThis cannot be undone.')) return;

        try {
            const fd = new FormData();
            fd.append('id', id);
            const res = await fetch('api/category_delete.php', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 900);
            } else {
                showToast(data.message || 'Delete failed.', 'error');
            }
        } catch (err) {
            showToast('Network error — please try again.', 'error');
        }
    }

    /* Quick toggle is_featured */
    async function toggleFeatured(id, newState) {
        try {
            const fd = new FormData();
            fd.append('id', id);
            fd.append('is_featured', newState);
            const res = await fetch('api/category_toggle_featured.php', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 600);
            } else {
                showToast(data.message || 'Update failed.', 'error');
            }
        } catch (err) {
            showToast('Network error — please try again.', 'error');
        }
    }

    /* Pagination demo: highlight clicked page */
    document.querySelectorAll('.cat-page-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.id === 'pagePrev' || this.id === 'pageNext') return;
            document.querySelectorAll('.cat-page-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

<?php require __DIR__ . '/admin-footer.php'; ?>