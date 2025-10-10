<?php
header('Content-Type: application/json');
require_once 'config.php';

$mes = $_GET['mes'] ?? '';

try {
    // Extraer año y mes
    list($year, $month) = explode('-', $mes);
    $primerDia = "$year-$month-01";
    $ultimoDia = date("Y-m-t", strtotime($primerDia));
    
    $stmt = $pdo->prepare("
        SELECT Fecha, COUNT(*) as total 
        FROM citas 
        WHERE Fecha BETWEEN ? AND ? 
        GROUP BY Fecha
    ");
    $stmt->execute([$primerDia, $ultimoDia]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Organizar por fecha
    $citasPorFecha = [];
    foreach($resultados as $row) {
        $citasPorFecha[$row['Fecha']] = array_fill(0, $row['total'], true);
    }
    
    echo json_encode([
        'success' => true,
        'citas' => $citasPorFecha
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>