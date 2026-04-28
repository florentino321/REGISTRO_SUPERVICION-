<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Preparamos la consulta con los nombres de columnas de tu db_darwin.sql
        $sql = "INSERT INTO detalle_registro (ID_ACCION, ID_AE, NRO_EXPEDIENTE, CONTRATO, OBSERVACIONES) 
                VALUES (:accion, :ae, :exp, :cont, :obs)";
        
        $stmt = $pdo->prepare($sql);
        
        // Ejecutamos pasando los datos del formulario
        $stmt->execute([
            ':accion' => $_POST['ID_ACCION'],
            ':ae'     => $_POST['ID_AE'],
            ':exp'    => $_POST['NRO_EXPEDIENTE'],
            ':cont'   => $_POST['CONTRATO'],
            ':obs'    => $_POST['OBSERVACIONES']
        ]);

        echo "<h1>¡Registro guardado con éxito!</h1>";
        echo "<a href='index.php'>Volver al formulario</a>";

    } catch (PDOException $e) {
        echo "Error al guardar los datos: " . $e->getMessage();
    }
}
?>