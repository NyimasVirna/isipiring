<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_data = getUserData($user_id);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>isi piring - Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body { background: #f0fdf4; font-family: 'Inter', Arial, sans-serif; }
    .navbar {
      background: rgba(255,255,255,0.7);
      border-bottom: 1px solid #bbf7d0;
      padding: 16px 0;
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      box-shadow: 0 2px 16px #0001;
      transition: background 0.3s, box-shadow 0.3s;
    }
    .navbar-content { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .brand { display: flex; align-items: center; gap: 10px; font-weight: bold; font-size: 1.2rem; color: #166534; }
    .nav-btns { display: flex; gap: 12px; }
    .nav-btns button { background: #fff; color: #166534; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 500; cursor: pointer; transition: background 0.2s; }
    .nav-btns button.active, .nav-btns button:hover { background: #16a34a; color: #fff; }
    main { max-width: 1200px; margin: 0 auto; padding: 32px 16px; }
  </style>
</head>
<body>
<nav class="navbar">
  <div class="navbar-content">
    <div class="brand">
      <span class="brand-icon"><img src="public/placeholder-logo.svg" alt="Logo" style="height:28px;width:28px;"></span>
      isi piring
    </div>
    <div class="nav-btns">
      <button class="active" onclick="showTab('home', this)">Beranda</button>
      <button onclick="showTab('food', this)">Makanan</button>
      <button onclick="showTab('dashboard', this)">Dashboard</button>
      <button onclick="showTab('profile', this)">Profil</button>
      <button onclick="showTab('community', this)">Komunitas</button>
      <!-- Hapus tombol Logout dari navbar -->
    </div>
  </div>
</nav>
<main>
  <div id="tab-home">
    <h1 style="font-size:2.2rem;font-weight:bold;color:#14532d;margin-bottom:10px;">Selamat datang, <?php echo htmlspecialchars($user_data['name']); ?>!</h1>
    <p style="color:#4b5563;max-width:650px;font-size:1.1rem;">Pantau asupan nutrisi harian, catat makanan, dan capai target kesehatan Anda bersama <b>isi piring</b>. Gunakan menu di atas untuk mulai mencatat makanan, melihat dashboard, mengelola profil, dan bergabung dengan komunitas sehat!</p>
    <div style="margin-top:40px;display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:32px;justify-content:center;align-items:stretch;">
      <div class="fitur-card" style="background:#fff;border:1.5px solid #bbf7d0;border-radius:18px;padding:32px 24px;text-align:center;box-shadow:0 2px 12px #0001;transition:box-shadow .2s,border .2s;cursor:pointer;">
        <div style="margin-bottom:16px;display:flex;justify-content:center;">
          <svg width="40" height="40" fill="none" stroke="#16a34a" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9 12h6"/><path d="M12 9v6"/></svg>
        </div>
        <div style="font-weight:bold;color:#166534;font-size:1.15rem;margin-bottom:6px;">Catat Makanan</div>
        <div style="color:#4b5563;font-size:1rem;">Log makanan harian dan pantau asupan nutrisi Anda secara real-time.</div>
      </div>
      <div class="fitur-card" style="background:#fff;border:1.5px solid #bbf7d0;border-radius:18px;padding:32px 24px;text-align:center;box-shadow:0 2px 12px #0001;transition:box-shadow .2s,border .2s;cursor:pointer;">
        <div style="margin-bottom:16px;display:flex;justify-content:center;">
          <svg width="40" height="40" fill="none" stroke="#2563eb" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
        </div>
        <div style="font-weight:bold;color:#166534;font-size:1.15rem;margin-bottom:6px;">Dashboard</div>
        <div style="color:#4b5563;font-size:1rem;">Lihat progres mingguan, bulanan, dan insight kesehatan Anda dengan visual yang informatif.</div>
      </div>
      <div class="fitur-card" style="background:#fff;border:1.5px solid #bbf7d0;border-radius:18px;padding:32px 24px;text-align:center;box-shadow:0 2px 12px #0001;transition:box-shadow .2s,border .2s;cursor:pointer;">
        <div style="margin-bottom:16px;display:flex;justify-content:center;">
          <svg width="40" height="40" fill="none" stroke="#ea580c" stroke-width="2.2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div style="font-weight:bold;color:#166534;font-size:1.15rem;margin-bottom:6px;">Komunitas</div>
        <div style="color:#4b5563;font-size:1rem;">Bergabung, berbagi pengalaman, dan ikuti challenge seru bersama pengguna lain.</div>
      </div>
    </div>
    <style>
      .fitur-card:hover {
        box-shadow:0 4px 24px #16a34a22;
        border:1.5px solid #16a34a;
      }
    </style>
  </div>
  <div id="tab-food" style="display:none;">
    <?php include 'includes/food-logger.php'; ?>
  </div>
  <div id="tab-dashboard" style="display:none;">
    <?php include 'includes/dashboard.php'; ?>
  </div>
  <div id="tab-profile" style="display:none;">
    <?php include 'includes/profile.php'; ?>
  </div>
  <div id="tab-community" style="display:none;">
    <?php include 'includes/community.php'; ?>
  </div>
</main>
<footer style="background:#f0fdf4;border-top:1px solid #bbf7d0;margin-top:48px;padding:32px 0 16px 0;text-align:center;">
  <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
    <img src="public/placeholder-logo.svg" alt="Logo isi piring" style="height:32px;width:32px;margin-bottom:4px;">
    <div style="font-weight:bold;font-size:1.1rem;color:#16a34a;">isi piring</div>
    <div style="color:#4b5563;font-size:0.98rem;margin-bottom:8px;">&copy; <?php echo date('Y'); ?> isi piring. All rights reserved.</div>
    <div style="display:flex;gap:18px;justify-content:center;align-items:center;">
      <a href="#" onclick="showTab('community')" style="color:#16a34a;text-decoration:none;font-weight:500;">Komunitas</a>
      <span style="color:#bbf7d0;">|</span>
      <a href="mailto:virna1705@gmail.com" style="color:#16a34a;text-decoration:none;font-weight:500;">Kontak</a>
    </div>
  </div>
</footer>
<script>
function showTab(tab, btn) {
  const tabs = ['home','food','dashboard','profile','community'];
  tabs.forEach(t => {
    document.getElementById('tab-' + t).style.display = (t === tab) ? '' : 'none';
  });
  // Update nav button active state
  if(btn) {
    document.querySelectorAll('.nav-btns button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
}
</script>
</body>
</html>
