<?php
require './reporteActivo.model.php';

if ($_POST) {
    $reporteActivo = new reporteActivo();
    switch ($_POST["accion"]) {
        case "CARGA_INICIAL":
            $respuesta = $reporteActivo->cargaInicial();
            echo json_encode($respuesta);
            break;
        case "CARGAR_VALOR":
            $respuesta = $reporteActivo->cargarValor();
            echo json_encode($respuesta);
            break;
        case "LISTAR_VALOR":
            $campo = $_POST['campo'];
            $respuesta = $reporteActivo->cagarValor($campo);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR":
            $campo = $_POST['campo'];
            $valor = $_POST['valor'];
            $respuesta = $reporteActivo->consultar($campo, $valor);
            echo json_encode($respuesta);
            break;
    }
}
