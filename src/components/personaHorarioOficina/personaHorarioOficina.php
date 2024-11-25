<?php
require '../index/index.model.php';

if (!$_SESSION['user']) {
    header('Location: ../');
}

$displayStyle = ($_SESSION['rolUsuario'] == "ASISTENTE") ? 'style="display:none;"' : '';

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
    <script src="./personaHorarioOficina.js"></script>
    <script src="../../lib/common/utils.js"></script>
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
            <li class="breadcrumb-item active">Horarios Funcionario</li>
        </ol>
        <button class="btn btn-info ml-3 mb-3" id="regresar" onclick="regresarFuncionario();"><span class="fa fa-backward"></span>&nbsp&nbspAtras</button>

    </nav>
    </div>
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                <h5>Horarios - <span id="nombrePersona">Persona</span></h5>
            </div>
            <div class="card-body" <?php if ($_SESSION['rolUsuario'] == "ASISTENTE") {
                                        echo 'style="display:none;"';
                                    } ?>>
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
                        <input class="form-control" id="idPersonaHorarioOficinaQuery" type="date" placeholder="Buscar por fecha" aria-label="Buscar" autofocus>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="fechaPersonaHorarioOficina">Fecha</label>
                        <input type="date" name="fechaPersonaHorarioOficina" id="fechaPersonaHorarioOficina" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="idOficina">Oficina</label>
                        <select name="idOficina" class="form-control br" id="idOficina">
                        </select>
                    </div>
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="idHorarioOficina">Horario Oficina</label>
                        <select name="idHorarioOficina" class="form-control mb-3 tmm" id="idHorarioOficina">
                        </select>
                    </div>
                    <div class="col-md-6 mt-2 mt-2">
                        <label for="notaPersonaHorarioOficina">Nota</label>
                        <input type="text" name="notaPersonaHorarioOficina" id="notaPersonaHorarioOficina" placeholder="Ingrese alguna nota" class="form-control text-mayus">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaPersonaHorarioOficina">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Oficina</th>
                            <th>Horario</th>
                            <th>Nota</th>
                            <th <?php if ($_SESSION['rolUsuario'] == "ASISTENTE") {
                                    echo 'style="display:none;"';
                                }; {
                                    echo 'style="text-align: right;"';
                                } ?>>Acciones</th>
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