<?php
require './horarioOficina.model.php';

if ($_POST) {
    $horarioOficina = new HorarioOficina();
    switch ($_POST['accion']) {
        case "CONSULTAR_HORARIOS_POR_ID_OFICINA":
            echo json_encode($horarioOficina->ConsultarPorIdOficina($_POST['id_oficina']));
            break;
        case "CONSULTAR_ID":
            echo json_encode($horarioOficina->ConsultarPorId($_POST['id_horario_oficina']));
            break;
        case "GUARDAR":
            $id_oficina = $_POST['id_oficina'];
            $hora_entrada = $_POST['hora_entrada'];
            $hora_salida = $_POST['hora_salida'];
            $salto_dia = $_POST['salto_dia'];

            if (!$id_oficina) {
                echo json_encode("No se encontro el id de oficina");
                return;
            }
            if (!$hora_entrada) {
                echo json_encode("Ingrese la hora de entrada");
                return;
            }
            if (!$hora_salida) {
                echo json_encode("Ingrese la hora de salida");
                return;
            }
            if (!$salto_dia) {
                echo json_encode("Seleccione el salto de día");
                return;
            }
            
            $respuesta = $horarioOficina->Guardar($id_oficina, $hora_entrada, $hora_salida, $salto_dia);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $id_horario_oficina = $_POST['id_horario_oficina'];
            $id_oficina = $_POST['id_oficina'];
            $hora_entrada = $_POST['hora_entrada'];
            $hora_salida = $_POST['hora_salida'];
            $salto_dia = $_POST['salto_dia'];

            if (!$id_oficina) {
                echo json_encode("No se encontro el id de oficina");
                return;
            }
            if (!$hora_entrada) {
                echo json_encode("Ingrese la hora de entrada");
                return;
            }
            if (!$hora_salida) {
                echo json_encode("Ingrese la hora de salida");
                return;
            }
            if (!$salto_dia) {
                echo json_encode("Seleccione el salto de día");
                return;
            }

            $respuesta = $horarioOficina->Modificar($id_horario_oficina, $id_oficina, $hora_entrada, $hora_salida, $salto_dia);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $id_horario_oficina = $_POST['id_horario_oficina'];
            $respuesta = $horarioOficina->Eliminar($id_horario_oficina);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $id_horario_oficina = $_POST['id_horario_oficina'];
            $respuesta = $horarioOficina->consultarRegistros($id_horario_oficina);
            echo json_encode($respuesta);
            break;
    }
}
