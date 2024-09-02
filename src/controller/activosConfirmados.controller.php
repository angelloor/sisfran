<?php
    require '../model/activosConfirmados.model.php';

    if($_POST){
        $activosConfirmados = new activosConfirmados();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($activosConfirmados->consultar());
            break;
        }
    }
?>