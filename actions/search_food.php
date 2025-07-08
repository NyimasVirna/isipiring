<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

$keyword = $_POST['keyword'] ?? '';

if ($keyword) {
    $results = cariMakanan($keyword);
    echo json_encode($results);
} else {
    echo json_encode([]);
}
?>
