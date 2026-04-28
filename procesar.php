<?php
include 'conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion_crud = $_POST['accion_crud'] ?? '';

    try {
        switch ($accion_crud) {
            case 'insert':
                $sql = "INSERT INTO detalle_registro 
                        (ID_ACCION, ID_AE, ID_ACTIVIDAD, ID_TA, id_tt, id_zp, id_zd, NRO_EXPEDIENTE, CONTRATO, OBSERVACIONES) 
                        VALUES (:accion, :ae, :actividad, :ta, :tt, :zp, :zd, :exp, :cont, :obs)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':accion'    => $_POST['ID_ACCION'],
                    ':ae'        => $_POST['ID_AE'],
                    ':actividad' => $_POST['ID_ACTIVIDAD'],
                    ':ta'        => $_POST['ID_TA'],
                    ':tt'        => $_POST['id_tt'],
                    ':zp'        => $_POST['id_zp'],
                    ':zd'        => $_POST['id_zd'],
                    ':exp'       => $_POST['NRO_EXPEDIENTE'],
                    ':cont'      => $_POST['CONTRATO'],
                    ':obs'       => $_POST['OBSERVACIONES']
                ]);
                echo json_encode(['success' => true, 'message' => 'Registro creado exitosamente']);
                break;

            case 'update':
                $id_registro = $_POST['ID_REGISTRO'];
                $sql = "UPDATE detalle_registro 
                        SET ID_ACCION = :accion, 
                            ID_AE = :ae, 
                            ID_ACTIVIDAD = :actividad,
                            ID_TA = :ta,
                            id_tt = :tt,
                            id_zp = :zp,
                            id_zd = :zd,
                            NRO_EXPEDIENTE = :exp, 
                            CONTRATO = :cont, 
                            OBSERVACIONES = :obs 
                        WHERE ID_REGISTRO = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':accion'    => $_POST['ID_ACCION'],
                    ':ae'        => $_POST['ID_AE'],
                    ':actividad' => $_POST['ID_ACTIVIDAD'],
                    ':ta'        => $_POST['ID_TA'],
                    ':tt'        => $_POST['id_tt'],
                    ':zp'        => $_POST['id_zp'],
                    ':zd'        => $_POST['id_zd'],
                    ':exp'       => $_POST['NRO_EXPEDIENTE'],
                    ':cont'      => $_POST['CONTRATO'],
                    ':obs'       => $_POST['OBSERVACIONES'],
                    ':id'        => $id_registro
                ]);
                echo json_encode(['success' => true, 'message' => 'Registro actualizado exitosamente']);
                break;

            case 'delete':
                $id_registro = $_POST['ID_REGISTRO'];
                $sql = "DELETE FROM detalle_registro WHERE ID_REGISTRO = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':id' => $id_registro]);
                echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente']);
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                break;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
?>