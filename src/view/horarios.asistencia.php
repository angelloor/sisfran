<?php
    require '../model/login.model.php';
    if($_SESSION['user'] == ""){
    	header('Location: ../');
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
    <script src="../js/main.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/popup.css">
  </head>
  <body>
  <!-- HEADER -->
  <?php
      require 'header.php';
  ?>
  <!-- HEADER -->
<nav aria-label="breadcrumb bg-light">
  <ol class="breadcrumb bg-transparent">
  <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
  <li class="breadcrumb-item active">Asistencia</li>
  <li class="breadcrumb-item active">Horarios</li>
    </ol>
</nav>
<div class="container text-center margin-t-30" style="margin-top: 200px">
    <p style="font-weight: 200; font-style: italic; color: #23376f; font-size: 50px;">
      Funcionalidad en <strong>Desarrollo</strong>
  </p>
</div>
  </body>
</html>