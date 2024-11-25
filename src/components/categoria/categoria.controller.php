<?php
require './categoria.model.php';

if ($_POST) {
    $categoria = new Categoria();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($categoria->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($categoria->ConsultarPorId($_POST['idCategoria']));
            break;
        case "GUARDAR":
            $nombreCategoria = $_POST['nombreCategoria'];
            $descripcionCategoria = $_POST['descripcionCategoria'];
            $personaId = $_POST['personaId'];
            if (!$nombreCategoria) {
                echo json_encode("Ingrese el nombre de la categoría");
                return;
            }
            if (!$descripcionCategoria) {
                echo json_encode("Ingrese la descripción de la categoría");
                return;
            }
            if (!$personaId) {
                echo json_encode("Seleccione el custodio");
                return;
            }
            $respuesta = $categoria->Guardar($nombreCategoria, $descripcionCategoria, $personaId);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $nombreCategoria = $_POST['nombreCategoria'];
            $descripcionCategoria = $_POST['descripcionCategoria'];
            $personaId = $_POST['personaId'];
            $idCategoria = $_POST['idCategoria'];
            if (!$nombreCategoria) {
                echo json_encode("Ingrese el nombre de la categoría");
                return;
            }
            if (!$descripcionCategoria) {
                echo json_encode("Ingrese la descripción de la categoría");
                return;
            }
            if (!$personaId) {
                echo json_encode("Seleccione el custodio");
                return;
            }
            $respuesta = $categoria->Modificar($idCategoria, $nombreCategoria, $descripcionCategoria, $personaId);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idCategoria = $_POST['idCategoria'];
            $respuesta = $categoria->Eliminar($idCategoria);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idCategoria = $_POST['idBuscar'];
            $respuesta = $categoria->ConsultarPorIdRow($idCategoria);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $idCategoria = $_POST['idCategoria'];
            $respuesta = $categoria->consultarRegistros($idCategoria);
            echo json_encode($respuesta);
            break;
        case "LISTAR_CATEGORIA":
            $respuesta = $categoria->listarCategoria();
            echo json_encode($respuesta);
            break;
    }
}
