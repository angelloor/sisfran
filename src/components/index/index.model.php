<?php
require('../../lib/connectios/MySQLPDO.php');

session_start();

class Login
{

    public function consultarUsuario($usuario, $clave)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from usuario where nombre_usuario = :usuario");
        $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->execute();
        $usuarioExiste = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExiste['count(*)'] == 0) {
            return "El usuario no existe";
        } else {
            $stmt = $connection->prepare("select u.id_usuario, p.id_persona, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario u inner join persona p on u.persona_id = p.id_persona inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where nombre_usuario = :usuario");
            $stmt->bindValue(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($clave, $datos['clave'])) {
                $_SESSION['idPersona'] = $datos['id_persona'];
                $_SESSION['user'] = $datos['nombre_usuario'];
                $_SESSION['rolUsuario'] = $datos['nombre_rol_usuario'];
                return "OK";
            } else {
                return "Usuario o contraseña incorrectos";
            }
        }
    }
}
