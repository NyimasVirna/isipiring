<?php // includes/food-logger.php ?>
<div id="food-logger-root">
  <div style="text-align:center; margin-bottom:24px;">
    <h1 style="font-size:2rem;font-weight:bold;color:#14532d;margin-bottom:8px;">Catat Makanan Anda</h1>
    <p style="color:#4b5563;">Pantau asupan nutrisi harian untuk hidup lebih sehat</p>
  </div>

  <div id="food-alert" style="max-width:800px;margin:0 auto 18px auto;"></div>

  <!-- Ringkasan Nutrisi Harian -->
  <div id="summary-cards" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:16px;margin-bottom:32px;"></div>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;max-width:100%;">

    <!-- Form Input Makanan -->
    <div style="background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:24px 20px;">
      <h2 style="color:#16a34a;font-size:1.1rem;font-weight:bold;margin-bottom:16px;">
        <svg width="18" height="18" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Makanan
      </h2>
      <form id="food-form" onsubmit="return false;">
        <div style="margin-bottom:16px;">
          <label for="meal-time">Waktu Makan</label><br>
          <select id="meal-time" style="width:100%;padding:8px;border-radius:6px;border:1px solid #bbf7d0;">
              <option value="sarapan">🌅 Sarapan</option>
              <option value="makan_siang">☀️ Makan Siang</option>
              <option value="makan_malam">🌙 Makan Malam</option>
              <option value="camilan">🍎 Camilan</option>
          </select>
        </div>
        <div style="margin-bottom:16px;">
          <label for="food-search">Cari Makanan</label><br>
          <div style="position:relative;">
            <input type="text" id="food-search" placeholder="Ketik nama makanan..." style="width:100%;padding:8px 8px 8px 36px;border-radius:6px;border:1px solid #bbf7d0;" autocomplete="off">
            <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);">
              <svg width="18" height="18" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="7"/>
                <line x1="16.5" y1="16.5" x2="21" y2="21"/>
              </svg>
            </span>
          </div>
          <div id="food-search-results" style="max-height:120px;overflow-y:auto;margin-top:4px;"></div>
        </div>
        <div id="selected-food-detail" style="display:none;margin-bottom:16px;background:#f0fdf4;padding:12px;border-radius:8px;"></div>
        <button type="submit" id="add-food-btn" style="width:100%;background:#16a34a;color:#fff;border:none;border-radius:8px;padding:12px 0;font-size:1rem;cursor:pointer;">Tambah ke Log</button>
      </form>
    </div>
    <!-- Log Makanan Harian -->
    <div style="background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:24px 20px;">
      <h2 style="color:#16a34a;font-size:1.1rem;font-weight:bold;margin-bottom:16px;">
        <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px;"><path d="M3 3h18v18H3z"/></svg>
        Log Makanan Hari Ini
      </h2>
      <div id="meal-logs">
        <!-- Diisi oleh JS -->
      </div>
    </div>
  </div>
</div>
<script>
let foodDatabase = [];
let foodLogs = [];
const mealTimes = [
  { id: "sarapan", label: "Sarapan", icon: `<svg width='16' height='16' fill='none' stroke='#f59e42' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><circle cx='12' cy='12' r='5'/><line x1='12' y1='1' x2='12' y2='3'/><line x1='12' y1='21' x2='12' y2='23'/><line x1='4.22' y1='4.22' x2='5.64' y2='5.64'/><line x1='18.36' y1='18.36' x2='19.78' y2='19.78'/><line x1='1' y1='12' x2='3' y2='12'/><line x1='21' y1='12' x2='23' y2='12'/><line x1='4.22' y1='19.78' x2='5.64' y2='18.36'/><line x1='18.36' y1='5.64' x2='19.78' y2='4.22'/></svg>` },
  { id: "makan_siang", label: "Makan Siang", icon: `<svg width='16' height='16' fill='none' stroke='#f59e42' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><circle cx='12' cy='12' r='10'/></svg>` },
  { id: "makan_malam", label: "Makan Malam", icon: `<svg width='16' height='16' fill='none' stroke='#2563eb' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><path d='M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z'/></svg>` },
  { id: "camilan", label: "Camilan", icon: `<svg width='16' height='16' fill='none' stroke='#ea580c' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><circle cx='12' cy='12' r='10'/><path d='M12 8v4l3 3'/></svg>` },
];
const targets = { calories: 2000, protein: 60, carbs: 250, fat: 67, fiber: 25 };
let selectedFood = null;
let portion = 100;
let selectedMeal = 'sarapan';

function showFoodAlert(msg, type) {
  document.getElementById('food-alert').innerHTML = `<div style='background:${type==='success'?'#dcfce7':'#fee2e2'};color:${type==='success'?'#166534':'#b91c1c'};padding:12px 18px;border-radius:8px;margin-bottom:8px;font-weight:500;'>${msg}</div>`;
}
function clearFoodAlert() {
  document.getElementById('food-alert').innerHTML = '';
}
function fetchFoods() {
  const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
  const getFoodsUrl = baseUrl + '/actions/get_foods.php';
  
  console.log('Fetching foods from:', getFoodsUrl); // Debug log
  
  fetch(getFoodsUrl)
    .then(r => {
      console.log('Get foods response status:', r.status); // Debug log
      return r.json();
    })
    .then(res => {
      console.log('Get foods response:', res); // Debug log
      if(res.success) {
        foodDatabase = res.foods;
        console.log('Food database loaded:', foodDatabase.length, 'items'); // Debug log
      } else {
        console.error('Get foods error:', res.message); // Debug log
        showFoodAlert('Gagal mengambil data makanan: ' + (res.message || 'Unknown error'), 'error');
      }
    })
    .catch(error => {
      console.error('Fetch foods error:', error); // Debug log
      showFoodAlert('Gagal mengambil data makanan: ' + error.message, 'error');
    });
}
function fetchFoodLogs() {
  const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
  const getLogsUrl = baseUrl + '/actions/get_food_logs.php?tanggal=' + new Date().toISOString().slice(0,10);
  
  console.log('Fetching food logs from:', getLogsUrl); // Debug log
  
  fetch(getLogsUrl)
    .then(r => {
      console.log('Get logs response status:', r.status); // Debug log
      return r.json();
    })
    .then(res => {
      console.log('Get logs response:', res); // Debug log
      if(res.success) {
        foodLogs = res.logs;
        console.log('Food logs loaded:', foodLogs.length, 'items'); // Debug log
        renderSummary();
        renderMealLogs();
      } else {
        console.error('Get logs error:', res.message); // Debug log
        showFoodAlert('Gagal mengambil log makanan: ' + (res.message || 'Unknown error'), 'error');
      }
    })
    .catch(error => {
      console.error('Fetch logs error:', error); // Debug log
      showFoodAlert('Gagal mengambil log makanan: ' + error.message, 'error');
    });
}
function renderSummary() {
  const total = {calories:0,protein:0,carbs:0,fat:0,fiber:0};
  foodLogs.forEach(f=>{
    total.calories += parseFloat(f.calories||0)*f.porsi/100;
    total.protein += parseFloat(f.protein||0)*f.porsi/100;
    total.carbs += parseFloat(f.carbs||0)*f.porsi/100;
    total.fat += parseFloat(f.fat||0)*f.porsi/100;
    total.fiber += parseFloat(f.fiber||0)*f.porsi/100;
  });
  let html = '';
  Object.entries(targets).forEach(([key, target]) => {
    const current = total[key];
    const percent = Math.min((current/target)*100,100);
    let label = key==='calories'?'Energi (kcal)':key==='protein'?'Protein (g)':key==='carbs'?'Karbo (g)':key==='fat'?'Lemak (g)':'Serat (g)';
    html += `<div style='text-align:center;'>
      <div style='font-size:1.5rem;font-weight:bold;color:#16a34a;'>${Math.round(current)}</div>
      <div style='font-size:0.95rem;color:#4b5563;margin-bottom:4px;'>${label}</div>
      <div style='background:#bbf7d0;border-radius:8px;height:8px;width:100%;margin-bottom:4px;overflow:hidden;'><div style='background:#16a34a;height:100%;border-radius:8px;width:${percent}%;transition:width 0.3s;'></div></div>
      <div style='font-size:0.85rem;color:#6b7280;'>Target: ${target}</div>
    </div>`;
  });
  document.getElementById('summary-cards').innerHTML = html;
}
function renderMealLogs() {
  let html = '';
  mealTimes.forEach(meal => {
    html += `<div style='border:1px solid #bbf7d0;border-radius:8px;padding:12px;margin-bottom:16px;'>
      <div style='display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;'>
        <span style='font-weight:500;'>${meal.icon} ${meal.label}</span>
        <span class='badge'>${foodLogs.filter(f=>f.waktu_makan===meal.id).length} item</span>
      </div>`;
    const logs = foodLogs.filter(f=>f.waktu_makan===meal.id);
    if(logs.length===0) {
      html += `<div style='color:#6b7280;font-size:0.95rem;'>Belum ada makanan yang dicatat</div>`;
    } else {
      logs.forEach(food => {
        html += `<div style='display:flex;justify-content:space-between;align-items:center;background:#f9fafb;padding:6px 10px;border-radius:6px;margin-bottom:4px;'>
          <div><div style='font-weight:500;'>${food.food_name}</div><div style='color:#6b7280;font-size:0.95rem;'>${food.porsi}g</div></div>
          <div style='text-align:right;'><div style='font-weight:500;'>${Math.round(food.calories*food.porsi/100)} kcal</div><div style='color:#6b7280;font-size:0.95rem;'>${Math.round(food.protein*food.porsi/100*10)/10}g protein</div></div>
        </div>`;
      });
    }
    html += `</div>`;
  });
  document.getElementById('meal-logs').innerHTML = html;
}
function resetFoodForm() {
  selectedFood = null;
  portion = 100;
  document.getElementById('food-search').value = '';
  document.getElementById('selected-food-detail').style.display = 'none';
  document.getElementById('food-search-results').innerHTML = '';
}
document.getElementById('meal-time').addEventListener('change', function(e){
  selectedMeal = this.value;
});
document.getElementById('food-search').addEventListener('input', function(e){
  const term = this.value.toLowerCase();
  if(!term) {
    document.getElementById('food-search-results').innerHTML = '';
    return;
  }
  const filtered = foodDatabase.filter(f => f.name.toLowerCase().includes(term));
  let html = '';
  filtered.forEach(food => {
    html += `<div class='food-search-item' data-id='${food.id}' style='padding:8px;border:1px solid #bbf7d0;border-radius:6px;margin-bottom:4px;cursor:pointer;background:#fff;'>
      <div style='font-weight:500;'>${food.name}</div>
      <div style='font-size:0.95rem;color:#6b7280;'>${food.calories} kcal, ${food.protein}g protein per ${food.serving||'100g'}</div>
    </div>`;
  });
  document.getElementById('food-search-results').innerHTML = html;
  document.querySelectorAll('.food-search-item').forEach(item => {
    item.onclick = function(){
      const id = parseInt(this.getAttribute('data-id'));
      selectedFood = foodDatabase.find(f => f.id === id);
      showSelectedFood();
    }
  });
});
function showSelectedFood() {
  if(!selectedFood) return;
  let html = `<div style='font-weight:500;color:#166534;margin-bottom:8px;'>${selectedFood.name}</div>
    <label>Porsi (gram): <input type='number' id='portion-input' value='${portion}' min='1' style='width:80px;margin-left:8px;border-radius:6px;border:1px solid #bbf7d0;padding:4px 8px;'></label>
    <div style='display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:0.95rem;margin-top:8px;'>
      <div>Energi: <span id='cal-val'></span> kcal</div>
      <div>Protein: <span id='pro-val'></span>g</div>
      <div>Karbo: <span id='carb-val'></span>g</div>
      <div>Lemak: <span id='fat-val'></span>g</div>
    </div>`;
  document.getElementById('selected-food-detail').innerHTML = html;
  document.getElementById('selected-food-detail').style.display = '';
  updateFoodDetail();
  document.getElementById('portion-input').addEventListener('input', function(){
    portion = parseInt(this.value)||100;
    updateFoodDetail();
  });
}
function updateFoodDetail() {
  if(!selectedFood) return;
  const multiplier = portion/100;
  document.getElementById('cal-val').textContent = Math.round(selectedFood.calories * multiplier);
  document.getElementById('pro-val').textContent = Math.round(selectedFood.protein * multiplier * 10)/10;
  document.getElementById('carb-val').textContent = Math.round(selectedFood.carbs * multiplier * 10)/10;
  document.getElementById('fat-val').textContent = Math.round(selectedFood.fat * multiplier * 10)/10;
}
document.getElementById('food-form').addEventListener('submit', function(e){
  e.preventDefault();
  console.log('Form submitted'); // Debug log
  
  if(!selectedFood) {
    console.log('No food selected'); // Debug log
    showFoodAlert('Silakan pilih makanan terlebih dahulu', 'error');
    return;
  }
  
  console.log('Selected food:', selectedFood); // Debug log
  console.log('Portion:', portion); // Debug log
  console.log('Selected meal:', selectedMeal); // Debug log
  
  const fd = new FormData();
  fd.append('makanan_id', selectedFood.id);
  fd.append('porsi', portion);
  fd.append('waktu_makan', selectedMeal);
  fd.append('tanggal', new Date().toISOString().slice(0,10));
  
  // Debug: log FormData contents
  for (let pair of fd.entries()) {
    console.log(pair[0] + ': ' + pair[1]);
  }
  
  // Disable button during request
  const submitBtn = document.getElementById('add-food-btn');
  const originalText = submitBtn.textContent;
  submitBtn.disabled = true;
  submitBtn.textContent = 'Memproses...';
  
  // Use absolute path for hosting compatibility
  const baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '');
  const addFoodUrl = baseUrl + '/actions/add_food.php';
  
  console.log('Sending request to:', addFoodUrl); // Debug log
  
  fetch(addFoodUrl, {
    method: 'POST',
    body: fd
  })
  .then(response => {
    console.log('Response status:', response.status); // Debug log
    console.log('Response headers:', response.headers); // Debug log
    return response.json();
  })
  .then(res => {
    console.log('Response data:', res); // Debug log
    if(res.success) {
      showFoodAlert(res.message||'Berhasil menambah makanan', 'success');
      fetchFoodLogs();
      resetFoodForm();
    } else {
      let msg = res.message || 'Gagal menambah makanan';
      console.error('Add food error:', msg); // Debug log
      showFoodAlert(msg, 'error');
    }
  })
  .catch(error => {
    console.error('Fetch error:', error); // Debug log
    showFoodAlert('Gagal menambah makanan: ' + error.message, 'error');
  })
  .finally(() => {
    // Re-enable button
    submitBtn.disabled = false;
    submitBtn.textContent = originalText;
  });
});
// Debug function
// Hapus fungsi checkSession dan checkTables

// Add console log for initialization
console.log('Food logger initialized'); // Debug log

// Inisialisasi
fetchFoods();
fetchFoodLogs();
</script> 