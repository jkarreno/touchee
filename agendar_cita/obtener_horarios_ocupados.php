<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$fecha = $data['fecha'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT Hora FROM citas WHERE Fecha = ?");
    $stmt->execute([$fecha]);
    $citas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Convertir formato de hora (HH:MM:SS a HH:MM)
    $horariosOcupados = array_map(function($hora) {
        return substr($hora, 0, 5);
    }, $citas);
    
    echo json_encode([
        'success' => true,
        'horarios' => $horariosOcupados
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>