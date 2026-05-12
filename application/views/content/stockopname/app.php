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
      --so-bg: #f4f7f6;
      --so-surface: #fff;
      --so-ink: #172033;
      --so-muted: #687386;
      --so-line: rgba(23, 32, 51, .09);
      --so-primary: #0f766e;
      --so-accent: #d97706;
    }

    body.so-dark {
      --so-bg: #14191f;
      --so-surface: #1d252d;
      --so-ink: #eef2f7;
      --so-muted: #aab4c0;
      --so-line: rgba(238, 242, 247, .12);
    }

    body {
      background: var(--so-bg);
      color: var(--so-ink);
      font-size: 15px;
    }

    .so-app {
      min-height: 100vh;
      display: flex;
    }

    .so-sidebar {
      width: 260px;
      background: var(--so-surface);
      border-right: 1px solid var(--so-line);
      position: fixed;
      inset: 0 auto 0 0;
      z-index: 1030;
      transition: transform .18s ease;
    }

    .so-brand {
      height: 64px;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0 18px;
      border-bottom: 1px solid var(--so-line);
    }

    .so-brand img {
      height: 38px;
      object-fit: contain;
    }

    .so-brand strong {
      display: block;
      line-height: 1.1;
    }

    .so-brand span {
      color: var(--so-muted);
      font-size: .78rem;
    }

    .so-nav {
      padding: 14px 10px;
    }

    .so-nav button {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 10px;
      border: 0;
      background: transparent;
      color: var(--so-muted);
      padding: 11px 12px;
      border-radius: 8px;
      text-align: left;
      font-weight: 600;
    }

    .so-nav button.active,
    .so-nav button:hover {
      background: rgba(15, 118, 110, .1);
      color: var(--so-primary);
    }

    .so-main {
      margin-left: 260px;
      min-width: 0;
      width: 100%;
    }

    .so-header {
      height: 64px;
      position: sticky;
      top: 0;
      z-index: 1020;
      background: rgba(244, 247, 246, .88);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--so-line);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 18px;
    }

    body.so-dark .so-header {
      background: rgba(20, 25, 31, .88);
    }

    .so-icon-btn {
      width: 40px;
      height: 40px;
      border: 1px solid var(--so-line);
      border-radius: 8px;
      background: var(--so-surface);
      color: var(--so-ink);
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .so-content {
      padding: 18px;
    }

    .so-panel {
      background: var(--so-surface);
      border: 1px solid var(--so-line);
      border-radius: 8px;
      padding: 16px;
    }

    .so-card-stat {
      min-height: 96px;
    }

    .so-card-stat .value {
      font-size: 1.65rem;
      font-weight: 800;
      letter-spacing: 0;
    }

    .so-card-stat .label {
      color: var(--so-muted);
      font-weight: 600;
    }

    .so-card-stat i {
      color: var(--so-primary);
    }

    .so-toolbar {
      display: flex;
      gap: 10px;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 14px;
      flex-wrap: wrap;
    }

    .so-section {
      display: none;
    }

    .so-section.active {
      display: block;
    }

    .so-fab {
      position: fixed;
      right: 20px;
      bottom: 22px;
      z-index: 1040;
      width: 54px;
      height: 54px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 12px 28px rgba(15, 118, 110, .32);
    }

    .form-control,
    .custom-select,
    .select2-container--bootstrap4 .select2-selection {
      border-radius: 8px;
    }

    .modal-content {
      border-radius: 8px;
      border: 0;
    }

    .table td,
    .table th {
      vertical-align: middle;
    }

    .font-weight-600 {
      font-weight: 600;
    }

    .so-loading {
      position: fixed;
      inset: 0;
      z-index: 2000;
      background: rgba(15, 23, 42, .18);
      display: none;
      align-items: center;
      justify-content: center;
    }

    .so-loading.show {
      display: flex;
    }

    .so-loading-box {
      background: var(--so-surface);
      color: var(--so-ink);
      border-radius: 8px;
      padding: 14px 18px;
      box-shadow: 0 18px 48px rgba(15, 23, 42, .18);
    }

    .so-camera {
      width: 100%;
      max-height: 320px;
      background: #111827;
      border-radius: 8px;
      display: none;
    }

    .so-master-hero {
      background: linear-gradient(135deg, rgba(15, 118, 110, .14), rgba(217, 119, 6, .12));
      border: 1px solid rgba(15, 118, 110, .14);
      border-radius: 22px;
      padding: 18px;
      margin-bottom: 16px;
    }

    .so-master-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 10px;
      margin-top: 14px;
    }

    .so-master-chip {
      background: rgba(255, 255, 255, .72);
      border: 1px solid rgba(23, 32, 51, .08);
      border-radius: 14px;
      padding: 12px 14px;
    }

    body.so-dark .so-master-chip {
      background: rgba(20, 25, 31, .72);
      border-color: rgba(255, 255, 255, .08);
    }

    .so-master-chip span {
      display: block;
      font-size: .75rem;
      color: var(--so-muted);
      text-transform: uppercase;
      letter-spacing: .08em;
    }

    .so-master-chip strong {
      display: block;
      margin-top: 4px;
      font-size: 1.05rem;
    }

    .so-code-actions {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .so-preview-card {
      border: 1px dashed var(--so-line);
      border-radius: 16px;
      padding: 14px;
      min-height: 100%;
      background: rgba(255, 255, 255, .68);
    }

    body.so-dark .so-preview-card {
      background: rgba(20, 25, 31, .64);
    }

    .so-preview-card img {
      max-width: 100%;
      border-radius: 10px;
      background: #fff;
      padding: 8px;
    }

    .so-preview-card svg {
      width: 100%;
      max-height: 84px;
      background: #fff;
      border-radius: 10px;
      padding: 8px;
    }

    .so-preview-label {
      font-size: .78rem;
      color: var(--so-muted);
      text-transform: uppercase;
      letter-spacing: .08em;
      margin-bottom: 8px;
    }

    @media (max-width: 991.98px) {
      .so-sidebar {
        transform: translateX(-100%);
      }

      .so-sidebar.show {
        transform: translateX(0);
      }

      .so-main {
        margin-left: 0;
      }

      .so-content {
        padding: 14px;
      }

      .so-panel {
        padding: 14px;
      }
    }

    /* ── Label / Sticker ─────────────────────────────── */
    .label-grid {
      display: grid;
      gap: 6px;
    }

    .label-grid-2col {
      grid-template-columns: repeat(2, 1fr);
    }

    .label-grid-3col {
      grid-template-columns: repeat(3, 1fr);
    }

    .label-grid-4col {
      grid-template-columns: repeat(4, 1fr);
    }

    .label-item {
      border: 1.5px dashed #ccc;
      border-radius: 8px;
      padding: 8px;
      background: #fff;
      text-align: center;
    }

    body.so-dark .label-item {
      background: #1d252d;
      border-color: #444;
    }

    .label-item .label-name {
      font-weight: 700;
      font-size: .83rem;
      line-height: 1.25;
      margin-bottom: 3px;
    }

    .label-item .label-code {
      font-size: .72rem;
      color: #666;
      margin-bottom: 5px;
    }

    .label-item .label-barcode {
      max-width: 100%;
      height: 36px;
      object-fit: contain;
      display: block;
      margin: 0 auto 4px;
    }

    .label-item .label-qr {
      width: 72px;
      height: 72px;
      display: block;
      margin: 0 auto 3px;
    }

    .label-item .label-satuan {
      font-size: .68rem;
      color: #999;
    }

    .print-queue-badge {
      position: relative;
    }

    .print-queue-badge .badge {
      position: absolute;
      top: -6px;
      right: -8px;
      font-size: .65rem;
    }

    /* ── Print media ─────────────────────────────────── */
    @media print {
      body>* {
        display: none !important;
      }

      #printArea {
        display: block !important;
        margin: 0;
        padding: 0;
      }
    }
  </style>
</head>

<body>
  <div class="so-loading" id="ajaxLoading">
    <div class="so-loading-box"><span class="spinner-border spinner-border-sm mr-2"></span>Memproses...</div>
  </div>
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
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="items">0</div>
                    <div class="label">Barang</div>
                  </div><i class="fas fa-box fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="items_active">0</div>
                    <div class="label">Barang Aktif</div>
                  </div><i class="fas fa-check-circle fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="warehouses_active">0</div>
                    <div class="label">Gudang Aktif</div>
                  </div><i class="fas fa-warehouse fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="locations_active">0</div>
                    <div class="label">Lokasi Aktif</div>
                  </div><i class="fas fa-qrcode fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="sessions_open">0</div>
                    <div class="label">Sesi Aktif</div>
                  </div><i class="fas fa-calendar-check fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="assignments_pending">0</div>
                    <div class="label">Assignment</div>
                  </div><i class="fas fa-users fa-2x"></i>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3 mb-3">
              <div class="so-panel so-card-stat">
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="value" data-stat="compare_recheck">0</div>
                    <div class="label">Recheck</div>
                  </div><i class="fas fa-redo fa-2x"></i>
                </div>
              </div>
            </div>
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
          <div class="so-master-hero">
            <div class="d-flex flex-wrap justify-content-between align-items-start" style="gap:12px">
              <div>
                <h4 class="mb-1">Master Barang</h4>
                <!-- <div class="text-muted">Sumber data kini memakai <strong>tb_master_barang_all</strong> dengan barcode, QR code, dan dimensi kemasan untuk keputusan operasional yang lebih cepat.</div> -->
              </div>
              <div class="so-code-actions">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="btnImport"><i class="fas fa-file-import"></i> Import</button>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnCetakSemua" title="Cetak label semua data barang sekaligus"><i class="fas fa-print"></i> Cetak Semua</button>
                <button type="button" class="btn btn-outline-success btn-sm print-queue-badge" id="btnOpenPrintQueue"><i class="fas fa-layer-group"></i> Cetak Terpilih <span class="badge badge-danger" id="printQueueBadge" style="display:none">0</span></button>
                <button type="button" class="btn btn-primary btn-sm js-create" data-module="barang"><i class="fas fa-plus"></i> Barang Baru</button>
              </div>
            </div>
            <div class="so-master-grid" hidden>
              <div class="so-master-chip"><span>Header Wajib</span><strong>kd_barang, kode_barang_system, nama_barang, satuan</strong></div>
              <div class="so-master-chip"><span>Scan Ready</span><strong>Preview barcode dan QR sebelum simpan</strong></div>
              <div class="so-master-chip"><span>Dimensi</span><strong>p x l x t dan berat tersimpan rapi</strong></div>
            </div>
          </div>
          <div class="so-panel">
            <div class="so-toolbar">
              <div hidden>
                <h5 class="mb-0">Master Barang</h5><small class="text-muted">AJAX datatable cepat, generate kode otomatis, dan preview siap scan</small>
              </div>
              <button type="button" class="btn btn-outline-dark btn-sm" id="btnSaldo"><i class="fas fa-database"></i> Saldo</button>
            </div>
            <table id="tableBarang" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th style="width:38px"><input type="checkbox" id="checkAllBarang" title="Centang semua di halaman ini" style="width:16px;height:16px;cursor:pointer"></th>
                  <th>KD Barang</th>
                  <th>Kode System</th>
                  <th>Barang</th>
                  <th>Barcode / QR</th>
                  <th>Dimensi</th>
                  <th>Berat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-session">
          <div class="so-panel">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Sesi Opname</h5><small class="text-muted">Kelola sesi OPEN, PROGRESS, RECHECK, DONE, CLOSED</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm" id="btnSessionCreate"><i class="fas fa-plus"></i> Tambah</button>
            </div>
            <table id="tableSession" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Status</th>
                  <th>Creator</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-assignment">
          <div class="so-panel">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Assignment Checker</h5><small class="text-muted">Dua checker untuk setiap lokasi dalam sesi</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm" id="btnAssignmentCreate"><i class="fas fa-plus"></i> Tambah</button>
            </div>
            <table id="tableAssignment" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>Sesi</th>
                  <th>Lokasi</th>
                  <th>Checker 1</th>
                  <th>Checker 2</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-opname">
          <div class="so-panel mb-3">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Input Qty Opname</h5><small class="text-muted">Autosave AJAX per item, lokasi, lot, expired date</small>
              </div>
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
              <div>
                <h5 class="mb-0">Compare & Approval</h5><small class="text-muted">Basis compare: item, location, lot, expired date</small>
              </div>
              <div class="d-flex flex-wrap" style="gap:8px">
                <select id="compareSession" class="form-control select2-session" style="min-width:220px"></select>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnGenerateCompare"><i class="fas fa-sync"></i> Generate</button>
                <button type="button" class="btn btn-outline-success btn-sm" id="btnExport"><i class="fas fa-file-export"></i> Export</button>
              </div>
            </div>
            <table id="tableCompare" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>Sesi</th>
                  <th>Barang</th>
                  <th>Lokasi</th>
                  <th>Lot</th>
                  <th>Expired</th>
                  <th>System</th>
                  <th>Checker 1</th>
                  <th>Checker 2</th>
                  <th>Status</th>
                  <th>Approval</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-audit">
          <div class="so-panel">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Audit Log</h5><small class="text-muted">Jejak aktivitas user</small>
              </div>
            </div>
            <table id="tableAudit" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>Waktu</th>
                  <th>User</th>
                  <th>Module</th>
                  <th>Aktivitas</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-gudang">
          <div class="so-panel">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Master Gudang</h5><small class="text-muted">DataTable ajax dan modal tambah/edit</small>
              </div>
              <button type="button" class="btn btn-primary btn-sm js-create" data-module="gudang"><i class="fas fa-plus"></i> Tambah</button>
            </div>
            <table id="tableGudang" class="table table-striped table-bordered dt-responsive nowrap w-100">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama Gudang</th>
                  <th>Status</th>
                  <th>Dibuat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </section>

        <section class="so-section" id="section-lokasi">
          <div class="so-panel">
            <div class="so-toolbar">
              <div>
                <h5 class="mb-0">Master Lokasi</h5><small class="text-muted">Relasi gudang, QR lokasi, scan QR</small>
              </div>
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
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Lokasi</th>
                  <th>Gudang</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
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
        <div class="modal-header">
          <h5 class="modal-title">Form Barang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="row">
            <div class="col-md-4 form-group"><label>KD Barang</label><input name="kd_barang" class="form-control" required>
              <div class="invalid-feedback d-block" data-error="kd_barang"></div>
            </div>
            <div class="col-md-4 form-group"><label>Kode Barang System</label><input name="kode_barang_system" class="form-control" required>
              <div class="invalid-feedback d-block" data-error="kode_barang_system"></div>
            </div>
            <div class="col-md-4 form-group"><label>Satuan</label><input name="satuan" class="form-control" placeholder="PCS / BOX" required>
              <div class="invalid-feedback d-block" data-error="satuan"></div>
            </div>
            <div class="col-md-12 form-group"><label>Nama Barang</label><input name="nama_barang" class="form-control" required>
              <div class="invalid-feedback d-block" data-error="nama_barang"></div>
            </div>
            <div class="col-md-6 form-group"><label>Barcode</label>
              <div class="input-group"><input name="barcode" class="form-control">
                <div class="input-group-append"><button type="button" class="btn btn-outline-primary js-generate-code" data-type="barcode"><i class="fas fa-barcode"></i></button></div>
              </div>
              <div class="invalid-feedback d-block" data-error="barcode"></div>
            </div>
            <div class="col-md-6 form-group"><label>QRCode</label>
              <div class="input-group"><input name="qrcode" class="form-control">
                <div class="input-group-append"><button type="button" class="btn btn-outline-info js-generate-code" data-type="qrcode"><i class="fas fa-qrcode"></i></button></div>
              </div>
              <div class="invalid-feedback d-block" data-error="qrcode"></div>
            </div>
            <div class="col-12">
              <div class="text-muted mb-2">Detail dimensi kemasan</div>
            </div>
            <div class="col-6 col-md-3 form-group"><label>Panjang (P)</label><input type="number" step="1" min="0" name="p" class="form-control" value="0"></div>
            <div class="col-6 col-md-3 form-group"><label>Lebar (L)</label><input type="number" step="1" min="0" name="l" class="form-control" value="0"></div>
            <div class="col-6 col-md-3 form-group"><label>Tinggi (T)</label><input type="number" step="1" min="0" name="t" class="form-control" value="0"></div>
            <div class="col-6 col-md-3 form-group"><label>Berat</label><input type="number" step="1" min="0" name="berat" class="form-control" value="0"></div>
            <div class="col-12">
              <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                  <div class="so-preview-card">
                    <div class="so-preview-label">Preview Barcode</div>
                    <img id="barangBarcodePreview" alt="Preview barcode" style="display:none">
                    <div class="text-muted small" id="barangBarcodeLabel">Belum ada barcode.</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="so-preview-card text-center">
                    <div class="so-preview-label text-left">Preview QR Code</div>
                    <img id="barangQrPreview" alt="Preview QR code" style="display:none">
                    <div class="text-muted small mt-2" id="barangQrLabel">Belum ada QR code.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalGudang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content js-form" data-module="gudang" novalidate>
        <div class="modal-header">
          <h5 class="modal-title">Form Gudang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group"><label>Kode Gudang</label><input name="warehouse_code" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="warehouse_code"></div>
          </div>
          <div class="form-group"><label>Nama Gudang</label><input name="warehouse_name" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="warehouse_name"></div>
          </div>
          <div class="form-group"><label>Status</label><select name="is_active" class="custom-select">
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalLokasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content js-form" data-module="lokasi" novalidate>
        <div class="modal-header">
          <h5 class="modal-title">Form Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group"><label>Gudang</label><select name="warehouse_id" class="form-control select2-warehouse" required></select>
            <div class="invalid-feedback d-block" data-error="warehouse_id"></div>
          </div>
          <div class="form-group"><label>Kode Lokasi</label><input name="location_code" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="location_code"></div>
          </div>
          <div class="form-group"><label>Nama Lokasi</label><input name="location_name" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="location_name"></div>
          </div>
          <div class="form-group"><label>QR Lokasi</label><input name="qr_location" class="form-control" placeholder="Otomatis dari kode lokasi bila kosong"></div>
          <div class="form-group"><label>Status</label><select name="is_active" class="custom-select">
              <option value="1">Aktif</option>
              <option value="0">Nonaktif</option>
            </select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" id="formImport" novalidate>
        <div class="modal-header">
          <h5 class="modal-title">Import Barang</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="file" name="file" class="form-control" accept=".csv,.txt,.xls,.xlsx" required>
          <small class="text-muted d-block mt-2">Header CSV: kd_barang, kode_barang_system, barcode, qrcode, nama_barang, satuan, p, l, t, berat.</small>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-upload"></i> Import</button></div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalSaldo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" id="formSaldo" novalidate>
        <div class="modal-header">
          <h5 class="modal-title">Import Saldo Awal</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
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
        <div class="modal-header">
          <h5 class="modal-title">Form Sesi Opname</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id">
          <div class="form-group"><label>Kode Sesi</label><input name="session_code" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="session_code"></div>
          </div>
          <div class="form-group"><label>Nama Sesi</label><input name="session_name" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="session_name"></div>
          </div>
          <div class="form-group"><label>Mulai</label><input type="datetime-local" name="start_date" class="form-control" required>
            <div class="invalid-feedback d-block" data-error="start_date"></div>
          </div>
          <div class="form-group"><label>Selesai</label><input type="datetime-local" name="end_date" class="form-control"></div>
          <div class="form-group"><label>Status</label><select name="status" class="custom-select">
              <option>OPEN</option>
              <option>PROGRESS</option>
              <option>RECHECK</option>
              <option>DONE</option>
              <option>CLOSED</option>
            </select></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalAssignment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" id="formAssignment" novalidate>
        <div class="modal-header">
          <h5 class="modal-title">Assignment Checker</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Sesi</label><select name="session_id" class="form-control select2-session" required></select>
            <div class="invalid-feedback d-block" data-error="session_id"></div>
          </div>
          <div class="form-group"><label>Lokasi</label><select name="location_id" class="form-control select2-location" required></select>
            <div class="invalid-feedback d-block" data-error="location_id"></div>
          </div>
          <div class="form-group"><label>Checker 1</label><select name="user_checker_1" class="form-control select2-checker" required></select>
            <div class="invalid-feedback d-block" data-error="user_checker_1"></div>
          </div>
          <div class="form-group"><label>Checker 2</label><select name="user_checker_2" class="form-control select2-checker" required></select>
            <div class="invalid-feedback d-block" data-error="user_checker_2"></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button></div>
      </form>
    </div>
  </div>

  <div id="printArea" style="display:none"></div>

  <div class="modal fade" id="modalPrintLabel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-print text-success mr-2"></i>Antrian Cetak Label &mdash; <span id="printLabelCountText">0 item</span></h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row align-items-end mb-3">
            <div class="col-auto form-group mb-0">
              <label class="small mb-1">Kolom per baris</label>
              <select id="labelColCount" class="custom-select custom-select-sm">
                <option value="2">2 kolom</option>
                <option value="3" selected>3 kolom</option>
                <option value="4">4 kolom</option>
              </select>
            </div>
            <div class="col-auto form-group mb-0">
              <label class="small mb-1">Salin per item</label>
              <input type="number" id="labelCopies" class="form-control form-control-sm" value="1" min="1" max="99" style="width:68px">
            </div>
            <div class="col-auto form-group mb-0">
              <label class="small mb-1">Tampilkan</label>
              <div class="d-flex" style="gap:6px">
                <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" id="showBarcode" checked><label class="custom-control-label" for="showBarcode">Barcode</label></div>
                <div class="custom-control custom-checkbox"><input class="custom-control-input" type="checkbox" id="showQrcode" checked><label class="custom-control-label" for="showQrcode">QR Code</label></div>
              </div>
            </div>
            <div class="col-auto ml-auto">
              <button type="button" class="btn btn-outline-danger btn-sm" id="btnClearQueue"><i class="fas fa-trash"></i> Kosongkan Antrian</button>
            </div>
          </div>
          <div id="printLabelPreview" class="label-grid label-grid-3col"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-success" id="btnDoPrint"><i class="fas fa-print"></i> Cetak Semua Label</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalQr" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">QR Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
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
        <div class="modal-header">
          <h5 class="modal-title">Scan QR Lokasi</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
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
        barangGenerate: '<?= site_url('stockopname/barang/generate-codes') ?>',
        barangAll: '<?= site_url('stockopname/barang/all') ?>',
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
        barang: {
          modal: '#modalBarang',
          table: null,
          show: URLS.barangShow,
          store: URLS.barangStore,
          del: URLS.barangDelete
        },
        gudang: {
          modal: '#modalGudang',
          table: null,
          show: URLS.gudangShow,
          store: URLS.gudangStore,
          del: URLS.gudangDelete
        },
        lokasi: {
          modal: '#modalLokasi',
          table: null,
          show: URLS.lokasiShow,
          store: URLS.lokasiStore,
          del: URLS.lokasiDelete
        }
      };
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2600,
        timerProgressBar: true
      });
      const loading = document.getElementById('ajaxLoading');
      const barangBarcodePreview = document.getElementById('barangBarcodePreview');
      const barangQrPreview = document.getElementById('barangQrPreview');
      const barangBarcodeLabel = document.getElementById('barangBarcodeLabel');
      const barangQrLabel = document.getElementById('barangQrLabel');
      let donutChart = null;
      const showLoading = (state) => loading.classList.toggle('show', !!state);
      const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
      } [char]));
      const api = async (url, options = {}) => {
        const response = await fetch(url, {
          credentials: 'same-origin',
          ...options
        });
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
        if (form.dataset.module === 'barang') syncBarangPreview(form);
      };
      const fillForm = (form, data) => {
        Object.keys(data || {}).forEach(key => {
          const field = form.querySelector(`[name="${key}"]`);
          if (!field) return;
          field.value = data[key] ?? '';
        });
        if (form.dataset.module === 'lokasi' && data.warehouse_id) {
          $(form).find('[name="warehouse_id"]').append(new Option(data.warehouse_name || data.warehouse_id, data.warehouse_id, true, true)).trigger('change');
        }
        if (form.dataset.module === 'barang') syncBarangPreview(form);
      };
      const reloadAll = () => {
        Object.values(modules).forEach(module => module.table && module.table.ajax.reload(null, false));
        ['sessionTable', 'assignmentTable', 'compareTable', 'auditTable'].forEach(key => window[key] && window[key].ajax.reload(null, false));
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
          donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ['Match', 'Selisih', 'Recheck', 'Approved'],
              datasets: [{
                data: data,
                backgroundColor: ['#0f766e', '#dc3545', '#d97706', '#2563eb']
              }]
            },
            options: {
              maintainAspectRatio: false,
              legend: {
                position: 'bottom'
              },
              cutoutPercentage: 62
            }
          });
        } catch (e) {}
      };
      const initSelect2 = () => {
        $('.select2-warehouse').each(function() {
          const parent = $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body);
          $(this).select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: $(this).data('placeholder') || 'Pilih gudang',
            allowClear: true,
            dropdownParent: parent,
            ajax: {
              url: URLS.warehouseSelect,
              dataType: 'json',
              delay: 250,
              data: params => ({
                q: params.term || ''
              }),
              processResults: json => ({
                results: (json.data || []).map(row => ({
                  id: row.id,
                  text: `${row.warehouse_code} - ${row.warehouse_name}`
                }))
              })
            }
          });
        });
        $('.select2-session').select2({
          theme: 'bootstrap4',
          width: '100%',
          placeholder: 'Pilih sesi',
          allowClear: true,
          dropdownParent: $(document.body),
          ajax: {
            url: URLS.sessionSelect,
            dataType: 'json',
            delay: 250,
            data: params => ({
              q: params.term || ''
            }),
            processResults: json => ({
              results: (json.data || []).map(row => ({
                id: row.id,
                text: `${row.session_code} - ${row.session_name}`
              }))
            })
          }
        });
        $('.select2-location').select2({
          theme: 'bootstrap4',
          width: '100%',
          placeholder: 'Pilih lokasi',
          allowClear: true,
          dropdownParent: $('#modalAssignment'),
          ajax: {
            url: URLS.locationSelect,
            dataType: 'json',
            delay: 250,
            data: params => ({
              q: params.term || ''
            }),
            processResults: json => ({
              results: (json.data || []).map(row => ({
                id: row.id,
                text: `${row.warehouse_name} - ${row.location_code} ${row.location_name}`
              }))
            })
          }
        });
        $('.select2-checker').select2({
          theme: 'bootstrap4',
          width: '100%',
          placeholder: 'Pilih checker',
          allowClear: true,
          dropdownParent: $('#modalAssignment'),
          ajax: {
            url: URLS.checkerSelect,
            dataType: 'json',
            delay: 250,
            data: params => ({
              q: params.term || ''
            }),
            processResults: json => ({
              results: (json.data || []).map(row => ({
                id: row.id,
                text: `${row.nik} - ${row.full_name} (${row.role_name || '-'})`
              }))
            })
          }
        });
      };
      const initTables = () => {
        modules.barang.table = $('#tableBarang').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.barangDt,
            type: 'POST'
          },
          order: [
            [1, 'asc']
          ],
          columnDefs: [{
              targets: 0,
              orderable: false,
              searchable: false,
              className: 'text-center'
            },
            {
              targets: -1,
              orderable: false,
              searchable: false
            }
          ],
          drawCallback: function() {
            // Restore centang sesuai printQueue setelah render ulang (paginasi / search)
            $('#tableBarang .js-print-check').each(function() {
              this.checked = printQueue.some(i => i.id === this.dataset.id);
            });
            syncCheckAll();
          }
        });
        modules.gudang.table = $('#tableGudang').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.gudangDt,
            type: 'POST'
          },
          order: [
            [0, 'asc']
          ],
          columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
          }]
        });
        modules.lokasi.table = $('#tableLokasi').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.lokasiDt,
            type: 'POST',
            data: data => {
              data.warehouse_id = $('#filterWarehouse').val() || '';
            }
          },
          order: [
            [0, 'asc']
          ],
          columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
          }]
        });
        window.sessionTable = $('#tableSession').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.sessionDt,
            type: 'POST'
          },
          order: [
            [2, 'desc']
          ],
          columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
          }]
        });
        window.assignmentTable = $('#tableAssignment').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.assignmentDt,
            type: 'POST'
          },
          order: [
            [0, 'desc']
          ],
          columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
          }]
        });
        window.compareTable = $('#tableCompare').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.compareDt,
            type: 'POST',
            data: data => {
              data.session_id = $('#compareSession').val() || '';
            }
          },
          order: [
            [0, 'desc']
          ],
          columnDefs: [{
            targets: -1,
            orderable: false,
            searchable: false
          }]
        });
        window.auditTable = $('#tableAudit').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: {
            url: URLS.auditDt,
            type: 'POST'
          },
          order: [
            [0, 'desc']
          ]
        });
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
          Toast.fire({
            icon: 'error',
            title: error.message || 'Data tidak ditemukan.'
          });
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
          const json = await api(modules[moduleName].store, {
            method: 'POST',
            body: new FormData(form)
          });
          $(modules[moduleName].modal).modal('hide');
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          const errors = error.data && error.data.errors ? error.data.errors : {};
          Object.keys(errors).forEach(key => {
            const el = form.querySelector(`[data-error="${key}"]`);
            if (el) el.textContent = errors[key];
          });
          Toast.fire({
            icon: 'error',
            title: error.message || 'Proses gagal.'
          });
        } finally {
          showLoading(false);
        }
      };
      const deleteRow = async (moduleName, id) => {
        const confirm = await Swal.fire({
          icon: 'warning',
          title: 'Hapus data?',
          text: 'Data akan dihapus atau dinonaktifkan bila masih dipakai transaksi.',
          showCancelButton: true,
          confirmButtonText: 'Ya, proses',
          cancelButtonText: 'Batal'
        });
        if (!confirm.isConfirmed) return;
        showLoading(true);
        try {
          const fd = new FormData();
          fd.append('id', id);
          const json = await api(modules[moduleName].del, {
            method: 'POST',
            body: fd
          });
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Gagal menghapus data.'
          });
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
      const barcodePreviewUrl = (value) => 'https://barcode.tec-it.com/barcode.ashx?data=' + encodeURIComponent(value) + '&code=Code128&translate-esc=off';
      const qrPreviewUrl = (value, size = 220) => 'https://api.qrserver.com/v1/create-qr-code/?size=' + size + 'x' + size + '&data=' + encodeURIComponent(value);
      const syncBarangPreview = (form = document.querySelector('#modalBarang form')) => {
        if (!form) return;
        const barcode = (form.querySelector('[name="barcode"]')?.value || '').trim();
        const qrcode = (form.querySelector('[name="qrcode"]')?.value || '').trim();
        if (barcode) {
          barangBarcodePreview.src = barcodePreviewUrl(barcode);
          barangBarcodePreview.style.display = 'block';
          barangBarcodeLabel.textContent = barcode;
        } else {
          barangBarcodePreview.removeAttribute('src');
          barangBarcodePreview.style.display = 'none';
          barangBarcodeLabel.textContent = 'Belum ada barcode.';
        }
        if (qrcode) {
          barangQrPreview.src = qrPreviewUrl(qrcode);
          barangQrPreview.style.display = 'inline-block';
          barangQrLabel.textContent = qrcode;
        } else {
          barangQrPreview.removeAttribute('src');
          barangQrPreview.style.display = 'none';
          barangQrLabel.textContent = 'Belum ada QR code.';
        }
      };
      const generateBarangCodes = async (type) => {
        const form = document.querySelector('#modalBarang form');
        showLoading(true);
        try {
          const json = await api(URLS.barangGenerate, {
            method: 'POST',
            body: new FormData(form)
          });
          const payload = json.data || {};
          if (type === 'barcode' && payload.barcode) {
            form.querySelector('[name="barcode"]').value = payload.barcode;
          }
          if (type === 'qrcode' && payload.qrcode) {
            form.querySelector('[name="qrcode"]').value = payload.qrcode;
          }
          if (type === 'all') {
            if (payload.barcode) form.querySelector('[name="barcode"]').value = payload.barcode;
            if (payload.qrcode) form.querySelector('[name="qrcode"]').value = payload.qrcode;
          }
          syncBarangPreview(form);
          Toast.fire({
            icon: 'success',
            title: 'Kode berhasil digenerate.'
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Generate kode gagal.'
          });
        } finally {
          showLoading(false);
        }
      };
      const showQr = (value) => {
        document.getElementById('qrValue').textContent = value;
        document.getElementById('qrImage').src = qrPreviewUrl(value, 180);
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
          const stream = await navigator.mediaDevices.getUserMedia({
            video: {
              facingMode: 'environment'
            }
          });
          video.srcObject = stream;
          video.style.display = 'block';
          await video.play();
          const detector = new BarcodeDetector({
            formats: ['qr_code', 'code_128', 'ean_13']
          });
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
              field.value = key.includes('date') && json.data[key] ? json.data[key].replace(' ', 'T').slice(0, 16) : (json.data[key] || '');
            });
          } catch (error) {
            Toast.fire({
              icon: 'error',
              title: error.message || 'Sesi tidak ditemukan.'
            });
          } finally {
            showLoading(false);
          }
        } else {
          form.querySelector('[name="session_code"]').value = 'SO-' + new Date().toISOString().slice(0, 10).replaceAll('-', '') + '-' + String(Date.now()).slice(-4);
          form.querySelector('[name="start_date"]').value = new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        }
        $('#modalSession').modal('show');
      };
      const submitSession = async (form) => {
        showLoading(true);
        form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
        try {
          const json = await api(URLS.sessionStore, {
            method: 'POST',
            body: new FormData(form)
          });
          $('#modalSession').modal('hide');
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          const errors = error.data && error.data.errors ? error.data.errors : {};
          Object.keys(errors).forEach(key => {
            const el = form.querySelector(`[data-error="${key}"]`);
            if (el) el.textContent = errors[key];
          });
          Toast.fire({
            icon: 'error',
            title: error.message || 'Sesi gagal disimpan.'
          });
        } finally {
          showLoading(false);
        }
      };
      const submitAssignment = async (form) => {
        showLoading(true);
        form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
        try {
          const json = await api(URLS.assignmentStore, {
            method: 'POST',
            body: new FormData(form)
          });
          $('#modalAssignment').modal('hide');
          form.reset();
          $(form).find('select').val(null).trigger('change');
          reloadAll();
          loadMyAssignments();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          const errors = error.data && error.data.errors ? error.data.errors : {};
          Object.keys(errors).forEach(key => {
            const el = form.querySelector(`[data-error="${key}"]`);
            if (el) el.textContent = errors[key];
          });
          Toast.fire({
            icon: 'error',
            title: error.message || 'Assignment gagal disimpan.'
          });
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
          const json = await api(URLS.opnameSaveInput, {
            method: 'POST',
            body: fd
          });
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Qty gagal disimpan.'
          });
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
        const genCode = event.target.closest('.js-generate-code');
        if (genCode) generateBarangCodes(genCode.dataset.type || 'all');
        const editSession = event.target.closest('.js-edit-session');
        if (editSession) openSession(editSession.dataset.id);
        const closeSession = event.target.closest('.js-close-session');
        if (closeSession) {
          Swal.fire({
            icon: 'warning',
            title: 'Tutup sesi?',
            showCancelButton: true,
            confirmButtonText: 'Tutup',
            cancelButtonText: 'Batal'
          }).then(async result => {
            if (!result.isConfirmed) return;
            const fd = new FormData();
            fd.append('id', closeSession.dataset.id);
            const json = await api(URLS.sessionClose, {
              method: 'POST',
              body: fd
            });
            reloadAll();
            Toast.fire({
              icon: 'success',
              title: json.message
            });
          });
        }
        const delAssignment = event.target.closest('.js-delete-assignment');
        if (delAssignment) {
          Swal.fire({
            icon: 'warning',
            title: 'Hapus assignment?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
          }).then(async result => {
            if (!result.isConfirmed) return;
            const fd = new FormData();
            fd.append('id', delAssignment.dataset.id);
            const json = await api(URLS.assignmentDelete, {
              method: 'POST',
              body: fd
            });
            reloadAll();
            loadMyAssignments();
            Toast.fire({
              icon: 'success',
              title: json.message
            });
          });
        }
        const saveOp = event.target.closest('.js-save-opname');
        if (saveOp) saveOpnameInput(saveOp);
        const approve = event.target.closest('.js-approve-compare');
        if (approve) {
          const fd = new FormData();
          fd.append('id', approve.dataset.id);
          fd.append('qty_final', approve.closest('.input-group').querySelector('.js-final-qty').value || 0);
          api(URLS.compareApprove, {
            method: 'POST',
            body: fd
          }).then(json => {
            reloadAll();
            Toast.fire({
              icon: 'success',
              title: json.message
            });
          });
        }
        const recheck = event.target.closest('.js-recheck-compare');
        if (recheck) {
          const fd = new FormData();
          fd.append('id', recheck.dataset.id);
          api(URLS.compareRecheck, {
            method: 'POST',
            body: fd
          }).then(json => {
            reloadAll();
            Toast.fire({
              icon: 'success',
              title: json.message
            });
          });
        }
      });
      document.querySelectorAll('.js-form').forEach(form => form.addEventListener('submit', event => {
        event.preventDefault();
        submitForm(form);
      }));
      document.querySelectorAll('.so-nav button').forEach(btn => btn.addEventListener('click', () => setSection(btn.dataset.section)));
      document.getElementById('toggleSidebar').addEventListener('click', () => document.getElementById('sidebar').classList.toggle('show'));
      document.getElementById('themeToggle').addEventListener('click', () => {
        document.body.classList.toggle('so-dark');
        localStorage.setItem('so-theme', document.body.classList.contains('so-dark') ? 'dark' : 'light');
      });
      document.getElementById('btnImport').addEventListener('click', () => $('#modalImport').modal('show'));
      document.getElementById('btnSaldo').addEventListener('click', () => $('#modalSaldo').modal('show'));
      document.getElementById('btnSessionCreate').addEventListener('click', () => openSession());
      document.getElementById('btnAssignmentCreate').addEventListener('click', () => {
        document.getElementById('formAssignment').reset();
        $('#formAssignment select').val(null).trigger('change');
        $('#modalAssignment').modal('show');
      });
      document.getElementById('btnScanLokasi').addEventListener('click', startScan);
      document.getElementById('btnScanBarang').addEventListener('click', startScan);
      document.getElementById('applyScan').addEventListener('click', applyScan);
      document.getElementById('formSession').addEventListener('submit', event => {
        event.preventDefault();
        submitSession(event.currentTarget);
      });
      document.getElementById('formAssignment').addEventListener('submit', event => {
        event.preventDefault();
        submitAssignment(event.currentTarget);
      });
      document.getElementById('formImport').addEventListener('submit', async event => {
        event.preventDefault();
        showLoading(true);
        try {
          const json = await api(URLS.barangImport, {
            method: 'POST',
            body: new FormData(event.currentTarget)
          });
          $('#modalImport').modal('hide');
          event.currentTarget.reset();
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Import gagal.'
          });
        } finally {
          showLoading(false);
        }
      });
      document.getElementById('formSaldo').addEventListener('submit', async event => {
        event.preventDefault();
        showLoading(true);
        try {
          const json = await api(URLS.saldoImport, {
            method: 'POST',
            body: new FormData(event.currentTarget)
          });
          $('#modalSaldo').modal('hide');
          event.currentTarget.reset();
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Import saldo gagal.'
          });
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
          const json = await api(URLS.compareGenerate, {
            method: 'POST',
            body: fd
          });
          reloadAll();
          Toast.fire({
            icon: 'success',
            title: json.message
          });
        } catch (error) {
          Toast.fire({
            icon: 'error',
            title: error.message || 'Generate compare gagal.'
          });
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
      document.querySelectorAll('#modalBarang [name="kd_barang"], #modalBarang [name="kode_barang_system"], #modalBarang [name="nama_barang"], #modalBarang [name="barcode"], #modalBarang [name="qrcode"]').forEach(el => {
        el.addEventListener('input', () => syncBarangPreview(document.querySelector('#modalBarang form')));
      });
      document.addEventListener('input', event => {
        if (event.target.classList.contains('js-op-qty')) {
          const btn = event.target.closest('.input-group').querySelector('.js-save-opname');
          debounce(() => saveOpnameInput(btn), 700)();
        }
      });
      // ── Print Queue ───────────────────────────────────────────────────────────
      let printQueue = []; // { id, kd, kdsys, nama, satuan, barcode, qrcode }
      let _printAllItems = null; // diisi saat Cetak Semua, null bila Cetak Terpilih

      const updatePrintBadge = () => {
        const n = printQueue.length;
        const badge = document.getElementById('printQueueBadge');
        badge.textContent = n;
        badge.style.display = n ? 'inline-block' : 'none';
      };

      // Sinkronkan indeterminate/checked pada checkbox "pilih semua halaman ini"
      const syncCheckAll = () => {
        const all = document.querySelectorAll('#tableBarang .js-print-check');
        const chk = [...all].filter(cb => cb.checked).length;
        const cbAll = document.getElementById('checkAllBarang');
        cbAll.checked = all.length > 0 && chk === all.length;
        cbAll.indeterminate = chk > 0 && chk < all.length;
      };

      // Bangun HTML satu label
      const buildLabelHtml = (item, bcUrl, qrUrl, doBarcode, doQr) => {
        const safe = s => String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return '<div class="label-item">' +
          '<div class="label-name">' + safe(item.nama) + '</div>' +
          '<div class="label-code">' + safe(item.kd) + ' &mdash; ' + safe(item.kdsys) + '</div>' +
          (doBarcode && bcUrl ? '<img src="' + bcUrl + '" class="label-barcode" alt="barcode">' : '') +
          (doQr && qrUrl ? '<img src="' + qrUrl + '" class="label-qr"     alt="qr">' : '') +
          '<div class="label-satuan">' + safe(item.satuan) + '</div>' +
          '</div>';
      };

      const renderLabelPreview = (items) => {
        if (items === undefined) items = _printAllItems || printQueue;
        const copies = Math.max(1, parseInt(document.getElementById('labelCopies').value) || 1);
        const cols = parseInt(document.getElementById('labelColCount').value) || 3;
        const doBarcode = document.getElementById('showBarcode').checked;
        const doQr = document.getElementById('showQrcode').checked;
        const preview = document.getElementById('printLabelPreview');
        preview.className = 'label-grid label-grid-' + cols + 'col';
        document.getElementById('printLabelCountText').textContent = items.length + ' item';

        if (!items.length) {
          preview.innerHTML = '<div class="text-muted p-3 text-center">Belum ada item. Centang baris pada tabel barang, atau gunakan tombol <strong>Cetak Semua</strong>.</div>';
          return;
        }
        let html = '';
        items.forEach(item => {
          const bcUrl = item.barcode ? barcodePreviewUrl(item.barcode) : '';
          const qrUrl = item.qrcode ? qrPreviewUrl(item.qrcode, 120) : '';
          for (let c = 0; c < copies; c++) html += buildLabelHtml(item, bcUrl, qrUrl, doBarcode, doQr);
        });
        preview.innerHTML = html;
      };

      // Buka popup cetak
      const doPrint = (items) => {
        if (items === undefined) items = _printAllItems || printQueue;
        const copies = Math.max(1, parseInt(document.getElementById('labelCopies').value) || 1);
        const cols = parseInt(document.getElementById('labelColCount').value) || 3;
        const doBarcode = document.getElementById('showBarcode').checked;
        const doQr = document.getElementById('showQrcode').checked;

        if (!items.length) {
          Toast.fire({
            icon: 'warning',
            title: 'Tidak ada item untuk dicetak.'
          });
          return;
        }
        let labelHtml = '';
        items.forEach(item => {
          const bcUrl = item.barcode ? barcodePreviewUrl(item.barcode) : '';
          const qrUrl = item.qrcode ? qrPreviewUrl(item.qrcode, 130) : '';
          for (let c = 0; c < copies; c++) labelHtml += buildLabelHtml(item, bcUrl, qrUrl, doBarcode, doQr);
        });

        const printHtml = `<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Cetak Label Barang</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,Helvetica,sans-serif}
.label-grid{display:grid;grid-template-columns:repeat(${cols},1fr);gap:4mm;padding:6mm}
.label-item{border:.5pt solid #aaa;padding:3mm;text-align:center;page-break-inside:avoid;break-inside:avoid}
.label-name{font-weight:700;font-size:8.5pt;line-height:1.2;margin-bottom:1.5mm}
.label-code{font-size:7pt;color:#444;margin-bottom:2mm}
.label-barcode{max-width:100%;height:26pt;object-fit:contain;display:block;margin:0 auto 2mm}
.label-qr{width:52pt;height:52pt;display:block;margin:0 auto 1.5mm}
.label-satuan{font-size:6.5pt;color:#888}
@page{margin:8mm}
</style>
</head>
<body>
<div class="label-grid">${labelHtml}</div>
<script>
(function(){
  var imgs=document.querySelectorAll('img'),n=imgs.length,done=0;
  if(n===0){window.print();return;}
  function tryPrint(){done++;if(done>=n)window.print();}
  imgs.forEach(function(img){img.onload=img.onerror=tryPrint;});
})();
<\/script>
</body>
</html>`;

        const win = window.open('', '_blank', 'width=960,height=720');
        win.document.write(printHtml);
        win.document.close();
      };

      // ── Checkbox per baris (delegated) ───────────────────────────────────────
      document.addEventListener('change', event => {
        const cb = event.target.closest('.js-print-check');
        if (!cb) return;
        const item = {
          id: cb.dataset.id,
          kd: cb.dataset.kd || '',
          kdsys: cb.dataset.kdsys || '',
          nama: cb.dataset.nama || '',
          satuan: cb.dataset.satuan || '',
          barcode: cb.dataset.barcode || '',
          qrcode: cb.dataset.qrcode || ''
        };
        if (cb.checked) {
          if (!printQueue.some(i => i.id === item.id)) printQueue.push(item);
        } else {
          printQueue = printQueue.filter(i => i.id !== item.id);
        }
        updatePrintBadge();
        syncCheckAll();
      });

      // ── Centang semua di halaman ini ─────────────────────────────────────────
      document.getElementById('checkAllBarang').addEventListener('change', function() {
        const state = this.checked;
        document.querySelectorAll('#tableBarang .js-print-check').forEach(cb => {
          cb.checked = state;
          const item = {
            id: cb.dataset.id,
            kd: cb.dataset.kd || '',
            kdsys: cb.dataset.kdsys || '',
            nama: cb.dataset.nama || '',
            satuan: cb.dataset.satuan || '',
            barcode: cb.dataset.barcode || '',
            qrcode: cb.dataset.qrcode || ''
          };
          if (state) {
            if (!printQueue.some(i => i.id === item.id)) printQueue.push(item);
          } else {
            printQueue = printQueue.filter(i => i.id !== item.id);
          }
        });
        updatePrintBadge();
      });

      // ── Buka modal Cetak Terpilih ─────────────────────────────────────────────
      document.getElementById('btnOpenPrintQueue').addEventListener('click', () => {
        _printAllItems = null;
        renderLabelPreview(printQueue);
        $('#modalPrintLabel').modal('show');
      });

      // ── Cetak Semua (ambil semua dari API → modal → cetak) ───────────────────
      document.getElementById('btnCetakSemua').addEventListener('click', async () => {
        showLoading(true);
        try {
          const json = await api(URLS.barangAll);
          const allItems = (json.data || []).map(row => ({
            id: String(row.id),
            kd: row.kd_barang || '',
            kdsys: row.kode_barang_system || '',
            nama: row.nama_barang || '',
            satuan: row.satuan || '',
            barcode: row.barcode || '',
            qrcode: row.qrcode || ''
          }));
          if (!allItems.length) {
            Toast.fire({
              icon: 'warning',
              title: 'Tidak ada data barang.'
            });
            return;
          }
          _printAllItems = allItems;
          renderLabelPreview(allItems);
          $('#modalPrintLabel').modal('show');
        } catch (e) {
          Toast.fire({
            icon: 'error',
            title: e.message || 'Gagal memuat data barang.'
          });
        } finally {
          showLoading(false);
        }
      });

      // ── Kosongkan antrian ────────────────────────────────────────────────────
      document.getElementById('btnClearQueue').addEventListener('click', () => {
        printQueue = [];
        _printAllItems = null;
        updatePrintBadge();
        document.querySelectorAll('#tableBarang .js-print-check').forEach(cb => {
          cb.checked = false;
        });
        syncCheckAll();
        renderLabelPreview([]);
      });

      // ── Tombol Cetak di dalam modal ──────────────────────────────────────────
      document.getElementById('btnDoPrint').addEventListener('click', () => doPrint());

      // ── Re-render preview saat opsi berubah ──────────────────────────────────
      ['labelColCount', 'labelCopies', 'showBarcode', 'showQrcode'].forEach(id =>
        document.getElementById(id).addEventListener('change', () => renderLabelPreview())
      );

      // Bersihkan _printAllItems saat modal ditutup agar Cetak Terpilih benar
      $('#modalPrintLabel').on('hidden.bs.modal', () => {
        _printAllItems = null;
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