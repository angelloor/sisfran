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
    <script src="./funcionario.js"></script>
    <script src="../../assets/js/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popupMobileDisplayTable.css">
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
                        <li class="breadcrumb-item active">Administración</li>
                        <li class="breadcrumb-item active" aria-current="page">Funcionario</li>
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
                <h5>Gestionar Funcionario</h5>
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
                        <input class="form-control" id="idFuncionario" type="search" placeholder="Buscar por nombre" aria-label="Buscar" autofocus>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Cedula">Cédula</label>
                        <input type="text" name="cedulaFuncionario" id="cedulaFuncionario" maxlength="10" placeholder="Ingrese su número de cédula" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="nombreCompleto">Nombre completo</label>
                        <input type="text" name="nombreFuncionario" id="nombreFuncionario" placeholder="Apellidos - Nombres" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Dirección">Dirección</label>
                        <input type="text" name="direccionFuncionario" id="direccionFuncionario" placeholder="Ingrese la dirección" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Teléfono">Teléfono</label>
                        <input type="text" name="telefonoFuncionario" id="telefonoFuncionario" maxlength="15" placeholder="Ingrese el teléfono" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="cargoId">Cargo</label>
                        <select name="cargoId" class="form-control br" id="cargoId">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="unidadId">Unidad</label>
                        <select name="unidadId" class="form-control br" id="unidadId">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="tipoContrato">Tipo contrato</label>
                        <select name="tipoContrato" class="form-control br" id="tipoContrato">
                            <option>CODIGO DE TRABAJO</option>
                            <option>LOSEP</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="salarioBase">Salario base</label>
                        <input type="text" name="salarioBase" id="salarioBase" maxlength="10" placeholder="Ingrese el salario base" class="form-control text-mayus">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaFuncionario">
                    <thead>
                        <tr>
                            <th scope="col" id="cedulaFuncionarioLbl">Cédula</th>
                            <th scope="col" id="nombreFuncionarioLbl">Nombre</th>
                            <th scope="col" id="direccionFuncionarioLbl">Dirección</th>
                            <th scope="col" id="telefonoFuncionarioLbl">Teléfono</th>
                            <th scope="col" id="cargoIdLbl">Cargo</th>
                            <th scope="col" id="unidadIdLbl">Unidad</th>
                            <th scope="col" id="tipoContratoLbl">Tipo contrato</th>
                            <th scope="col" id="salarioBaseLbl">Salario base</th>
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
</body>
<!-- Mobile Display Table -->
<script src="../../assets/js/popupMobileDisplayTable.js"></script>
<?php
require '../../lib/common/popupMobileDisplayTable.php';
?>
<!-- Mobile Display Table -->
</html>