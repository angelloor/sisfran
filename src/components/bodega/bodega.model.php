<?php
require('../../lib/connectios/MySQLPDO.php');

class Bodega
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, b.persona_id as persona_id, p.nombre_persona from bodega b inner join persona p on b.persona_id = p.id_persona order by b.id_bodega asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idBodega)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, b.persona_id as persona_id, p.nombre_persona from bodega b inner join persona p on b.persona_id = p.id_persona where b.id_bodega = :idBodega");
        $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idBodega)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, b.persona_id as persona_id, p.nombre_persona from bodega b inner join persona p on b.persona_id = p.id_persona where b.nombre_bodega like :patron");
        $stmt->bindValue(":patron", "%" . $idBodega . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($nombreBodega, $ubicacion, $personaId)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from bodega where nombre_bodega = :nombreBodega;");
        $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "La bodega ya existe";
        } else {
            $stmt = $connection->prepare("insert into `bodega` (`nombre_bodega`,`ubicacion`,`persona_id`) values (:nombreBodega, :ubicacion, :personaId);");
            $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
            $stmt->bindValue(":ubicacion", $ubicacion, PDO::PARAM_STR);
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idBodega, $nombreBodega, $ubicacion, $personaId)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from bodega where nombre_bodega = :nombreBodega;");
        $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_bodega from bodega where id_bodega = :idBodega;");
        $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $bodegaBD = $results['nombre_bodega'];

        if ($nombreBodega == $bodegaBD) {
            $stmt = $connection->prepare("update `bodega` 
                                            set `nombre_bodega` = :nombreBodega,
                                            `ubicacion` = :ubicacion,
                                            `persona_id` = :personaId
                                            where `id_bodega` = :idBodega;");
            $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
            $stmt->bindValue(":ubicacion", $ubicacion, PDO::PARAM_STR);
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
            $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al modificar la información $personaId";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "La bodega ya existe";
            } else {
                $stmt = $connection->prepare("update `bodega` 
                                                set `nombre_bodega` = :nombreBodega,
                                                `ubicacion` = :ubicacion,
                                                `persona_id` = :personaId
                                                where `id_bodega` = :idBodega;");
                $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
                $stmt->bindValue(":ubicacion", $ubicacion, PDO::PARAM_STR);
                $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
                $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información $personaId";
                }
            }
        }
    }

    public function Eliminar($idBodega)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from bodega where id_bodega = :idBodega");
        $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }

    public function consultarRegistros($idBodega)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from activo where bodega_id = :idBodega;");
        $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function listarBodega()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_bodega, nombre_bodega from bodega order by nombre_bodega asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
