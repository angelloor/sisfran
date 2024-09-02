<?php
    require('../lib/connectios/MySQLPDO.php');

    class Funcionario{

        public function ConsultarTodo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select p.id_persona, p.cedula, p.nombre_persona, p.direccion, p.telefono, c.nombre_cargo, u.nombre_unidad from persona p inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad order by p.nombre_persona asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idFuncionario){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select p.id_persona, p.cedula, p.nombre_persona, p.direccion, p.telefono, c.nombre_cargo, u.nombre_unidad from persona p inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad where id_persona = :idFuncionario");
            $stmt->bindValue(":idFuncionario", $idFuncionario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idFuncionario){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select p.id_persona, p.cedula, p.nombre_persona, p.direccion, p.telefono, c.nombre_cargo, u.nombre_unidad from persona p inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad where p.nombre_persona like :patron order by p.nombre_persona asc");
            $stmt->bindValue(":patron", "%".$idFuncionario."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function Guardar($cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select id_cargo from cargo where nombre_cargo = :cargoFuncionario");
            $stmt->bindValue(":cargoFuncionario", $cargoFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCargo = $results['id_cargo'];

            $stmt = $connection->prepare("select count(*) from persona where cedula = :cedulaFuncionario");
            $stmt->bindValue(":cedulaFuncionario", $cedulaFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "El Funcionario ya existe ";
            }else{
                $stmt = $connection->prepare("select id_unidad from unidad where nombre_unidad = :unidadFuncionario");
                $stmt->bindValue(":unidadFuncionario", $unidadFuncionario, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idUnidad = $results['id_unidad'];
                
                $stmt = $connection->prepare("insert into `persona` (`cedula`,`nombre_persona`,`direccion`,`telefono`,`cargo_id`,`unidad_id`) 
                                            values (:cedulaFuncionario, :nombreFuncionario, :direccionFuncionario, :telefonoFuncionario, :cargoFuncionario, :unidadFuncionario);");
                $stmt->bindValue(":cedulaFuncionario",$cedulaFuncionario, PDO::PARAM_INT);
                $stmt->bindValue(":nombreFuncionario",$nombreFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":direccionFuncionario",$direccionFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":telefonoFuncionario",$telefonoFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":cargoFuncionario",$idCargo, PDO::PARAM_INT);
                $stmt->bindValue(":unidadFuncionario",$idUnidad, PDO::PARAM_INT);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idFuncionario,$cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario){
            $connection = new MySQLPDO();

            $stmt = $connection->prepare("select count(*) from persona where cedula = :cedulaFuncionario");
            $stmt->bindValue(":cedulaFuncionario", $cedulaFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            $stmt = $connection->prepare("select cedula from persona where id_persona = :idFuncionario;");
            $stmt->bindValue(":idFuncionario", $idFuncionario, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $cedulaBD = $results['cedula'];

            if ($cedulaFuncionario == $cedulaBD) {
                $stmt = $connection->prepare("select id_cargo from cargo where nombre_cargo = :cargoFuncionario");
                    $stmt->bindValue(":cargoFuncionario", $cargoFuncionario, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCargo = $results['id_cargo'];
    
                    $stmt = $connection->prepare("select id_unidad from unidad where nombre_unidad = :unidadFuncionario");
                    $stmt->bindValue(":unidadFuncionario", $unidadFuncionario, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idUnidad = $results['id_unidad'];
                
                    $stmt = $connection->prepare("update `persona` 
                                                set `cedula` = :cedulaFuncionario, 
                                                `nombre_persona` = :nombreFuncionario,
                                                `direccion` = :direccionFuncionario,
                                                `telefono` = :telefonoFuncionario,
                                                `cargo_id` = :cargoFuncionario,
                                                `unidad_id` = :unidadFuncionario
                                                where `id_persona` = :idFuncionario;");
                    $stmt->bindValue(":cedulaFuncionario",$cedulaFuncionario, PDO::PARAM_INT);
                    $stmt->bindValue(":nombreFuncionario",$nombreFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":direccionFuncionario",$direccionFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":telefonoFuncionario",$telefonoFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":cargoFuncionario",$idCargo, PDO::PARAM_INT);
                    $stmt->bindValue(":unidadFuncionario",$idUnidad, PDO::PARAM_INT);
                    $stmt->bindValue(":idFuncionario",$idFuncionario,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
            }else{
                if($existeRegistro >= 1){
                    return "El numero de cedula ya esta asignado a un funcionario";
                }else{
                    $stmt = $connection->prepare("select id_cargo from cargo where nombre_cargo = :cargoFuncionario");
                    $stmt->bindValue(":cargoFuncionario", $cargoFuncionario, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCargo = $results['id_cargo'];
    
                    $stmt = $connection->prepare("select id_unidad from unidad where nombre_unidad = :unidadFuncionario");
                    $stmt->bindValue(":unidadFuncionario", $unidadFuncionario, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idUnidad = $results['id_unidad'];
                
                    $stmt = $connection->prepare("update `persona` 
                                                set `cedula` = :cedulaFuncionario, 
                                                `nombre_persona` = :nombreFuncionario,
                                                `direccion` = :direccionFuncionario,
                                                `telefono` = :telefonoFuncionario,
                                                `cargo_id` = :cargoFuncionario,
                                                `unidad_id` = :unidadFuncionario
                                                where `id_persona` = :idFuncionario;");
                    $stmt->bindValue(":cedulaFuncionario",$cedulaFuncionario, PDO::PARAM_INT);
                    $stmt->bindValue(":nombreFuncionario",$nombreFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":direccionFuncionario",$direccionFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":telefonoFuncionario",$telefonoFuncionario, PDO::PARAM_STR);
                    $stmt->bindValue(":cargoFuncionario",$idCargo, PDO::PARAM_INT);
                    $stmt->bindValue(":unidadFuncionario",$idUnidad, PDO::PARAM_INT);
                    $stmt->bindValue(":idFuncionario",$idFuncionario,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idFuncionario){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("delete from persona where id_persona = :idFuncionario");
            $stmt->bindValue(":idFuncionario",$idFuncionario, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function listarCargo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_cargo from cargo order by nombre_cargo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarUnidad(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_unidad from unidad order by nombre_unidad asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function consultarRegistros($idFuncionario){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) as registros from entrega_recepcion where persona_id = :idFuncionario;");
            $stmt->bindValue(":idFuncionario",$idFuncionario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>