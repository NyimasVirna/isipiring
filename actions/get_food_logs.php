<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$tanggal = $_GET['tanggal'] ?? null;

$sql = 'SELECT lm.*, m.nama as food_name, m.kalori, m.protein, m.karbohidrat, m.lemak, m.serat, m.satuan, m.berat_per_porsi
        FROM log_makanan lm
        JOIN makanan m ON lm.makanan_id = m.id
        WHERE lm.user_id = ?';
$params = [$user_id];
if ($tanggal) {
    $sql .= ' AND lm.tanggal = ?';
    $params[] = $tanggal;
}
$sql .= ' ORDER BY lm.tanggal DESC, lm.waktu_makan';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $logs[] = [
        'id' => $row['id'],
        'food_name' => $row['food_name'],
        'calories' => $row['kalori'],
        'protein' => $row['protein'],
        'carbs' => $row['karbohidrat'],
        'fat' => $row['lemak'],
        'fiber' => $row['serat'],
        'serving' => $row['berat_per_porsi'] . ' ' . $row['satuan'],
        'porsi' => $row['porsi'],
        'waktu_makan' => $row['waktu_makan'],
        'tanggal' => $row['tanggal']
    ];
}
echo json_encode(['success' => true, 'logs' => $logs]); 