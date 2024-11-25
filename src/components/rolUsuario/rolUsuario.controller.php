<?php
require './rolUsuario.model.php';

if ($_POST) {
    $rolUsuario = new RolUsuario();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($rolUsuario->ConsultarTodo());
            break;
        case "LISTAR_ROLES":
            $respuesta = $rolUsuario->listarRoles();
            echo json_encode($respuesta);
            break;
    }
}
