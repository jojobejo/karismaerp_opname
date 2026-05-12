ALTER TABLE `tb_master_barang_all`
  ADD COLUMN `barcode` VARCHAR(120) NULL AFTER `kode_barang_system`,
  ADD COLUMN `qrcode` VARCHAR(160) NULL AFTER `barcode`;

ALTER TABLE `tb_master_barang_all`
  ADD KEY `idx_tb_master_barang_all_barcode` (`barcode`),
  ADD KEY `idx_tb_master_barang_all_qrcode` (`qrcode`);
