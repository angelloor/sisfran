<?php
require('../../lib/connectios/MySQLPDO.php');

class Color
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_color, nombre_color from color");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_color, nombre_color from color where id_color = :idColor");
        $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_color, nombre_color from color where nombre_color like :patron");
        $stmt->bindValue(":patron", "%" . $idColor . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($nombreColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from color where nombre_color = :nombreColor;");
        $stmt->bindValue(":nombreColor", $nombreColor, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "El color ya existe";
        } else {
            $stmt = $connection->prepare("insert into `color` (`nombre_color`) 
                                values (:nombreColor);");
            $stmt->bindValue(":nombreColor", $nombreColor, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idColor, $nombreColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from color where nombre_color = :nombreColor;");
        $stmt->bindValue(":nombreColor", $nombreColor, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_color from color where id_color = :idColor;");
        $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $colorBD = $results['nombre_color'];

        if ($nombreColor == $colorBD) {
            $stmt = $connection->prepare("update `color` 
                                set `nombre_color` = :nombreColor
                                where `id_color` = :idColor;");
            $stmt->bindValue(":nombreColor", $nombreColor, PDO::PARAM_STR);
            $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al modificar la información";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "El color ya existe";
            } else {
                $stmt = $connection->prepare("update `color` 
                                    set `nombre_color` = :nombreColor
                                    where `id_color` = :idColor;");
                $stmt->bindValue(":nombreColor", $nombreColor, PDO::PARAM_STR);
                $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }
    }

    public function Eliminar($idColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from color where id_color = :idColor");
        $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }

    public function consultarRegistros($idColor)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from activo where color_id = :idColor;");
        $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function listarColor()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_color, nombre_color from color order by nombre_color asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
