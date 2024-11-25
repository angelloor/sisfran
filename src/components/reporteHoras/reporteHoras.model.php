<?php
require('../../lib/connectios/MySQLPDO.php');

class reporteHoras
{

    public function cargaInicial()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_asistencia, nombre_persona, nombre_oficina, fecha_e_asistencia, fecha_s_asistencia, hora_e_asistencia, hora_s_asistencia from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id =  o.id_oficina order by a.fecha_e_asistencia desc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultar($idPersona, $fechaInicio, $fechaFin)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_asistencia, persona_id, nombre_persona, nombre_oficina, fecha_e_asistencia, fecha_s_asistencia, hora_e_asistencia, hora_s_asistencia from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id =  o.id_oficina where persona_id = :idPersona and fecha_e_asistencia between :fechaInicio and :fechaFin order by a.fecha_e_asistencia desc;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFin", $fechaFin, PDO::PARAM_STR);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
}


