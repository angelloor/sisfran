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
    <script src="../../assets/js/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popup.css">
    <link rel="stylesheet" href="../../assets/css/popupMobileDisplayTable.css">
    <!-- API GOOGLE MAPS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuFNTu49oRZu6CoSfW10ocnPQjAvuxlQY" async defer></script>
    <script src="./asistencia.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
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
            <li class="breadcrumb-item active">Oficinas</li>
        </ol>
    </nav>
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card-header bg-primary text-color-white">
            <h5>Registro de asistencia</h5>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
                    <div class="btn-group-sm">
                        <button class="btn btn-info" id="registrarEntrada" onclick="registrarEntrada();">Registrar Entrada&nbsp&nbsp<span class="fa-solid fa-right-to-bracket"></span></button>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-xl-4 input-group mt-2">
                    <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar todo</button>
                    <input class="form-control" id="idAsistencia" type="date" aria-label="Buscar" autofocus>
                </div>
            </div>
            <!-- Google Maps -->
            <div id="map"></div>
            <!-- Google Maps -->
            <div class="row" id="cabecera">
                <div class="col-md-6 mt-2 mt-2">
                    <label for="oficinaId">Oficina</label>
                    <select name="oficinaId" class="form-control br" id="oficinaId" onchange="handleChangeOficina(this.value)">
                    </select>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="fechaAsistencia">Fecha</label>
                    <input type="date" name="fechaAsistencia" id="fechaAsistencia" class="form-control text-mayus" readonly>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="horaAsistencia">Hora Marcación</label>
                    <input type="time" name="horaAsistencia" id="horaAsistencia" class="form-control" required readonly>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="observacionesAsistencia">Observaciones</label>
                    <input type="text" name="observacionesAsistencia" id="observacionesAsistencia" class="form-control text-mayus">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="lat">Latitud</label>
                    <input type="text" name="lat" id="lat" class="form-control text-mayus" readonly>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="lng">Longitud</label>
                    <input type="text" name="lng" id="lng" class="form-control text-mayus" readonly>
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="radioValidoMetros">Radio permitido</label>
                    <input type="text" name="radioValidoMetros" id="radioValidoMetros" class="form-control text-mayus" readonly>
                </div>
            </div>
            <div id="alertaInfo">
                <div class="alert alert-info text-center mt-4" role="alert" id="mensaje">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <table class="table tabled-bordered table-sm" id="tablaOficina">
                <thead>
                    <th scope="col" id="asistenciaIdLbl">ID</th>
                    <th scope="col" id="nombreOficinaLbl">Oficina</th>
                    <th scope="col" id="tipoLbl">Tipo</th>
                    <th scope="col" id="fechaLbl">Fecha</th>
                    <th scope="col" id="horaLbl">Hora</th>
                    <th scope="col" id="latitudLbl">Latitud</th>
                    <th scope="col" id="longitudLbl">Longigutd</th>
                    <th scope="col" id="observacionesLbl">Observaciones</th>
                    <th>Acciones</th>
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