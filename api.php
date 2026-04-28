<?php
include 'conexion.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'get_distritos':
            $id_zp = $_GET['id_zp'] ?? 0;
            $stmt = $pdo->prepare("SELECT id_zd, NOMBRE_DISTRITO FROM zona_distrito WHERE id_zp = ?");
            $stmt->execute([$id_zp]);
            echo json_encode($stmt->fetchAll());
            break;

        case 'get_ae':
            $id_accion = $_GET['id_accion'] ?? 0;
            $stmt = $pdo->prepare("SELECT ID_AE, ACCION_ESPECIFICA FROM accion_especifica WHERE ID_ACCION = ?");
            $stmt->execute([$id_accion]);
            echo json_encode($stmt->fetchAll());
            break;

        case 'get_detalle_completo':
            $id = $_GET['id'] ?? 0;
            $query = "SELECT r.*, 
                             a.NOMBRE_ACCION, 
                             ae.ACCION_ESPECIFICA, 
                             act.NOMBRE_ACTIVIDAD, 
                             ta.NOMBRE_TA, 
                             tt.NOMBRE_TRANSPORTE, 
                             zp.NOMBRE_PROVINCIA, 
                             zd.NOMBRE_DISTRITO
                      FROM detalle_registro r
                      LEFT JOIN accion a ON r.ID_ACCION = a.ID_ACCION
                      LEFT JOIN accion_especifica ae ON r.ID_AE = ae.ID_AE
                      LEFT JOIN actividad act ON r.ID_ACTIVIDAD = act.ID_ACTIVIDAD
                      LEFT JOIN tipo_agente ta ON r.ID_TA = ta.ID_TA
                      LEFT JOIN tipo_transporte tt ON r.id_tt = tt.id_tt
                      LEFT JOIN zona_provincia zp ON r.id_zp = zp.id_zp
                      LEFT JOIN zona_distrito zd ON r.id_zd = zd.id_zd
                      WHERE r.ID_REGISTRO = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch());
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>