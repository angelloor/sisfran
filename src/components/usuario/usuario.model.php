<?php
require('../../lib/connectios/MySQLPDO.php');


class Usuario
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario as u inner join persona as p on u.persona_id = p.id_persona inner join rol_usuario as ru on u.rol_usuario_id = ru.id_rol_usuario");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idUsuario)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select u.id_usuario, u.persona_id, p.nombre_persona, u.nombre_usuario, u.clave, u.rol_usuario_id, ru.nombre_rol_usuario from usuario as u inner join persona as p on u.persona_id = p.id_persona inner join rol_usuario as ru on u.rol_usuario_id = ru.id_rol_usuario and id_usuario = :idUsuario");
        $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idUsuario)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario u inner join persona p on u.persona_id = p.id_persona inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where p.nombre_persona like :patron ");
        $stmt->bindValue(":patron", "%" . $idUsuario . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function Guardar($personaId, $nombre, $clave, $rolUsuarioId)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select nombre_rol_usuario  from rol_usuario where id_rol_usuario = :rolUsuarioId");
        $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreRolUsuario = $results['nombre_rol_usuario'];

        //            
        $stmt = $connection->prepare("select count(*) from usuario where nombre_usuario = :nombreUsuario;");
        $stmt->bindValue(":nombreUsuario", $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeUsuario = $results['count(*)'];

        if ($existeUsuario >= 1) {
            return "el nombre de usuario ya existe";
        }

        if ($nombreRolUsuario == "ADMINISTRADOR") {
            return "Solo pueda haber un Administrador";
        } else {
            $PASSWORD_DEFAULT = "1234";

            $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

            $stmt = $connection->prepare("insert into `usuario`
                                                        (`persona_id`,
                                                        `nombre_usuario`,
                                                        `clave`,
                                                        `rol_usuario_id`)
                                            values (:personaId,
                                                    :nombre,
                                                    :hashedPassword,
                                                    :rolUsuarioId);");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":hashedPassword", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idUsuario, $personaId, $nombre, $clave, $rolUsuarioId)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select nombre_rol_usuario  from rol_usuario where id_rol_usuario = :rolUsuarioId");
        $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreRolUsuario = $results['nombre_rol_usuario'];

        $stmt = $connection->prepare("select count(*) from usuario where nombre_usuario = :nombreUsuario;");
        $stmt->bindValue(":nombreUsuario", $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeUsuario = $results['count(*)'];

        $stmt = $connection->prepare("select nombre_usuario from usuario where id_usuario = :idUsuario;");
        $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreUsuarioBD = $results['nombre_usuario'];

        if ($nombre == $nombreUsuarioBD) {
            if ($idUsuario == 1) {
                $PASSWORD_DEFAULT = "1234";

                $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);
                
                $stmt = $connection->prepare("update `usuario`
                                set `persona_id` = :personaId,
                                `nombre_usuario` = :nombre,
                                `clave` = :hashedPassword,
                                `rol_usuario_id` = :rolUsuarioId
                                where `id_usuario` = :idUsuario;");
                $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
                $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindValue(":hashedPassword", $hashedPassword, PDO::PARAM_STR);
                $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_INT);
                $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información";
                }
            } else {
                if ($nombreRolUsuario == "ADMINISTRADOR") {
                    return "Solo pueda haber un Administrador";
                } else {
                    $PASSWORD_DEFAULT = "1234";

                    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

                    $stmt = $connection->prepare("update `usuario`
                                    set `persona_id` = :personaId,
                                    `nombre_usuario` = :nombre,
                                    `clave` = :hashedPassword,
                                    `rol_usuario_id` = :rolUsuarioId
                                    where `id_usuario` = :idUsuario;");
                    $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
                    $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                    $stmt->bindValue(":hashedPassword", $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_INT);
                    $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        return "OK";
                    } else {
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        } else {
            if ($existeUsuario >= 1) {
                return "el nombre de usuario ya existe";
            } else {
                if ($idUsuario == 1) {
                    $PASSWORD_DEFAULT = "1234";

                    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

                    $stmt = $connection->prepare("update `usuario`
                                    set `persona_id` = :personaId,
                                    `nombre_usuario` = :nombre,
                                    `clave` = :hashedPassword,
                                    `rol_usuario_id` = :rolUsuarioId
                                    where `id_usuario` = :idUsuario;");
                    $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
                    $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                    $stmt->bindValue(":hashedPassword", $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_INT);
                    $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        return "OK";
                    } else {
                        return "Error: se ha generado un error al modificar la información";
                    }
                } else {
                    if ($nombreRolUsuario == "ADMINISTRADOR") {
                        return "Solo pueda haber un Administrador";
                    } else {
                        $PASSWORD_DEFAULT = "1234";

                        $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

                        $stmt = $connection->prepare("update `usuario`
                                        set `persona_id` = :personaId,
                                        `nombre_usuario` = :nombre,
                                        `clave` = :hashedPassword,
                                        `rol_usuario_id` = :rolUsuarioId
                                        where `id_usuario` = :idUsuario;");
                        $stmt->bindValue(":personaId", $personaId, PDO::PARAM_INT);
                        $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                        $stmt->bindValue(":hashedPassword", $hashedPassword, PDO::PARAM_STR);
                        $stmt->bindValue(":rolUsuarioId", $rolUsuarioId, PDO::PARAM_INT);
                        $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                        if ($stmt->execute()) {
                            return "OK";
                        } else {
                            return "Error: se ha generado un error al modificar la información";
                        }
                    }
                }
            }
        }
    }

    public function Eliminar($idUsuario)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from usuario");
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalUsuarios = $results['count(*)'];

        $stmt = $connection->prepare("select ru.nombre_rol_usuario from usuario u inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where u.id_usuario = :idUsuario;");
        $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRolUsuario = $results['nombre_rol_usuario'];

        if ($totalUsuarios == 1) {
            return "No puede eliminar todos los usuarios";
        } else {
            if ($existeRolUsuario == "ADMINISTRADOR") {
                return "No puede eliminar al Administrador";
            } else {
                $stmtdel = $connection->prepare("delete from usuario where id_usuario = :idUsuario");
                $stmtdel->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                if ($stmtdel->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al eliminar el registro";
                }
            }
        }
    }
}