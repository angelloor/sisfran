<?php
require './permiso.model.php';

if ($_POST) {
    $permiso = new Permiso();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($permiso->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($permiso->ConsultarPorId($_POST['idPermiso']));
            break;
        case "CONSULTAR_ID_PERSONA":
            $idPersona = $_POST['idPersona'];
            echo json_encode($permiso->ConsultarPorIdPersona($idPersona));
            break;
        case "CONSULTAR_ID_ROW":
            $idPermiso = $_POST['idBuscar'];
            $respuesta = $permiso->ConsultarPorIdRow($idPermiso);
            echo json_encode($respuesta);
            break;
        case "GUARDAR":
            $idPersona = $_POST['idPersona'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $estado = $_POST['estado'];
            $documentacion = $_POST['documentacion'];
            $observaciones = $_POST['observaciones'];

            if (!$idPersona) {
                echo json_encode("No se encontro a la persona");
                return;
            }
            if (!$fechaInicio) {
                echo json_encode("Seleccione la fecha de inicio del permiso");
                return;
            }
            if (!$fechaFin) {
                echo json_encode("Seleccione la fecha de fin del permiso");
                return;
            }
            if (!$estado) {
                echo json_encode("Seleccione el estado");
                return;
            }
            if (!$observaciones) {
                echo json_encode("Ingrese las observaciones");
                return;
            }
            if (!$idPersona) {
                echo json_encode("No se encontro a la persona");
                return;
            }
            if (!$fechaInicio) {
                echo json_encode("Seleccione la fecha de inicio del permiso");
                return;
            }
            if (!$fechaFin) {
                echo json_encode("Seleccione la fecha de fin del permiso");
                return;
            }
            if (!$estado) {
                echo json_encode("Seleccione el estado");
                return;
            }
            if (!$observaciones) {
                echo json_encode("Ingrese las observaciones");
                return;
            }

            $respuesta = $permiso->Guardar($idPersona, $fechaInicio, $fechaFin, $estado, $documentacion, $observaciones);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $idPermiso = $_POST['idPermiso'];
            $idPersona = $_POST['idPersona'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFin = $_POST['fechaFin'];
            $estado = $_POST['estado'];
            $documentacion = $_POST['documentacion'];
            $observaciones = $_POST['observaciones'];

            if (!$idPersona) {
                echo json_encode("No se encontro a la persona");
                return;
            }
            if (!$fechaInicio) {
                echo json_encode("Seleccione la fecha de inicio del permiso");
                return;
            }
            if (!$fechaFin) {
                echo json_encode("Seleccione la fecha de fin del permiso");
                return;
            }
            if (!$estado) {
                echo json_encode("Seleccione el estado");
                return;
            }
            if (!$observaciones) {
                echo json_encode("Ingrese las observaciones");
                return;
            }

            $respuesta = $permiso->Modificar($idPermiso, $fechaInicio, $fechaFin, $estado, $observaciones);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idPermiso = $_POST['idPermiso'];
            $respuesta = $permiso->Eliminar($idPermiso);
            echo json_encode($respuesta);
            break;
    }
}
