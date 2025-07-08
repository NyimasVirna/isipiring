<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Belum login.']);
    exit;
}
$user_id = $_SESSION['user_id'];
$content = trim($_POST['content'] ?? '');
if ($content === '') {
    echo json_encode(['success' => false, 'message' => 'Konten tidak boleh kosong.']);
    exit;
}
$sql = "INSERT INTO community_posts (user_id, content) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$ok = $stmt->execute([$user_id, $content]);
if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Post berhasil ditambahkan.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambah post.']);
} 