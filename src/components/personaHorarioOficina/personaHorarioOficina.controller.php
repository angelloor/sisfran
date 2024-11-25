<?php
require './personaHorarioOficina.model.php';

if ($_POST) {
    $personaHorarioOficina = new PersonaHorarioOficina();
    switch ($_POST['accion']) {
        case "CONSULTAR_POR_ID_PERSONA":
            echo json_encode($personaHorarioOficina->ConsultarPorIdPersona($_POST['id_persona']));
            break;
        case "CONSULTAR_ID":
            echo json_encode($personaHorarioOficina->ConsultarPorId($_POST['id_persona_horario_oficina']));
            break;
        case "GUARDAR":
            $persona_id = $_POST['persona_id'];
            $oficina_id = $_POST['oficina_id'];
            $horario_oficina_id = $_POST['horario_oficina_id'];
            $fecha_persona_horario_oficina = $_POST['fecha_persona_horario_oficina'];
            $nota_persona_horario_oficina = $_POST['nota_persona_horario_oficina'];

            if (!$persona_id) {
                echo json_encode("No se encontro a la persona");
                return;
            }
            if (!$oficina_id) {
                echo json_encode("No se encontro la oficina");
                return;
            }
            if (!$horario_oficina_id) {
                echo json_encode("No se encontro el horario de la oficina");
                return;
            }
            if (!$fecha_persona_horario_oficina) {
                echo json_encode("Seleccione la fecha para asignar al funcionario");
                return;
            }

            $respuesta = $personaHorarioOficina->Guardar($persona_id, $oficina_id, $horario_oficina_id, $fecha_persona_horario_oficina, $nota_persona_horario_oficina);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $id_persona_horario_oficina = $_POST['id_persona_horario_oficina'];
            $persona_id = $_POST['persona_id'];
            $oficina_id = $_POST['oficina_id'];
            $horario_oficina_id = $_POST['horario_oficina_id'];
            $fecha_persona_horario_oficina = $_POST['fecha_persona_horario_oficina'];
            $nota_persona_horario_oficina = $_POST['nota_persona_horario_oficina'];

            if (!$id_persona_horario_oficina) {
                echo json_encode("No se encontro el horario asignado");
                return;
            }
            if (!$persona_id) {
                echo json_encode("No se encontro a la persona");
                return;
            }
            if (!$oficina_id) {
                echo json_encode("No se encontro la oficina");
                return;
            }
            if (!$horario_oficina_id) {
                echo json_encode("No se encontro el horario de la oficina");
                return;
            }
            if (!$fecha_persona_horario_oficina) {
                echo json_encode("Seleccione la fecha para asignar al funcionario");
                return;
            }

            $respuesta = $personaHorarioOficina->Modificar($id_persona_horario_oficina, $persona_id, $oficina_id, $horario_oficina_id, $fecha_persona_horario_oficina, $nota_persona_horario_oficina);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $id_persona_horario_oficina = $_POST['id_persona_horario_oficina'];
            $respuesta = $personaHorarioOficina->Eliminar($id_persona_horario_oficina);
            echo json_encode($respuesta);
            break;
        case "LISTAR_OFICINA":
            $respuesta = $personaHorarioOficina->listarOficina();
            echo json_encode($respuesta);
            break;
        case "LISTAR_HORARIO_OFICINA":
            $id_oficina = $_POST['id_oficina'];
            $respuesta = $personaHorarioOficina->listarHorarioOficina($id_oficina);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $id_persona = $_POST['id_persona'];
            $fecha = $_POST['fecha'];
            $respuesta = $personaHorarioOficina->ConsultarPorIdRow($id_persona, $fecha);
            echo json_encode($respuesta);
            break;
        case "LISTAR_OFICINA_BY_FUNCIONARIO_DATE":
            $idPersona = $_POST['idPersona'];
            $fechaActual = $_POST['fechaActual'];
            $respuesta = $personaHorarioOficina->listarOficinaByFuncionarioDate($idPersona, $fechaActual);
            echo json_encode($respuesta);
            break;
    }
}
