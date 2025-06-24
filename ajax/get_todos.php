<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

try {
    $stmt = $pdo->prepare('SELECT id, title, is_done FROM todos WHERE user_id = ? ORDER BY created_at DESC');
    $stmt->execute([$_SESSION['user_id']]);
    echo json_encode($stmt->fetchAll());
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch todos']);
}
?>