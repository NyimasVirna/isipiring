<?php
// User functions
function getUserData($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function updateUserProfile($user_id, $data) {
    global $pdo;
    $sql = "UPDATE users SET 
            nama = ?, 
            tanggal_lahir = ?, 
            jenis_kelamin = ?, 
            tinggi_badan = ?, 
            berat_badan = ?, 
            tingkat_aktivitas = ?,
            kondisi_khusus = ?,
            updated_at = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        $data['nama'],
        $data['tanggal_lahir'],
        $data['jenis_kelamin'],
        $data['tinggi_badan'],
        $data['berat_badan'],
        $data['tingkat_aktivitas'],
        json_encode($data['kondisi_khusus']),
        $user_id
    ]);
}

// AKG calculation functions
function hitungAKG($user_data) {
    $umur = hitungUmur($user_data['tanggal_lahir']);
    $jenis_kelamin = $user_data['jenis_kelamin'];
    $berat_badan = $user_data['berat_badan'];
    $tinggi_badan = $user_data['tinggi_badan'];
    $tingkat_aktivitas = $user_data['tingkat_aktivitas'];
    $kondisi_khusus = json_decode($user_data['kondisi_khusus'], true) ?? [];

    // Hitung BMR menggunakan rumus Harris-Benedict
    if ($jenis_kelamin == 'P') {
        $bmr = 655 + (9.6 * $berat_badan) + (1.8 * $tinggi_badan) - (4.7 * $umur);
    } else {
        $bmr = 66 + (13.7 * $berat_badan) + (5 * $tinggi_badan) - (6.8 * $umur);
    }

    // Faktor aktivitas
    $faktor_aktivitas = [
        'ringan' => 1.3,
        'sedang' => 1.5,
        'berat' => 1.7
    ];

    $energi = $bmr * $faktor_aktivitas[$tingkat_aktivitas];

    // Penyesuaian untuk kondisi khusus
    if (isset($kondisi_khusus['hamil']) && $kondisi_khusus['hamil']) {
        $energi += 300; // Tambahan untuk ibu hamil
    }
    if (isset($kondisi_khusus['menyusui']) && $kondisi_khusus['menyusui']) {
        $energi += 500; // Tambahan untuk ibu menyusui
    }

    // Hitung kebutuhan makronutrien berdasarkan AKG Kemenkes
    $protein = $berat_badan * 0.8; // 0.8g per kg BB
    if ($jenis_kelamin == 'P' && isset($kondisi_khusus['hamil'])) {
        $protein += 10; // Tambahan protein untuk ibu hamil
    }
    if ($jenis_kelamin == 'P' && isset($kondisi_khusus['menyusui'])) {
        $protein += 15; // Tambahan protein untuk ibu menyusui
    }

    // Distribusi kalori: 50-65% karbo, 10-15% protein, 20-35% lemak
    $karbohidrat = ($energi * 0.6) / 4; // 60% dari total energi
    $lemak = ($energi * 0.25) / 9; // 25% dari total energi
    $serat = 25; // Standar AKG

    // Mikronutrien berdasarkan AKG Kemenkes
    $kalsium = ($jenis_kelamin == 'P') ? 1000 : 1000;
    $zat_besi = ($jenis_kelamin == 'P') ? 18 : 9;
    $vitamin_a = ($jenis_kelamin == 'P') ? 500 : 600;
    $vitamin_c = ($jenis_kelamin == 'P') ? 75 : 90;

    // Penyesuaian untuk ibu hamil dan menyusui
    if ($jenis_kelamin == 'P') {
        if (isset($kondisi_khusus['hamil']) && $kondisi_khusus['hamil']) {
            $kalsium += 200;
            $zat_besi += 9;
            $vitamin_a += 300;
            $vitamin_c += 10;
        }
        if (isset($kondisi_khusus['menyusui']) && $kondisi_khusus['menyusui']) {
            $kalsium += 200;
            $zat_besi += 4;
            $vitamin_a += 350;
            $vitamin_c += 45;
        }
    }

    return [
        'energi' => round($energi),
        'protein' => round($protein, 1),
        'lemak' => round($lemak, 1),
        'karbohidrat' => round($karbohidrat, 1),
        'serat' => $serat,
        'kalsium' => $kalsium,
        'zat_besi' => $zat_besi,
        'vitamin_a' => $vitamin_a,
        'vitamin_c' => $vitamin_c
    ];
}

function hitungUmur($tanggal_lahir) {
    $lahir = new DateTime($tanggal_lahir);
    $sekarang = new DateTime();
    return $sekarang->diff($lahir)->y;
}

// Food functions
function cariMakanan($keyword) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM makanan WHERE nama LIKE ? ORDER BY nama");
    $stmt->execute(['%' . $keyword . '%']);
    return $stmt->fetchAll();
}

function getMakananById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM makanan WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function tambahLogMakanan($user_id, $makanan_id, $waktu_makan, $porsi, $tanggal = null) {
    global $pdo;
    if (!$tanggal) $tanggal = date('Y-m-d');
    
    $stmt = $pdo->prepare("INSERT INTO log_makanan (user_id, makanan_id, waktu_makan, porsi, tanggal) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$user_id, $makanan_id, $waktu_makan, $porsi, $tanggal]);
}

function getLogMakananHarian($user_id, $tanggal = null) {
    global $pdo;
    if (!$tanggal) $tanggal = date('Y-m-d');
    
    $stmt = $pdo->prepare("
        SELECT lm.*, m.nama, m.kalori, m.protein, m.lemak, m.karbohidrat, m.serat, 
               m.kalsium, m.zat_besi, m.vitamin_a, m.vitamin_c, m.kategori
        FROM log_makanan lm 
        JOIN makanan m ON lm.makanan_id = m.id 
        WHERE lm.user_id = ? AND lm.tanggal = ?
        ORDER BY lm.waktu_makan, lm.created_at
    ");
    $stmt->execute([$user_id, $tanggal]);
    return $stmt->fetchAll();
}

function hitungTotalNutrisiHarian($user_id, $tanggal = null) {
    $log_makanan = getLogMakananHarian($user_id, $tanggal);
    
    $total = [
        'energi' => 0,
        'protein' => 0,
        'lemak' => 0,
        'karbohidrat' => 0,
        'serat' => 0,
        'kalsium' => 0,
        'zat_besi' => 0,
        'vitamin_a' => 0,
        'vitamin_c' => 0
    ];
    
    foreach ($log_makanan as $item) {
        $multiplier = $item['porsi'] / 100; // Asumsi data per 100g
        $total['energi'] += $item['kalori'] * $multiplier;
        $total['protein'] += $item['protein'] * $multiplier;
        $total['lemak'] += $item['lemak'] * $multiplier;
        $total['karbohidrat'] += $item['karbohidrat'] * $multiplier;
        $total['serat'] += $item['serat'] * $multiplier;
        $total['kalsium'] += $item['kalsium'] * $multiplier;
        $total['zat_besi'] += $item['zat_besi'] * $multiplier;
        $total['vitamin_a'] += $item['vitamin_a'] * $multiplier;
        $total['vitamin_c'] += $item['vitamin_c'] * $multiplier;
    }
    
    return $total;
}

function hapusLogMakanan($id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM log_makanan WHERE id = ? AND user_id = ?");
    return $stmt->execute([$id, $user_id]);
}

// Dashboard functions
function getStatistikMingguan($user_id) {
    global $pdo;
    $tanggal_mulai = date('Y-m-d', strtotime('-6 days'));
    $tanggal_akhir = date('Y-m-d');
    
    $stmt = $pdo->prepare("
        SELECT 
            DATE(lm.tanggal) as tanggal,
            SUM(m.kalori * lm.porsi / 100) as total_kalori,
            SUM(m.protein * lm.porsi / 100) as total_protein,
            SUM(m.karbohidrat * lm.porsi / 100) as total_karbohidrat,
            SUM(m.lemak * lm.porsi / 100) as total_lemak
        FROM log_makanan lm
        JOIN makanan m ON lm.makanan_id = m.id
        WHERE lm.user_id = ? AND lm.tanggal BETWEEN ? AND ?
        GROUP BY DATE(lm.tanggal)
        ORDER BY lm.tanggal
    ");
    
    $stmt->execute([$user_id, $tanggal_mulai, $tanggal_akhir]);
    return $stmt->fetchAll();
}

// Utility functions
function formatAngka($angka, $desimal = 0) {
    return number_format($angka, $desimal, ',', '.');
}

function hitungPersentase($nilai, $target) {
    if ($target == 0) return 0;
    return min(($nilai / $target) * 100, 100);
}

function getStatusGizi($bmi) {
    if ($bmi < 18.5) return ['status' => 'Kurus', 'class' => 'warning'];
    if ($bmi < 25) return ['status' => 'Normal', 'class' => 'success'];
    if ($bmi < 30) return ['status' => 'Gemuk', 'class' => 'warning'];
    return ['status' => 'Obesitas', 'class' => 'danger'];
}

function hitungBMI($berat, $tinggi) {
    $tinggi_m = $tinggi / 100;
    return $berat / ($tinggi_m * $tinggi_m);
}
?>
