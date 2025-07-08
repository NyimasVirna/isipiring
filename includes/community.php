<?php // includes/community.php ?>
<div id="community-root">
  <div style="text-align:center;margin-bottom:24px;">
    <h1 style="font-size:2rem;font-weight:bold;color:#14532d;margin-bottom:8px;">Komunitas isi piring</h1>
    <p style="color:#4b5563;">Berbagi pengalaman dan belajar bersama untuk hidup lebih sehat</p>
  </div>
  <div style="display:flex;gap:8px;justify-content:center;margin-bottom:24px;">
    <button class="comm-tab-btn comm-tab-active" onclick="showCommTab('feed',this)">Feed</button>
    <button class="comm-tab-btn" onclick="showCommTab('challenges',this)">Challenge</button>
    <button class="comm-tab-btn" onclick="showCommTab('groups',this)">Grup</button>
  </div>
  <div id="comm-tab-feed"></div>
  <div id="comm-tab-challenges" style="display:none;"></div>
  <div id="comm-tab-groups" style="display:none;"></div>
</div>
<style>
.comm-tab-btn {
  background: #fff;
  border: 1px solid #bbf7d0;
  color: #166534;
  border-radius: 8px;
  padding: 8px 20px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.comm-tab-active, .comm-tab-btn:hover {
  background: #16a34a;
  color: #fff;
  border-color: #16a34a;
}
</style>
<script>
function showCommTab(tab, btn) {
  ['feed','challenges','groups'].forEach(t => {
    document.getElementById('comm-tab-'+t).style.display = (t===tab)?'':'none';
  });
  document.querySelectorAll('.comm-tab-btn').forEach(b => b.classList.remove('comm-tab-active'));
  btn.classList.add('comm-tab-active');
}

function renderFeed(posts) {
  let html = `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;margin-bottom:24px;'>
    <div style='font-weight:500;color:#16a34a;margin-bottom:8px;'>Bagikan Pengalaman Anda</div>
    <textarea id='new-post' placeholder='Apa yang ingin Anda bagikan hari ini?' style='width:100%;min-height:80px;padding:8px;border-radius:6px;border:1px solid #bbf7d0;margin-bottom:8px;'></textarea>
    <button onclick='addPost()' class='dash-btn' style='float:right;'>Posting</button>
    <div style='clear:both;'></div>
    <div id='feed-alert' style='margin-top:8px;'></div>
  </div>`;
  posts.forEach(post => {
    html += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;margin-bottom:16px;'>
      <div style='display:flex;align-items:center;gap:8px;margin-bottom:8px;'>
        <span style='font-weight:500;'>${post.author_name||'Anonim'}</span>
        <span style='color:#6b7280;font-size:0.95rem;'>• ${new Date(post.created_at).toLocaleString('id-ID',{dateStyle:'medium',timeStyle:'short'})}</span>
      </div>
      <div style='color:#14532d;margin-bottom:8px;'>${post.content}</div>
      <div style='display:flex;gap:16px;align-items:center;margin-top:8px;'>
        <span title='Like' style='cursor:pointer;display:flex;align-items:center;'>
          <svg width='20' height='20' fill='none' stroke='#ea580c' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><path d='M20.8 4.6c-1.4-1.4-3.7-1.4-5.1 0l-.7.7-.7-.7c-1.4-1.4-3.7-1.4-5.1 0-1.4 1.4-1.4 3.7 0 5.1l.7.7 5.1 5.1 5.1-5.1.7-.7c1.4-1.4 1.4-3.7 0-5.1z'></path></svg>
        </span>
        <span title='Reply' style='cursor:pointer;display:flex;align-items:center;'>
          <svg width='20' height='20' fill='none' stroke='#2563eb' stroke-width='2' viewBox='0 0 24 24' style='vertical-align:middle;'><polyline points='9 17 4 12 9 7'></polyline><path d='M20 18v-1a4 4 0 0 0-4-4H4'></path></svg>
        </span>
      </div>
    </div>`;
  });
  document.getElementById('comm-tab-feed').innerHTML = html;
}

function fetchFeed() {
  fetch('actions/get_community_feed.php')
    .then(r=>r.json())
    .then(res=>{
      if(res.success) renderFeed(res.posts);
      else document.getElementById('comm-tab-feed').innerHTML = '<div style="color:#b91c1c;">Gagal memuat feed komunitas.</div>';
    })
    .catch(()=>{
      document.getElementById('comm-tab-feed').innerHTML = '<div style="color:#b91c1c;">Gagal memuat feed komunitas.</div>';
    });
}

function addPost() {
  const val = document.getElementById('new-post').value.trim();
  if(!val) return;
  fetch('actions/add_community_post.php', {
    method: 'POST',
    body: new URLSearchParams({content: val})
  })
  .then(r=>r.json())
  .then(res=>{
    const alert = document.getElementById('feed-alert');
    if(res.success) {
      alert.innerHTML = `<span style='color:#166534;'>${res.message}</span>`;
      document.getElementById('new-post').value = '';
      fetchFeed();
    } else {
      alert.innerHTML = `<span style='color:#b91c1c;'>${res.message}</span>`;
    }
  })
  .catch(()=>{
    document.getElementById('feed-alert').innerHTML = `<span style='color:#b91c1c;'>Gagal posting.</span>`;
  });
}

function renderChallenges(challenges) {
  let html = '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">';
  challenges.forEach(ch => {
    html += `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>
      <div style='font-weight:500;color:#16a34a;font-size:1.1rem;margin-bottom:8px;'>${ch.title}</div>
      <div style='color:#4b5563;font-size:0.95rem;margin-bottom:8px;'>${ch.description}</div>
      <div style='color:#6b7280;font-size:0.95rem;margin-bottom:8px;'>Peserta: <b>${ch.participants}</b></div>
      <div style='color:#ea580c;font-size:0.95rem;margin-bottom:8px;'>Sisa waktu: <b>${ch.days_left} hari</b></div>
      <div style='color:#f59e42;font-size:0.95rem;margin-bottom:8px;'>Reward: <b>${ch.reward}</b></div>
      <button class='dash-btn' style='width:100%;'>Ikut Challenge</button>
    </div>`;
  });
  html += '</div>';
  document.getElementById('comm-tab-challenges').innerHTML = html;
}

function fetchChallenges() {
  fetch('actions/get_community_challenges.php')
    .then(r=>r.json())
    .then(res=>{
      if(res.success) renderChallenges(res.challenges);
      else document.getElementById('comm-tab-challenges').innerHTML = '<div style="color:#b91c1c;">Gagal memuat challenge.</div>';
    })
    .catch(()=>{
      document.getElementById('comm-tab-challenges').innerHTML = '<div style="color:#b91c1c;">Gagal memuat challenge.</div>';
    });
}

function renderGroups() {
  document.getElementById('comm-tab-groups').innerHTML = `<div style='background:#fff;border:1px solid #bbf7d0;border-radius:16px;padding:20px;'>Fitur grup akan segera hadir!</div>`;
}

// Inisialisasi
fetchFeed();
fetchChallenges();
renderGroups();
</script> 