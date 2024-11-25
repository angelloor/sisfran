<?php
require './sistema.model.php';

if ($_POST) {
    $sistema = new Sistema();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($sistema->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($sistema->ConsultarPorId($_POST['idSistema']));
            break;
        case "GUARDAR":
            $nombreSistema = $_POST['nombreSistema'];
            $direccion = $_POST['direccion'];
            if (!$nombreSistema) {
                echo json_encode("Ingrese el nombre del sistema");
                return;
            }
            if (!$direccion) {
                echo json_encode("Ingrese la dirección de acceso al sistema");
                return;
            }
            $respuesta = $sistema->Guardar($nombreSistema, $direccion);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $nombreSistema = $_POST['nombreSistema'];
            $direccion = $_POST['direccion'];
            $idSistema = $_POST['idSistema'];
            if (!$nombreSistema) {
                echo json_encode("Ingrese el nombre del sistema");
                return;
            }
            if (!$direccion) {
                echo json_encode("Ingrese la dirección de acceso al sistema");
                return;
            }
            $respuesta = $sistema->Modificar($idSistema, $nombreSistema, $direccion);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idSistema = $_POST['idSistema'];
            $respuesta = $sistema->Eliminar($idSistema);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idSistema = $_POST['idBuscar'];
            $respuesta = $sistema->ConsultarPorIdRow($idSistema);
            echo json_encode($respuesta);
            break;
        case "LISTAR_SISTEMAS":
            echo json_encode($sistema->cargarSistemas());
            break;
    }
}
