<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

$response = [];

// Cek struktur tabel log_makanan
try {
    $stmt = $pdo->query("DESCRIBE log_makanan");
    $log_makanan_structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['log_makanan_structure'] = $log_makanan_structure;
} catch (Exception $e) {
    $response['log_makanan_error'] = $e->getMessage();
}

// Cek struktur tabel makanan
try {
    $stmt = $pdo->query("DESCRIBE makanan");
    $makanan_structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['makanan_structure'] = $makanan_structure;
} catch (Exception $e) {
    $response['makanan_error'] = $e->getMessage();
}

// Cek struktur tabel users
try {
    $stmt = $pdo->query("DESCRIBE users");
    $users_structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['users_structure'] = $users_structure;
} catch (Exception $e) {
    $response['users_error'] = $e->getMessage();
}

// Cek sample data
try {
    $stmt = $pdo->query("SELECT id, nama FROM makanan LIMIT 5");
    $sample_foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['sample_foods'] = $sample_foods;
} catch (Exception $e) {
    $response['sample_foods_error'] = $e->getMessage();
}

try {
    $stmt = $pdo->query("SELECT id, name FROM users LIMIT 5");
    $sample_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response['sample_users'] = $sample_users;
} catch (Exception $e) {
    $response['sample_users_error'] = $e->getMessage();
}

echo json_encode($response); 