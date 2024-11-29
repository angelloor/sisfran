<?php
require './firma.model.php';

if ($_POST) {
    $firma = new firma();
    switch ($_POST["accion"]) {
        case "CONSULTAR":
            echo json_encode($firma->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($firma->ConsultarPorId($_POST["idFirma"]));
            break;
        case "MODIFICAR":
            $idFirma = $_POST["idFirma"];
            $personaId = $_POST["personaId"];
            $denominacion = $_POST["denominacion"];
            if (!$personaId) {
                echo json_encode("Seleccione un funcionario para las Firmas");
                return;
            }
            if (!$denominacion) {
                echo json_encode("Ingrese la demoninación del funcionario");
                return;
            }
            $respuesta = $firma->Modificar($idFirma, $personaId, $denominacion);
            echo json_encode($respuesta);
            break;
    }
}
