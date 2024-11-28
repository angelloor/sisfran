<?php
require '../index/index.model.php';

if (!$_SESSION['user']) {
  header('Location: ../');
}
if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") {
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
  <script src="./actaDigital.js"></script>
  <script src="../../assets/js/utils.js"></script>
  <link rel="stylesheet" href="../../assets/css/main.css">
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
            <li class="breadcrumb-item active">Credenciales</li>
            <li class="breadcrumb-item active" aria-current="page">Actas digitales</li>
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
        <h5>Actas digitales</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
            <div class="btn-group-sm">
              <button class="btn btn-success" id="guardar" onclick="Generar();"><span class="fa fa-save"></span>&nbsp&nbspGenerar</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mt-2">
            <label for="funcionario">Funcionario</label>
            <select name="idPersona" id="idPersona" class="form-control br">
            </select>
          </div>
          <div class="col-md-6 mt-2">
            <label for="nombres">Año laboral</label>
            <input type="text" name="periodo" id="periodo" placeholder="Ingrese el año laboral" class="form-control text-mayus">
          </div>
        </div>
        <h4 class="mt-5">Sistemas</h4>
        <div id="sistemas">

        </div>
      </div>
    </div>
  </div>
  <!-- Gestionar  -->
</body>

</html>