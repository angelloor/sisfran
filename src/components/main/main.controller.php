<?php
require './main.model.php';

if ($_POST) {
    $main = new Main();
    switch ($_POST['accion']) {
        case "LISTAR_CATEGORIA_MAIN":
            $respuesta = $main->listarCategoriaMain();
            echo json_encode($respuesta);
            break;
        case "LISTAR_ACTIVO_MAIN":
            $respuesta = $main->listarActivoMain();
            echo json_encode($respuesta);
            break;
        case "LISTAR_FUNCIONARIO_POR_CATEGORIA_MAIN":
            $categoria = $_POST['categoria'];
            $respuesta = $main->listarFuncionarioPorCategoriaMain($categoria);
            echo json_encode($respuesta);
            break;
    }
}
