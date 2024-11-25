<?php
require('../../lib/connectios/MySQLPDO.php');

class Main
{

    public function listarCategoriaMain()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select distinct er.id_entrega_recepcion, c.nombre_categoria from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join categoria c on a.categoria_id = c.id_categoria order by c.nombre_categoria asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarActivoMain()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select er.id_entrega_recepcion, a.codigo as activo from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.historico = 1 order by a.codigo asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function listarFuncionarioPorCategoriaMain($categoria)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select distinct er.id_entrega_recepcion, p.nombre_persona from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join categoria ca on a.categoria_id = ca.id_categoria inner join persona p on er.persona_id = p.id_persona where ca.nombre_categoria = :nombreCategoria order by p.nombre_persona asc;");
        $stmt->bindValue(":nombreCategoria", $categoria, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
