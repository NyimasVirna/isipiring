<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$makanan_id = $_POST['makanan_id'] ?? null;
$porsi = $_POST['porsi'] ?? null;
$waktu_makan = $_POST['waktu_makan'] ?? null;
$tanggal = $_POST['tanggal'] ?? date('Y-m-d');

// Debug: log data yang diterima
error_log("Add food debug - user_id: $user_id, makanan_id: $makanan_id, porsi: $porsi, waktu_makan: $waktu_makan, tanggal: $tanggal");

if (!$makanan_id || !$porsi || !$waktu_makan) {
    echo json_encode(['success' => false, 'message' => 'Data makanan, porsi, dan waktu makan wajib diisi.']);
    exit;
}

$stmt = $pdo->prepare('INSERT INTO log_makanan (user_id, makanan_id, porsi, waktu_makan, tanggal) VALUES (?, ?, ?, ?, ?)');
$ok = $stmt->execute([$user_id, $makanan_id, $porsi, $waktu_makan, $tanggal]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Log makanan berhasil disimpan.']);
} else {
    $errorInfo = $stmt->errorInfo();
    error_log("Database error: " . print_r($errorInfo, true));
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan log makanan: ' . $errorInfo[2]]);
}
