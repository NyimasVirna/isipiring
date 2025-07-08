<div id="dashboard-root">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;gap:16px;flex-wrap:wrap;">
    <div>
      <h1 style="font-size:2rem;font-weight:bold;color:#14532d;">Dashboard Nutrisi</h1>
      <p style="color:#4b5563;">Pantau pencapaian target nutrisi Anda</p>
    </div>
    <div>
      <button id="btn-weekly" class="dash-btn dash-btn-active" onclick="setDashView('weekly')">Mingguan</button>
      <button id="btn-monthly" class="dash-btn" onclick="setDashView('monthly')">Bulanan</button>
    </div>
  </div>
  <div id="dashboard-alert" style="max-width:900px;margin:0 auto 18px auto;"></div>
  <div id="dashboard-summary-cards" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;"></div>
  <div id="dashboard-main-content"></div>
  <div id="dashboard-insight" style="margin-top:32px;"></div>
</div>
<style>
.dash-btn {
  background: #fff;
  border: 1px solid #bbf7d0;
  color: #166534;
  border-radius: 8px;
  padding: 8px 20px;
  font-size: 1rem;
  margin-left: 4px;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.dash-btn-active, .dash-btn:hover {
  background: #16a34a;
  color: #fff;
  border-color: #16a34a;
}
</style>
<script>
let dashData = { weekly: [], monthly: [] };
let dashView = 'weekly';
const dashTargets = { calories: 2000, protein: 60, carbs: 250, fat: 67, fiber: 25 };
function showDashAlert(msg, type) {
  document.getElementById('dashboard-alert').innerHTML = `<div style='background:${type==='success'?'#dcfce7':'#fee2e2'};color:${type==='success'?'#166534':'#b91c1c'};padding:12px 18px;border-radius:8px;margin-bottom:8px;font-weight:500;'>${msg}</div>`;
}
function clearDashAlert() {
  document.getElementById('dashboard-alert').innerHTML = '';
}
function fetchDashboard() {
  fetch('actions/get_dashboard_summary.php')
    .then(r=>r.json())
    .then(res=>{
      if(res.success) {
        dashData.weekly = res.weekly;
        dashData.monthly = res.monthly;
        renderDashboard(dashView);
      } else {
        showDashAlert(res.message||'Gagal mengambil data dashboard', 'error');
      }
    })
    .catch(()=>showDashAlert('Gagal mengambil data dashboard', 'error'));
}
function setDashView(mode) {
  dashView = mode;
  document.getElementById('btn-weekly').classList.toggle('dash-btn-active', mode==='weekly');
  document.getElementById('btn-monthly').classList.toggle('dash-btn-active', mode==='monthly');
  renderDashboard(mode);
}
function renderDashboard(mode) {
  clearDashAlert();
  // Summary Cards
  let summaryHtml = '';
  if(mode==='weekly') {
    // Rata-rata harian
    const days = dashData.weekly.length;
    const totalKal = dashData.weekly.reduce((sum, d)=>sum+parseFloat(d.calories||0),0);
    const avgKal = days ? totalKal/days : 0;
    const achievement = Math.round((avgKal/dashTargets.calories)*100);
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#ea580c' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><circle cx='12' cy='12' r='10'/><path d='M12 8v4l3 3'/></svg> Rata-rata Harian
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${Math.round(avgKal)} kcal</div>
      <div style='font-size:0.95rem;color:#4b5563;'>Target: 2,000 kcal</div>
      <div style='background:#bbf7d0;border-radius:8px;height:8px;width:100%;margin-top:8px;overflow:hidden;'><div style='background:#16a34a;height:100%;border-radius:8px;width:${achievement}%;transition:width 0.3s;'></div></div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#2563eb' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><line x1='12' y1='20' x2='12' y2='10'/><line x1='18' y1='20' x2='18' y2='4'/><line x1='6' y1='20' x2='6' y2='16'/></svg> Pencapaian
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${achievement}%</div>
      <div class='badge' style='background:#bbf7d0;color:#166534;'>${achievement>=90?'Excellent':achievement>=80?'Good':'Needs Improvement'}</div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#f59e42' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><rect x='3' y='4' width='18' height='18' rx='2'/><line x1='16' y1='2' x2='16' y2='6'/><line x1='8' y1='2' x2='8' y2='6'/><line x1='3' y1='10' x2='21' y2='10'/></svg> Hari Aktif
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${days}</div>
      <div style='font-size:0.95rem;color:#4b5563;'>hari minggu ini</div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#16a34a' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><barChartIcon/></svg> Konsistensi
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${achievement}%</div>
      <div style='font-size:0.95rem;color:#4b5563;'>tingkat konsistensi</div>
    </div>`;
  } else {
    // Bulanan
    const weeks = dashData.monthly.length;
    const avgKal = weeks ? dashData.monthly.reduce((s,w)=>s+parseFloat(w.avg_calories||0),0)/weeks : 0;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#ea580c' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><rect x='3' y='4' width='18' height='18' rx='2'/><line x1='16' y1='2' x2='16' y2='6'/><line x1='8' y1='2' x2='8' y2='6'/><line x1='3' y1='10' x2='21' y2='10'/></svg> Rata-rata Bulanan
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${Math.round(avgKal)} kcal</div>
      <div style='font-size:0.95rem;color:#4b5563;'>Target: 2,000 kcal</div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#2563eb' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><line x1='12' y1='20' x2='12' y2='10'/><line x1='18' y1='20' x2='18' y2='4'/><line x1='6' y1='20' x2='6' y2='16'/></svg> Pencapaian
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${Math.round((avgKal/dashTargets.calories)*100)}%</div>
      <div class='badge' style='background:#bbf7d0;color:#166534;'>${avgKal/dashTargets.calories>=0.9?'Good':'Perlu Perbaikan'}</div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#f59e42' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><targetIcon/></svg> Minggu Terbaik
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${weeks>0?Math.max(...dashData.monthly.map(w=>parseFloat(w.avg_calories||0))):0} kcal</div>
      <div style='font-size:0.95rem;color:#4b5563;'>minggu terbaik bulan ini</div>
    </div>`;
    summaryHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>
        <svg width='18' height='18' fill='none' stroke='#ea580c' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;margin-right:6px;'><flameIcon/></svg> Streak Terpanjang
      </div>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;margin-bottom:4px;'>${weeks}</div>
      <div style='font-size:0.95rem;color:#4b5563;'>minggu berturut-turut</div>
    </div>`;
  }
  document.getElementById('dashboard-summary-cards').innerHTML = summaryHtml.replace(/kal\b/g, 'kcal');

  // Main Content
  let mainHtml = '';
  if(mode==='weekly') {
    // Grafik bar asupan kalori mingguan
    mainHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;margin-bottom:16px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>Asupan Kalori Mingguan</div>
      <div style='color:#4b5563;font-size:0.95rem;margin-bottom:12px;'>Perbandingan dengan target harian</div>`;
    dashData.weekly.forEach(day => {
      const percent = Math.min((parseFloat(day.calories||0)/dashTargets.calories)*100,100);
      mainHtml += `<div style='margin-bottom:10px;'><div style='display:flex;justify-content:space-between;font-size:0.98rem;'><span style='font-weight:500;'>${day.tanggal}</span><span style='color:#6b7280;'>${Math.round(day.calories)} / ${dashTargets.calories} kcal</span></div><div style='background:#bbf7d0;border-radius:8px;height:12px;width:100%;overflow:hidden;'><div style='background:#16a34a;height:100%;border-radius:8px;width:${percent}%;transition:width 0.3s;'></div></div></div>`;
    });
    mainHtml += `</div>`;
    // Grafik bar makronutrien mingguan
    mainHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>Distribusi Makronutrien</div>
      <div style='color:#4b5563;font-size:0.95rem;margin-bottom:12px;'>Rata-rata mingguan</div>`;
    ["protein","carbs","fat"].forEach(macro => {
      const avg = dashData.weekly.length ? dashData.weekly.reduce((s,d)=>s+parseFloat(d[macro]||0),0)/dashData.weekly.length : 0;
      const target = dashTargets[macro];
      const percent = Math.min((avg/target)*100,100);
      let label = macro==="protein"?"Protein":macro==="carbs"?"Karbohidrat":"Lemak";
      mainHtml += `<div style='margin-bottom:10px;'><div style='display:flex;justify-content:space-between;'><span style='font-weight:500;'>${label}</span><span style='color:#6b7280;'>${Math.round(avg)}g / ${target}g</span></div><div style='background:#bbf7d0;border-radius:8px;height:8px;width:100%;overflow:hidden;'><div style='background:#16a34a;height:100%;border-radius:8px;width:${percent}%;transition:width 0.3s;'></div></div><div style='font-size:0.85rem;color:#6b7280;'>${Math.round(percent)}% dari target</div></div>`;
    });
    mainHtml += `</div>`;
  } else {
    // Grafik bar progress bulanan
    mainHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;margin-bottom:16px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>Progress Bulanan</div>
      <div style='color:#4b5563;font-size:0.95rem;margin-bottom:12px;'>Pencapaian target per minggu</div>`;
    dashData.monthly.forEach(week => {
      const percent = Math.min((parseFloat(week.avg_calories||0)/dashTargets.calories)*100,100);
      mainHtml += `<div style='margin-bottom:10px;'><div style='display:flex;justify-content:space-between;font-size:0.98rem;'><span style='font-weight:500;'>${week.start_date} - ${week.end_date}</span><span style='color:#6b7280;'>${Math.round(week.avg_calories)} kcal</span></div><div style='background:#bbf7d0;border-radius:8px;height:12px;width:100%;overflow:hidden;'><div style='background:#16a34a;height:100%;border-radius:8px;width:${percent}%;transition:width 0.3s;'></div></div></div>`;
    });
    mainHtml += `</div>`;
    // Ringkasan bulanan
    mainHtml += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>Ringkasan Bulan Ini</div>
      <div style='color:#4b5563;font-size:0.95rem;margin-bottom:12px;'>Statistik pencapaian</div>
      <div style='display:flex;flex-direction:column;gap:8px;'>
        <div style='display:flex;justify-content:space-between;align-items:center;padding:16px 20px;margin-bottom:10px;background:#f0fdf4;border-radius:8px;'>
          <span style='font-weight:500;'>Rata-rata Pencapaian</span>
          <span style='font-size:1.2rem;font-weight:bold;color:#16a34a;'>${Math.round((dashData.monthly.reduce((s,w)=>s+parseFloat(w.avg_calories||0),0)/Math.max(1,dashData.monthly.length))/dashTargets.calories*100)}%</span>
        </div>
        <div style='display:flex;justify-content:space-between;align-items:center;padding:16px 20px;margin-bottom:10px;background:#dbeafe;border-radius:8px;'>
          <span style='font-weight:500;'>Minggu Terbaik</span>
          <span style='font-size:1.2rem;font-weight:bold;color:#2563eb;'>${dashData.monthly.length>0?Math.max(...dashData.monthly.map(w=>parseFloat(w.avg_calories||0))):0} kcal</span>
        </div>
        <div style='display:flex;justify-content:space-between;align-items:center;padding:16px 20px;margin-bottom:10px;background:#fef3c7;border-radius:8px;'>
          <span style='font-weight:500;'>Perlu Perbaikan</span>
          <span style='font-size:1.2rem;font-weight:bold;color:#ea580c;'>${dashData.monthly.filter(w=>parseFloat(w.avg_calories||0)<dashTargets.calories*0.8).length} minggu</span>
        </div>
        <div style='display:flex;justify-content:space-between;align-items:center;padding:16px 20px;margin-bottom:10px;background:#ede9fe;border-radius:8px;'>
          <span style='font-weight:500;'>Streak Terpanjang</span>
          <span style='font-size:1.2rem;font-weight:bold;color:#7c3aed;'>${dashData.monthly.length}</span>
        </div>
      </div>
    </div>`;
  }
  document.getElementById('dashboard-main-content').innerHTML = mainHtml;

  // Insight
  let insightHtml = `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
    <div style='color:#16a34a;font-weight:bold;font-size:1.1rem;margin-bottom:8px;'>Insight & Rekomendasi</div>
    <div style='display:grid;grid-template-columns:1fr 1fr;gap:16px;'>
      <div style='background:#f0fdf4;padding:12px;border-radius:8px;'>
        <div style='font-weight:700;color:#166534;margin-bottom:4px;'>Kekuatan Anda</div>
        <div style='color:#166534;font-size:0.95rem;'>${dashData.weekly.length && dashData.weekly.reduce((s,d)=>s+parseFloat(d.protein||0),0)/dashData.weekly.length>dashTargets.protein?"Konsistensi asupan protein sangat baik!":"Konsistensi protein perlu ditingkatkan."}</div>
      </div>
      <div style='background:#fef3c7;padding:12px;border-radius:8px;'>
        <div style='font-weight:700;color:#ea580c;margin-bottom:4px;'>Area Perbaikan</div>
        <div style='color:#ea580c;font-size:0.95rem;'>${dashData.weekly.length && dashData.weekly.reduce((s,d)=>s+parseFloat(d.fiber||0),0)/dashData.weekly.length<dashTargets.fiber?"Asupan serat masih kurang. Coba tambahkan lebih banyak sayuran dan buah-buahan.":"Asupan serat sudah baik."}</div>
      </div>
    </div>
  </div>`;
  document.getElementById('dashboard-insight').innerHTML = insightHtml;
}
fetchDashboard();
</script>