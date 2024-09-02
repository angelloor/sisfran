<?php
    require '../model/login.model.php';

    if($_POST){
        $login = new Login();
        switch($_POST['accion']){
            case "LOGIN":
                $usuario = $_POST['usuario'];
                $clave = $_POST['clave'];
                $respuesta = $login->consultarUsuario($usuario,$clave);
                echo json_encode($respuesta);
            break;
        }
    }
?>