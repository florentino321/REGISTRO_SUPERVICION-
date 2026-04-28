<?php
include 'conexion.php';

if (isset($_GET['accion_id'])) {
    $id = $_GET['accion_id'];
    
    // Consulta para obtener acciones específicas según la acción seleccionada
    $stmt = $pdo->prepare("SELECT ID_AE, ACCION_ESPECIFICA FROM accion_especifica WHERE ID_ACCION = ?");
    $stmt->execute([$id]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Devolvemos los datos en formato JSON para JavaScript
    header('Content-Type: application/json');
    echo json_encode($resultados);
}
?>