<?php
require '../index/index.model.php';
if (!$_SESSION['user']) {
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
  <script src="../../assets/js/utils.js"></script>
  <script src="./reporteHoras.js"></script>
  <link rel="stylesheet" href="../../assets/css/main.css">
  <link rel="stylesheet" href="../../assets/css/popup.css">
  <link rel="stylesheet" href="../../assets/css/popupMobileDisplayTable.css">
</head>

<body style="height: 100vh;">
  <!-- HEADER -->
  <?php
  require '../../lib/common/header.php';
  ?>
  <!-- HEADER -->
  <div class="container-fluid text-center">
    <div class="row align-items-center">
      <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
        <nav aria-label="breadcrumb bg-light">
          <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
            <li class="breadcrumb-item active">Reportes</li>
            <li class="breadcrumb-item active" aria-current="page">Reporte de horas</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- BREADCRUMB -->
  <div class="container-fluid">
    <div class="card margin-b-30">
      <div class="card-header bg-primary text-color-white">
        <h5>Reporte de horas</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
            <div class="btn-group-sm">
              <button class="btn btn-success" onclick="consultar();" id="consultar"><span class="fa fa-file-pdf"></span>&nbsp&nbspConsultar</button>
              <button class="btn btn-success" onclick="pdf();" id="pdf"><span class="fa fa-file-pdf"></span>&nbsp&nbspPdf</button>
              <button class="btn btn-success" onclick="excel();" id="excel"><span class="fa fa-file-pdf"></span>&nbsp&nbspExcel</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mt-12">
            <label for="funcionario">Funcionario</label>
            <select name="idPersona" id="idPersona" class="form-control br">
            </select>
          </div>
          <div class="col-md-6 mt-12">
          </div>
          <div class="col-md-6 mt-2 mt-2">
            <label for="fechaInicio">Fecha Inicio</label>
            <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
          </div>
          <div class="col-md-6 mt-2 mt-2">
            <label for="fechaFin">Fecha Fin</label>
            <input type="date" name="fechaFin" id="fechaFin" class="form-control">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <table class="table tabled-bordered table-sm" id="tablaActivo">
          <thead>
            <tr>
              <th scope="col" id="nombrePersonaLbl">Funcionario</th>
              <th scope="col" id="nombreOficinaLbl">Oficina</th>
              <th scope="col" id="fechaEAsistenciaLbl">Fecha Entrada</th>
              <th scope="col" id="horaEAsistenciaLbl">Hora Entrada</th>
              <th scope="col" id="fechaSAsistenciaLbl">Fecha Salida</th>
              <th scope="col" id="horaSAsistenciaLbl">Hora Salida</th>
              <th scope="col" id="tiempoFinalLbl">Horas Jornada</th>
              <th class="th-text-align-right">Acciones</th>
            </tr>
          </thead>
          <tbody id="datos">
          </tbody>
        </table>
        <div id="alertaDatos">
          <div class="alert alert-success text-center" role="alert">
            No se ha encontrado datos con los siguientes criterios
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