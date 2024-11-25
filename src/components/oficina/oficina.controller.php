<?php
require './oficina.model.php';

if ($_POST) {
    $oficina = new Oficina();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($oficina->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($oficina->ConsultarPorId($_POST['idOficina']));
            break;
        case "GUARDAR":
            $nombreOficina = $_POST['nombreOficina'];
            $descripcionOficina = $_POST['descripcionOficina'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $radioValidoMetros = $_POST['radioValidoMetros'];

            if (!$nombreOficina) {
                echo json_encode("Ingrese el nombre de la oficina");
                return;
            }
            if (!$descripcionOficina) {
                echo json_encode("Ingrese la descripción de la oficina");
                return;
            }
            if (!$lat) {
                echo json_encode("No se pudo determinar la latitud de la ubicación");
                return;
            }

            if (!$lng) {
                echo json_encode("No se pudo determinar la longitud de la ubicación");
                return;
            }
            if (!$radioValidoMetros) {
                echo json_encode("Ingrese el radio valido de metros para el registro de asistencia");
                return;
            }
            
            $respuesta = $oficina->Guardar($nombreOficina, $descripcionOficina, $lat, $lng, $radioValidoMetros);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $idOficina = $_POST['idOficina'];
            $nombreOficina = $_POST['nombreOficina'];
            $descripcionOficina = $_POST['descripcionOficina'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $radioValidoMetros = $_POST['radioValidoMetros'];
            
            if (!$nombreOficina) {
                echo json_encode("Ingrese el nombre de la oficina");
                return;
            }
            if (!$descripcionOficina) {
                echo json_encode("Ingrese la descripción de la oficina");
                return;
            }
            if (!$lat) {
                echo json_encode("No se pudo determinar la latitud de la ubicación");
                return;
            }

            if (!$lng) {
                echo json_encode("No se pudo determinar la longitud de la ubicación");
                return;
            }
            if (!$radioValidoMetros) {
                echo json_encode("Ingrese el radio valido de metros para el registro de asistencia");
                return;
            }

            $respuesta = $oficina->Modificar($idOficina, $nombreOficina, $descripcionOficina, $lat, $lng, $radioValidoMetros);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idOficina = $_POST['idOficina'];
            $respuesta = $oficina->Eliminar($idOficina);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idOficina = $_POST['idBuscar'];
            $respuesta = $oficina->ConsultarPorIdRow($idOficina);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $idOficina = $_POST['idOficina'];
            $respuesta = $oficina->consultarRegistros($idOficina);
            echo json_encode($respuesta);
            break;
    }
}
