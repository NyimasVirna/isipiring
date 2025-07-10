<?php
require_once '../config/database.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $stmt = $pdo->query('SELECT id, nama, kalori, protein, lemak, karbohidrat, serat, satuan, berat_per_porsi FROM makanan');
    $foods = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $foods[] = [
            'id' => $row['id'],
            'name' => $row['nama'],
            'calories' => $row['kalori'],
            'protein' => $row['protein'],
            'carbs' => $row['karbohidrat'],
            'fat' => $row['lemak'],
            'fiber' => $row['serat'],
            'serving' => $row['berat_per_porsi'] . ' ' . $row['satuan']
        ];
    }
    error_log("Foods loaded successfully: " . count($foods) . " items");
    echo json_encode(['success' => true, 'foods' => $foods]);
} catch (Exception $e) {
    error_log("Error in get_foods.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} 