<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php'; 

if(isset($_SESSION['user_id'])) {
    header('auth/login.php');
}

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
$user_data = null;

if ($user_id) {
    $user_data = getUserData($user_id);
}
?>

<?php // landing.php ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>isi piring - Nutrition Tracker</title>
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
    .nav-btns a { background: #16a34a; color: #fff; border-radius: 8px; padding: 8px 20px; text-decoration: none; font-weight: 500; transition: background 0.2s; }
    .nav-btns a:hover { background: #14532d; }
    .hero { max-width: 900px; margin: 48px auto 0 auto; background: #fff; border-radius: 24px; box-shadow: 0 2px 16px #0001; padding: 48px 32px; text-align: center; }
    .hero-icon { margin-bottom: 16px; }
    .hero-title { font-size: 2.5rem; font-weight: bold; color: #166534; margin-bottom: 8px; }
    .hero-desc { color: #4b5563; font-size: 1.2rem; margin-bottom: 24px; }
    .hero-btns { display: flex; gap: 16px; justify-content: center; margin-top: 24px; }
    .features { max-width: 900px; margin: 48px auto 0 auto; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 32px; }
    .feature-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px #0001; padding: 32px 20px; text-align: center; }
    .feature-icon { margin-bottom: 12px; }
    .feature-title { font-weight: bold; color: #166534; font-size: 1.1rem; margin-bottom: 8px; }
    .feature-desc { color: #4b5563; font-size: 0.98rem; }
    @media (max-width: 900px) { .features { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 600px) { .features { grid-template-columns: 1fr; } .hero { padding: 32px 8px; } }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="navbar-content">
      <div class="brand">
        <img src="public/placeholder-logo.svg" alt="Logo" style="height:28px;width:28px;">
        isi piring
      </div>
      <div class="nav-btns">
        <a href="auth/login.php">Login</a>
        <a href="auth/register.php">Register</a>
      </div>
    </div>
  </nav>
  <main>
    <section class="hero">
      <div class="hero-icon">
        <svg width="56" height="56" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/><line x1="12" y1="2" x2="12" y2="6"/></svg>
      </div>
      <div class="hero-title">Pantau Nutrisi, Raih Hidup Sehat</div>
      <div class="hero-desc">Aplikasi pelacak nutrisi harian berbasis web yang membantu Anda mencapai target kesehatan dengan mudah, cepat, dan menyenangkan.</div>
      <div class="hero-btns">
        <a href="auth/login.php" class="hero-btn" style="background:#16a34a;color:#fff;padding:12px 32px;border-radius:8px;font-size:1.1rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
          <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="10 17 15 12 10 7"/></svg>
          Login
        </a>
        <a href="auth/register.php" class="hero-btn" style="background:#fff;color:#16a34a;padding:12px 32px;border-radius:8px;font-size:1.1rem;font-weight:500;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border:1.5px solid #16a34a;">
          <svg width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Register
        </a>
      </div>
    </section>
    <section class="features">
      <div class="feature-card">
        <div class="feature-icon">
          <svg width="32" height="32" fill="none" stroke="#16a34a" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <div class="feature-title">Catat Makanan</div>
        <div class="feature-desc">Log makanan harian dengan mudah, dapatkan insight asupan kalori dan nutrisi secara real-time.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">
          <svg width="32" height="32" fill="none" stroke="#2563eb" stroke-width="2.2" viewBox="0 0 24 24"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
        </div>
        <div class="feature-title">Dashboard Dinamis</div>
        <div class="feature-desc">Pantau progres mingguan & bulanan, dapatkan rekomendasi personal untuk hidup lebih sehat.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon">
          <svg width="32" height="32" fill="none" stroke="#ea580c" stroke-width="2.2" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <div class="feature-title">Komunitas Sehat</div>
        <div class="feature-desc">Bergabung dengan komunitas, berbagi pengalaman, dan ikuti challenge seru bersama pengguna lain.</div>
      </div>
    </section>
  </main>
  <footer style="background:#f0fdf4;border-top:1px solid #bbf7d0;margin-top:48px;padding:32px 0 16px 0;text-align:center;">
    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
      <img src="public/placeholder-logo.svg" alt="Logo isi piring" style="height:32px;width:32px;margin-bottom:4px;">
      <div style="font-weight:bold;font-size:1.1rem;color:#16a34a;">isi piring</div>
      <div style="color:#4b5563;font-size:0.98rem;margin-bottom:8px;">&copy; <?php echo date('Y'); ?> isi piring. All rights reserved.</div>
      <div style="display:flex;gap:18px;justify-content:center;align-items:center;">
        <a href="#" style="color:#16a34a;text-decoration:none;font-weight:500;">Komunitas</a>
        <span style="color:#bbf7d0;">|</span>
        <a href="mailto:support@isipiring.com" style="color:#16a34a;text-decoration:none;font-weight:500;">Kontak</a>
      </div>
    </div>
  </footer>
</body>
</html>
