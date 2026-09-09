-- ============================================================
--  Clad Theory — categories table
--  Database: clad_theory
-- ============================================================
--
--  Columns
--  ─────────────────────────────────────────────────────────
--  id          — auto-increment primary key
--  name        — category title (unique, required)
--  description — optional free-text description
--  image       — relative web path to thumbnail, e.g.
--                "assets/images/categories/fashion.jpg"
--  status      — 'active' (visible) | 'inactive' (hidden)
--  is_featured — 1 = show in featured cards row, 0 = normal
--  created_at  — row creation timestamp (auto)
--  updated_at  — last update timestamp (auto-updated)
-- ============================================================

CREATE TABLE IF NOT EXISTS `categories` (
    `id`          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(160)    NOT NULL,
    `description` TEXT                NULL DEFAULT NULL,
    `image`       VARCHAR(400)        NULL DEFAULT NULL
                  COMMENT 'Relative web path, e.g. assets/images/categories/foo.jpg',
    `status`      ENUM('active','inactive')
                                  NOT NULL DEFAULT 'active',
    `is_featured` TINYINT(1)      NOT NULL DEFAULT 0
                  COMMENT '1 = show in featured highlights row',
    `created_at`  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                  ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE  KEY `uq_categories_name` (`name`),
    KEY     `idx_categories_status`  (`status`),
    KEY     `idx_categories_featured`(`is_featured`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Product categories for Clad Theory storefront';
