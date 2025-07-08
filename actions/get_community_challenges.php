<?php
require_once '../config/database.php';
header('Content-Type: application/json');

$sql = "SELECT id, title, description, participants, days_left, reward FROM community_challenges ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$challenges = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode([
    'success' => true,
    'challenges' => $challenges
]); 