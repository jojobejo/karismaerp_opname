-- =========================================================
-- DATABASE STOCK OPNAME
-- NORMALIZED STRUCTURE
-- ENGINE : InnoDB
-- CHARSET : utf8mb4
-- =========================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =========================================================
-- ROLE
-- =========================================================

CREATE TABLE tbopname_role (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uk_role_name (role_name)
) ENGINE=InnoDB;


-- =========================================================
-- USER
-- =========================================================

CREATE TABLE tbopname_user (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id TINYINT UNSIGNED NOT NULL,

    nik VARCHAR(30) NOT NULL,
    full_name VARCHAR(150) NOT NULL,

    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,

    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_nik (nik),
    UNIQUE KEY uk_username (username),

    KEY idx_role_id (role_id),
    KEY idx_active (is_active),

    CONSTRAINT fk_user_role
        FOREIGN KEY (role_id)
        REFERENCES tbopname_role(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- SUPPLIER
-- =========================================================

CREATE TABLE tbopname_supplier (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    supplier_code VARCHAR(30) NOT NULL,
    supplier_name VARCHAR(150) NOT NULL,

    phone VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    address TEXT DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uk_supplier_code (supplier_code),
    KEY idx_supplier_name (supplier_name)
) ENGINE=InnoDB;


-- =========================================================
-- GUDANG
-- =========================================================

CREATE TABLE tbopname_warehouse (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    warehouse_code VARCHAR(30) NOT NULL,
    warehouse_name VARCHAR(100) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uk_warehouse_code (warehouse_code),
    KEY idx_warehouse_name (warehouse_name)
) ENGINE=InnoDB;


-- =========================================================
-- LOKASI RAK
-- =========================================================

CREATE TABLE tbopname_location (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    warehouse_id BIGINT UNSIGNED NOT NULL,

    location_code VARCHAR(50) NOT NULL,
    location_name VARCHAR(100) NOT NULL,

    qr_location VARCHAR(255) DEFAULT NULL,

    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uk_location_code (location_code),

    KEY idx_warehouse_id (warehouse_id),
    KEY idx_active (is_active),

    CONSTRAINT fk_location_warehouse
        FOREIGN KEY (warehouse_id)
        REFERENCES tbopname_warehouse(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- MASTER BARANG
-- =========================================================

CREATE TABLE tbopname_item (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    supplier_id BIGINT UNSIGNED DEFAULT NULL,

    item_code VARCHAR(50) NOT NULL,
    barcode VARCHAR(100) DEFAULT NULL,
    qrcode VARCHAR(100) DEFAULT NULL,

    item_name VARCHAR(255) NOT NULL,

    unit VARCHAR(30) NOT NULL,

    weight DECIMAL(12,2) DEFAULT 0,

    length DECIMAL(12,2) DEFAULT 0,
    width DECIMAL(12,2) DEFAULT 0,
    height DECIMAL(12,2) DEFAULT 0,

    minimum_stock INT DEFAULT 0,

    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_item_code (item_code),
    UNIQUE KEY uk_barcode (barcode),
    UNIQUE KEY uk_qrcode (qrcode),

    KEY idx_supplier_id (supplier_id),
    KEY idx_item_name (item_name),
    FULLTEXT KEY ft_item_name (item_name),

    CONSTRAINT fk_item_supplier
        FOREIGN KEY (supplier_id)
        REFERENCES tbopname_supplier(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;


-- =========================================================
-- STOCK BATCH / LOT
-- =========================================================

CREATE TABLE tbopname_stock (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    item_id BIGINT UNSIGNED NOT NULL,
    warehouse_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,

    lot_number VARCHAR(100) NOT NULL,
    expired_date DATE NOT NULL,

    qty_system DECIMAL(18,2) NOT NULL DEFAULT 0,
    qty_available DECIMAL(18,2) NOT NULL DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    KEY idx_item_id (item_id),
    KEY idx_location_id (location_id),
    KEY idx_warehouse_id (warehouse_id),

    KEY idx_lot_number (lot_number),
    KEY idx_expired_date (expired_date),

    KEY idx_stock_lookup (
        item_id,
        location_id,
        lot_number,
        expired_date
    ),

    CONSTRAINT fk_stock_item
        FOREIGN KEY (item_id)
        REFERENCES tbopname_item(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_stock_warehouse
        FOREIGN KEY (warehouse_id)
        REFERENCES tbopname_warehouse(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_stock_location
        FOREIGN KEY (location_id)
        REFERENCES tbopname_location(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- SESSION OPNAME
-- =========================================================

CREATE TABLE tbopname_session (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    session_code VARCHAR(50) NOT NULL,
    session_name VARCHAR(255) NOT NULL,

    start_date DATETIME NOT NULL,
    end_date DATETIME DEFAULT NULL,

    status ENUM(
        'OPEN',
        'PROGRESS',
        'RECHECK',
        'DONE',
        'CLOSED'
    ) NOT NULL DEFAULT 'OPEN',

    created_by BIGINT UNSIGNED NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uk_session_code (session_code),

    KEY idx_status (status),
    KEY idx_created_by (created_by),

    CONSTRAINT fk_session_user
        FOREIGN KEY (created_by)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- ASSIGNMENT USER
-- =========================================================

CREATE TABLE tbopname_assignment (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    session_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,

    user_checker_1 BIGINT UNSIGNED NOT NULL,
    user_checker_2 BIGINT UNSIGNED NOT NULL,

    status ENUM(
        'PENDING',
        'PROCESS',
        'FINISH',
        'RECHECK'
    ) NOT NULL DEFAULT 'PENDING',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    KEY idx_session_id (session_id),
    KEY idx_location_id (location_id),

    KEY idx_checker_1 (user_checker_1),
    KEY idx_checker_2 (user_checker_2),

    UNIQUE KEY uk_assignment (
        session_id,
        location_id
    ),

    CONSTRAINT fk_assignment_session
        FOREIGN KEY (session_id)
        REFERENCES tbopname_session(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_assignment_location
        FOREIGN KEY (location_id)
        REFERENCES tbopname_location(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_assignment_checker_1
        FOREIGN KEY (user_checker_1)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_assignment_checker_2
        FOREIGN KEY (user_checker_2)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- INPUT OPNAME
-- =========================================================

CREATE TABLE tbopname_input (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    session_id BIGINT UNSIGNED NOT NULL,
    assignment_id BIGINT UNSIGNED NOT NULL,

    user_id BIGINT UNSIGNED NOT NULL,

    item_id BIGINT UNSIGNED NOT NULL,
    warehouse_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,

    lot_number VARCHAR(100) NOT NULL,
    expired_date DATE NOT NULL,

    qty_input DECIMAL(18,2) NOT NULL DEFAULT 0,

    scan_code VARCHAR(100) DEFAULT NULL,

    input_type ENUM(
        'SCAN',
        'SEARCH',
        'MANUAL'
    ) NOT NULL DEFAULT 'SCAN',

    device_id VARCHAR(255) DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    KEY idx_session_id (session_id),
    KEY idx_assignment_id (assignment_id),

    KEY idx_user_id (user_id),
    KEY idx_item_id (item_id),

    KEY idx_location_id (location_id),

    KEY idx_compare (
        session_id,
        item_id,
        location_id,
        lot_number,
        expired_date
    ),

    CONSTRAINT fk_input_session
        FOREIGN KEY (session_id)
        REFERENCES tbopname_session(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_input_assignment
        FOREIGN KEY (assignment_id)
        REFERENCES tbopname_assignment(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_input_user
        FOREIGN KEY (user_id)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_input_item
        FOREIGN KEY (item_id)
        REFERENCES tbopname_item(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_input_warehouse
        FOREIGN KEY (warehouse_id)
        REFERENCES tbopname_warehouse(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_input_location
        FOREIGN KEY (location_id)
        REFERENCES tbopname_location(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =========================================================
-- HASIL COMPARE
-- =========================================================

CREATE TABLE tbopname_compare (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    session_id BIGINT UNSIGNED NOT NULL,

    item_id BIGINT UNSIGNED NOT NULL,
    warehouse_id BIGINT UNSIGNED NOT NULL,
    location_id BIGINT UNSIGNED NOT NULL,

    lot_number VARCHAR(100) NOT NULL,
    expired_date DATE NOT NULL,

    qty_system DECIMAL(18,2) NOT NULL DEFAULT 0,

    qty_user_1 DECIMAL(18,2) NOT NULL DEFAULT 0,
    qty_user_2 DECIMAL(18,2) NOT NULL DEFAULT 0,

    qty_final DECIMAL(18,2) DEFAULT NULL,

    is_match TINYINT(1) NOT NULL DEFAULT 0,
    need_recheck TINYINT(1) NOT NULL DEFAULT 0,

    approved_by BIGINT UNSIGNED DEFAULT NULL,
    approved_at DATETIME DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    KEY idx_session_id (session_id),

    KEY idx_item_compare (
        item_id,
        location_id,
        lot_number,
        expired_date
    ),

    KEY idx_match (is_match),
    KEY idx_recheck (need_recheck),

    CONSTRAINT fk_compare_session
        FOREIGN KEY (session_id)
        REFERENCES tbopname_session(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_compare_item
        FOREIGN KEY (item_id)
        REFERENCES tbopname_item(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_compare_warehouse
        FOREIGN KEY (warehouse_id)
        REFERENCES tbopname_warehouse(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_compare_location
        FOREIGN KEY (location_id)
        REFERENCES tbopname_location(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_compare_approved
        FOREIGN KEY (approved_by)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;


-- =========================================================
-- LOG AKTIVITAS
-- =========================================================

CREATE TABLE tbopname_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id BIGINT UNSIGNED NOT NULL,

    module_name VARCHAR(100) NOT NULL,
    activity_type VARCHAR(100) NOT NULL,

    table_name VARCHAR(100) DEFAULT NULL,
    reference_id BIGINT UNSIGNED DEFAULT NULL,

    description TEXT DEFAULT NULL,

    ip_address VARCHAR(50) DEFAULT NULL,
    device_info TEXT DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    KEY idx_user_id (user_id),
    KEY idx_module (module_name),
    KEY idx_activity (activity_type),
    KEY idx_reference (reference_id),

    CONSTRAINT fk_log_user
        FOREIGN KEY (user_id)
        REFERENCES tbopname_user(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


SET FOREIGN_KEY_CHECKS = 1;