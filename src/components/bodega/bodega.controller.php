<?php
require './bodega.model.php';

if ($_POST) {
    $bodega = new Bodega();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($bodega->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($bodega->ConsultarPorId($_POST['idBodega']));
            break;
        case "GUARDAR":
            $nombreBodega = $_POST['nombreBodega'];
            $ubicacion = $_POST['ubicacion'];
            $personaId = $_POST['personaId'];
            if (!$nombreBodega) {
                echo json_encode("Ingrese el nombre de la bodega");
                return;
            }
            if (!$ubicacion) {
                echo json_encode("Ingrese la ubicación de la bodega");
                return;
            }
            if (!$personaId) {
                echo json_encode("Seleccione el responsable de la bodega");
                return;
            }
            $respuesta = $bodega->Guardar($nombreBodega, $ubicacion, $personaId);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $nombreBodega = $_POST['nombreBodega'];
            $ubicacion = $_POST['ubicacion'];
            $personaId = $_POST['personaId'];
            $idBodega = $_POST['idBodega'];
            if (!$nombreBodega) {
                echo json_encode("Ingrese el nombre de la bodega");
                return;
            }
            if (!$ubicacion) {
                echo json_encode("Ingrese la ubicación de la bodega");
                return;
            }
            if (!$personaId) {
                echo json_encode("Ingrese el responsable de la bodega");
                return;
            }
            $respuesta = $bodega->Modificar($idBodega, $nombreBodega, $ubicacion, $personaId);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idBodega = $_POST['idBodega'];
            $respuesta = $bodega->Eliminar($idBodega);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idBodega = $_POST['idBuscar'];
            $respuesta = $bodega->ConsultarPorIdRow($idBodega);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $idBodega = $_POST['idBodega'];
            $respuesta = $bodega->consultarRegistros($idBodega);
            echo json_encode($respuesta);
            break;
        case "LISTAR_BODEGA":
            $respuesta = $bodega->listarBodega();
            echo json_encode($respuesta);
            break;
    }
}
