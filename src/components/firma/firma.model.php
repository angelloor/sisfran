<?php
require('../../lib/connectios/MySQLPDO.php');

class firma
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select f.id_firma ,p.nombre_persona, f.denominacion from firma f inner join persona p on f.persona_id = p.id_persona;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idFirma)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select f.id_firma ,p.nombre_persona, f.denominacion from firma f inner join persona p on f.persona_id = p.id_persona where f.id_firma = :idFirma;");
        $stmt->bindValue(":idFirma", $idFirma, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function Modificar($idFirma, $nombrePersona, $denominacion)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_persona from persona where nombre_persona = :nombrePersona;");
        $stmt->bindValue(":nombrePersona", $nombrePersona, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idPersona = $results['id_persona'];

        $stmt = $connection->prepare("update `firma` set `persona_id` = :idPersona, `denominacion` = :denominacion where `id_firma` = :idFirma;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":idFirma", $idFirma, PDO::PARAM_INT);
        $stmt->bindValue(":denominacion", $denominacion, PDO::PARAM_STR);

        if (($stmt->execute())) {
            return "OK";
        } else {
            return "Error: se ha generado un error al modificar la información";
        }
    }

}
