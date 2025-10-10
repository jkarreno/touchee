<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['Nombre'] ?? '';
$genero = $data['Genero'] ?? '';
$fechaNacimiento = $data['FechaNacimiento'] ?? '';
$celular = $data['telefono'] ?? '';
$correo = $data['CorreoElectronico'] ?? '';
$clienteId = $data['Id'] ?? null;

try {
    if($clienteId) {
        // Actualizar cliente existente
        $stmt = $pdo->prepare("
            UPDATE clientes 
            SET Nombre = ?, Genero = ?, FechaNacimiento = ?, CorreoElectronico = ?
            WHERE Id = ?
        ");
        $stmt->execute([$nombre, $genero, $fechaNacimiento, $correo, $clienteId]);
        
        echo json_encode([
            'success' => true,
            'clienteId' => $clienteId,
            'mensaje' => 'Cliente actualizado correctamente'
        ]);
    } else {
        // Insertar nuevo cliente
        $stmt = $pdo->prepare("
            INSERT INTO clientes (Nombre, Genero, FechaNacimiento, Celular, CorreoElectronico) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nombre, $genero, $fechaNacimiento, $celular, $correo]);
        
        echo json_encode([
            'success' => true,
            'clienteId' => $pdo->lastInsertId(),
            'mensaje' => 'Cliente registrado correctamente'
        ]);
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>