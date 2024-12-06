<?php
require '../index/index.model.php';

if (!$_SESSION['user']) {
    header('Location: ../');
}
if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") {
    header('Location: ./');
}
if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
    header('Location: ./');
}
if ($_SESSION['rolUsuario'] == "ASISTENTE") {
    header('Location: ./');
}
?>

<!doctype html>
<html lang="es">

<head>
    <title>SISFRAN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descriptions" content="Sistema para la generación de actas y control de inventario">
    <meta name="author" content="Cristian Arauz">
    <link rel="icon" type="image/png" href="../../assets/img/logo.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../../assets/css/all.min.css">
    <!-- SWEET ALERT -->
    <link href="../../assets/css/dark.css" rel="stylesheet">
    <script src="../../assets/js/sweetalert2.min.js"></script>
    <!-- SCRIPTS -->
    <script src="../../assets/js/all.min.js"></script>
    <script src="./activo.js"></script>
    <script src="../../assets/js/utils.js"></script>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/popupMobileDisplayTable.css">
</head>

<body>
    <!-- HEADER -->
    <?php
    require '../../lib/common/header.php';
    ?>
    <!-- HEADER -->
    <!-- BREADCRUMB -->
    <div class="container-fluid text-center">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
                <nav aria-label="breadcrumb bg-light">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Inventario</li>
                        <li class="breadcrumb-item active" aria-current="page">Activos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB -->
    <!-- Gestionar  -->
    <div class="container-fluid">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                <h5>Gestionar activos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-7 col-xl-7 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success" id="guardar" onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                            <button class="btn btn-success" id="modificar" onclick="Modificar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspModificar</button>
                            <button class="btn btn-primary" id="cancelar" onclick="Cancelar();"><span class="fa fa-ban"></span>&nbsp&nbspCancelar</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-5 col-xl-5">
                        <div class="btn-toolbar pc-flex-end">
                            <div class="btn-group mt-2">
                                <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar todo</button>
                            </div>
                            <div class="input-group mt-2">
                                <select name="campoBuscar" id="campoBuscar" class="form-control mr-2">
                                    <option>Código</option>
                                    <option>Nombre</option>
                                    <option>Marca</option>
                                    <option>Modelo</option>
                                    <option>Serie</option>
                                </select>
                                <input class="form-control" id="idActivo" type="search" placeholder="Buscar" aria-label="Buscar" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="categoriaId">Categoría</label>
                        <select name="categoriaId" id="categoriaId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="marcaId">Marca</label>
                        <select name="marcaId" id="marcaId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="estadoId"><strong>Estado</strong></label>
                        <select name="estadoId" id="estadoId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="colorId">Color</label>
                        <select name="colorId" id="colorId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="caracteristica"><strong>Características</strong></label>
                        <input type="text" name="caracteristica" id="caracteristica" placeholder="Ejemplo: i7 - 512BG - 8RAM" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="bodegaId">Bodega</label>
                        <select name="bodegaId" id="bodegaId" class="form-control br">
                        </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="codigo"><strong>Código</strong></label>
                        <input type="text" name="codigo" id="codigo" maxlength="9" placeholder="Ingrese el código" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" placeholder="Ingrese el modelo" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="serie">Serie</label>
                        <input type="text" name="serie" id="serie" placeholder="Ingrese la serie" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="ubicacionIngreso">Origen del activo</label>
                        <input type="text" name="ubicacionIngreso" id="ubicacionIngreso" placeholder="Ingrese el origen del activo" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="fechaIngreso">Fecha de ingreso</label>
                        <input type="date" name="fechaIngreso" id="fechaIngreso" placeholder="Ingrese la fecha de ingreso" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="valorCompra">Valor de compra</label>
                        <input type="text" name="valorCompra" id="valorCompra" placeholder="Ingrese el valor de la compra" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="comentario"><strong>Comentario</strong></label>
                        <textarea name="comentario" id="comentario" cols="60" rows="1" placeholder="Ingrese un comentario" class="form-control"></textarea>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="comprobacionInventario"><strong>Comprobación inventario</strong></label>
                        <select name="comprobacionInventario" id="comprobacionInventario" class="form-control br">
                            <option>NO</option>
                            <option>SI</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaActivo">
                    <thead>
                        <tr>
                            <th scope="col" id="codigoLbl">Código</th>
                            <th scope="col" id="nombreLbl">Nombre</th>
                            <th scope="col" id="categoriaIdLbl">Categoría</th>
                            <th scope="col" id="caracteristicaLbl">Característica</th>
                            <th scope="col" id="marcaIdLbl">Marca</th>
                            <th scope="col" id="modeloLbl">Modelo</th>
                            <th scope="col" id="serieLbl">Serie</th>
                            <th scope="col" id="estadoIdLbl">Estado</th>
                            <th scope="col" id="comprobacionInventarioLbl">CI</th>
                            <th scope="col" class="btn-center-objet">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos">

                    </tbody>
                </table>
                <div id="alertaDatos">
                    <div class="alert alert-success text-center" role="alert">
                        No se ha encontrado datos
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<!-- Mobile Display Table -->
<script src="../../assets/js/popupMobileDisplayTable.js"></script>
<?php
require '../../lib/common/popupMobileDisplayTable.php';
?>
<!-- Mobile Display Table -->
</html>