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
  <script src="./main.js"></script>
  <script src="../../assets/js/utils.js"></script>
  <link rel="stylesheet" href="../../assets/css/main.css">
  <link rel="stylesheet" href="../../assets/css/popup.css">
</head>

<body>
  <!-- HEADER -->
  <?php
  require '../../lib/common/header.php';
  ?>
  <!-- HEADER -->
  <nav aria-label="breadcrumb bg-light">
    <ol class="breadcrumb bg-transparent">
      <li class="breadcrumb-item"><a href="../main/main.php">Inicio</a></li>
      <li class="breadcrumb-item active">Funciones</li>
    </ol>
  </nav>
  <div class="container text-center margin-b-30">
    <div class="row text-center">
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                echo 'style="display:none;"';
                                                              } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/ga.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Generar actas</h5>
            <p class="card-text">Genera todas las actas de manera rápida</p>
            <button id="btnCategoria" name="categoria" class="btn-abrir-popup btn-success-rc">Acceder</button>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                echo 'style="display:none;"';
                                                              } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/au.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Generar actas por funcionario</h5>
            <p class="card-text">Genera las actas de acuerdo a un funcionario seleccionado</p>
            <button id="btnFuncionario" name="funcionario" class="btn-abrir-popup btn-success-rc">Acceder</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                      echo 'style="display:none;"';
                                                                    } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/ab.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Generar actas por activo</h5>
            <p class="card-text">Genera un acta seleccionando un activo</p>
            <button id="btnActivo" name="activo" class="btn-abrir-popup btn-success-rc">Acceder</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                echo 'style="display:none;"';
                                                              } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/ci.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Comprobar inventario</h5>
            <p class="card-text">Comprueba los activos de la institución</p>
            <button onclick="location.href='../comprobacionInventario/comprobacionInventario.php'" class="btn-abrir-popup btn-success-rc" type="button">Acceder</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                      echo 'style="display:none;"';
                                                                    } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/rp.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Reportes</h5>
            <p class="card-text">Activos, Comprobación de inventario y movimiento de activos</p>
            <button id="btnReporte" name="reporte" class="btn-abrir-popup btn-success-rc">Acceder</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                      echo 'style="display:none;"';
                                                                    } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/ad.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Credenciales</h5>
            <p class="card-text">Genera actas de credenciales digitales de los sistemas</p>
            <button id="btnActaDigital" name="actaDigital" class="btn-abrir-popup btn-success-rc">Acceder</button>
          </div>
        </div>
      </div>

      <!-- Asistencia -->
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
                                                                echo 'style="display:none;"';
                                                              } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/au.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Asistencia</h5>
            <p class="card-text">Permite registrar tus asistencias</p>
            <button onclick="location.href='../asistencia/asistencia.php?idPersona=<?php echo $_SESSION['idPersona'] ?>'" class="btn-abrir-popup btn-success-rc" type="button">Acceder</button>
          </div>
        </div>
      </div>
      <!-- Permiso -->
      <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
                                                                echo 'style="display:none;"';
                                                              } ?>>
        <div class="card-sm width-card ml-auto mr-auto" id="card-inicio">
          <img src="../../assets/img/ab.png" class="card-img-top mt-3 img-card" alt="Imagen">
          <div class="card-body">
            <h5 class="card-title">Permisos</h5>
            <p class="card-text">Permite registrar tus permisos</p>
            <button onclick="location.href='../permiso/permiso.php?idPersona=<?php echo $_SESSION['idPersona'] ?>'" class="btn-abrir-popup btn-success-rc" type="button">Acceder</button>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="overlay" id="overlay">
    <div class="popup" id="popup">
      <a href="#" class="btn-cerrar-popup" id="btnCerrarPopup"><i class="fas fa-times"></i></a>
      <br>
      <div id="popupBodyCategoria" class="popupBody">
        <h4 class="mb-3">Seleccionar Categor&iacute;a</h4>
        <div class="form">
          <div class="contenedor-inputs">
            <select name="SelectCategoria" class="form-control mb-3 tmm" id="SelectCategoria">
            </select>
          </div>
          <button id="BtnGenerarTodasActas" onclick="GenerarTodasActas();" class="btn-submit">Enviar</button>
        </div>
      </div>
      <div id="popupBodyFuncionario" class="popupBody">
        <h4 class="mb-3">Seleccionar la Categor&iacute;a y el Funcionario</h4>
        <div class="form">
          <div class="contenedor-inputs">
            <select name="SelectCategoriaDos" class="form-control mb-3 tmm" id="SelectCategoriaDos">
            </select>
            <select name="SelectFuncionario" class="form-control mb-3 tmm" id="SelectFuncionario">
            </select>
            <h4>Salto de linea</h4>
            <input type="text" id="saltoLineaDos" name="saltoLineaDos" class="form-control">
          </div>
          <button id="BtnGenerarPorUsuario" onclick="GenerarPorFuncionario();" class="btn-submit">Enviar</button>
        </div>
      </div>
      <div id="popupBodyActivo" class="popupBody">
        <h4 class="mb-3">Seleccionar Activo</h4>
        <div class="form">
          <div class="contenedor-inputs">
            <label for="activo"></label>
            <datalist id="activo" name="activo">
            </datalist>
            <input id="codigoActivo" list="activo">
            <h4>Salto de linea</h4>
            <input type="text" id="saltoLineaTres" name="saltoLineaTres" class="form-control">
          </div>
          <button id="BtnGenerarPorActivo" onclick="GenerarPorActivo();" class="btn-submit">Enviar</button>
        </div>
      </div>
      <div id="popupBodyReporte" class="popupBody">
        <h4 class="mb-3">Seleccionar Tipo de Reporte</h4>
        <div class="form">
          <a class="btn btn-submit col-12 mb-3" href="../reporteActivo/reporteActivo.php">Activos</a>
          <a class="btn btn-submit col-12 mb-3" href="../historico/historico.php">Histórico de activos</a>
          <a class="btn btn-submit col-12 mb-3" href="../movimientoActivo/movimientoActivo.php">Movimientos de activos</a>
          <a class="btn btn-submit col-12 mb-3" href="../activosConfirmados/activosConfirmados.php">Activos Confirmados</a>
          <a class="btn btn-submit col-12 mb-3" href="../activosNoConfirmados/activosNoConfirmados.php">Activos No Confirmados</a>
          <a class="btn btn-submit col-12 mb-3" href="../reporteHoras/reporteHoras.php">Reporte de horas</a>
        </div>
      </div>
      <div id="popupBodyActaDigital" class="popupBody">
        <h4 class="mb-3">Seleccionar la Acción</h4>
        <div class="form">
          <a class="btn btn-submit col-12 mb-3" href="../actaDigital/actaDigital.php">Actas digitales</a>
          <a class="btn btn-submit col-12 mb-3" href="../sistema/sistema.php" <?php if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
                                                                        echo 'style="display:none;"';
                                                                      } ?>>Sistemas</a>
        </div>
      </div>
    </div>
  </div>
  <script src="../../assets/js/popup.js"></script>
</body>

</html>