<?php
    require('../lib/connectios/MySQLPDO.php');

    class Sistema{

        public function cargarSistemas(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_sistema, direccion_sistema from sistema");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function listarFuncionario(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_persona from persona order by nombre_persona asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>