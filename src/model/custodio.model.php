<?php
    require('../lib/connectios/MySQLPDO.php');

    class Custodio{

        public function ConsultarTodo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona order by c.id_custodio asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idCustodio){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona where c.id_custodio = :idCustodio");
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idCustodio){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona where p.nombre_persona like :patron");
            $stmt->bindValue(":patron", "%".$idCustodio."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarFuncionarios(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_persona from persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($personaId){
            $connection = new MySQLPDO();

            $stmt = $connection->prepare("select count(*) from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :personaId;");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "El custodio ya existe";
            }else{
                $stmt = $connection->prepare("select id_persona from persona where nombre_persona = :personaId");
                $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idp = $results['id_persona'];

                $stmt = $connection->prepare("insert into `custodio` (`persona_id`) 
                                            values (:nombreCustodio);");
                $stmt->bindValue(":nombreCustodio",$idp, PDO::PARAM_INT);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idCustodio,$nombreCustodio){

            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :nombreCustodio;");
            $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            $stmt = $connection->prepare("select p.nombre_persona from custodio cu inner join persona p on cu.persona_id = p.id_persona where cu.id_custodio = :idCustodio;");
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $custodioBD = $results['nombre_persona'];

            if ($nombreCustodio == $custodioBD) {
                $stmt = $connection->prepare("select id_persona from persona where nombre_persona = :nombreCustodio");
                $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idp = $results['id_persona'];

                $stmt = $connection->prepare("update `custodio` 
                                            set `persona_id` = :idPersona
                                            where `id_custodio` = :idCustodio;");
                $stmt->bindValue(":idPersona",$idp,PDO::PARAM_INT); 
                $stmt->bindValue(":idCustodio",$idCustodio,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }else{
                if($existeRegistro >= 1){
                    return "El custodio ya existe";
                }else{
                    $stmt = $connection->prepare("select id_persona from persona where nombre_persona = :nombreCustodio");
                    $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idp = $results['id_persona'];
    
                    $stmt = $connection->prepare("update `custodio` 
                                                set `persona_id` = :idPersona
                                                where `id_custodio` = :idCustodio;");
                    $stmt->bindValue(":idPersona",$idp,PDO::PARAM_INT); 
                    $stmt->bindValue(":idCustodio",$idCustodio,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idCustodio){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("delete from custodio where id_custodio = :idCustodio");
            $stmt->bindValue(":idCustodio",$idCustodio, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idCustodio){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select count(*) as registros from entrega_recepcion where custodio_id = :idCustodio;");
            $stmt->bindValue(":idCustodio",$idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>