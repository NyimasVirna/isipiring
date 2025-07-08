<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

$response = [
    'logged_in' => isset($_SESSION['user_id']),
    'user_id' => $_SESSION['user_id'] ?? null,
    'user_name' => $_SESSION['user_name'] ?? null,
    'session_data' => $_SESSION
];

// Cek apakah ada data makanan
$stmt = $pdo->query('SELECT COUNT(*) as count FROM makanan');
$food_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Cek apakah ada data user
$stmt = $pdo->query('SELECT COUNT(*) as count FROM users');
$user_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

$response['database_info'] = [
    'food_count' => $food_count,
    'user_count' => $user_count
];

echo json_encode($response); 