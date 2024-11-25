<?php
require '../index/index.model.php';

if (!$_SESSION['user']) {
    header('Location: ../');
}
if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
    header('Location: ./');
}
if ($_SESSION['rolUsuario'] == "ASISTENTE") {
    header('Location: ./');
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
    <script src="./comprobacionInventario.js"></script>
    <script src="../../lib/common/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
</head>

<body>
    <!-- HEADER -->
    <?php
  require '../../lib/common/header.php';
    ?>
    <!-- HEADER -->
    <!-- BREADCRUMB -->
    <div class="container-fluid text-center">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 mt-2">
                <nav aria-label="breadcrumb bg-light">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Funciones</li>
                        <li class="breadcrumb-item active">Comprobación Activo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB -->
    <div class="container">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                <h5>Comprobación de Inventario</h5>
            </div>
            <div class="card-body text">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-xl-12 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success mt-2" id="nuevo" onclick="Nuevo();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspNuevo</button>
                            <button class="btn btn-success mt-2" id="guardar" onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                            <button class="btn btn-primary mt-2" id="cancelar" onclick="Cancelar();"><span class="fa fa-ban"></span>&nbsp&nbspCancelar</button>
                            <button class="btn btn-danger mt-2" id="restablecer" onclick="Restablecer();"><span class="fa fa-redo-alt"></span>&nbsp&nbspRestablecer</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="codigo">Codigo</label>
                        <input type="text" name="codigo" id="codigo" placeholder="Codigo" class="form-control">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="estadoId">Estado</label>
                        <select name="estadoId" id="estadoId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="personaId">Funcionario</label>
                        <select name="personaId" id="personaId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="comentario">Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario" cols="30" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gestionar  -->

</html>