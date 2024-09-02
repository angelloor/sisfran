<?php
    require('../lib/connectios/MySQLPDO.php');

    class Categoria{

        public function ConsultarTodo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_categoria, nombre_categoria, descripcion_categoria from categoria");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idCategoria){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_categoria, nombre_categoria, descripcion_categoria from categoria where id_categoria = :idCategoria");
            $stmt->bindValue(":idCategoria", $idCategoria, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idCategoria){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_categoria, nombre_categoria, descripcion_categoria from categoria where nombre_categoria like :patron");
            $stmt->bindValue(":patron", "%".$idCategoria."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreCategoria, $descripcionCategoria){
            $connection = new MySQLPDO();

            $stmt = $connection->prepare("select count(*) from categoria where nombre_categoria = :nombreCategoria;");
            $stmt->bindValue(":nombreCategoria", $nombreCategoria, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "La categoria ya existe";
            }else{
                $stmt = $connection->prepare("insert into `categoria` (`nombre_categoria`, `descripcion_categoria`)
                                            values (:nombreCategoria, :descripcionCategoria);");
                $stmt->bindValue(":nombreCategoria",$nombreCategoria, PDO::PARAM_STR);
                $stmt->bindValue(":descripcionCategoria",$descripcionCategoria, PDO::PARAM_STR);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idCategoria,$nombreCategoria, $descripcionCategoria){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) from categoria where nombre_categoria = :nombreCategoria;");
            $stmt->bindValue(":nombreCategoria", $nombreCategoria, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            $stmt = $connection->prepare("select nombre_categoria from categoria where id_categoria = :idCategoria;");
            $stmt->bindValue(":idCategoria", $idCategoria, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoriaBD = $results['nombre_categoria'];

            if ($nombreCategoria == $categoriaBD) {
                $stmt = $connection->prepare("update `categoria` 
                                                set `nombre_categoria` = :nombreCategoria,
                                                `descripcion_categoria` = :descripcionCategoria
                                                where `id_categoria` = :idCategoria;");
                    $stmt->bindValue(":nombreCategoria",$nombreCategoria, PDO::PARAM_STR);
                    $stmt->bindValue(":descripcionCategoria",$descripcionCategoria, PDO::PARAM_STR);
                    $stmt->bindValue(":idCategoria",$idCategoria,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
            }else{
                if($existeRegistro >= 1){
                    return "La categoria ya existe";
                }else{
                    $stmt = $connection->prepare("update `categoria` 
                                                set `nombre_categoria` = :nombreCategoria,
                                                `descripcion_categoria` = :descripcionCategoria
                                                where `id_categoria` = :idCategoria;");
                    $stmt->bindValue(":nombreCategoria",$nombreCategoria, PDO::PARAM_STR);
                    $stmt->bindValue(":descripcionCategoria",$descripcionCategoria, PDO::PARAM_STR);
                    $stmt->bindValue(":idCategoria",$idCategoria,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idCategoria){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("delete from categoria where id_categoria = :idCategoria");
            $stmt->bindValue(":idCategoria",$idCategoria, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idCategoria){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) as registros from activo where categoria_id = :idCategoria;");
            $stmt->bindValue(":idCategoria",$idCategoria, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>