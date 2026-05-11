<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= html_escape($page_title) ?></title>
  <link rel="icon" href="<?= base_url('assets/images/Karisma.png') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <style>
    :root { --so-primary:#0f766e; --so-ink:#172033; --so-muted:#687386; --so-bg:#eef4f3; }
    body { min-height:100vh; background:linear-gradient(145deg,#eef4f3 0%,#f8fafc 52%,#f5f1e8 100%); color:var(--so-ink); }
    .so-login-wrap { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px 14px; }
    .so-login-card { width:100%; max-width:420px; background:#fff; border:1px solid rgba(23,32,51,.08); border-radius:8px; box-shadow:0 20px 60px rgba(15,23,42,.12); overflow:hidden; }
    .so-login-head { padding:28px 24px 18px; border-bottom:1px solid rgba(23,32,51,.08); }
    .so-logo { height:56px; object-fit:contain; margin-bottom:18px; }
    .so-title { font-size:1.35rem; font-weight:700; margin:0; letter-spacing:0; }
    .so-subtitle { color:var(--so-muted); margin:4px 0 0; }
    .so-login-body { padding:22px 24px 24px; }
    .form-control { height:46px; border-radius:8px; }
    .input-group-text { border-radius:8px; background:#f8fafc; }
    .btn-login { height:46px; border-radius:8px; background:var(--so-primary); border-color:var(--so-primary); font-weight:700; }
    .custom-control-label { color:var(--so-muted); }
  </style>
</head>
<body>
<main class="so-login-wrap">
  <section class="so-login-card">
    <div class="so-login-head">
      <img class="so-logo" src="<?= base_url('assets/images/karisma.png') ?>" alt="Karisma">
      <h1 class="so-title">Stock Opname</h1>
      <p class="so-subtitle">Masuk untuk kelola barang, gudang, dan lokasi.</p>
    </div>
    <div class="so-login-body">
      <form id="loginForm" autocomplete="on" novalidate>
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
          </div>
          <div class="invalid-feedback d-block" data-error="username"></div>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
          </div>
          <div class="invalid-feedback d-block" data-error="password"></div>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
            <label class="custom-control-label" for="remember">Remember session</label>
          </div>
          <a href="<?= site_url('Auth') ?>">Login utama</a>
        </div>
        <button type="submit" class="btn btn-primary btn-login btn-block">
          <span class="label">Masuk</span>
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </form>
    </div>
  </section>
</main>
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script>
(() => {
  const form = document.getElementById('loginForm');
  const button = form.querySelector('button[type="submit"]');
  const setLoading = (state) => {
    button.disabled = state;
    button.querySelector('.spinner-border').classList.toggle('d-none', !state);
    button.querySelector('.label').textContent = state ? 'Memproses...' : 'Masuk';
  };
  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    form.querySelectorAll('[data-error]').forEach(el => el.textContent = '');
    if (!form.username.value.trim()) {
      form.querySelector('[data-error="username"]').textContent = 'Username wajib diisi.';
      return;
    }
    if (!form.password.value.trim()) {
      form.querySelector('[data-error="password"]').textContent = 'Password wajib diisi.';
      return;
    }
    setLoading(true);
    try {
      const response = await fetch('<?= site_url('stockopname/login-process') ?>', { method:'POST', body:new FormData(form), credentials:'same-origin' });
      const raw = await response.text();
      let json;
      try {
        json = JSON.parse(raw);
      } catch (parseError) {
        throw new Error('Respons login tidak valid. Periksa konfigurasi base URL atau server.');
      }
      if (!json.status) throw new Error(json.message || 'Login gagal.');
      window.location.href = json.data.redirect || '<?= site_url('stockopname') ?>';
    } catch (error) {
      Swal.fire({ icon:'error', title:'Login gagal', text:error.message });
    } finally {
      setLoading(false);
    }
  });
})();
</script>
</body>
</html>
