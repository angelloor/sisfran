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
    <script src="./oficina.js"></script>
    <script src="../../lib/common/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popup.css">
    <!-- API GOOGLE MAPS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuFNTu49oRZu6CoSfW10ocnPQjAvuxlQY&callback=initMap" async defer></script>
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
            <h5>Gestionar oficinas</h5>
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
                    <input class="form-control" id="idOficina" type="search" placeholder="Buscar por nombre" aria-label="Buscar" autofocus>
                </div>
            </div>
            <!-- Google Maps -->
            <button class="btn btn-success mb-2" onclick="getCurrentLocation()">Ubicación actual</button>

            <div id="map"></div>
            <!-- Google Maps -->
            <div class="row">
                <div class="col-md-6 mt-2 mt-2">
                    <label for="nombreOficina">Nombre de la Oficina</label>
                    <input type="text" name="nombreOficina" id="nombreOficina" placeholder="Ingrese el nombre de la oficina" class="form-control text-mayus">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="descripcionOficina">Descripción de la Oficina</label>
                    <input type="text" name="descripcionOficina" id="descripcionOficina" placeholder="Ingrese la descripción de la oficina" class="form-control text-mayus">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="lat">Latitud</label>
                    <input type="text" name="lat" id="lat" placeholder="Ingrese la latitud de la oficina" class="form-control text-mayus">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="lng">Longitud</label>
                    <input type="text" name="lng" id="lng" placeholder="Ingrese la longitud de la oficina" class="form-control text-mayus">
                </div>
                <div class="col-md-6 mt-2 mt-2">
                    <label for="radioValidoMetros">Radio Válido (metros)</label>
                    <input type="number" name="radioValidoMetros" id="radioValidoMetros" placeholder="Ingrese el radio válido en metros" class="form-control" min="0" max="20">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <table class="table tabled-bordered table-sm" id="tablaOficina">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Latitud</th>
                        <th>Longitud</th>
                        <th>Radio Válido (metros)</th>
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
    <script>
        //Google Maps
        let map, marker, geocoder;

        function initMap() {
            // Inicializar el mapa centrado en una ubicación por defecto
            const defaultLocation = {
                lat: -1.4868878508099954,
                lng: -78.00130909493816
            }; // Oficina Matriz
            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 18,
            });

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: defaultLocation,
            });

            geocoder = new google.maps.Geocoder();

            // Evento para actualizar las coordenadas cuando el marcador se mueve
            google.maps.event.addListener(marker, 'position_changed', function() {
                setValue("lat", marker.getPosition().lat());
                setValue("lng", marker.getPosition().lng());
            });

        }

        // Función para obtener la ubicación actual del usuario
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    marker.setPosition(pos);
                }, () => {
                    alert('No se pudo obtener la ubicación actual');
                });
            } else {
                alert('El navegador no soporta Geolocalización');
            }
        }
        // Control number
        document.getElementById('radioValidoMetros').addEventListener('input', function(e) {
            // Remover todo lo que no sea un número
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>
    <!-- Gestionar  -->
</body>

</html>