<?php
    require '../model/rol_usuario.model.php';

    if($_POST){
        $RolUsuario = new RolUsuario();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($RolUsuario->ConsultarTodo());
            break;
        }
    }
?>