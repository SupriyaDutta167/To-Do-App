<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id']) || !isset($data['is_done'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE todos SET is_done = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$data['is_done'], $data['id'], $_SESSION['user_id']]);
    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update todo']);
}
?>