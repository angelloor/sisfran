<?php
require('../../lib/connectios/MySQLPDO.php');

class Sistema
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_sistema, nombre_sistema, direccion_sistema from sistema");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idSistema)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_sistema, nombre_sistema, direccion_sistema from sistema where id_sistema = :idSistema");
        $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idSistema)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_sistema, nombre_sistema, direccion_sistema from sistema where nombre_sistema like :patron");
        $stmt->bindValue(":patron", "%" . $idSistema . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($nombreSistema, $direccion)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from sistema where nombre_sistema = :nombreSistema;");
        $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "El sistema ya existe";
        } else {
            $stmt = $connection->prepare("insert into `sistema` (`nombre_sistema`,`direccion_sistema`) 
                                values (:nombreSistema,:direccionSistema);");
            $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
            $stmt->bindValue(":direccionSistema", $direccion, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idSistema, $nombreSistema, $direccion)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) from sistema where nombre_sistema = :nombreSistema;");
        $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_sistema from sistema where id_sistema = :idSistema;");
        $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $sistemaBD = $results['nombre_sistema'];

        if ($nombreSistema == $sistemaBD) {
            $stmt = $connection->prepare("update `sistema` 
                                    set `nombre_sistema` = :nombreSistema,
                                    `direccion_sistema` = :direccionSistema
                                    where `id_sistema` = :idSistema;");
            $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
            $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
            $stmt->bindValue(":direccionSistema", $direccion, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al modificar la información";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "El sistema ya existe";
            } else {
                $stmt = $connection->prepare("update `sistema` 
                                    set `nombre_sistema` = :nombreSistema,
                                    `direccion_sistema` = :direccionSistema
                                    where `id_sistema` = :idSistema;");
                $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
                $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
                $stmt->bindValue(":direccionSistema", $direccion, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }
    }

    public function Eliminar($idSistema)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from sistema where id_sistema = :idSistema");
        $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }

    public function cargarSistemas()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_sistema, nombre_sistema, direccion_sistema from sistema order by nombre_sistema asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
