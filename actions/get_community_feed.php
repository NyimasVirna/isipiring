<?php
session_start();
require_once '../config/database.php';
header('Content-Type: application/json');

$sql = "SELECT cp.id, u.name AS author_name, cp.content, cp.created_at
        FROM community_posts cp
        JOIN users u ON cp.user_id = u.id
        ORDER BY cp.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode([
    'success' => true,
    'posts' => $posts
]); 