<?php
require './entregaRecepcion.model.php';

if ($_POST) {
    $entregaRecepcion = new entregaRecepcion();
    switch ($_POST["accion"]) {
        case "CONSULTAR":
            echo json_encode($entregaRecepcion->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($entregaRecepcion->ConsultarPorId($_POST["idEntregaRecepcion"]));
            break;
        case "GUARDAR":
            $idPersona = $_POST["idPersona"];
            $codigoActivo = $_POST["codigoActivo"];
            $fecha = $_POST["fecha"];
            $comentario = $_POST["comentario"];
            if (!$idPersona) {
                echo json_encode("Seleccione un funcionario para asignar la acta");
                return;
            }
            if (!$codigoActivo) {
                echo json_encode("Seleccione el código del activo");
                return;
            }
            if (!$fecha) {
                echo json_encode("Seleccione la fecha de la entrega recepción");
                return;
            }
            if (!$comentario) {
                echo json_encode("Ingrese un comentario");
                return;
            }
            $respuesta = $entregaRecepcion->Guardar($idPersona, $codigoActivo, $fecha, $comentario);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $idPersona = $_POST["idPersona"];
            $codigoActivo = $_POST["codigoActivo"];
            $fecha = $_POST["fecha"];
            $comentario = $_POST["comentario"];
            $idEntregaRecepcion = $_POST["idEntregaRecepcion"];
            if (!$idPersona) {
                echo json_encode("Seleccione un funcionario para asignar la acta");
                return;
            }
            if (!$codigoActivo) {
                echo json_encode("Seleccione el código del activo");
                return;
            }
            if (!$fecha) {
                echo json_encode("Seleccione la fecha del acta");
                return;
            }
            if (!$comentario) {
                echo json_encode("Ingrese un comentario");
                return;
            }
            $respuesta = $entregaRecepcion->Modificar($idEntregaRecepcion, $idPersona, $codigoActivo, $fecha, $comentario);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idEntregaRecepcion = $_POST["idEntregaRecepcion"];
            $respuesta = $entregaRecepcion->Eliminar($idEntregaRecepcion);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idEntregaRecepcion = $_POST['idEntregaRecepcion'];
            $campoBuscar = $_POST['campoBuscar'];
            $respuesta = $entregaRecepcion->ConsultarPorIdRow($idEntregaRecepcion, $campoBuscar);
            echo json_encode($respuesta);
            break;
    }
}
