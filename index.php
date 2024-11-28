<?php
session_start();
if (isset($_GET['logout'])) {
  session_destroy();
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
  <link rel="icon" type="image/png" href="src/assets/img/logo.png" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="src/assets/css/bootstrap.min.css">
  <script src="src/assets/js/jquery.js"></script>
  <script src="src/assets/js/bootstrap.min.js"></script>
  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="src/assets/css/all.min.css">
  <!-- SWEET ALERT -->
  <link href="src/assets/css/dark.css" rel="stylesheet">
  <script src="src/assets/js/sweetalert2.min.js"></script>
  <!-- SCRIPTS -->
  <script src="src/assets/js/all.min.js"></script>
  <script src="src/assets/js/jquery.js"></script>
  <script src="src/components/index/index.js"></script>
  <script src="src/assets/js/utils.js"></script>
  <link rel="stylesheet" href="src/assets/css/main.css">
</head>

<body class="bg-branding center-body" id="index">
  <div class="container">
    <div class="row">
      <div class="col text-center">
        <img class="mb-4" src="src/assets/img/logo_dark.svg" alt="" height="50" />
      </div>
    </div>
    <div class="row">
      <div class="col text-center">
        <h1 class="h3 mb-3 font-weight-medium text-color-white">Iniciar Sesión</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-8 col-sm-8 col-md-4 col-xl-4 text-center" class="input-center">
        <input class="form-control" type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" autofocus onkeypress="enter(1)">
      </div>
    </div>
    <div class="row">
      <div class="col-8 col-sm-8 col-md-4 col-xl-4 text-center" class="input-center">
        <input type="password" id="clave" name="clave" class="form-control mt-20" placeholder="Contraseña" onkeypress="enter(2)">
      </div>
    </div>
    <div class="row pt-3">
      <div class="col text-center">
        <input type="submit" onclick="iniciarSesion();" class="btn btn-success btn-success-rc" value="Ingresar">
      </div>
    </div>
    <div class="row">
      <div class="col text-center">
        <p class="mt-4 mb-3 text-muted">&copy; 2024 <br>Version 1.1.0</p>
      </div>
    </div>
  </div>
</body>

</html>