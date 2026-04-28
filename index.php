<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Supervisión Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
</head>
<body class="bg-light">
    <div class="container-fluid mt-4 px-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-primary">Sistema de Supervisión</h4>
                <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" id="btnNuevoRegistro">
                    <i class="bi bi-plus-lg"></i> + Nuevo Registro
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tablaRegistros">
                        <thead class="table-light">
                            <tr>
                                <th>Expediente</th>
                                <th>Contrato</th>
                                <th>Acción</th>
                                <th>Provincia</th>
                                <th class='text-center'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT r.*, a.NOMBRE_ACCION, zp.NOMBRE_PROVINCIA 
                                      FROM detalle_registro r 
                                      LEFT JOIN accion a ON r.ID_ACCION = a.ID_ACCION 
                                      LEFT JOIN zona_provincia zp ON r.id_zp = zp.id_zp
                                      ORDER BY r.ID_REGISTRO DESC";
                            $stmt = $pdo->query($query);
                            while ($row = $stmt->fetch()) {
                                echo "<tr data-id='{$row['ID_REGISTRO']}' 
                                          data-accion='{$row['ID_ACCION']}' 
                                          data-ae='{$row['ID_AE']}' 
                                          data-actividad='{$row['ID_ACTIVIDAD']}'
                                          data-ta='{$row['ID_TA']}'
                                          data-tt='{$row['id_tt']}'
                                          data-zp='{$row['id_zp']}'
                                          data-zd='{$row['id_zd']}'
                                          data-exp='{$row['NRO_EXPEDIENTE']}' 
                                          data-cont='{$row['CONTRATO']}' 
                                          data-obs='".htmlspecialchars($row['OBSERVACIONES'])."'>
                                        <td class='fw-medium'>{$row['NRO_EXPEDIENTE']}</td>
                                        <td>{$row['CONTRATO']}</td>
                                        <td><span class='badge bg-info text-dark'>{$row['NOMBRE_ACCION']}</span></td>
                                        <td>{$row['NOMBRE_PROVINCIA']}</td>
                                        <td class='text-center'>
                                            <div class='btn-group' role='group'>
                                                <button class='btn btn-outline-info btn-sm btn-ver' title='Ver Detalle'>Ver</button>
                                                <button class='btn btn-outline-primary btn-sm btn-editar' title='Editar'>Editar</button>
                                                <button class='btn btn-outline-danger btn-sm btn-eliminar' title='Eliminar'>Borrar</button>
                                            </div>
                                        </td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Formulario (Nuevo/Editar) -->
    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <form id="formRegistro">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitulo">Nuevo Registro</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="ID_REGISTRO" id="ID_REGISTRO">
                        <input type="hidden" name="accion_crud" id="accion_crud" value="insert">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Acción Principal</label>
                                <select name="ID_ACCION" id="selector-accion" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $stmtA = $pdo->query("SELECT ID_ACCION, NOMBRE_ACCION FROM accion");
                                    while ($a = $stmtA->fetch()) {
                                        echo "<option value='{$a['ID_ACCION']}'>{$a['NOMBRE_ACCION']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Acción Específica</label>
                                <select name="ID_AE" id="selector-ae" class="form-select" required>
                                    <option value="">Seleccione acción primero</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Actividad</label>
                                <select name="ID_ACTIVIDAD" id="selector-actividad" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $stmtAct = $pdo->query("SELECT ID_ACTIVIDAD, NOMBRE_ACTIVIDAD FROM actividad");
                                    while ($act = $stmtAct->fetch()) {
                                        echo "<option value='{$act['ID_ACTIVIDAD']}'>{$act['NOMBRE_ACTIVIDAD']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo de Agente</label>
                                <select name="ID_TA" id="selector-ta" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $stmtTa = $pdo->query("SELECT ID_TA, NOMBRE_TA FROM tipo_agente");
                                    while ($ta = $stmtTa->fetch()) {
                                        echo "<option value='{$ta['ID_TA']}'>{$ta['NOMBRE_TA']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Provincia</label>
                                <select name="id_zp" id="selector-zp" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $stmtZp = $pdo->query("SELECT id_zp, NOMBRE_PROVINCIA FROM zona_provincia");
                                    while ($zp = $stmtZp->fetch()) {
                                        echo "<option value='{$zp['id_zp']}'>{$zp['NOMBRE_PROVINCIA']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Distrito</label>
                                <select name="id_zd" id="selector-zd" class="form-select">
                                    <option value="">Seleccione provincia primero</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Transporte</label>
                                <select name="id_tt" id="selector-tt" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $stmtTt = $pdo->query("SELECT id_tt, NOMBRE_TRANSPORTE FROM tipo_transporte");
                                    while ($tt = $stmtTt->fetch()) {
                                        // NOMBRE_TRANSPORTE es INT en el SQL, lo tratamos como tal
                                        echo "<option value='{$tt['id_tt']}'>Opción {$tt['NOMBRE_TRANSPORTE']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nro. Expediente</label>
                                <input type="text" name="NRO_EXPEDIENTE" id="NRO_EXPEDIENTE" class="form-control" placeholder="EXP-0000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Contrato</label>
                                <input type="text" name="CONTRATO" id="CONTRATO" class="form-control" placeholder="CONT-0000">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Observaciones</label>
                                <textarea name="OBSERVACIONES" id="OBSERVACIONES" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary px-4" id="btnGuardar">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detalle (Read Only) -->
    <div class="modal fade" id="modalVer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-dark">
                    <h5 class="modal-title fw-bold">Detalles del Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped mb-0">
                        <tbody id="contenidoVer">
                            <!-- Se llena vía JS -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="app.js"></script>
</body>
</html>