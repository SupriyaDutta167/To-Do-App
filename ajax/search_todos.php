<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// Get parameters
$search = isset($data['search']) ? trim($data['search']) : '';
$filter = isset($data['filter']) ? $data['filter'] : 'all';

try {
    $sql = 'SELECT id, title, is_done FROM todos WHERE user_id = ?';
    $params = [$_SESSION['user_id']];
    
    // Add search condition if search term provided
    if ($search !== '') {
        $sql .= ' AND title LIKE ?';
        $params[] = '%' . $search . '%';
    }
    
    // Add filter condition
    if ($filter === 'pending') {
        $sql .= ' AND is_done = 0';
    } elseif ($filter === 'completed') {
        $sql .= ' AND is_done = 1';
    }
    
    $sql .= ' ORDER BY created_at DESC';
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $todos = $stmt->fetchAll();
    
    echo json_encode([
        'status' => 'success',
        'todos' => $todos,
        'count' => count($todos)
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Search failed']);
}
?>