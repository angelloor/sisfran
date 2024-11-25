<?php
require('../../lib/connectios/MySQLPDO.php');

class Permiso
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_permiso, persona_id, nombre_persona, fecha_inicio_permiso, fecha_fin_permiso, estado_permiso, documentacion_permiso, observaciones_permiso from permiso p inner join persona per on p.persona_id = per.id_persona order by id_permiso desc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idPermiso)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_permiso, persona_id, nombre_persona, fecha_inicio_permiso, fecha_fin_permiso, estado_permiso, documentacion_permiso, observaciones_permiso from permiso p inner join persona per on p.persona_id = per.id_persona where id_permiso = :idPermiso order by id_permiso desc;");
        $stmt->bindValue(":idPermiso", $idPermiso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdPersona($idPersona)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_permiso, persona_id, nombre_persona, fecha_inicio_permiso, fecha_fin_permiso, estado_permiso, documentacion_permiso, observaciones_permiso from permiso p inner join persona per on p.persona_id = per.id_persona where persona_id = :idPersona order by id_permiso desc;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idPermiso)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_permiso, persona_id, nombre_persona, fecha_inicio_permiso, fecha_fin_permiso, estado_permiso, documentacion_permiso, observaciones_permiso from permiso p inner join persona per on p.persona_id = per.id_persona where nombre_persona like :patron");
        $stmt->bindValue(":patron", "%" . $idPermiso . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($idPersona, $fechaInicio, $fechaFin, $estado, $documentacion, $observaciones)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("insert into `permiso` (`persona_id`,`fecha_inicio_permiso`,`fecha_fin_permiso`,`estado_permiso`, `documentacion_permiso`, `observaciones_permiso`) 
                                            values (:idPersona, :fechaInicio, :fechaFin, :estado,  :documentacion, :observaciones);");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindValue(":documentacion", $documentacion, PDO::PARAM_STR);
        $stmt->bindValue(":observaciones", $observaciones, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Modificar($idPermiso, $fechaInicio, $fechaFin, $estado, $observaciones)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("update `permiso` 
        set
        `fecha_inicio_permiso` = :fechaInicio,
        `fecha_fin_permiso` = :fechaFin,
        `estado_permiso` = :estado,
        `observaciones_permiso` = :observaciones
        where `id_permiso` = :idPermiso;");
        $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFin", $fechaFin, PDO::PARAM_STR);
        $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindValue(":observaciones", $observaciones, PDO::PARAM_STR);
        $stmt->bindValue(":idPermiso", $idPermiso, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Eliminar($idPermiso)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from permiso where id_permiso = :idPermiso");
        $stmt->bindValue(":idPermiso", $idPermiso, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }
}
