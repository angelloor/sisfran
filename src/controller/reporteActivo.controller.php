<?php

    require '../model/reporteActivo.model.php';

    if($_POST){
        $reporteActivo = new reporteActivo();
        switch($_POST["accion"]){
            case "CARGAINICIAL":
                $respuesta = $reporteActivo->cargaInicial();
                echo json_encode($respuesta);
            break;
            case "CARGARVALOR":
                $respuesta = $reporteActivo->cargarValor();
                echo json_encode($respuesta);
            break;
            case "LISTARVALOR":
                $campo = $_POST['campo'];
                $respuesta = $reporteActivo->cagarValor($campo);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR":
                $campo = $_POST['campo'];
                $valor = $_POST['valor'];
                $respuesta = $reporteActivo->consultar($campo,$valor);
                echo json_encode($respuesta);
            break;
        }
    }
?>