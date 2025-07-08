<?php
require_once '../config/database.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $birth_date = $_POST['birth_date'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $activity = $_POST['activity'] ?? null;
    $is_pregnant = isset($_POST['is_pregnant']) ? 1 : 0;
    $is_breastfeed = isset($_POST['is_breastfeed']) ? 1 : 0;

    if (!$name || !$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Nama, email, dan password wajib diisi.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Format email tidak valid.']);
        exit;
    }
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar.']);
        exit;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password, birth_date, gender, height, weight, activity, is_pregnant, is_breastfeed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $ok = $stmt->execute([$name, $email, $hash, $birth_date, $gender, $height, $weight, $activity, $is_pregnant, $is_breastfeed]);
    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'Registrasi berhasil. Silakan login.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registrasi gagal.']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']); 