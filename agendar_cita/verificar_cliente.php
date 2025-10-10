<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$telefono = $data['telefono'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE Celular = ?");
    $stmt->execute([$telefono]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($cliente) {
        echo json_encode([
            'existe' => true,
            'cliente' => $cliente
        ]);
    } else {
        echo json_encode([
            'existe' => false
        ]);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>