<?php
require_once '../config/database.php';
header('Content-Type: application/json');
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
echo json_encode(['success' => true, 'foods' => $foods]); 