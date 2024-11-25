<?php
require('../../lib/connectios/MySQLPDO.php');

class entregaRecepcion
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, er.fecha, er.comentario from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo where a.historico = 1 order by a.codigo asc limit 50");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idEntregaRecepcion)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select er.id_entrega_recepcion, er.persona_id, a.codigo, er.fecha, er.comentario from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo where er.id_entrega_recepcion = :idEntregaRecepcion");
        $stmt->bindValue(":idEntregaRecepcion", $idEntregaRecepcion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idEntregaRecepcion, $campoBuscar)
    {
        $connection = new MySQLPDO();

        if ($campoBuscar == "Funcionario") {
            $stmt = $connection->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, er.fecha, er.comentario from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo where (p.nombre_persona like :patron) and (historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idEntregaRecepcion . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($campoBuscar == "Activo") {
            $stmt = $connection->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, er.fecha, er.comentario from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo where (a.codigo like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idEntregaRecepcion . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function Guardar($idPersona, $codigoActivo, $fecha, $comentario)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from activo where codigo = :codigo");
        $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeActivo = $results['count(*)'];

        if ($existeActivo == 0) {
            return "El Activo no se encuentra registrado";
        }

        $stmt = $connection->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0)");
        $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $historicoActivo = $results['count(*)'];
        if ($historicoActivo == 1) {
            return "El Activo se encuentra dado de baja";
        }

        $stmt = $connection->prepare("select count(*) from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.codigo = :codigo;");
        $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeActa = $results['count(*)'];

        if ($existeActa >= 1) {
            return "El activo ya se encuentra asignado a un funcionario";
        }

        $stmt = $connection->prepare("select id_activo from activo where codigo = :codigoActivo");
        $stmt->bindValue(":codigoActivo", $codigoActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idActivo = $results['id_activo'];

        $stmt = $connection->prepare("insert into `entrega_recepcion`
                                                    (`persona_id`,
                                                    `activo_id`,
                                                    `fecha`,
                                                    `comentario`)
                                        values (:idPersona,
                                                :idActivo,
                                                :fecha,
                                                :comentario);");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindValue(":comentario", $comentario, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al guardar la información";
        }
    }

    public function Modificar($idActa, $idPersona, $codigoActivo, $fecha, $comentario)
    {
        $connection = new MySQLPDO();

        $fechaTotal = getdate();
        $diaInicial = $fechaTotal['mday'];
        $mesInicial = $fechaTotal['mon'];
        $año = $fechaTotal['year'];
        if ($diaInicial <= 9) {
            $dia = "0" . $diaInicial;
        } else {
            $dia = $diaInicial;
        }
        if ($mesInicial <= 9) {
            $mes = "0" . $mesInicial;
        } else {
            $mes = $mesInicial;
        }
        $fechaActual = $año . "-" . $mes . "-" . $dia;

        $stmt = $connection->prepare("select id_activo from activo where codigo = :codigoActivo");
        $stmt->bindValue(":codigoActivo", $codigoActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idActivo = $results['id_activo'];

        $stmt = $connection->prepare("update `entrega_recepcion`
                                            set `persona_id` = :idPersona,
                                            `activo_id` = :idActivo,
                                            `fecha` = :fecha,
                                            `comentario` = :comentario
                                            where `id_entrega_recepcion` = :idActa;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindValue(":comentario", $comentario, PDO::PARAM_STR);
        $stmt->bindValue(":idActa", $idActa, PDO::PARAM_INT);

        $stmt1 = $connection->prepare("insert into `movimiento_activo`
                                                    (`activo_id`,
                                                    `persona_id`,
                                                    `fecha_movimiento`)
                                        values (:idActivo,
                                                :idPersona,    
                                                :fecha);");
        $stmt1->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt1->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt1->bindValue(":fecha", $fechaActual, PDO::PARAM_STR);
        if (($stmt->execute()) && ($stmt1->execute())) {
            return "OK";
        } else {
            return "Error: se ha generado un error al modificar la información";
        }
    }

    public function Eliminar($idEntregaRecepcion)
    {
        $connection = new MySQLPDO();
        $stmtdel = $connection->prepare("delete from entrega_recepcion where id_entrega_recepcion = :idEntregaRecepcion");
        $stmtdel->bindValue(":idEntregaRecepcion", $idEntregaRecepcion, PDO::PARAM_INT);
        if ($stmtdel->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }
}
