<?php
require './actaDigital.model.php';

if ($_POST) {
    $sistema = new Sistema();
    switch ($_POST['accion']) {
        case "LISTAR_SISTEMAS":
            echo json_encode($sistema->cargarSistemas());
            break;
    }
}
