<?php
    require('../lib/connectios/MySQLPDO.php');

    class RolUsuario{

        public function ConsultarTodo(){
            $connection = new MySQLPDO();
            $stmt = $connection->prepare("select nombre_rol_usuario, descripcion_rol_usuario from rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>