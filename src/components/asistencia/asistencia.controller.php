<?php
require './asistencia.model.php';

if ($_POST) {
    $asistencia = new Asistencia();
    switch ($_POST['accion']) {
        case "CONSULTAR_TODO":
            echo json_encode($asistencia->ConsultarTodo($_POST['id_persona']));
            break;
        case "CONSULTAR_ID_PERSONA":
            echo json_encode($asistencia->ConsultarPorIdPersona($_POST['id_persona']));
            break;
        case "CONSULTAR_ID_PERSONA_FECHA":
            echo json_encode($asistencia->ConsultarPorIdPersonaYFecha($_POST['id_persona'], $_POST['fecha']));
            break;
        case "REGISTRAR_ENTRADA":
            $personaId = $_POST['personaId'];
            $oficinaId = $_POST['oficinaId'];
            $fechaAsistencia = $_POST['fechaAsistencia'];
            $horaAsistencia = $_POST['horaAsistencia'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $observacionesAsistencia = $_POST['observacionesAsistencia'];


            if (!$personaId) {
                echo json_encode("No se encontro a la persona");
                return;
            }

            if (!$oficinaId) {
                echo json_encode("Seleccione un oficina");
                return;
            }

            if (!$fechaAsistencia) {
                echo json_encode("Seleccione la fecha de  asistencia");
                return;
            }

            if (!$horaAsistencia) {
                echo json_encode("Seleccione la hora de  asistencia");
                return;
            }

            if (!$lat) {
                echo json_encode("No se pudo determinar la latitud de la ubicación");
                return;
            }

            if (!$lng) {
                echo json_encode("No se pudo determinar la longitud de la ubicación");
                return;
            }


            $respuesta = $asistencia->RegistrarEntrada($personaId, $oficinaId, $fechaAsistencia, $horaAsistencia, $lat, $lng, $observacionesAsistencia);
            echo json_encode($respuesta);
            break;
        case "REGISTRAR_SALIDA":
            $idAsistencia = $_POST['idAsistencia'];
            $fechaAsistencia = $_POST['fechaAsistencia'];
            $horaAsistencia = $_POST['horaAsistencia'];
            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $observacionesAsistencia = $_POST['observacionesAsistencia'];

            if (!$idAsistencia) {
                echo json_encode("No se encontro la asistencia");
                return;
            }

            if (!$oficinaId) {
                echo json_encode("Seleccione un oficina");
                return;
            }

            if (!$fechaAsistencia) {
                echo json_encode("Seleccione la fecha de  asistencia");
                return;
            }

            if (!$horaAsistencia) {
                echo json_encode("Seleccione la hora de  asistencia");
                return;
            }

            if (!$lat) {
                echo json_encode("No se pudo determinar la latitud de la ubicación");
                return;
            }

            if (!$lng) {
                echo json_encode("No se pudo determinar la longitud de la ubicación");
                return;
            }

            $respuesta = $asistencia->RegistrarSalida($idAsistencia, $fechaAsistencia, $horaAsistencia, $lat, $lng, $observacionesAsistencia);
            echo json_encode($respuesta);
            break;
        case "COUNT_ASISTENCIA":
            $personaId = $_POST['personaId'];
            $oficinaId = $_POST['oficinaId'];
            $fechaActual = $_POST['fechaActual'];

            $respuesta = $asistencia->CountAsistencia($personaId, $oficinaId, $fechaActual);
            echo json_encode($respuesta);
            break;
    }
}
