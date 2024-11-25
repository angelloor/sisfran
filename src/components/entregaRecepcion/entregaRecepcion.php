<?php
require '../index/index.model.php';

if (!$_SESSION['user']) {
    header('Location: ../');
}
if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") {
    header('Location: ./');
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
    <script src="./entregaRecepcion.js"></script>
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
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                <nav aria-label="breadcrumb bg-light">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Inventario</li>
                        <li class="breadcrumb-item active" aria-current="page">Entrega recepción</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB -->
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                <h5>Entrega recepción</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-7 col-xl-7 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success" id="guardar" onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                            <button class="btn btn-success" id="modificar" onclick="Modificar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspModificar</button>
                            <button class="btn btn-primary" id="cancelar" onclick="Cancelar();"><span class="fa fa-ban"></span>&nbsp&nbspCancelar</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-5 col-xl-5">
                        <div class="btn-toolbar pc-flex-end">
                            <div class="btn-group mt-2">
                                <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar todo</button>
                            </div>
                            <div class="input-group mt-2">
                                <select name="campoBuscar" id="campoBuscar" class="form-control mr-2">
                                    <option>Funcionario</option>
                                    <option>Activo</option>
                                </select>
                                <input class="form-control" id="idEntregaRecepcion" type="search" placeholder="Buscar" aria-label="Buscar" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="idPersona">Funcionario</label>
                        <select name="idPersona" id="idPersona" class="form-control br">
                        </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="activo">Activo</label>
                        <datalist id="activo" name="activo">
                        </datalist>
                        <input id="codigoActivo" list="activo" class="form-control br">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="fecha">Fecha de entrega</label>
                        <input type="date" id="fecha" class="form-control">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="comentario">Comentario</label>
                        <input type="text" name="comentario" id="comentario" placeholder="Ingrese un comentario" class="form-control text-mayus">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaUsuario">
                    <thead>
                        <tr>
                            <th>Funcionario</th>
                            <th>Activo</th>
                            <th>Fecha de entrega</th>
                            <th>Comentario/th>
                            <th class="th-text-align-right">Acciones</th>
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
    </div>
    <!-- Gestionar  -->

</html>