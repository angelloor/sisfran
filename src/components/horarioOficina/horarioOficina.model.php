<?php
require('../../lib/connectios/MySQLPDO.php');

class HorarioOficina
{

    public function ConsultarPorIdOficina($idOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_horario_oficina, oficina_id, hora_entrada, hora_salida, salto_dia from horario_oficina where oficina_id = :idOficina;");
        $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idHorarioOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_horario_oficina, oficina_id, hora_entrada, hora_salida, salto_dia from horario_oficina where id_horario_oficina = :idHorarioOficina");
        $stmt->bindValue(":idHorarioOficina", $idHorarioOficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function Guardar($id_oficina, $hora_entrada, $hora_salida, $salto_dia)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("insert into `horario_oficina` (`oficina_id`,`hora_entrada`,`hora_salida`,`salto_dia`) 
                                            values (:oficina_id, :hora_entrada, :hora_salida, :salto_dia);");
        $stmt->bindValue(":oficina_id", $id_oficina, PDO::PARAM_INT);
        $stmt->bindValue(":hora_entrada", $hora_entrada, PDO::PARAM_STR);
        $stmt->bindValue(":hora_salida", $hora_salida, PDO::PARAM_STR);
        $stmt->bindValue(":salto_dia", $salto_dia, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Modificar($id_horario_oficina, $id_oficina, $hora_entrada, $hora_salida, $salto_dia)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("update `horario_oficina` 
                                            set 
                                            `OFICINA_ID` = :oficina_id,
                                            `HORA_ENTRADA` = :hora_entrada,
                                            `HORA_SALIDA` = :hora_salida,
                                            `SALTO_DIA` = :salto_dia
                                            where `id_horario_oficina` = :idHorarioOficina;");
        $stmt->bindValue(":oficina_id", $id_oficina, PDO::PARAM_INT);
        $stmt->bindValue(":hora_entrada", $hora_entrada, PDO::PARAM_STR);
        $stmt->bindValue(":hora_salida", $hora_salida, PDO::PARAM_STR);
        $stmt->bindValue(":salto_dia", $salto_dia, PDO::PARAM_STR);
        $stmt->bindValue(":idHorarioOficina", $id_horario_oficina, PDO::PARAM_INT);



        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Eliminar($idHorarioOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from horario_oficina where id_horario_oficina = :idHorarioOficina");
        $stmt->bindValue(":idHorarioOficina", $idHorarioOficina, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function consultarRegistros($idHorarioOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from persona_horario_oficina where horario_oficina_id = :idHorarioOficina;");
        $stmt->bindValue(":idHorarioOficina", $idHorarioOficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
