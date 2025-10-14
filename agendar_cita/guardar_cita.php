<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$cliente = $data['Cliente'] ?? '';
$servicio = $data['Servicio'] ?? '';
$fecha = $data['Fecha'] ?? '';
$hora = $data['Hora'] ?? '';

try {
    $stmt = $pdo->prepare("
        INSERT INTO citas (Cliente, Usuario, Servicio, Fecha, Hora) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$cliente, '8', $servicio, $fecha, $hora]);
    
    echo json_encode([
        'success' => true,
        'citaId' => $pdo->lastInsertId(),
        'mensaje' => 'Cita registrada correctamente'
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>