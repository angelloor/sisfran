<?php
require('../../lib/connectios/MySQLPDO.php');

class Activo
{

    public function ConsultarTodo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where a.historico = 1 order by a.codigo asc limit 50");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ConsultarPorId($idActivo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where a.id_activo = :idActivo");
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ConsultarPorIdRow($idBuscar, $campoBuscar)
    {
        $connection = new MySQLPDO();
        if ($campoBuscar == "Código") {
            $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where (a.codigo like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idBuscar . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($campoBuscar == "Nombre") {
            $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where (a.nombre_activo like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idBuscar . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($campoBuscar == "Marca") {
            $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where (m.nombre_marca like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idBuscar . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($campoBuscar == "Modelo") {
            $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where (a.modelo like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idBuscar . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($campoBuscar == "Serie") {
            $stmt = $connection->prepare("select a.id_activo, a.categoria_id, c.nombre_categoria, a.marca_id, m.nombre_marca, a.estado_id, e.nombre_estado, a.color_id, co.nombre_color, a.bodega_id, bo.nombre_bodega, a.codigo, a.nombre_activo, a.caracteristica, a.modelo, a.serie, a.ubicacion_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario, a.historico, a.fecha_historico from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega bo on a.bodega_id = bo.id_bodega where (a.serie like :patron) and (a.historico = 1) order by a.codigo asc");
            $stmt->bindValue(":patron", "%" . $idBuscar . "%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public function Guardar($categoriaId, $marcaId, $estadoId, $colorId, $caracteristica, $bodegaId, $codigo, $nombre, $modelo, $serie, $ubicacionIngreso, $fechaIngreso, $valorCompra, $comentario, $comprobacionInventario)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0);");
        $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        if ($existeRegistro >= 1) {
            return "Activo ya existe ";
        } else {
            $stmt = $connection->prepare("insert into `activo`(`categoria_id`, `marca_id`, `estado_id`, `color_id`, `caracteristica`, `bodega_id`, `codigo`, `nombre_activo`, `modelo`, `serie`, `ubicacion_ingreso`,`fecha_ingreso`, `valor_compra`, `comentario`, `comprobacion_inventario`) values (:categoriaId, :marcaId, :estadoId, :colorId, :caracteristica, :bodegaId, :codigo, :nombre, :modelo, :serie, :origenIngreso, :fechaIngreso, :valorCompra, :comentario, :comprobacionInventario)");
            $stmt->bindValue(":categoriaId", $categoriaId, PDO::PARAM_INT);
            $stmt->bindValue(":marcaId", $marcaId, PDO::PARAM_INT);
            $stmt->bindValue(":estadoId", $estadoId, PDO::PARAM_INT);
            $stmt->bindValue(":colorId", $colorId, PDO::PARAM_INT);
            $stmt->bindValue(":caracteristica", $caracteristica, PDO::PARAM_STR);
            $stmt->bindValue(":bodegaId", $bodegaId, PDO::PARAM_INT);
            $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":modelo", $modelo, PDO::PARAM_STR);
            $stmt->bindValue(":serie", $serie, PDO::PARAM_STR);
            $stmt->bindValue(":origenIngreso", $ubicacionIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":valorCompra", $valorCompra, PDO::PARAM_STR);
            $stmt->bindValue(":comentario", $comentario, PDO::PARAM_STR);
            $stmt->bindValue(":comprobacionInventario", $comprobacionInventario, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }

    public function Modificar($idActivo, $categoriaId, $marcaId, $estadoId, $colorId, $caracteristica, $bodegaId, $codigo, $nombre, $modelo, $serie, $ubicacionIngreso, $fechaIngreso, $valorCompra, $comentario, $comprobacionInventario)
    {
        $connection = new MySQLPDO();

        $stmt = $connection->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0);");
        $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $existeRegistro = $results['count(*)'];

        $stmt = $connection->prepare("select codigo from activo where id_activo = :idActivo;");
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $codigoBD = $results['codigo'];

        if ($codigo == $codigoBD) {
            $stmt = $connection->prepare("update `activo` set `categoria_id`= :categoriaId,
                    `marca_id`= :marcaId,`estado_id`= :estadoId,`color_id`= :colorId,`caracteristica`= :caracteristica,
                    `bodega_id`= :bodegaId,`codigo`= :codigo,`nombre_activo`= :nombre,
                    `modelo`= :modelo,`serie`= :serie,`ubicacion_ingreso`= :origenIngreso,`fecha_ingreso`= :fechaIngreso,
                    `valor_compra`= :valorCompra,`comentario`= :comentario,`comprobacion_inventario`= :comprobacionInventario where id_activo = :idActivo");

            $stmt->bindValue(":categoriaId", $categoriaId, PDO::PARAM_INT);
            $stmt->bindValue(":marcaId", $marcaId, PDO::PARAM_INT);
            $stmt->bindValue(":estadoId", $estadoId, PDO::PARAM_INT);
            $stmt->bindValue(":colorId", $colorId, PDO::PARAM_INT);
            $stmt->bindValue(":caracteristica", $caracteristica, PDO::PARAM_STR);
            $stmt->bindValue(":bodegaId", $bodegaId, PDO::PARAM_INT);
            $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":modelo", $modelo, PDO::PARAM_STR);
            $stmt->bindValue(":serie", $serie, PDO::PARAM_STR);
            $stmt->bindValue(":origenIngreso", $ubicacionIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":valorCompra", $valorCompra, PDO::PARAM_STR);
            $stmt->bindValue(":comentario", $comentario, PDO::PARAM_STR);
            $stmt->bindValue(":comprobacionInventario", $comprobacionInventario, PDO::PARAM_STR);
            $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "OK";
            } else {
                return "Error: se ha generado un error al modificar la información";
            }
        } else {
            if ($existeRegistro >= 1) {
                return "El codigo " . $codigo . " ya se esta utilizando en otro activo";
            } else {
                $stmt = $connection->prepare("update `activo` set `categoria_id`= :categoriaId,
                    `marca_id`= :marcaId,`estado_id`= :estadoId,`color_id`= :colorId,`caracteristica`= :caracteristica,
                    `bodega_id`= :bodegaId,`codigo`= :codigo,`nombre_activo`= :nombre,
                    `modelo`= :modelo,`serie`= :serie,`ubicacion_ingreso`= :origenIngreso,`fecha_ingreso`= :fechaIngreso,
                    `valor_compra`= :valorCompra,`comentario`= :comentario,`comprobacion_inventario`= :comprobacionInventario where id_activo = :idActivo");

                $stmt->bindValue(":categoriaId", $categoriaId, PDO::PARAM_INT);
                $stmt->bindValue(":marcaId", $marcaId, PDO::PARAM_INT);
                $stmt->bindValue(":estadoId", $estadoId, PDO::PARAM_INT);
                $stmt->bindValue(":colorId", $colorId, PDO::PARAM_INT);
                $stmt->bindValue(":caracteristica", $caracteristica, PDO::PARAM_STR);
                $stmt->bindValue(":bodegaId", $bodegaId, PDO::PARAM_INT);
                $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
                $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stmt->bindValue(":modelo", $modelo, PDO::PARAM_STR);
                $stmt->bindValue(":serie", $serie, PDO::PARAM_STR);
                $stmt->bindValue(":origenIngreso", $ubicacionIngreso, PDO::PARAM_STR);
                $stmt->bindValue(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR);
                $stmt->bindValue(":valorCompra", $valorCompra, PDO::PARAM_STR);
                $stmt->bindValue(":comentario", $comentario, PDO::PARAM_STR);
                $stmt->bindValue(":comprobacionInventario", $comprobacionInventario, PDO::PARAM_STR);
                $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    return "OK";
                } else {
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }
    }

    public function Eliminar($idActivo, $fechaEliminar)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("update `activo` set `historico` = 0, `fecha_historico` = :fechaeliminar  where id_activo = :idActivo");
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->bindValue(":fechaeliminar", $fechaEliminar, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "OK";
        } else {
            return "Error: se ha generado un error al eliminar el registro";
        }
    }

    public function consultarRegistros($idActivo)
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select count(*) as registros from entrega_recepcion where activo_id = :idActivo;");
        $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function listarActivo()
    {
        $connection = new MySQLPDO();
        $stmt = $connection->prepare("select a.id_activo, a.codigo activo from activo a where a.historico = 1 order by a.codigo asc;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
