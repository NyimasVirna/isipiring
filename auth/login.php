<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Email dan password wajib diisi.']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        unset($user['password']);
        echo json_encode(['success' => true]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Email atau password salah.']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - isi piring</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <style>
    body { background: #f0fdf4; font-family: 'Segoe UI', Arial, sans-serif; }
    .login-container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(16,185,129,0.08); padding: 32px 28px; }
    .login-title { font-size: 2rem; font-weight: bold; color: #14532d; margin-bottom: 8px; text-align: center; }
    .login-desc { color: #4b5563; text-align: center; margin-bottom: 24px; }
    .form-group { margin-bottom: 18px; }
    label { font-weight: 500; color: #166534; display: block; margin-bottom: 6px; }
    input[type=email], input[type=password] { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #bbf7d0; background: #f9fafb; font-size: 1rem; }
    .login-btn { width: 100%; background: #16a34a; color: #fff; border: none; border-radius: 8px; padding: 12px 0; font-size: 1.1rem; font-weight: 500; cursor: pointer; margin-top: 8px; }
    .login-btn:hover { background: #166534; }
    .login-link { text-align: center; margin-top: 18px; }
    .login-alert { background: #fee2e2; color: #b91c1c; padding: 10px 16px; border-radius: 8px; margin-bottom: 12px; text-align: center; }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-title">Login</div>
    <div class="login-desc">Masuk ke akun isi piring Anda</div>
    <div id="login-alert" class="login-alert" style="display:none;"></div>
    <form id="login-form" method="post" autocomplete="off">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
    <div class="login-link">
      Belum punya akun? <a href="../auth/register.php">Daftar di sini</a>
    </div>
  </div>

  <script>
    const form = document.getElementById('login-form');
    form.onsubmit = function(e) {
      e.preventDefault();
      const alertBox = document.getElementById('login-alert');
      alertBox.style.display = 'none';
      const fd = new FormData(form);

      fetch('', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
          if (res.success) {
            window.location.href = '../index.php';
          } else {
            alertBox.style.display = 'block';
            alertBox.innerHTML = res.message || 'Login gagal';
          }
        })
        .catch(() => {
          alertBox.style.display = 'block';
          alertBox.innerHTML = 'Login gagal, coba lagi.';
        });
    };
  </script>
</body>
</html>
