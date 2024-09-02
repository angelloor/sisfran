<?php
    require '../model/login.model.php';
    if($_SESSION['user'] == ""){
    	header('Location: ../');
    }
    if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){
    	header('Location: ./');
    }
    if($_SESSION['rolUsuario'] == "INVITADO"){
    	header('Location: ./');
    }
    if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){
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
    <link rel="icon" type="image/png" href="../assets/img/logo.png"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- SWEET ALERT -->
    <link href="../assets/css/dark.css" rel="stylesheet">
    <script src="../assets/js/sweetalert2.min.js"></script>
    <!-- SCRIPTS -->
    <script src="../assets/js/all.min.js"></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../js/rol_usuario.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
  </head>
  <body>
  <!-- HEADER -->
  <?php
      require 'header.php';
  ?>
  <!-- HEADER -->
<!-- BREADCRUMB -->
<div class="container-fluid text-center">
  <div class="row align-items-center">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
        <nav aria-label="breadcrumb bg-light">
      <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        <li class="breadcrumb-item active">Administración</li>
        <li class="breadcrumb-item active" aria-current="page">Roles de usuario</li>
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
                  <h5>Roles de usuario (Informativo)</h5>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaRolUsuario">
                    <thead>
                        <tr>
                            <th class="padding-ru">Nombre</th>
                            <th class="padding-ru">Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="datos">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Gestionar  -->
  </body>
</html>




















