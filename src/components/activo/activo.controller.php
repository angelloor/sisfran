<?php
require './activo.model.php';

if ($_POST) {
    $activo = new Activo();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($activo->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($activo->ConsultarPorId($_POST['idActivo']));
            break;
        case "GUARDAR":
            $categoriaId = $_POST['categoriaId'];
            $marcaId = $_POST['marcaId'];
            $estadoId = $_POST['estadoId'];
            $colorId = $_POST['colorId'];
            $caracteristica = $_POST['caracteristica'];
            $bodegaId = $_POST['bodegaId'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $modelo = $_POST['modelo'];
            $serie = $_POST['serie'];
            $ubicacionIngreso = $_POST['ubicacionIngreso'];
            $fechaIngreso = $_POST['fechaIngreso'];
            $valorCompra = $_POST['valorCompra'];
            $comentario = $_POST['comentario'];
            $comprobacionInventario = $_POST['comprobacionInventario'];

            if (!$categoriaId) {
                echo json_encode("Seleccione la categoría");
                return;
            }
            if (!$marcaId) {
                echo json_encode("Seleccione la marca");
                return;
            }
            if (!$estadoId) {
                echo json_encode("Seleccione el estado");
                return;
            }
            if (!$colorId) {
                echo json_encode("Seleccione el color");
                return;
            }
            if (!$caracteristica) {
                echo json_encode("Ingrese la característica del activo");
                return;
            }
            if (!$bodegaId) {
                echo json_encode("seleccione la bodega");
                return;
            }
            if (!$codigo) {
                echo json_encode("Ingrese el código asignado al activo");
                return;
            }
            if (!$nombre) {
                echo json_encode("Ingrese el nombre del activo");
                return;
            }
            if (!$modelo) {
                echo json_encode("Ingrese el modelo");
                return;
            }
            if (!$serie) {
                echo json_encode("Ingrese el número de serie");
                return;
            }
            if (!$ubicacionIngreso) {
                echo json_encode("Ingrese el origen del activo");
                return;
            }
            if (!$fechaIngreso) {
                echo json_encode("Seleccione la fecha del ingreso");
                return;
            }
            if (!$valorCompra) {
                echo json_encode("Ingrese el valor de la compra");
                return;
            }
            if (!$comprobacionInventario) {
                echo json_encode("Seleccione la comprobación de inventario");
                return;
            }
            $respuesta = $activo->Guardar($categoriaId, $marcaId, $estadoId, $colorId, $caracteristica, $bodegaId, $codigo, $nombre, $modelo, $serie, $ubicacionIngreso, $fechaIngreso, $valorCompra, $comentario, $comprobacionInventario);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $categoriaId = $_POST['categoriaId'];
            $marcaId = $_POST['marcaId'];
            $estadoId = $_POST['estadoId'];
            $colorId = $_POST['colorId'];
            $caracteristica = $_POST['caracteristica'];
            $bodegaId = $_POST['bodegaId'];
            $codigo = $_POST['codigo'];
            $nombre = $_POST['nombre'];
            $modelo = $_POST['modelo'];
            $serie = $_POST['serie'];
            $ubicacionIngreso = $_POST['ubicacionIngreso'];
            $fechaIngreso = $_POST['fechaIngreso'];
            $valorCompra = $_POST['valorCompra'];
            $comentario = $_POST['comentario'];
            $comprobacionInventario = $_POST['comprobacionInventario'];
            $idActivo = $_POST['idActivo'];

            if (!$categoriaId) {
                echo json_encode("Seleccione la categoría");
                return;
            }
            if (!$marcaId) {
                echo json_encode("Seleccione la marca");
                return;
            }
            if (!$estadoId) {
                echo json_encode("Seleccione el estado");
                return;
            }
            if (!$colorId) {
                echo json_encode("Seleccione el color");
                return;
            }
            if (!$caracteristica) {
                echo json_encode("Ingrese la característica del activo");
                return;
            }
            if (!$bodegaId) {
                echo json_encode("seleccione la bodega");
                return;
            }
            if (!$codigo) {
                echo json_encode("Ingrese el código asignado al activo");
                return;
            }
            if (!$nombre) {
                echo json_encode("Ingrese el nombre del activo");
                return;
            }
            if (!$modelo) {
                echo json_encode("Ingrese el modelo");
                return;
            }
            if (!$serie) {
                echo json_encode("Ingrese el número de serie");
                return;
            }
            if (!$ubicacionIngreso) {
                echo json_encode("Ingrese el origen del activo");
                return;
            }
            if (!$fechaIngreso) {
                echo json_encode("Seleccione la fecha del ingreso");
                return;
            }
            if (!$valorCompra) {
                echo json_encode("Ingrese el valor de la compra");
                return;
            }
            if (!$comprobacionInventario) {
                echo json_encode("Seleccione la comprobación de inventario");
                return;
            }
            $respuesta = $activo->Modificar($idActivo, $categoriaId, $marcaId, $estadoId, $colorId, $caracteristica, $bodegaId, $codigo, $nombre, $modelo, $serie, $ubicacionIngreso, $fechaIngreso, $valorCompra, $comentario, $comprobacionInventario);
            echo json_encode($respuesta);
            break;
        case "ELIMINAR":
            $idActivo = $_POST['idActivo'];
            $fechaEliminar = $_POST['fechaEliminar'];
            $respuesta = $activo->Eliminar($idActivo, $fechaEliminar);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idBuscar = $_POST['idActivo'];
            $campoBuscar = $_POST['campoBuscar'];
            $respuesta = $activo->ConsultarPorIdRow($idBuscar, $campoBuscar);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $idActivo = $_POST['idActivo'];
            $respuesta = $activo->consultarRegistros($idActivo);
            echo json_encode($respuesta);
            break;
        case "LISTAR_ACTIVO":
            $respuesta = $activo->listarActivo();
            echo json_encode($respuesta);
            break;
    }
}
