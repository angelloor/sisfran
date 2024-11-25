<?php
require './reporteHoras.model.php';

if ($_POST) {
    $reporteHoras = new reporteHoras();
    switch ($_POST["accion"]) {
        case "CARGA_INICIAL":
            $respuesta = $reporteHoras->cargaInicial();
            echo json_encode($respuesta);
            break;
        case "CONSULTAR":
            $idPersona = $_POST['idPersona'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];

            $respuesta = $reporteHoras->consultar($idPersona, $fechaInicio, $fechaFin);
            echo json_encode($respuesta);
            break;
    }
}
