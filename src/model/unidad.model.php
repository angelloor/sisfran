<?php
    require('../lib/connectios/MySQLPDO.php');

    class Unidad{
        
        public function ConsultarTodo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_unidad, nombre_unidad from unidad order by nombre_unidad asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idUnidad){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_unidad, nombre_unidad from unidad where id_unidad = :idUnidad");
            $stmt->bindValue(":idUnidad", $idUnidad, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idUnidad){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_unidad, nombre_unidad from unidad where nombre_unidad like :patron order by nombre_unidad asc");
            $stmt->bindValue(":patron", "%".$idUnidad."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreUnidad){
            $connection = new MySQLPDO();

            $stmt = $connection->prepare("select count(*) from unidad where nombre_unidad = :nombreUnidad");
            $stmt->bindValue(":nombreUnidad", $nombreUnidad, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "La unidad ya existe ";
            }else{
                $stmt = $connection->prepare("insert into `unidad` (`nombre_unidad`) 
                                            values (:nombreUnidad);");
                $stmt->bindValue(":nombreUnidad",$nombreUnidad, PDO::PARAM_STR);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idUnidad,$nombreUnidad){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) from unidad where nombre_unidad = :nombreUnidad");
            $stmt->bindValue(":nombreUnidad", $nombreUnidad, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            $stmt = $connection->prepare("select nombre_unidad from unidad where id_unidad = :idUnidad;");
            $stmt->bindValue(":idUnidad", $idUnidad, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $unidadBD = $results['nombre_unidad'];

            if ($nombreUnidad == $unidadBD) {
                $stmt = $connection->prepare("update `unidad` 
                                set `nombre_unidad` = :nombreUnidad
                                where `id_unidad` = :idUnidad;");
                $stmt->bindValue(":nombreUnidad",$nombreUnidad,PDO::PARAM_STR); 
                $stmt->bindValue(":idUnidad",$idUnidad,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }else{
                if($existeRegistro >= 1){
                    return "La unidad ya existe ";
                }else{
                    $stmt = $connection->prepare("update `unidad` 
                                    set `nombre_unidad` = :nombreUnidad
                                    where `id_unidad` = :idUnidad;");
                    $stmt->bindValue(":nombreUnidad",$nombreUnidad,PDO::PARAM_STR); 
                    $stmt->bindValue(":idUnidad",$idUnidad,PDO::PARAM_INT); 
                    if($stmt->execute()){
                    return "OK";
                    }else{
                    return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idUnidad){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("delete from unidad where id_unidad = :idUnidad");
            $stmt->bindValue(":idUnidad",$idUnidad, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idUnidad){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) as registros from persona where unidad_id = :idUnidad;");
            $stmt->bindValue(":idUnidad",$idUnidad, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>