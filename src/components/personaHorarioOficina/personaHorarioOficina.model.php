<?php
require('../../lib/connectios/MySQLPDO.php');

class PersonaHorarioOficina
{

    public function ConsultarPorIdPersona($id_persona)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select pho.id_persona_horario_oficina, pho.persona_id, pho.oficina_id, pho.horario_oficina_id, pho.fecha_persona_horario_oficina, pho.nota_persona_horario_oficina, ho.hora_entrada, ho.hora_salida, o.id_oficina,o.nombre_oficina from persona_horario_oficina pho inner join horario_oficina ho on pho.horario_oficina_id =  ho.id_horario_oficina inner join oficina o on pho.oficina_id = o.id_oficina where pho.persona_id = :idPersona order by pho.fecha_persona_horario_oficina asc;");
        $stmt->bindValue(":idPersona", $id_persona, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($id_persona_horario_oficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select pho.id_persona_horario_oficina, pho.persona_id, pho.oficina_id, pho.horario_oficina_id, pho.fecha_persona_horario_oficina, pho.nota_persona_horario_oficina, ho.hora_entrada, ho.hora_salida, o.id_oficina,o.nombre_oficina from persona_horario_oficina pho inner join horario_oficina ho on pho.horario_oficina_id =  ho.id_horario_oficina inner join oficina o on pho.oficina_id = o.id_oficina where pho.id_persona_horario_oficina = :idPersonaHorarioOficina;");
        $stmt->bindValue(":idPersonaHorarioOficina", $id_persona_horario_oficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function Guardar($persona_id, $oficina_id, $horario_oficina_id, $fecha_persona_horario_oficina, $nota_persona_horario_oficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("insert into `persona_horario_oficina` (`persona_id`, `oficina_id`,`horario_oficina_id`,`fecha_persona_horario_oficina`, `nota_persona_horario_oficina`) 
                                            values (:idPersona, :idOficina,:idHorarioOficina, :fechaPersonaHorarioOficina, :notaPersonaHorarioOficina);");
        $stmt->bindValue(":idPersona", $persona_id, PDO::PARAM_INT);
        $stmt->bindValue(":idOficina", $oficina_id, PDO::PARAM_INT);
        $stmt->bindValue(":idHorarioOficina", $horario_oficina_id, PDO::PARAM_INT);
        $stmt->bindValue(":fechaPersonaHorarioOficina", $fecha_persona_horario_oficina, PDO::PARAM_STR);
        $stmt->bindValue(":notaPersonaHorarioOficina", $nota_persona_horario_oficina, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function modificar($id_persona_horario_oficina, $persona_id, $oficina_id, $horario_oficina_id, $fecha_persona_horario_oficina, $nota_persona_horario_oficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("update `persona_horario_oficina` 
                                            set 
                                            `persona_id` = :idPersona,
                                            `oficina_id` = :idOficina,
                                            `horario_oficina_id` = :idHorarioOficina,
                                            `fecha_persona_horario_oficina` = :fechaPersonaHorarioOficina,
                                            `nota_persona_horario_oficina` = :notaPersonaHorarioOficina
                                            where `id_persona_horario_oficina` = :idPersonaHorarioOficina;");
        $stmt->bindValue(":idPersona", $persona_id, PDO::PARAM_INT);
        $stmt->bindValue(":idOficina", $oficina_id, PDO::PARAM_INT);
        $stmt->bindValue(":idHorarioOficina", $horario_oficina_id, PDO::PARAM_INT);
        $stmt->bindValue(":fechaPersonaHorarioOficina", $fecha_persona_horario_oficina, PDO::PARAM_STR);
        $stmt->bindValue(":notaPersonaHorarioOficina", $nota_persona_horario_oficina, PDO::PARAM_STR);
        $stmt->bindValue(":idPersonaHorarioOficina", $id_persona_horario_oficina, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Eliminar($id_persona_horario_oficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from persona_horario_oficina where id_persona_horario_oficina = :idPersonaHorarioOficina");
        $stmt->bindValue(":idPersonaHorarioOficina", $id_persona_horario_oficina, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function listarOficina()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_oficina, nombre_oficina from oficina order by nombre_oficina asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarHorarioOficina($id_oficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_horario_oficina, oficina_id, hora_entrada, hora_salida, salto_dia from horario_oficina where oficina_id = :idOficina order by id_horario_oficina asc;");
        $stmt->bindValue(":idOficina", $id_oficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($id_persona, $fecha)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select pho.id_persona_horario_oficina, pho.persona_id, pho.oficina_id, pho.horario_oficina_id, pho.fecha_persona_horario_oficina, pho.nota_persona_horario_oficina, ho.hora_entrada, ho.hora_salida, o.id_oficina,o.nombre_oficina from persona_horario_oficina pho inner join horario_oficina ho on pho.horario_oficina_id =  ho.id_horario_oficina inner join oficina o on pho.oficina_id = o.id_oficina where pho.persona_id = :idPersona and pho.fecha_persona_horario_oficina = :fecha;");
        $stmt->bindValue(":idPersona", $id_persona, PDO::PARAM_INT);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarOficinaByFuncionarioDate($idPersona, $fechaActual)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select pho.id_persona_horario_oficina, pho.fecha_persona_horario_oficina, pho.oficina_id, o.id_oficina, o.nombre_oficina from persona_horario_oficina pho inner join oficina o on pho.oficina_id = o.id_oficina where pho.persona_id = :idPersona and pho.fecha_persona_horario_oficina = :fechaActual;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":fechaActual", $fechaActual, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
