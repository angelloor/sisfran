<?php
require('../../lib/connectios/MySQLPDO.php');

class reporteActivo
{

    public function cargaInicial()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where a.historico = 1  order by codigo asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cagarValor($campo)
    {
        $connection = new MySQLPDO();
        if ($campo == "categoria") {
            $stmt = $connection->prepare("select nombre_categoria as nombre from categoria order by nombre_categoria asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($campo == "marca") {
            $stmt = $connection->prepare("select nombre_marca as nombre from marca order by nombre_marca asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($campo == "estado") {
            $stmt = $connection->prepare("select nombre_estado as nombre from estado order by nombre_estado asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($campo == "funcionario") {
            $stmt = $connection->prepare("select nombre_persona as nombre from persona order by nombre_persona asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function consultar($campo, $valor)
    {
        $connection = new MySQLPDO();
        if ($campo == "categoria") {
            if ($valor == "*") {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where a.historico = 1 order by a.codigo asc");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where (ca.nombre_categoria = :valor) and (a.historico = 1) order by a.codigo asc; ");
                $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if ($campo == "marca") {
            if ($valor == "*") {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where a.historico = 1 order by a.codigo asc");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where (m.nombre_marca = :valor) and (a.historico = 1) order by a.codigo asc;");
                $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if ($campo == "estado") {
            if ($valor == "*") {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where a.historico = 1 order by a.codigo asc");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where (e.nombre_estado = :valor) and (a.historico = 1) order by a.codigo asc;");
                $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        if ($campo == "funcionario") {
            if ($valor == "*") {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where a.historico = 1 order by a.codigo asc");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join persona p on er.persona_id = p.id_persona where (p.nombre_persona = :valor) and (a.historico = 1) order by a.codigo asc;");
                $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }

    public function cargarValor()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select id_categoria, nombre_categoria as nombre from categoria order by nombre_categoria asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
