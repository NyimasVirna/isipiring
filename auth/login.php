<?php
session_start();
require_once '../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  if (!$email || !$password) {
    $error = 'Email dan password wajib diisi.';
  } else {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      header('Location: ../index.php');
      exit;
    } else {
      $error = 'Email atau password salah.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | isi piring</title>
  <style>
    body {
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(135deg, #e6f9ed 0%, #bbf7d0 60%,rgb(79, 183, 117) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 0;
    }
    .login-card {
      display: flex;
      background: #fff;
      border-radius: 32px;
      /* Shadow lebih tebal dan lembut */
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 1.5px 8px 0 rgba(22,163,74,0.10);
      overflow: hidden;
      max-width: 850px;
      width: 100%;
      min-height: 420px;
      margin: 0 16px;
      /* Animasi muncul dari bawah */
      opacity: 0;
      transform: translateY(60px) scale(0.98);
      animation: slideUp 0.7s cubic-bezier(.23,1.01,.32,1) 0.1s both;
    }
    @keyframes slideUp {
      0% {
        opacity: 0;
        transform: translateY(60px) scale(0.98);
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    .login-left {
      background: linear-gradient(135deg, #e6f9ed 0%, #bbf7d0 100%);
      color: #14532d;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 56px 36px 56px 36px;
    }
    .login-illustration {
      width: 110px;
      margin-bottom: 24px;
    }
    .login-left h2 {
      margin: 0 0 12px 0;
      font-size: 1.5rem;
      font-weight: bold;
    }
    .login-left p {
      margin: 0;
      font-size: 1.05rem;
      color: #166534;
    }
    .login-right {
      flex: 1;
      padding: 56px 48px 56px 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .login-right h2 {
      margin-bottom: 28px;
      color: #14532d;
      font-size: 2rem;
      font-weight: bold;
    }
    .login-form input {
      width: 100%;
      padding: 16px 18px;
      margin-bottom: 22px;
      border-radius: 14px;
      border: 1.5px solid #bbf7d0;
      background: #f9fafb;
      font-size: 1rem;
      transition: border 0.2s;
      box-sizing: border-box;
      display: block;
    }
    .login-form input:focus {
      border: 1.5px solid #16a34a;
      outline: none;
    }
    .login-form button {
      width: 100%;
      padding: 16px 0;
      background: #16a34a;
      color: #fff;
      border: none;
      border-radius: 14px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s;
      margin-bottom: 12px;
      margin-top: 8px;
    }
    .login-form button:hover {
      background: #14532d;
    }
    .login-links {
      margin-top: 18px;
      text-align: center;
    }
    .login-links a {
      color: #16a34a;
      text-decoration: underline;
      font-size: 0.98rem;
    }
    .login-error {
      background: #fee2e2;
      color: #b91c1c;
      padding: 12px 18px;
      border-radius: 10px;
      margin-bottom: 18px;
      text-align: center;
      font-size: 1.05rem;
      font-weight: 500;
    }
    @media (max-width: 700px) {
      .login-card { flex-direction: column; min-height: unset; }
      .login-left, .login-right { padding: 32px 12px; }
      .login-left { border-radius: 32px 32px 0 0; }
      .login-right { border-radius: 0 0 32px 32px; }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-left">
      <img src="../public/placeholder-logo.svg" alt="Logo" class="login-illustration">
      <h2>Selamat Datang di <span style="color:#16a34a;">isi piring</span></h2>
      <p>Pantau asupan nutrisi dan capai hidup sehat!</p>
    </div>
    <div class="login-right">
      <h2>Login</h2>
      <?php if ($error): ?>
        <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form method="POST" action="login.php" class="login-form" autocomplete="off">
        <input type="email" name="email" placeholder="Email" required autocomplete="username" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
        <button type="submit">Masuk</button>
      </form>
      <div class="login-links">
        <a href="register.php">Belum punya akun? Daftar</a>
      </div>
    </div>
  </div>
</body>
</html>
