<div id="profile-root">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;gap:16px;flex-wrap:wrap;">
    <div>
      <h1 style="font-size:2.5rem;font-weight:bold;color:#14532d;margin-bottom:4px;">Profil Saya</h1>
      <p style="color:#4b5563;font-size:1.1rem;">Kelola informasi pribadi dan target kesehatan Anda</p>
    </div>
    <div style="display:flex;gap:12px;">
      <button id="edit-profile-btn" class="dash-btn" style="min-width:120px;">Edit Profil</button>
      <button id="logout-btn" class="dash-btn" style="background:#dc2626;color:#fff;border-color:#dc2626;min-width:120px;">Log Out</button>
    </div>
  </div>
  <div id="profile-alert" style="max-width:800px;margin:0 auto 18px auto;"></div>
  <form id="profile-form" style="background:#fff;border:1px solid #bbf7d0;border-radius:20px;box-shadow:0 2px 12px rgba(16,185,129,0.06);padding:32px 28px;max-width:800px;margin-bottom:32px;margin-left:auto;margin-right:auto;">
    <div style="font-weight:600;color:#14532d;font-size:1.2rem;margin-bottom:18px;">Informasi Pribadi</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px 32px;margin-bottom:24px;">
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Nama Lengkap</label>
        <input type="text" id="profile-name" name="name" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
      </div>
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Email</label>
        <input type="email" id="profile-email" name="email" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
      </div>
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Tanggal Lahir</label>
        <input type="date" id="profile-birth" name="birth_date" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
      </div>
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Jenis Kelamin</label>
        <select id="profile-gender" name="gender" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
          <option value="female">Perempuan</option>
          <option value="male">Laki-laki</option>
        </select>
      </div>
    </div>
    <div style="font-weight:600;color:#14532d;font-size:1.2rem;margin-bottom:18px;">Kesehatan</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px 32px;margin-bottom:24px;">
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Tinggi Badan (cm)</label>
        <input type="number" id="profile-height" name="height" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
      </div>
      <div>
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Berat Badan (kg)</label>
        <input type="number" id="profile-weight" name="weight" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
      </div>
      <div style="grid-column:1/3;">
        <label style="font-weight:500;color:#166534;display:block;margin-bottom:6px;">Tingkat Aktivitas</label>
        <select id="profile-activity" name="activity" style="width:100%;padding:10px 14px;border-radius:8px;border:1px solid #bbf7d0;background:#f9fafb;font-size:1rem;">
          <option value="sedentary">Sedentary (Tidak aktif)</option>
          <option value="light">Light (Olahraga ringan 1-3x/minggu)</option>
          <option value="moderate">Moderate (Olahraga 3-5x/minggu)</option>
          <option value="active">Active (Olahraga 6-7x/minggu)</option>
          <option value="very_active">Very Active (Olahraga 2x/hari)</option>
        </select>
      </div>
      <div id="female-extra" style="display:none;grid-column:1/3;background:#fce7f3;padding:20px 24px;border-radius:12px;margin-top:8px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
          <span style="font-size:1.1rem;color:#334155;">Sedang hamil</span>
          <input type="checkbox" id="profile-pregnant" name="is_pregnant" style="width:20px;height:20px;">
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <span style="font-size:1.1rem;color:#334155;">Sedang menyusui</span>
          <input type="checkbox" id="profile-breastfeeding" name="is_breastfeed" style="width:20px;height:20px;">
        </div>
      </div>
    </div>
    <button type="submit" class="dash-btn" style="margin-top:12px;min-width:120px;float:right;">Simpan</button>
    <div style="clear:both;"></div>
  </form>
  <div id="profile-stats" style="max-width:800px;margin-left:auto;margin-right:auto;"></div>
</div>
<style>
@media (max-width: 700px) {
  #profile-form {
    padding: 18px 6vw;
  }
  #profile-form > div[style*='grid-template-columns'] {
    grid-template-columns: 1fr !important;
    gap: 18px 0 !important;
  }
}
</style>
<script>
function showProfileAlert(msg, type) {
  document.getElementById('profile-alert').innerHTML = `<div style='background:${type==='success'?'#dcfce7':'#fee2e2'};color:${type==='success'?'#166534':'#b91c1c'};padding:12px 18px;border-radius:8px;margin-bottom:8px;font-weight:500;'>${msg}</div>`;
}
function clearProfileAlert() {
  document.getElementById('profile-alert').innerHTML = '';
}
function fetchProfile() {
  fetch('actions/get_profile.php')
    .then(r=>r.json())
    .then(res=>{
      if(res.success) {
        const u = res.user;
        document.getElementById('profile-name').value = u.name||'';
        document.getElementById('profile-email').value = u.email||'';
        document.getElementById('profile-birth').value = u.birth_date||'';
        document.getElementById('profile-gender').value = u.gender||'female';
        document.getElementById('profile-height').value = u.height||'';
        document.getElementById('profile-weight').value = u.weight||'';
        document.getElementById('profile-activity').value = u.activity||'moderate';
        document.getElementById('profile-pregnant').checked = u.is_pregnant==1;
        document.getElementById('profile-breastfeeding').checked = u.is_breastfeed==1;
        document.getElementById('female-extra').style.display = (u.gender==='female')?'block':'none';
        renderProfileStats(u);
      } else {
        showProfileAlert(res.message||'Gagal mengambil data profil', 'error');
      }
    })
    .catch(()=>showProfileAlert('Gagal mengambil data profil', 'error'));
}
function updateProfile(editable) {
  document.getElementById('profile-name').disabled = !editable;
  document.getElementById('profile-email').disabled = !editable;
  document.getElementById('profile-birth').disabled = !editable;
  document.getElementById('profile-gender').disabled = !editable;
  document.getElementById('profile-height').disabled = !editable;
  document.getElementById('profile-weight').disabled = !editable;
  document.getElementById('profile-activity').disabled = !editable;
  document.getElementById('profile-pregnant').disabled = !editable;
  document.getElementById('profile-breastfeeding').disabled = !editable;
}
function renderProfileStats(profile) {
  function calculateAge(birthDate) {
    if(!birthDate) return '-';
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
      age--;
    }
    return age;
  }
  function calculateBMI(weight, height) {
    if(!weight||!height) return '-';
    const h = parseFloat(height)/100;
    const bmi = parseFloat(weight)/(h*h);
    return bmi.toFixed(1);
  }
  function getBMICategory(bmi) {
    if (bmi < 18.5) return { category: "Underweight", color: "#2563eb" };
    if (bmi < 25) return { category: "Normal", color: "#16a34a" };
    if (bmi < 30) return { category: "Overweight", color: "#ea580c" };
    return { category: "Obese", color: "#dc2626" };
  }
  function calculateDailyCalories(profile) {
    if(!profile.weight||!profile.height||!profile.birth_date) return '-';
    const bmr = 655 + 9.6*parseFloat(profile.weight) + 1.8*parseFloat(profile.height) - 4.7*calculateAge(profile.birth_date);
    const activityMultipliers = {sedentary:1.2,light:1.375,moderate:1.55,active:1.725,very_active:1.9};
    let calories = bmr * activityMultipliers[profile.activity||'moderate'];
    if(profile.is_pregnant==1) calories += 300;
    if(profile.is_breastfeed==1) calories += 500;
    return Math.round(calories);
  }
  const age = calculateAge(profile.birth_date);
  const bmi = calculateBMI(profile.weight, profile.height);
  const bmiInfo = getBMICategory(parseFloat(bmi));
  const dailyCalories = calculateDailyCalories(profile);
  let html = `<div style='background:#f0fdf4;padding:20px 24px;border-radius:16px;margin-bottom:12px;box-shadow:0 1px 6px rgba(16,185,129,0.04);'>
    <div style='font-weight:500;color:#166534;margin-bottom:4px;'>Usia: <span style='color:#14532d;'>${age} tahun</span></div>
    <div style='font-weight:500;color:#166534;margin-bottom:4px;'>BMI: <span style='color:${bmiInfo.color};font-weight:bold;'>${bmi} (${bmiInfo.category})</span></div>
    <div style='font-weight:500;color:#166534;margin-bottom:4px;'>Kebutuhan Energi Harian (kcal): <span style='color:#14532d;'>${dailyCalories} kcal</span></div>
  </div>`;
  document.getElementById('profile-stats').innerHTML = html;
}
let editable = false;
document.getElementById('edit-profile-btn').onclick = function() {
  editable = !editable;
  this.textContent = editable ? 'Simpan' : 'Edit Profil';
  updateProfile(editable);
  clearProfileAlert();
  if(!editable) {
    // Simpan
    const form = document.getElementById('profile-form');
    const fd = new FormData(form);
    fetch('actions/update_profile.php', {
      method: 'POST',
      body: fd
    })
    .then(r=>r.json())
    .then(res=>{
      if(res.success) {
        showProfileAlert(res.message||'Profil berhasil diupdate', 'success');
        fetchProfile();
      } else {
        showProfileAlert(res.message||'Gagal update profil', 'error');
      }
    })
    .catch(()=>showProfileAlert('Gagal update profil', 'error'));
  }
};
document.getElementById('profile-form').onsubmit = function(e) {
  e.preventDefault();
  if(editable) {
    document.getElementById('edit-profile-btn').click();
  }
};
document.getElementById('profile-gender').onchange = function() {
  document.getElementById('female-extra').style.display = this.value==='female'?'block':'none';
};
document.getElementById('logout-btn').onclick = function() {
  if(confirm('Yakin ingin log out?')) {
    fetch('auth/logout.php')
      .then(r=>r.json())
      .then(res=>{
        if(res.success) {
          window.location.href = 'landing_page.php';
        } else {
          showProfileAlert('Gagal log out', 'error');
        }
      })
      .catch(()=>showProfileAlert('Gagal log out', 'error'));
  }
};
fetchProfile();
updateProfile(false);
</script>
