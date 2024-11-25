<?php
require('../../lib/connectios/MySQLPDO.php');

class Asistencia
{
    public function ConsultarTodo($id_persona)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_asistencia, a.persona_id, a.oficina_id, a.fecha_e_asistencia, a.fecha_s_asistencia, a.hora_e_asistencia, a.hora_s_asistencia, a.latitud_e_asistencia, a.latitud_s_asistencia, a.longitud_e_asistencia, a.longitud_s_asistencia, a.observaciones_e_asistencia, a.observaciones_s_asistencia, p.nombre_persona, o.nombre_oficina from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id = o.id_oficina where a.persona_id = :personaId order by a.id_asistencia desc;");
        $stmt->bindValue(":personaId", $id_persona, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdPersona($id_persona)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_asistencia, a.persona_id, a.oficina_id, a.fecha_e_asistencia, a.fecha_s_asistencia, a.hora_e_asistencia, a.hora_s_asistencia, a.latitud_e_asistencia, a.latitud_s_asistencia, a.longitud_e_asistencia, a.longitud_s_asistencia, a.observaciones_e_asistencia, a.observaciones_s_asistencia, p.nombre_persona, o.nombre_oficina from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id = o.id_oficina where a.persona_id = :personaId order by a.id_asistencia desc;");
        $stmt->bindValue(":personaId", $id_persona, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdPersonaYFecha($id_persona, $fecha)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_asistencia, a.persona_id, a.oficina_id, a.fecha_e_asistencia, a.fecha_s_asistencia, a.hora_e_asistencia, a.hora_s_asistencia, a.latitud_e_asistencia, a.latitud_s_asistencia, a.longitud_e_asistencia, a.longitud_s_asistencia, a.observaciones_e_asistencia, a.observaciones_s_asistencia, p.nombre_persona, o.nombre_oficina from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id = o.id_oficina where a.persona_id = :personaId and a.fecha_e_asistencia = :fecha order by a.id_asistencia desc;");
        $stmt->bindValue(":personaId", $id_persona, PDO::PARAM_INT);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function RegistrarEntrada($personaId, $oficinaId, $fechaAsistencia, $horaAsistencia, $lat, $lng, $observacionesAsistencia)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("insert into `asistencia`(`persona_id`, `oficina_id`, `fecha_e_asistencia`, `hora_e_asistencia`, `latitud_e_asistencia`, `longitud_e_asistencia`, `observaciones_e_asistencia`) 
            values (:personaId, :oficinaId, :fechaAsistencia, :horaAsistencia, :lat, :lng, :observacionesAsistencia);");
        $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
        $stmt->bindValue(":oficinaId", $oficinaId, PDO::PARAM_INT);
        $stmt->bindValue(":fechaAsistencia", $fechaAsistencia, PDO::PARAM_STR);
        $stmt->bindValue(":horaAsistencia", $horaAsistencia, PDO::PARAM_STR);
        $stmt->bindValue(":lat", $lat, PDO::PARAM_STR);
        $stmt->bindValue(":lng", $lng, PDO::PARAM_STR);
        $stmt->bindValue(":observacionesAsistencia", $observacionesAsistencia, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function RegistrarSalida($idAsistencia, $fechaAsistencia, $horaAsistencia, $lat, $lng, $observacionesAsistencia)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("update `asistencia` set `fecha_s_asistencia` = :fechaAsistencia,`hora_s_asistencia` = :horaAsistencia,`latitud_s_asistencia` = :lat,`longitud_s_asistencia` = :lng,`observaciones_s_asistencia` = :observacionesAsistencia where id_asistencia = :idAsistencia;");

        $stmt->bindValue(":fechaAsistencia", $fechaAsistencia, PDO::PARAM_STR);
        $stmt->bindValue(":horaAsistencia", $horaAsistencia, PDO::PARAM_STR);
        $stmt->bindValue(":lat", $lat, PDO::PARAM_STR);
        $stmt->bindValue(":lng", $lng, PDO::PARAM_STR);
        $stmt->bindValue(":observacionesAsistencia", $observacionesAsistencia, PDO::PARAM_STR);
        $stmt->bindValue(":idAsistencia", $idAsistencia, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function CountAsistencia($personaId, $oficinaId, $fechaAsistencia)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as contador from `asistencia` where persona_id = :personaId and oficina_id = :oficinaId and fecha_e_asistencia = :fechaAsistencia;");
        $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
        $stmt->bindValue(":oficinaId", $oficinaId, PDO::PARAM_STR);
        $stmt->bindValue(":fechaAsistencia", $fechaAsistencia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
