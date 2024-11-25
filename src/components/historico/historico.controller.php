<?php
require './historico.model.php';

if ($_POST) {
    $historico = new historico();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($historico->consultar());
            break;
        case "CONSULTAR_ID":
            $idActivo = $_POST['idActivo'];
            $fechaHistorico = $_POST['fechaHistorico'];
            echo json_encode($historico->ConsultarPorId($idActivo, $fechaHistorico));
            break;
        case "CONSULTAR_POR_FECHA":
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            echo json_encode($historico->ConsultarPorFecha($fechaInicio, $fechaFinal));
            break;
    }
}
