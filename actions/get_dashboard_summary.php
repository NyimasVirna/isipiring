<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login.']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil 7 hari terakhir
$sql = "SELECT lm.tanggal,
    SUM(m.kalori*lm.porsi/100) as calories,
    SUM(m.protein*lm.porsi/100) as protein,
    SUM(m.karbohidrat*lm.porsi/100) as carbs,
    SUM(m.lemak*lm.porsi/100) as fat,
    SUM(m.serat*lm.porsi/100) as fiber
FROM log_makanan lm
JOIN makanan m ON lm.makanan_id = m.id
WHERE lm.user_id = ? AND lm.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
GROUP BY lm.tanggal
ORDER BY lm.tanggal ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$weekly = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil 4 minggu terakhir (per minggu)
$sql2 = "SELECT YEARWEEK(lm.tanggal,1) as week,
    MIN(lm.tanggal) as start_date,
    MAX(lm.tanggal) as end_date,
    AVG(m.kalori*lm.porsi/100) as avg_calories,
    AVG(m.protein*lm.porsi/100) as avg_protein,
    AVG(m.karbohidrat*lm.porsi/100) as avg_carbs,
    AVG(m.lemak*lm.porsi/100) as avg_fat,
    AVG(m.serat*lm.porsi/100) as avg_fiber
FROM log_makanan lm
JOIN makanan m ON lm.makanan_id = m.id
WHERE lm.user_id = ? AND lm.tanggal >= DATE_SUB(CURDATE(), INTERVAL 28 DAY)
GROUP BY YEARWEEK(lm.tanggal,1)
ORDER BY week DESC
LIMIT 4";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$user_id]);
$monthly = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Format data weekly agar tanggal konsisten (YYYY-MM-DD)
$weekly = array_map(function($row) {
    $row['tanggal'] = date('Y-m-d', strtotime($row['tanggal']));
    $row['calories'] = round($row['calories']);
    $row['protein'] = round($row['protein']);
    $row['carbs'] = round($row['carbs']);
    $row['fat'] = round($row['fat']);
    $row['fiber'] = round($row['fiber']);
    return $row;
}, $weekly);

// Format data monthly agar konsisten dengan frontend
$monthly = array_map(function($row) {
    $row['start_date'] = date('Y-m-d', strtotime($row['start_date']));
    $row['end_date'] = date('Y-m-d', strtotime($row['end_date']));
    $row['avg_calories'] = round($row['avg_calories']);
    // Rename avg_protein, avg_carbs, avg_fat, avg_fiber ke protein, carbs, fat, fiber
    $row['protein'] = round($row['avg_protein']);
    $row['carbs'] = round($row['avg_carbs']);
    $row['fat'] = round($row['avg_fat']);
    $row['fiber'] = round($row['avg_fiber']);
    unset($row['avg_protein'], $row['avg_carbs'], $row['avg_fat'], $row['avg_fiber']);
    return $row;
}, $monthly);

echo json_encode([
    'success' => true,
    'weekly' => $weekly,
    'monthly' => $monthly
]); 