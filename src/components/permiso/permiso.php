<?php
require '../index/index.model.php';
if (!$_SESSION['user']) {
    header('Location: ../');
}

?>
<!doctype html>
<html lang="es">

<head>
    <title>SISFRAN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descriptions" content="Sistema para la generación de actas y control de inventario">
    <meta name="author" content="Cristian Arauz">
    <link rel="icon" type="image/png" href="../../assets/img/logo.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../../assets/css/all.min.css">
    <!-- SWEET ALERT -->
    <link href="../../assets/css/dark.css" rel="stylesheet">
    <script src="../../assets/js/sweetalert2.min.js"></script>
    <!-- SCRIPTS -->
    <script src="../../assets/js/all.min.js"></script>
    <script src="./permiso.js"></script>
    <script src="../../assets/js/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popup.css">
    <link rel="stylesheet" href="../../assets/css/popupMobileDisplayTable.css">
</head>

<body style="height: 100vh;">
    <!-- HEADER -->
    <?php
    require '../../lib/common/header.php';
    ?>
    <!-- HEADER -->
    <nav aria-label="breadcrumb bg-light">
        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
            <li class="breadcrumb-item active">Asistencia</li>
            <li class="breadcrumb-item active">Permisos</li>
        </ol>
    </nav>
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card-header bg-primary text-color-white">
            <h5>Permisos</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
                    <div class="btn-group-sm">
                        <button class="btn btn-success" id="guardar" onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                        <button class="btn btn-success" id="modificar" onclick="Modificar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspModificar</button>
                        <button class="btn btn-primary" id="cancelar" onclick="Cancelar();"><span class="fa fa-ban"></span>&nbsp&nbspCancelar</button>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-xl-4 input-group mt-2">
                    <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar todo</button>
                    <input class="form-control" id="idPermiso" type="search" placeholder="Buscar por solicitante" aria-label="Buscar" autofocus>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-2 mt-2">
                    <label for="fechaInicio">Fecha Inicio</label>
                    <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="fechaFin">Fecha Fin</label>
                    <input type="date" name="fechaFin" id="fechaFin" class="form-control">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="estado">Estado</label>
                    <select name="estado" class="form-control br" id="estado">
                        <option>EMITIDO</option>
                        <?php if (($_SESSION['rolUsuario'] === "ADMINISTRADOR")) {
                            echo '<option>APROBADO</option>';
                            echo '<option>NEGADO</option>';
                        } ?>
                    </select>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="observaciones">Observaciones</label>
                    <input type="text" name="observaciones" id="observaciones" class="form-control">
                </div>
                <div class="col-md-6 mt-2 mt-2" id="cabeceraDocumentacion">
                    <label for="documentacion">Documentación</label>
                    <input type="file" name="documentacion" id="documentacion" class="form-control">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <table class="table tabled-bordered table-sm" id="tablaPermiso">
                <thead>
                    <tr>
                        <th scope="col" id="idPermisoLbl">Id</th>
                        <th scope="col" id="fechaInicioPermisoLbl">Fecha Inicio</th>
                        <th scope="col" id="fechaFinPermisoLbl">Fecha Fin</th>
                        <?php if (($_SESSION['rolUsuario'] === "ADMINISTRADOR")) {
                            echo '<th scope="col" id="nombrePersonaLbl">Solicitante</th>';
                        } ?>
                        <th scope="col" id="estadoPermisoLbl">Estado</th>
                        <th scope="col" id="observacionesPermisoLbl">Observaciones</th>
                        <th scope="col" id="documentacionPermisoLbl">Documentación</th>
                        <th style='text-align: right;'>Acciones</th>
                    </tr>
                </thead>
                <tbody id="datos">

                </tbody>
            </table>
            <div id="alertaDatos">
                <div class="alert alert-success text-center" role="alert">
                    No se ha encontrado datos
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Mobile Display Table -->
<script src="../../assets/js/popupMobileDisplayTable.js"></script>
<?php
require '../../lib/common/popupMobileDisplayTable.php';
?>
<!-- Mobile Display Table -->
</html>