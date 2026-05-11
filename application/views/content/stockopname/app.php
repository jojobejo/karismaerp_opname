<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= html_escape($page_title) ?></title>
  <link rel="icon" href="<?= base_url('assets/images/Karisma.png') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <style>
    :root {
      --so-bg:#f4f7f6; --so-surface:#fff; --so-ink:#172033; --so-muted:#687386;
      --so-line:rgba(23,32,51,.09); --so-primary:#0f766e; --so-accent:#d97706;
    }
    body.so-dark { --so-bg:#14191f; --so-surface:#1d252d; --so-ink:#eef2f7; --so-muted:#aab4c0; --so-line:rgba(238,242,247,.12); }
    body { background:var(--so-bg); color:var(--so-ink); font-size:15px; }
    .so-app { min-height:100vh; display:flex; }
    .so-sidebar { width:260px; background:var(--so-surface); border-right:1px solid var(--so-line); position:fixed; inset:0 auto 0 0; z-index:1030; transition:transform .18s ease; }
    .so-brand { height:64px; display:flex; align-items:center; gap:12px; padding:0 18px; border-bottom:1px solid var(--so-line); }
    .so-brand img { height:38px; object-fit:contain; }
    .so-brand strong { display:block; line-height:1.1; }
    .so-brand span { color:var(--so-muted); font-size:.78rem; }
    .so-nav { padding:14px 10px; }
    .so-nav button { width:100%; display:flex; align-items:center; gap:10px; border:0; background:transparent; color:var(--so-muted); padding:11px 12px; border-radius:8px; text-align:left; font-weight:600; }
    .so-nav button.active, .so-nav button:hover { background:rgba(15,118,110,.1); color:var(--so-primary); }
    .so-main { margin-left:260px; min-width:0; width:100%; }
    .so-header { height:64px; position:sticky; top:0; z-index:1020; background:rgba(244,247,246,.88); backdrop-filter:blur(14px); border-bottom:1px solid var(--so-line); display:flex; align-items:center; justify-content:space-between; padding:0 18px; }
    body.so-dark .so-header { background:rgba(20,25,31,.88); }
    .so-icon-btn { width:40px; height:40px; border:1px solid var(--so-line); border-radius:8px; background:var(--so-surface); color:var(--so-ink); display:inline-flex; align-items:center; justify-content:center; }
    .so-content { padding:18px; }
    .so-panel { background:var(--so-surface); border:1px solid var(--so-line); border-radius:8px; padding:16px; }
    .so-card-stat { min-height:96px; }
    .so-card-stat .value { font-size:1.65rem; font-weight:800; letter-spacing:0; }
    .so-card-stat .label { color:var(--so-muted); font-weight:600; }
    .so-card-stat i { color:var(--so-primary); }
    .so-toolbar { display:flex; gap:10px; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; }
    .so-section { display:none; }
    .so-section.active { display:block; }
    .so-fab { position:fixed; right:20px; bottom:22px; z-index:1040; width:54px; height:54px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 12px 28px rgba(15,118,110,.32); }
    .form-control, .custom-select, .select2-container--bootstrap4 .select2-selection { border-radius:8px; }
    .modal-content { border-radius:8px; border:0; }
    .table td, .table th { vertical-align:middle; }
    .font-weight-600 { font-weight:600; }
    .so-loading { position:fixed; inset:0; z-index:2000; background:rgba(15,23,42,.18); display:none; align-items:center; justify-content:center; }
    .so-loading.show { display:flex; }
    .so-loading-box { background:var(--so-surface); color:var(--so-ink); border-radius:8px; padding:14px 18px; box-shadow:0 18px 48px rgba(15,23,42,.18); }
    .so-camera { width:100%; max-height:320px; background:#111827; border-radius:8px; display:none; }
    @media (max-width: 991.98px) {
      .so-sidebar { transform:translateX(-100%); }
      .so-sidebar.show { transform:translateX(0); }
      .so-main { margin-left:0; }
      .so-content { padding:14px; }
      .so-panel { padding:14px; }
    }
  </style>
</head>
<body>
<div class="so-loading" id="ajaxLoading"><div class="so-loading-box"><span class="spinner-border spinner-border-sm mr-2"></span>Memproses...</div></div>
<div class="so-app">
  <aside class="so-sidebar" id="sidebar">
    <div class="so-brand">
      <img src="<?= base_url('assets/images/karisma.png') ?>" alt="Karisma">
      <div><strong>Stock Opname</strong><span>Mobile web app</span></div>
    </div>
    <nav class="so-nav">
      <button type="button" class="active" data-section="dashboard"><i class="fas fa-chart-pie"></i> Dashboard</button>
      <button type="button" data-section="barang"><i class="fas fa-box"></i> Master Barang</button>
      <button type="button" data-section="gudang"><i class="fas fa-warehouse"></i> Master Gudang</button>
      <button type="button" data-section="lokasi"><i class="fas fa-map-marker-alt"></i> Master Lokasi</button>
      <button type="button" data-section="session"><i class="fas fa-calendar-check"></i> Sesi Opname</button>
      <button type="button" data-section="assignment"><i class="fas fa-users-cog"></i> Assignment</button>
      <button type="button" data-section="opname"><i class="fas fa-clipboard-list"></i> Input Qty</button>
      <button type="button" data-section="compare"><i class="fas fa-balance-scale"></i> Compare</button>
      <button type="button" data-section="audit"><i class="fas fa-history"></i> Audit Log</button>
    </nav>
  </aside>

  <main class="so-main">
    <header class="so-header">
      <div class="d-flex align-items-center">
        <button type="button" class="so-icon-btn d-lg-none mr-2" id="toggleSidebar" title="Menu"><i class="fas fa-bars"></i></button>
        <div>
          <strong id="sectionTitle">Dashboard</strong>
          <div class="text-muted small"><?= html_escape($user['name']) ?> - <?= html_escape($user['role']) ?></div>
        </div>
      </div>
      <div class="d-flex align-items-center">
        <button type="button" class="so-icon-btn mr-2" id="themeToggle" title="Tema"><i class="fas fa-adjust"></i></button>
        <a class="so-icon-btn" href="<?= site_url('stockopname/logout') ?>" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
      </div>
    </header>

    <div class="so-content">
      <section class="so-section active" id="section-dashboard">
        <div class="row">
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="items">0</div><div class="label">Barang</div></div><i class="fas fa-box fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="items_active">0</div><div class="label">Barang Aktif</div></div><i class="fas fa-check-circle fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="warehouses_active">0</div><div class="label">Gudang Aktif</div></div><i class="fas fa-warehouse fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="locations_active">0</div><div class="label">Lokasi Aktif</div></div><i class="fas fa-qrcode fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="sessions_open">0</div><div class="label">Sesi Aktif</div></div><i class="fas fa-calendar-check fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="assignments_pending">0</div><div class="label">Assignment</div></div><i class="fas fa-users fa-2x"></i></div></div></div>
          <div class="col-6 col-lg-3 mb-3"><div class="so-panel so-card-stat"><div class="d-flex justify-content-between"><div><div class="value" data-stat="compare_recheck">0</div><div class="label">Recheck</div></div><i class="fas fa-redo fa-2x"></i></div></div></div>
        </div>
        <div class="so-panel">
          <div class="row align-items-center">
            <div class="col-lg-4 mb-3 mb-lg-0"><canvas id="donutChart" height="220"></canvas></div>
            <div class="col-lg-8">
              <h5 class="mb-2">Flow Modul</h5>
              <div class="row text-muted">
                <div class="col-md-4 mb-2"><strong class="text-body">1. Master & Saldo</strong><br>Barang, gudang, lokasi, QR, dan saldo awal per lot expired.</div>
                <div class="col-md-4 mb-2"><strong class="text-body">2. Sesi & Checker</strong><br>Buat sesi, assignment dua checker per lokasi, lalu input qty mobile.</div>
                <div class="col-md-4 mb-2"><strong class="text-body">3. Compare</strong><br>Compare item, location, lot, expired date, recheck selisih, approval supervisor.</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="so-section" id="section-barang">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Master Barang</h5><small class="text-muted">CRUD ajax, search realtime, import CSV</small></div>
            <div>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="btnImport"><i class="fas fa-file-import"></i> Import</button>
              <button type="button" class="btn btn-outline-dark btn-sm" id="btnSaldo"><i class="fas fa-database"></i> Saldo</button>
              <button type="button" class="btn btn-primary btn-sm js-create" data-module="barang"><i class="fas fa-plus"></i> Tambah</button>
            </div>
          </div>
          <table id="tableBarang" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Kode</th><th>Barang</th><th>Barcode</th><th>Supplier</th><th>Satuan</th><th>Min</th><th>Status</th><th>Aksi</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-session">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Sesi Opname</h5><small class="text-muted">Kelola sesi OPEN, PROGRESS, RECHECK, DONE, CLOSED</small></div>
            <button type="button" class="btn btn-primary btn-sm" id="btnSessionCreate"><i class="fas fa-plus"></i> Tambah</button>
          </div>
          <table id="tableSession" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Kode</th><th>Nama</th><th>Mulai</th><th>Selesai</th><th>Status</th><th>Creator</th><th>Aksi</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-assignment">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Assignment Checker</h5><small class="text-muted">Dua checker untuk setiap lokasi dalam sesi</small></div>
            <button type="button" class="btn btn-primary btn-sm" id="btnAssignmentCreate"><i class="fas fa-plus"></i> Tambah</button>
          </div>
          <table id="tableAssignment" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Sesi</th><th>Lokasi</th><th>Checker 1</th><th>Checker 2</th><th>Status</th><th>Aksi</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-opname">
        <div class="so-panel mb-3">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Input Qty Opname</h5><small class="text-muted">Autosave AJAX per item, lokasi, lot, expired date</small></div>
            <button type="button" class="btn btn-outline-info btn-sm" id="btnScanBarang"><i class="fas fa-camera"></i> Scan</button>
          </div>
          <div class="row">
            <div class="col-md-5 form-group"><label>Assignment saya</label><select id="opAssignment" class="form-control"></select></div>
            <div class="col-md-7 form-group"><label>Cari / scan barang</label><input id="opSearch" class="form-control" placeholder="Kode, nama, barcode, QR, lot"></div>
          </div>
        </div>
        <div id="opStockList" class="row"></div>
      </section>

      <section class="so-section" id="section-compare">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Compare & Approval</h5><small class="text-muted">Basis compare: item, location, lot, expired date</small></div>
            <div class="d-flex flex-wrap" style="gap:8px">
              <select id="compareSession" class="form-control select2-session" style="min-width:220px"></select>
              <button type="button" class="btn btn-outline-primary btn-sm" id="btnGenerateCompare"><i class="fas fa-sync"></i> Generate</button>
              <button type="button" class="btn btn-outline-success btn-sm" id="btnExport"><i class="fas fa-file-export"></i> Export</button>
            </div>
          </div>
          <table id="tableCompare" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Sesi</th><th>Barang</th><th>Lokasi</th><th>Lot</th><th>Expired</th><th>System</th><th>Checker 1</th><th>Checker 2</th><th>Status</th><th>Approval</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-audit">
        <div class="so-panel">
          <div class="so-toolbar"><div><h5 class="mb-0">Audit Log</h5><small class="text-muted">Jejak aktivitas user</small></div></div>
          <table id="tableAudit" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Waktu</th><th>User</th><th>Module</th><th>Aktivitas</th><th>Deskripsi</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-gudang">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Master Gudang</h5><small class="text-muted">DataTable ajax dan modal tambah/edit</small></div>
            <button type="button" class="btn btn-primary btn-sm js-create" data-module="gudang"><i class="fas fa-plus"></i> Tambah</button>
          </div>
          <table id="tableGudang" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Kode</th><th>Nama Gudang</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr></thead>
          </table>
        </div>
      </section>

      <section class="so-section" id="section-lokasi">
        <div class="so-panel">
          <div class="so-toolbar">
            <div><h5 class="mb-0">Master Lokasi</h5><small class="text-muted">Relasi gudang, QR lokasi, scan QR</small></div>
            <div>
              <button type="button" class="btn btn-outline-info btn-sm" id="btnScanLokasi"><i class="fas fa-camera"></i> Scan</button>
              <button type="button" class="btn btn-primary btn-sm js-create" data-module="lokasi"><i class="fas fa-plus"></i> Tambah</button>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-5">
              <select id="filterWarehouse" class="form-control select2-warehouse" data-placeholder="Filter gudang"></select>
            </div>
          </div>
          <table id="tableLokasi" class="table table-striped table-bordered dt-responsive nowrap w-100">
            <thead><tr><th>Kode</th><th>Lokasi</th><th>Gudang</th><th>Status</th><th>Aksi</th></tr></thead>
          </table>
        </div>
      </section>
    </div>
  </main>
</div>

<button type="button" class="btn btn-primary so-fab js-create" id="fabAdd" data-module="barang" title="Tambah"><i class="fas fa-plus"></i></button>

<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form class="modal-content js-form" data-module="barang" novalidate>
      <div class="modal-header"><h5 class="modal-title">Form Barang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="row">
          <div class="col-md-4 form-group"><label>Kode Barang</label><input name="item_code" class="form-control" required><div class="invalid-feedback d-block" data-error="item_code"></div></div>
          <div class="col-md-8 form-group"><label>Nama Barang</label><input name="item_name" class="form-control" required><div class="invalid-feedback d-block" data-error="item_name"></div></div>
          <div class="col-md-4 form-group"><label>Barcode</label><input name="barcode" class="form-control"><div class="invalid-feedback d-block" data-error="barcode"></div></div>
          <div class="col-md-4 form-group"><label>QRCode</label><input name="qrcode" class="form-control"><div class="invalid-feedback d-block" data-error="qrcode"></div></div>
          <div class="col-md-4 form-group"><label>Satuan</label><input name="unit" class="form-control" placeholder="PCS / BOX" required><div class="invalid-feedback d-block" data-error="unit"></div></div>
          <div class="col-md-6 form-group"><label>Supplier</label><select name="supplier_id" class="form-control select2-supplier"></select><div class="invalid-feedback d-block" data-error="supplier_id"></div></div>
          <div class="col-md-3 form-group"><label>Minimum Stock</label><input type="number" min="0" name="minimum_stock" class="form-control" value="0"></div>
          <div class="col-md-3 form-group"><label>Status</label><select name="is_active" class="custom-select"><option value="1">Aktif</option><option value="0">Nonaktif</option></select></div>
          <div class="col-12"><div class="text-muted mb-2">Detail dimensi</div></div>
          <div class="col-6 col-md-3 form-group"><label>Berat</label><input type="number" step="0.01" name="weight" class="form-control" value="0"></div>
          <div class="col-6 col-md-3 form-group"><label>Panjang</label><input type="number" step="0.01" name="length" class="form-control" value="0"></div>
          <div class="col-6 col-md-3 form-group"><label>Lebar</label><input type="number" step="0.01" name="width" class="form-control" value="0"></div>
          <div class="col-6 col-md-3 form-group"><label>Tinggi</label><input type="number" step="0.01" name="height" class="form-control" value="0"></div>
        </div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalGudang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content js-form" data-module="gudang" novalidate>
      <div class="modal-header"><h5 class="modal-title">Form Gudang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="form-group"><label>Kode Gudang</label><input name="warehouse_code" class="form-control" required><div class="invalid-feedback d-block" data-error="warehouse_code"></div></div>
        <div class="form-group"><label>Nama Gudang</label><input name="warehouse_name" class="form-control" required><div class="invalid-feedback d-block" data-error="warehouse_name"></div></div>
        <div class="form-group"><label>Status</label><select name="is_active" class="custom-select"><option value="1">Aktif</option><option value="0">Nonaktif</option></select></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalLokasi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content js-form" data-module="lokasi" novalidate>
      <div class="modal-header"><h5 class="modal-title">Form Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="form-group"><label>Gudang</label><select name="warehouse_id" class="form-control select2-warehouse" required></select><div class="invalid-feedback d-block" data-error="warehouse_id"></div></div>
        <div class="form-group"><label>Kode Lokasi</label><input name="location_code" class="form-control" required><div class="invalid-feedback d-block" data-error="location_code"></div></div>
        <div class="form-group"><label>Nama Lokasi</label><input name="location_name" class="form-control" required><div class="invalid-feedback d-block" data-error="location_name"></div></div>
        <div class="form-group"><label>QR Lokasi</label><input name="qr_location" class="form-control" placeholder="Otomatis dari kode lokasi bila kosong"></div>
        <div class="form-group"><label>Status</label><select name="is_active" class="custom-select"><option value="1">Aktif</option><option value="0">Nonaktif</option></select></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="formImport" novalidate>
      <div class="modal-header"><h5 class="modal-title">Import Barang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="file" name="file" class="form-control" accept=".csv,.txt,.xls,.xlsx" required>
        <small class="text-muted d-block mt-2">Header CSV: item_code, item_name, unit, barcode, qrcode, minimum_stock, supplier_code.</small>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-upload"></i> Import</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalSaldo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="formSaldo" novalidate>
      <div class="modal-header"><h5 class="modal-title">Import Saldo Awal</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="file" name="file" class="form-control" accept=".csv,.txt" required>
        <small class="text-muted d-block mt-2">Header CSV: item_code, warehouse_code, location_code, lot_number, expired_date, qty_system, qty_available.</small>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-upload"></i> Import</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalSession" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="formSession" novalidate>
      <div class="modal-header"><h5 class="modal-title">Form Sesi Opname</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="form-group"><label>Kode Sesi</label><input name="session_code" class="form-control" required><div class="invalid-feedback d-block" data-error="session_code"></div></div>
        <div class="form-group"><label>Nama Sesi</label><input name="session_name" class="form-control" required><div class="invalid-feedback d-block" data-error="session_name"></div></div>
        <div class="form-group"><label>Mulai</label><input type="datetime-local" name="start_date" class="form-control" required><div class="invalid-feedback d-block" data-error="start_date"></div></div>
        <div class="form-group"><label>Selesai</label><input type="datetime-local" name="end_date" class="form-control"></div>
        <div class="form-group"><label>Status</label><select name="status" class="custom-select"><option>OPEN</option><option>PROGRESS</option><option>RECHECK</option><option>DONE</option><option>CLOSED</option></select></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalAssignment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" id="formAssignment" novalidate>
      <div class="modal-header"><h5 class="modal-title">Assignment Checker</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <div class="form-group"><label>Sesi</label><select name="session_id" class="form-control select2-session" required></select><div class="invalid-feedback d-block" data-error="session_id"></div></div>
        <div class="form-group"><label>Lokasi</label><select name="location_id" class="form-control select2-location" required></select><div class="invalid-feedback d-block" data-error="location_id"></div></div>
        <div class="form-group"><label>Checker 1</label><select name="user_checker_1" class="form-control select2-checker" required></select><div class="invalid-feedback d-block" data-error="user_checker_1"></div></div>
        <div class="form-group"><label>Checker 2</label><select name="user_checker_2" class="form-control select2-checker" required></select><div class="invalid-feedback d-block" data-error="user_checker_2"></div></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
    </form>
  </div>
</div>

<div class="modal fade" id="modalQr" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">QR Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body text-center">
        <img id="qrImage" alt="QR lokasi" class="img-fluid mb-3" width="180" height="180">
        <div class="font-weight-bold" id="qrValue"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalScan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Scan QR Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <video id="scanVideo" class="so-camera" playsinline></video>
        <div class="input-group mt-2">
          <input type="text" class="form-control" id="scanManual" placeholder="Input manual hasil scan">
          <div class="input-group-append"><button class="btn btn-primary" type="button" id="applyScan">Cari</button></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
(() => {
  const URLS = {
    stats: '<?= site_url('stockopname/dashboard-stats') ?>',
    chart: '<?= site_url('stockopname/dashboard-chart') ?>',
    barangDt: '<?= site_url('stockopname/barang/datatable') ?>',
    barangShow: '<?= site_url('stockopname/barang/show') ?>/',
    barangStore: '<?= site_url('stockopname/barang/store') ?>',
    barangDelete: '<?= site_url('stockopname/barang/delete') ?>',
    barangImport: '<?= site_url('stockopname/barang/import') ?>',
    saldoImport: '<?= site_url('stockopname/saldo/import') ?>',
    gudangDt: '<?= site_url('stockopname/gudang/datatable') ?>',
    gudangShow: '<?= site_url('stockopname/gudang/show') ?>/',
    gudangStore: '<?= site_url('stockopname/gudang/store') ?>',
    gudangDelete: '<?= site_url('stockopname/gudang/delete') ?>',
    lokasiDt: '<?= site_url('stockopname/lokasi/datatable') ?>',
    lokasiShow: '<?= site_url('stockopname/lokasi/show') ?>/',
    lokasiStore: '<?= site_url('stockopname/lokasi/store') ?>',
    lokasiDelete: '<?= site_url('stockopname/lokasi/delete') ?>',
    sessionDt: '<?= site_url('stockopname/session/datatable') ?>',
    sessionShow: '<?= site_url('stockopname/session/show') ?>/',
    sessionStore: '<?= site_url('stockopname/session/store') ?>',
    sessionClose: '<?= site_url('stockopname/session/close') ?>',
    sessionSelect: '<?= site_url('stockopname/session/select') ?>',
    assignmentDt: '<?= site_url('stockopname/assignment/datatable') ?>',
    assignmentStore: '<?= site_url('stockopname/assignment/store') ?>',
    assignmentDelete: '<?= site_url('stockopname/assignment/delete') ?>',
    opnameAssignments: '<?= site_url('stockopname/opname/assignments') ?>',
    opnameStockLookup: '<?= site_url('stockopname/opname/stock-lookup') ?>',
    opnameSaveInput: '<?= site_url('stockopname/opname/save-input') ?>',
    compareDt: '<?= site_url('stockopname/compare/datatable') ?>',
    compareGenerate: '<?= site_url('stockopname/compare/generate') ?>',
    compareRecheck: '<?= site_url('stockopname/compare/recheck') ?>',
    compareApprove: '<?= site_url('stockopname/compare/approve') ?>',
    auditDt: '<?= site_url('stockopname/audit/datatable') ?>',
    exportReport: '<?= site_url('stockopname/report/export') ?>',
    supplierSelect: '<?= site_url('stockopname/supplier/select') ?>',
    warehouseSelect: '<?= site_url('stockopname/warehouse/select') ?>',
    locationSelect: '<?= site_url('stockopname/location/select') ?>',
    checkerSelect: '<?= site_url('stockopname/checker/select') ?>'
  };
  const modules = {
    barang: { modal:'#modalBarang', table:null, show:URLS.barangShow, store:URLS.barangStore, del:URLS.barangDelete },
    gudang: { modal:'#modalGudang', table:null, show:URLS.gudangShow, store:URLS.gudangStore, del:URLS.gudangDelete },
    lokasi: { modal:'#modalLokasi', table:null, show:URLS.lokasiShow, store:URLS.lokasiStore, del:URLS.lokasiDelete }
  };
  const Toast = Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:2600, timerProgressBar:true });
  const loading = document.getElementById('ajaxLoading');
  let donutChart = null;
  const showLoading = (state) => loading.classList.toggle('show', !!state);
  const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
  const api = async (url, options = {}) => {
    const response = await fetch(url, { credentials:'same-origin', ...options });
    const json = await response.json();
    if (response.status === 401 && json.data && json.data.redirect) window.location.href = json.data.redirect;
    if (!json.status) throw json;
    return json;
  };
  const resetForm = (form) => {
    form.reset();
    form.querySelector('[name="id"]').value = '';
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    $(form).find('select').val(null).trigger('change');
    $(form).find('[name="is_active"]').val('1').trigger('change');
  };
  const fillForm = (form, data) => {
    Object.keys(data || {}).forEach(key => {
      const field = form.querySelector(`[name="${key}"]`);
      if (!field) return;
      field.value = data[key] ?? '';
    });
    if (form.dataset.module === 'barang' && data.supplier_id) {
      const text = `${data.supplier_name || ''}`;
      $(form).find('[name="supplier_id"]').append(new Option(text, data.supplier_id, true, true)).trigger('change');
    }
    if (form.dataset.module === 'lokasi' && data.warehouse_id) {
      $(form).find('[name="warehouse_id"]').append(new Option(data.warehouse_name || data.warehouse_id, data.warehouse_id, true, true)).trigger('change');
    }
  };
  const reloadAll = () => {
    Object.values(modules).forEach(module => module.table && module.table.ajax.reload(null, false));
    ['sessionTable','assignmentTable','compareTable','auditTable'].forEach(key => window[key] && window[key].ajax.reload(null, false));
    loadStats();
  };
  const loadStats = async () => {
    try {
      const json = await api(URLS.stats);
      Object.keys(json.data).forEach(key => {
        const el = document.querySelector(`[data-stat="${key}"]`);
        if (el) el.textContent = Number(json.data[key]).toLocaleString('id-ID');
      });
      loadChart();
    } catch (e) {}
  };
  const loadChart = async () => {
    try {
      const json = await api(URLS.chart);
      const data = [json.data.match, json.data.discrepancy, json.data.recheck, json.data.approved];
      const ctx = document.getElementById('donutChart');
      if (!ctx || typeof Chart === 'undefined') return;
      if (donutChart) donutChart.destroy();
      donutChart = new Chart(ctx, { type:'doughnut', data:{ labels:['Match','Selisih','Recheck','Approved'], datasets:[{ data:data, backgroundColor:['#0f766e','#dc3545','#d97706','#2563eb'] }] }, options:{ maintainAspectRatio:false, legend:{ position:'bottom' }, cutoutPercentage:62 } });
    } catch (e) {}
  };
  const initSelect2 = () => {
    $('.select2-supplier').select2({
      theme:'bootstrap4', width:'100%', placeholder:'Pilih supplier', allowClear:true, dropdownParent:$('#modalBarang'),
      ajax:{ url:URLS.supplierSelect, dataType:'json', delay:250, data:params => ({ q:params.term || '' }), processResults:json => ({ results:(json.data || []).map(row => ({ id:row.id, text:`${row.supplier_code} - ${row.supplier_name}` })) }) }
    });
    $('.select2-warehouse').each(function() {
      const parent = $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body);
      $(this).select2({
        theme:'bootstrap4', width:'100%', placeholder:$(this).data('placeholder') || 'Pilih gudang', allowClear:true, dropdownParent:parent,
        ajax:{ url:URLS.warehouseSelect, dataType:'json', delay:250, data:params => ({ q:params.term || '' }), processResults:json => ({ results:(json.data || []).map(row => ({ id:row.id, text:`${row.warehouse_code} - ${row.warehouse_name}` })) }) }
      });
    });
    $('.select2-session').select2({
      theme:'bootstrap4', width:'100%', placeholder:'Pilih sesi', allowClear:true, dropdownParent:$(document.body),
      ajax:{ url:URLS.sessionSelect, dataType:'json', delay:250, data:params => ({ q:params.term || '' }), processResults:json => ({ results:(json.data || []).map(row => ({ id:row.id, text:`${row.session_code} - ${row.session_name}` })) }) }
    });
    $('.select2-location').select2({
      theme:'bootstrap4', width:'100%', placeholder:'Pilih lokasi', allowClear:true, dropdownParent:$('#modalAssignment'),
      ajax:{ url:URLS.locationSelect, dataType:'json', delay:250, data:params => ({ q:params.term || '' }), processResults:json => ({ results:(json.data || []).map(row => ({ id:row.id, text:`${row.warehouse_name} - ${row.location_code} ${row.location_name}` })) }) }
    });
    $('.select2-checker').select2({
      theme:'bootstrap4', width:'100%', placeholder:'Pilih checker', allowClear:true, dropdownParent:$('#modalAssignment'),
      ajax:{ url:URLS.checkerSelect, dataType:'json', delay:250, data:params => ({ q:params.term || '' }), processResults:json => ({ results:(json.data || []).map(row => ({ id:row.id, text:`${row.nik} - ${row.full_name} (${row.role_name || '-'})` })) }) }
    });
  };
  const initTables = () => {
    modules.barang.table = $('#tableBarang').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.barangDt, type:'POST' }, order:[[0,'asc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }] });
    modules.gudang.table = $('#tableGudang').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.gudangDt, type:'POST' }, order:[[0,'asc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }] });
    modules.lokasi.table = $('#tableLokasi').DataTable({
      processing:true, serverSide:true, responsive:true,
      ajax:{ url:URLS.lokasiDt, type:'POST', data:data => { data.warehouse_id = $('#filterWarehouse').val() || ''; } },
      order:[[0,'asc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }]
    });
    window.sessionTable = $('#tableSession').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.sessionDt, type:'POST' }, order:[[2,'desc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }] });
    window.assignmentTable = $('#tableAssignment').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.assignmentDt, type:'POST' }, order:[[0,'desc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }] });
    window.compareTable = $('#tableCompare').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.compareDt, type:'POST', data:data => { data.session_id = $('#compareSession').val() || ''; } }, order:[[0,'desc']], columnDefs:[{ targets:-1, orderable:false, searchable:false }] });
    window.auditTable = $('#tableAudit').DataTable({ processing:true, serverSide:true, responsive:true, ajax:{ url:URLS.auditDt, type:'POST' }, order:[[0,'desc']] });
  };
  const openCreate = (moduleName) => {
    const form = document.querySelector(`${modules[moduleName].modal} form`);
    resetForm(form);
    $(modules[moduleName].modal).modal('show');
  };
  const openEdit = async (moduleName, id) => {
    const form = document.querySelector(`${modules[moduleName].modal} form`);
    resetForm(form);
    showLoading(true);
    try {
      const json = await api(modules[moduleName].show + id);
      fillForm(form, json.data);
      $(modules[moduleName].modal).modal('show');
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Data tidak ditemukan.' });
    } finally {
      showLoading(false);
    }
  };
  const submitForm = async (form) => {
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    const required = [...form.querySelectorAll('[required]')].find(field => !field.value.trim());
    if (required) {
      const error = form.querySelector(`[data-error="${required.name}"]`);
      if (error) error.textContent = 'Field ini wajib diisi.';
      required.focus();
      return;
    }
    showLoading(true);
    try {
      const moduleName = form.dataset.module;
      const json = await api(modules[moduleName].store, { method:'POST', body:new FormData(form) });
      $(modules[moduleName].modal).modal('hide');
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      const errors = error.data && error.data.errors ? error.data.errors : {};
      Object.keys(errors).forEach(key => {
        const el = form.querySelector(`[data-error="${key}"]`);
        if (el) el.textContent = errors[key];
      });
      Toast.fire({ icon:'error', title:error.message || 'Proses gagal.' });
    } finally {
      showLoading(false);
    }
  };
  const deleteRow = async (moduleName, id) => {
    const confirm = await Swal.fire({ icon:'warning', title:'Hapus data?', text:'Data akan dihapus atau dinonaktifkan bila masih dipakai transaksi.', showCancelButton:true, confirmButtonText:'Ya, proses', cancelButtonText:'Batal' });
    if (!confirm.isConfirmed) return;
    showLoading(true);
    try {
      const fd = new FormData();
      fd.append('id', id);
      const json = await api(modules[moduleName].del, { method:'POST', body:fd });
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Gagal menghapus data.' });
    } finally {
      showLoading(false);
    }
  };
  const setSection = (name) => {
    document.querySelectorAll('.so-section').forEach(el => el.classList.remove('active'));
    document.getElementById(`section-${name}`).classList.add('active');
    document.querySelectorAll('.so-nav button').forEach(btn => btn.classList.toggle('active', btn.dataset.section === name));
    document.getElementById('sectionTitle').textContent = document.querySelector(`.so-nav button[data-section="${name}"]`).textContent.trim();
    document.getElementById('fabAdd').dataset.module = name === 'dashboard' ? 'barang' : name;
    document.getElementById('fabAdd').style.display = name === 'dashboard' ? 'none' : 'flex';
    document.getElementById('sidebar').classList.remove('show');
    setTimeout(() => Object.values(modules).forEach(module => module.table && module.table.columns.adjust().responsive.recalc()), 80);
  };
  const showQr = (value) => {
    document.getElementById('qrValue').textContent = value;
    document.getElementById('qrImage').src = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' + encodeURIComponent(value);
    $('#modalQr').modal('show');
  };
  const applyScan = () => {
    const value = document.getElementById('scanManual').value.trim();
    if (!value) return;
    setSection('lokasi');
    $('#tableLokasi').DataTable().search(value).draw();
    $('#modalScan').modal('hide');
  };
  const startScan = async () => {
    $('#modalScan').modal('show');
    const video = document.getElementById('scanVideo');
    if (!('BarcodeDetector' in window) || !navigator.mediaDevices) {
      video.style.display = 'none';
      return;
    }
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video:{ facingMode:'environment' } });
      video.srcObject = stream;
      video.style.display = 'block';
      await video.play();
      const detector = new BarcodeDetector({ formats:['qr_code', 'code_128', 'ean_13'] });
      const timer = setInterval(async () => {
        if (!$('#modalScan').hasClass('show')) {
          clearInterval(timer);
          stream.getTracks().forEach(track => track.stop());
          return;
        }
        const codes = await detector.detect(video);
        if (codes.length) {
          document.getElementById('scanManual').value = codes[0].rawValue;
          applyScan();
        }
      }, 800);
    } catch (e) {
      video.style.display = 'none';
    }
  };
  const debounce = (fn, delay = 350) => {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => fn(...args), delay);
    };
  };
  const openSession = async (id = null) => {
    const form = document.getElementById('formSession');
    form.reset();
    form.querySelector('[name="id"]').value = '';
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    if (id) {
      showLoading(true);
      try {
        const json = await api(URLS.sessionShow + id);
        Object.keys(json.data || {}).forEach(key => {
          const field = form.querySelector(`[name="${key}"]`);
          if (!field) return;
          field.value = key.includes('date') && json.data[key] ? json.data[key].replace(' ', 'T').slice(0,16) : (json.data[key] || '');
        });
      } catch (error) {
        Toast.fire({ icon:'error', title:error.message || 'Sesi tidak ditemukan.' });
      } finally {
        showLoading(false);
      }
    } else {
      form.querySelector('[name="session_code"]').value = 'SO-' + new Date().toISOString().slice(0,10).replaceAll('-', '') + '-' + String(Date.now()).slice(-4);
      form.querySelector('[name="start_date"]').value = new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0,16);
    }
    $('#modalSession').modal('show');
  };
  const submitSession = async (form) => {
    showLoading(true);
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    try {
      const json = await api(URLS.sessionStore, { method:'POST', body:new FormData(form) });
      $('#modalSession').modal('hide');
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      const errors = error.data && error.data.errors ? error.data.errors : {};
      Object.keys(errors).forEach(key => {
        const el = form.querySelector(`[data-error="${key}"]`);
        if (el) el.textContent = errors[key];
      });
      Toast.fire({ icon:'error', title:error.message || 'Sesi gagal disimpan.' });
    } finally {
      showLoading(false);
    }
  };
  const submitAssignment = async (form) => {
    showLoading(true);
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    try {
      const json = await api(URLS.assignmentStore, { method:'POST', body:new FormData(form) });
      $('#modalAssignment').modal('hide');
      form.reset();
      $(form).find('select').val(null).trigger('change');
      reloadAll();
      loadMyAssignments();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      const errors = error.data && error.data.errors ? error.data.errors : {};
      Object.keys(errors).forEach(key => {
        const el = form.querySelector(`[data-error="${key}"]`);
        if (el) el.textContent = errors[key];
      });
      Toast.fire({ icon:'error', title:error.message || 'Assignment gagal disimpan.' });
    } finally {
      showLoading(false);
    }
  };
  const loadMyAssignments = async () => {
    try {
      const json = await api(URLS.opnameAssignments);
      const select = document.getElementById('opAssignment');
      select.innerHTML = '<option value="">Pilih assignment</option>';
      (json.data || []).forEach(row => {
        const opt = document.createElement('option');
        opt.value = row.id;
        opt.textContent = `${row.session_code} - ${row.warehouse_name}/${row.location_code} (${row.status})`;
        select.appendChild(opt);
      });
    } catch (e) {}
  };
  const renderStocks = (rows) => {
    const list = document.getElementById('opStockList');
    if (!rows.length) {
      list.innerHTML = '<div class="col-12"><div class="so-panel text-muted">Data stock tidak ditemukan.</div></div>';
      return;
    }
    list.innerHTML = rows.map(row => `
      <div class="col-md-6 col-xl-4 mb-3">
        <div class="so-panel">
          <div class="d-flex justify-content-between mb-2"><strong>${escapeHtml(row.item_code)}</strong><span class="badge badge-light">${escapeHtml(row.location_code)}</span></div>
          <div class="font-weight-600">${escapeHtml(row.item_name)}</div>
          <div class="text-muted small mb-2">Lot ${escapeHtml(row.lot_number)} / Exp ${escapeHtml(row.expired_date)} / System ${escapeHtml(row.qty_system)}</div>
          <div class="input-group">
            <input type="number" step="0.01" class="form-control js-op-qty" data-stock="${row.id}" data-scan="${escapeHtml(row.qrcode || row.barcode || row.item_code)}" placeholder="Qty fisik">
            <div class="input-group-append"><button class="btn btn-primary js-save-opname" data-stock="${row.id}"><i class="fas fa-save"></i></button></div>
          </div>
        </div>
      </div>`).join('');
  };
  const lookupStocks = debounce(async () => {
    const assignment = document.getElementById('opAssignment').value;
    const q = document.getElementById('opSearch').value.trim();
    if (!assignment) {
      document.getElementById('opStockList').innerHTML = '<div class="col-12"><div class="so-panel text-muted">Pilih assignment terlebih dahulu.</div></div>';
      return;
    }
    try {
      const json = await api(URLS.opnameStockLookup + '?assignment_id=' + encodeURIComponent(assignment) + '&q=' + encodeURIComponent(q));
      renderStocks(json.data || []);
    } catch (e) {}
  }, 300);
  const saveOpnameInput = async (button) => {
    const card = button.closest('.so-panel');
    const qty = card.querySelector('.js-op-qty');
    const fd = new FormData();
    fd.append('assignment_id', document.getElementById('opAssignment').value);
    fd.append('stock_id', button.dataset.stock);
    fd.append('qty_input', qty.value || '0');
    fd.append('scan_code', qty.dataset.scan || '');
    fd.append('input_type', document.getElementById('opSearch').value ? 'SEARCH' : 'MANUAL');
    fd.append('device_id', navigator.userAgent);
    try {
      const json = await api(URLS.opnameSaveInput, { method:'POST', body:fd });
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Qty gagal disimpan.' });
    }
  };

  document.addEventListener('click', event => {
    const create = event.target.closest('.js-create');
    if (create) openCreate(create.dataset.module);
    const edit = event.target.closest('.js-edit');
    if (edit) openEdit(edit.dataset.module, edit.dataset.id);
    const del = event.target.closest('.js-delete');
    if (del) deleteRow(del.dataset.module, del.dataset.id);
    const qr = event.target.closest('.js-qr');
    if (qr) showQr(qr.dataset.value);
    const editSession = event.target.closest('.js-edit-session');
    if (editSession) openSession(editSession.dataset.id);
    const closeSession = event.target.closest('.js-close-session');
    if (closeSession) {
      Swal.fire({ icon:'warning', title:'Tutup sesi?', showCancelButton:true, confirmButtonText:'Tutup', cancelButtonText:'Batal' }).then(async result => {
        if (!result.isConfirmed) return;
        const fd = new FormData();
        fd.append('id', closeSession.dataset.id);
        const json = await api(URLS.sessionClose, { method:'POST', body:fd });
        reloadAll();
        Toast.fire({ icon:'success', title:json.message });
      });
    }
    const delAssignment = event.target.closest('.js-delete-assignment');
    if (delAssignment) {
      Swal.fire({ icon:'warning', title:'Hapus assignment?', showCancelButton:true, confirmButtonText:'Hapus', cancelButtonText:'Batal' }).then(async result => {
        if (!result.isConfirmed) return;
        const fd = new FormData();
        fd.append('id', delAssignment.dataset.id);
        const json = await api(URLS.assignmentDelete, { method:'POST', body:fd });
        reloadAll();
        loadMyAssignments();
        Toast.fire({ icon:'success', title:json.message });
      });
    }
    const saveOp = event.target.closest('.js-save-opname');
    if (saveOp) saveOpnameInput(saveOp);
    const approve = event.target.closest('.js-approve-compare');
    if (approve) {
      const fd = new FormData();
      fd.append('id', approve.dataset.id);
      fd.append('qty_final', approve.closest('.input-group').querySelector('.js-final-qty').value || 0);
      api(URLS.compareApprove, { method:'POST', body:fd }).then(json => { reloadAll(); Toast.fire({ icon:'success', title:json.message }); });
    }
    const recheck = event.target.closest('.js-recheck-compare');
    if (recheck) {
      const fd = new FormData();
      fd.append('id', recheck.dataset.id);
      api(URLS.compareRecheck, { method:'POST', body:fd }).then(json => { reloadAll(); Toast.fire({ icon:'success', title:json.message }); });
    }
  });
  document.querySelectorAll('.js-form').forEach(form => form.addEventListener('submit', event => { event.preventDefault(); submitForm(form); }));
  document.querySelectorAll('.so-nav button').forEach(btn => btn.addEventListener('click', () => setSection(btn.dataset.section)));
  document.getElementById('toggleSidebar').addEventListener('click', () => document.getElementById('sidebar').classList.toggle('show'));
  document.getElementById('themeToggle').addEventListener('click', () => { document.body.classList.toggle('so-dark'); localStorage.setItem('so-theme', document.body.classList.contains('so-dark') ? 'dark' : 'light'); });
  document.getElementById('btnImport').addEventListener('click', () => $('#modalImport').modal('show'));
  document.getElementById('btnSaldo').addEventListener('click', () => $('#modalSaldo').modal('show'));
  document.getElementById('btnSessionCreate').addEventListener('click', () => openSession());
  document.getElementById('btnAssignmentCreate').addEventListener('click', () => { document.getElementById('formAssignment').reset(); $('#formAssignment select').val(null).trigger('change'); $('#modalAssignment').modal('show'); });
  document.getElementById('btnScanLokasi').addEventListener('click', startScan);
  document.getElementById('btnScanBarang').addEventListener('click', startScan);
  document.getElementById('applyScan').addEventListener('click', applyScan);
  document.getElementById('formSession').addEventListener('submit', event => { event.preventDefault(); submitSession(event.currentTarget); });
  document.getElementById('formAssignment').addEventListener('submit', event => { event.preventDefault(); submitAssignment(event.currentTarget); });
  document.getElementById('formImport').addEventListener('submit', async event => {
    event.preventDefault();
    showLoading(true);
    try {
      const json = await api(URLS.barangImport, { method:'POST', body:new FormData(event.currentTarget) });
      $('#modalImport').modal('hide');
      event.currentTarget.reset();
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Import gagal.' });
    } finally {
      showLoading(false);
    }
  });
  document.getElementById('formSaldo').addEventListener('submit', async event => {
    event.preventDefault();
    showLoading(true);
    try {
      const json = await api(URLS.saldoImport, { method:'POST', body:new FormData(event.currentTarget) });
      $('#modalSaldo').modal('hide');
      event.currentTarget.reset();
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Import saldo gagal.' });
    } finally {
      showLoading(false);
    }
  });
  $('#filterWarehouse').on('change', () => modules.lokasi.table.ajax.reload());
  $('#compareSession').on('change', () => window.compareTable && window.compareTable.ajax.reload());
  document.getElementById('btnGenerateCompare').addEventListener('click', async () => {
    const fd = new FormData();
    fd.append('session_id', document.getElementById('compareSession').value || '');
    showLoading(true);
    try {
      const json = await api(URLS.compareGenerate, { method:'POST', body:fd });
      reloadAll();
      Toast.fire({ icon:'success', title:json.message });
    } catch (error) {
      Toast.fire({ icon:'error', title:error.message || 'Generate compare gagal.' });
    } finally {
      showLoading(false);
    }
  });
  document.getElementById('btnExport').addEventListener('click', () => {
    const sessionId = document.getElementById('compareSession').value || '';
    window.location.href = URLS.exportReport + '?session_id=' + encodeURIComponent(sessionId);
  });
  document.getElementById('opAssignment').addEventListener('change', lookupStocks);
  document.getElementById('opSearch').addEventListener('input', lookupStocks);
  document.addEventListener('input', event => {
    if (event.target.classList.contains('js-op-qty')) {
      const btn = event.target.closest('.input-group').querySelector('.js-save-opname');
      debounce(() => saveOpnameInput(btn), 700)();
    }
  });
  if (localStorage.getItem('so-theme') === 'dark') document.body.classList.add('so-dark');
  document.getElementById('fabAdd').style.display = 'none';
  initSelect2();
  initTables();
  loadStats();
  loadMyAssignments();
})();
</script>
</body>
</html>
