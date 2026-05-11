-- =========================================================
-- STOCK OPNAME SUPPORT SQL
-- Jalankan setelah struktur_database_stockopname.sql bila ingin fitur
-- status aktif gudang dan seed role/user awal tersedia.
-- =========================================================

ALTER TABLE tbopname_warehouse
    ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER warehouse_name,
    ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
    ADD KEY idx_active (is_active);

INSERT INTO tbopname_role (role_name)
VALUES ('ADMIN'), ('SUPERVISOR'), ('CHECKER')
ON DUPLICATE KEY UPDATE role_name = VALUES(role_name);

-- Password default: stockopname123
-- Ganti password setelah login pertama.
INSERT INTO tbopname_user (role_id, nik, full_name, username, password, is_active)
SELECT r.id, 'SO-ADMIN', 'Administrator Stock Opname', 'stockadmin',
       '$2y$10$UtC7Ns08yVGUL627sXVopOTXSvUrK4RwPUPqLxkaUKwDp8sfyNDEu',
       1
FROM tbopname_role r
WHERE r.role_name = 'ADMIN'
ON DUPLICATE KEY UPDATE
    full_name = VALUES(full_name),
    role_id = VALUES(role_id),
    is_active = 1;

-- Index tambahan untuk query mobile/autosave/compare.
ALTER TABLE tbopname_stock
    ADD UNIQUE KEY uk_stock_balance (item_id, warehouse_id, location_id, lot_number, expired_date);

ALTER TABLE tbopname_input
    ADD UNIQUE KEY uk_input_autosave (assignment_id, user_id, item_id, location_id, lot_number, expired_date),
    ADD KEY idx_input_user_session (session_id, user_id);

ALTER TABLE tbopname_compare
    ADD UNIQUE KEY uk_compare_key (session_id, item_id, location_id, lot_number, expired_date),
    ADD KEY idx_compare_approval (approved_by, approved_at);
