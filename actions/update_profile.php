<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login.']);
    exit;
}

$id = $_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$birth_date = $_POST['birth_date'] ?? null;
$gender = $_POST['gender'] ?? null;
$height = $_POST['height'] ?? null;
$weight = $_POST['weight'] ?? null;
$activity = $_POST['activity'] ?? null;
$is_pregnant = isset($_POST['is_pregnant']) ? 1 : 0;
$is_breastfeed = isset($_POST['is_breastfeed']) ? 1 : 0;

if (!$name || !$email) {
    echo json_encode(['success' => false, 'message' => 'Nama dan email wajib diisi.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
    exit;
}

// Cek email unik (kecuali email user sendiri)
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
$stmt->execute([$email, $id]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Email sudah digunakan user lain.']);
    exit;
}

$stmt = $pdo->prepare('UPDATE users SET name=?, email=?, birth_date=?, gender=?, height=?, weight=?, activity=?, is_pregnant=?, is_breastfeed=? WHERE id=?');
$ok = $stmt->execute([$name, $email, $birth_date, $gender, $height, $weight, $activity, $is_pregnant, $is_breastfeed, $id]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Profil berhasil diupdate.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal update profil.']);
} 