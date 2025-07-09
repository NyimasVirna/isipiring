<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | isi piring</title>
  <style>
    body {
      min-height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Arial, sans-serif;
      background: linear-gradient(135deg, #e6f9ed 0%, #bbf7d0 60%, #16a34a 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 0;
    }
    .register-card {
      display: flex;
      background: #fff;
      border-radius: 32px;
      /* Shadow lebih tebal dan lembut */
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18), 0 1.5px 8px 0 rgba(22,163,74,0.10);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
      min-height: 480px;
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
    .register-left {
      background: linear-gradient(135deg, #e6f9ed 0%, #bbf7d0 100%);
      color: #14532d;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 56px 36px 56px 36px;
    }
    .register-illustration {
      width: 110px;
      margin-bottom: 24px;
    }
    .register-left h2 {
      margin: 0 0 12px 0;
      font-size: 1.5rem;
      font-weight: bold;
    }
    .register-left p {
      margin: 0;
      font-size: 1.05rem;
      color: #166534;
    }
    .register-right {
      flex: 1.2;
      padding: 56px 48px 56px 48px; /* lebih lega */
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .register-right h2 {
      margin-bottom: 28px;
      color: #14532d;
      font-size: 2rem;
      font-weight: bold;
    }
    .register-form input, .register-form select {
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
    .register-form input:focus, .register-form select:focus {
      border: 1.5px solid #16a34a;
      outline: none;
    }
    .register-form button {
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
    .register-form button:hover {
      background: #14532d;
    }
    .register-links {
      margin-top: 18px;
      text-align: center;
    }
    .register-links a {
      color: #16a34a;
      text-decoration: underline;
      font-size: 0.98rem;
    }
    .register-form {
      margin-top: 18px;
    }
    .female-extra {
      display: none;
      margin-bottom: 22px;
      background: #fde7f3;
      border: 2px solid #fff;
      padding: 22px 20px 16px 20px;
      border-radius: 18px;
      color: #a21a5b;
      font-size: 1.08rem;
      box-shadow: 0 2px 12px rgba(253, 231, 243, 0.12);
    }
    .female-extra .extra-title {
      font-weight: 600;
      color: #a21a5b;
      margin-bottom: 12px;
      font-size: 1.08rem;
      letter-spacing: 0.5px;
    }
    .female-extra .checkbox-row {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .female-extra label {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 1.08rem;
      font-weight: 500;
      color: #a21a5b;
      background: #fff;
      border-radius: 10px;
      padding: 6px 14px 6px 10px; /* lebih simetris */
      box-shadow: 0 1px 4px rgba(253, 231, 243, 0.10);
      transition: background 0.2s;
      line-height: 1.2;
      min-height: 32px;
    }
    .female-extra label:hover {
      background: #fff0fa;
    }
    .female-extra input[type=checkbox] {
      width: 22px;
      height: 22px;
      accent-color: #e75480;
      border-radius: 6px;
      margin-right: 0;
      vertical-align: middle;
    }
    @media (max-width: 700px) {
      .register-card { flex-direction: column; min-height: unset; }
      .register-left, .register-right { padding: 32px 12px; }
      .register-left { border-radius: 32px 32px 0 0; }
      .register-right { border-radius: 0 0 32px 32px; }
    }
  </style>
</head>
<body>
  <div class="register-card">
    <div class="register-left">
      <img src="../public/placeholder-logo.svg" alt="Logo" class="register-illustration">
      <h2>Bergabung dengan <span style="color:#16a34a;">isi piring</span></h2>
      <p>Mulai perjalanan sehatmu hari ini!</p>
    </div>
    <div class="register-right">
      <h2>Register</h2>

      <!-- NEW: Tempat alert -->
      <div id="alert-box"></div>

      <form id="register-form" class="register-form">
        <input type="text" name="name" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required autocomplete="username">
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
        <input type="date" name="birth_date" placeholder="Tanggal Lahir" required>
        <select name="gender" id="reg-gender" required>
          <option value="">Pilih Jenis Kelamin</option>
          <option value="female">Perempuan</option>
          <option value="male">Laki-laki</option>
        </select>
        <div class="female-extra" id="female-extra">
          <div class="extra-title">Kondisi Khusus</div>
          <div class="checkbox-row">
            <label><input type="checkbox" name="is_pregnant"> Sedang hamil</label>
            <label><input type="checkbox" name="is_breastfeed"> Sedang menyusui</label>
          </div>
        </div>
        <input type="number" name="height" placeholder="Tinggi Badan (cm)" min="50" max="250" required>
        <input type="number" name="weight" placeholder="Berat Badan (kg)" min="10" max="300" required>
        <button type="submit">Daftar</button>
      </form>

      <div class="register-links">
        <a href="login.php">Sudah punya akun? Login</a>
      </div>
    </div>
  </div>

  <script>
    // Tampilkan checkbox kondisi jika gender perempuan
    const genderSelect = document.getElementById('reg-gender');
    const femaleExtra = document.getElementById('female-extra');
    genderSelect.addEventListener('change', function () {
      if (this.value === 'female') {
        femaleExtra.style.display = 'block';
      } else {
        femaleExtra.style.display = 'none';
        femaleExtra.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
      }
    });

    // NEW: Tangani form submit dengan AJAX
    const form = document.getElementById('register-form');
    const alertBox = document.getElementById('alert-box');

    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      alertBox.innerHTML = '';

      const formData = new FormData(form);

      try {
        const res = await fetch('register_action.php', {
          method: 'POST',
          body: formData
        });

        const result = await res.json();

        const alert = document.createElement('div');
        alert.className = 'alert ' + (result.success ? 'alert-success' : 'alert-error');
        alert.innerText = result.message;
        alertBox.appendChild(alert);

        if (result.success) {
          setTimeout(() => {
            window.location.href = 'login.php';
          }, 2000);
        }

      } catch (error) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-error';
        alert.innerText = 'Terjadi kesalahan saat mengirim data.';
        alertBox.appendChild(alert);
        console.error(error);
      }
    });
  </script>
</body>
</html>