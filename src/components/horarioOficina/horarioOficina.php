<?php
require '../index/index.model.php';
if (!$_SESSION['user']) {
    header('Location: ../');
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
    <script src="./horarioOficina.js"></script>
    <script src="../../assets/js/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popup.css">
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
            <li class="breadcrumb-item active">Horarios Oficinas</li>
        </ol>
        <button class="btn btn-info ml-3 mb-3" id="regresar" onclick="regresarOficinas();"><span class="fa fa-backward"></span>&nbsp&nbspAtras</button>
    </nav>
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                <h5>Horarios - <span id="nombreOficina">Terminal</span></h5>
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
                        <input style="visibility: hidden;" class="form-control" id="idHorarioOficina" type="search" placeholder="Buscar por ID" aria-label="Buscar" autofocus>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="horaEntrada">Hora entrada</label>
                        <input type="time" name="horaEntrada" id="horaEntrada" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="horaSalida">Hora salida</label>
                        <input type="time" name="horaSalida" id="horaSalida" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="saltoDia">Salto día</label>
                        <select name="saltoDia" class="form-control mb-3 tmm" id="saltoDia">
                            <option value="NO">No</option>
                            <option value="SI">Si</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaHorarioOficina">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hora entrada</th>
                            <th>Hora salida</th>
                            <th>Salto de día</th>
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
    </div>
    <!-- Gestionar  -->
</body>

</html>