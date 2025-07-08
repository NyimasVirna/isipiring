<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - isi piring</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <style>
    body { background: #f0fdf4; font-family: 'Segoe UI', Arial, sans-serif; }
    .reg-container { max-width: 440px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(16,185,129,0.08); padding: 32px 28px; }
    .reg-title { font-size: 2rem; font-weight: bold; color: #14532d; margin-bottom: 8px; text-align: center; }
    .reg-desc { color: #4b5563; text-align: center; margin-bottom: 24px; }
    .form-group { margin-bottom: 18px; }
    label { font-weight: 500; color: #166534; display: block; margin-bottom: 6px; }
    input, select { width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid #bbf7d0; background: #f9fafb; font-size: 1rem; }
    .reg-btn { width: 100%; background: #16a34a; color: #fff; border: none; border-radius: 8px; padding: 12px 0; font-size: 1.1rem; font-weight: 500; cursor: pointer; margin-top: 8px; }
    .reg-btn:hover { background: #166534; }
    .reg-link { text-align: center; margin-top: 18px; }
    .reg-alert { background: #fee2e2; color: #b91c1c; padding: 10px 16px; border-radius: 8px; margin-bottom: 12px; text-align: center; }
    .form-row { display: flex; gap: 12px; }
    .form-row > div { flex: 1; }
    @media (max-width: 600px) { .form-row { flex-direction: column; gap: 0; } }
  </style>
</head>
<body>
  <div class="reg-container">
    <div class="reg-title">Daftar Akun</div>
    <div class="reg-desc">Buat akun baru untuk mulai menggunakan isi piring</div>
    <div id="reg-alert"></div>
    <form id="reg-form" autocomplete="off">
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" required autofocus>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="birth_date">Tanggal Lahir</label>
          <input type="date" id="birth_date" name="birth_date">
        </div>
        <div class="form-group">
          <label for="gender">Jenis Kelamin</label>
          <select id="gender" name="gender">
            <option value="female">Perempuan</option>
            <option value="male">Laki-laki</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="height">Tinggi Badan (cm)</label>
          <input type="number" id="height" name="height">
        </div>
        <div class="form-group">
          <label for="weight">Berat Badan (kg)</label>
          <input type="number" id="weight" name="weight">
        </div>
      </div>
      <div class="form-group">
        <label for="activity">Tingkat Aktivitas</label>
        <select id="activity" name="activity">
          <option value="sedentary">Sedentary (Tidak aktif)</option>
          <option value="light">Light (Olahraga ringan 1-3x/minggu)</option>
          <option value="moderate">Moderate (Olahraga 3-5x/minggu)</option>
          <option value="active">Active (Olahraga 6-7x/minggu)</option>
          <option value="very_active">Very Active (Olahraga 2x/hari)</option>
        </select>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label><input type="checkbox" id="is_pregnant" name="is_pregnant"> Sedang hamil</label>
        </div>
        <div class="form-group">
          <label><input type="checkbox" id="is_breastfeed" name="is_breastfeed"> Sedang menyusui</label>
        </div>
      </div>
      <button type="submit" class="reg-btn">Daftar</button>
    </form>
    <div class="reg-link">
      Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
  </div>
  <script>
    document.getElementById('reg-form').onsubmit = function(e) {
      e.preventDefault();
      document.getElementById('reg-alert').innerHTML = '';
      const fd = new FormData(this);
      fetch('register_action.php', { method: 'POST', body: fd })
        .then(r=>r.json())
        .then(res=>{
          if(res.success) {
            document.getElementById('reg-alert').innerHTML = '<span style="color:#166534;">'+(res.message||'Registrasi berhasil!')+'</span>';
            setTimeout(()=>{ window.location.href = 'login.php'; }, 1200);
          } else {
            document.getElementById('reg-alert').innerHTML = res.message||'Registrasi gagal';
          }
        })
        .catch(()=>{
          document.getElementById('reg-alert').innerHTML = 'Registrasi gagal, coba lagi.';
        });
    };
  </script>
</body>
</html>
