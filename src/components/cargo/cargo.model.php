<?php
require('../../lib/connectios/MySQLPDO.php');

class Cargo
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_cargo, nombre_cargo from cargo order by nombre_cargo asc");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idCargo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_cargo, nombre_cargo from cargo where id_cargo = :idCargo");
        $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idCargo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_cargo, nombre_cargo from cargo where nombre_cargo like :patron order by nombre_cargo asc;");
        $stmt->bindValue(":patron", "%" . $idCargo . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($nombreCargo)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from cargo where nombre_cargo = :nombreCargo");
        $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "El cargo ya existe ";
        } else {
            $stmt = $connection->prepare("insert into `cargo` (`nombre_cargo`) 
                                            values (:nombreCargo);");
            $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idCargo, $nombreCargo)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from cargo where nombre_cargo = :nombreCargo");
        $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_cargo from cargo where id_cargo = :idCargo;");
        $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $cargoBD = $results['nombre_cargo'];

        if ($nombreCargo == $cargoBD) {
            $stmt = $connection->prepare("update `cargo` 
                                    set `nombre_cargo` = :nombreCargo
                                    where `id_cargo` = :idCargo;");
            $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
            $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al modificar la información";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "El cargo ya existe ";
            } else {
                $stmt = $connection->prepare("update `cargo` 
                                    set `nombre_cargo` = :nombreCargo
                                    where `id_cargo` = :idCargo;");
                $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
                $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }
    }

    public function Eliminar($idCargo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("delete from cargo where id_cargo = :idCargo");
        $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }

    public function consultarRegistros($idCargo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from persona where cargo_id = :idCargo;");
        $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function listarCargo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_cargo, nombre_cargo from cargo order by nombre_cargo asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
