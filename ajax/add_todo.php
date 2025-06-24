<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['title']) || trim($data['title']) === '') {
    echo json_encode(['status' => 'error', 'message' => 'Title is required']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO todos (user_id, title) VALUES (?, ?)');
    $stmt->execute([$_SESSION['user_id'], trim($data['title'])]);
    echo json_encode(['status' => 'success', 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add todo']);
}
?>