<?php
require('../../lib/connectios/MySQLPDO.php');

class Oficina
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_oficina, nombre_oficina, descripcion_oficina, latitud_oficina, longitud_oficina, radio_valido_metros from oficina");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_oficina, nombre_oficina, descripcion_oficina, latitud_oficina, longitud_oficina, radio_valido_metros from oficina where id_oficina = :idOficina");
        $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_oficina, nombre_oficina, descripcion_oficina, latitud_oficina, longitud_oficina, radio_valido_metros from oficina where nombre_oficina like :patron");
        $stmt->bindValue(":patron", "%" . $idOficina . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($nombreOficina, $descripcionOficina, $lat, $lng, $radioValidoMetros)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from oficina where nombre_oficina = :nombreOficina;");
        $stmt->bindValue(":nombreOficina", $nombreOficina, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "La oficina ya existe";
        } else {
            $stmt = $connection->prepare("insert into `oficina` (`nombre_oficina`,`descripcion_oficina`,`latitud_oficina`,`longitud_oficina`,`radio_valido_metros`) 
                                            values (:nombreOficina, :descripcionOficina, :lat, :lng,  :radioValidoMetros);");
            $stmt->bindValue(":nombreOficina", $nombreOficina, PDO::PARAM_STR);
            $stmt->bindValue(":descripcionOficina", $descripcionOficina, PDO::PARAM_STR);
            $stmt->bindValue(":lat", $lat, PDO::PARAM_STR);
            $stmt->bindValue(":lng", $lng, PDO::PARAM_STR);
            $stmt->bindValue(":radioValidoMetros", $radioValidoMetros, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idOficina, $nombreOficina, $descripcionOficina, $lat, $lng, $radioValidoMetros)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from oficina where nombre_oficina = :nombreOficina;");
        $stmt->bindValue(":nombreOficina", $nombreOficina, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_oficina from oficina where id_oficina = :idOficina;");
        $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $oficinaBD = $results['nombre_oficina'];

        if ($nombreOficina == $oficinaBD) {
            $stmt = $connection->prepare("update `oficina` 
                                            set 
                                            `nombre_oficina` = :nombreOficina,
                                            `descripcion_oficina` = :descripcionOficina,
                                            `latitud_oficina` = :lat,
                                            `longitud_oficina` = :lng,
                                            `radio_valido_metros` = :radioValidoMetros
                                            where `id_oficina` = :idOficina;");
            $stmt->bindValue(":nombreOficina", $nombreOficina, PDO::PARAM_STR);
            $stmt->bindValue(":descripcionOficina", $descripcionOficina, PDO::PARAM_STR);
            $stmt->bindValue(":lat", $lat, PDO::PARAM_STR);
            $stmt->bindValue(":lng", $lng, PDO::PARAM_STR);
            $stmt->bindValue(":radioValidoMetros", $radioValidoMetros, PDO::PARAM_INT);
            $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "La oficina ya existe";
            } else {
                $stmt = $connection->prepare("update `oficina` 
                                                set
                                                `nombre_oficina` = :nombreOficina,
                                                `descripcion_oficina` = :descripcionOficina,
                                                `latitud_oficina` = :lat,
                                                `longitud_oficina` = :lng,
                                                `radio_valido_metros` = :radioValidoMetros
                                                where `id_oficina` = :idOficina;");
                $stmt->bindValue(":nombreOficina", $nombreOficina, PDO::PARAM_STR);
                $stmt->bindValue(":descripcionOficina", $descripcionOficina, PDO::PARAM_STR);
                $stmt->bindValue(":lat", $lat, PDO::PARAM_STR);
                $stmt->bindValue(":lng", $lng, PDO::PARAM_STR);
                $stmt->bindValue(":radioValidoMetros", $radioValidoMetros, PDO::PARAM_INT);
                $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }
    }

    public function Eliminar($idOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from oficina where id_oficina = :idOficina");
        $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function consultarRegistros($idOficina)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from horario_oficina where oficina_id = :idOficina;");
        $stmt->bindValue(":idOficina", $idOficina, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
