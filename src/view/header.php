<html:5>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="index.php">
        <img src="../assets/img/logo_dark.svg" class="card-img-top img-nav" alt="Imagen">
      </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <!-- Administración  -->
            <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "INVITADO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS")){ echo 'style="display:none;"';} ?>>
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administración</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="empleados.php">Empleados</a>
                  <a class="dropdown-item" href="usuarios.php">Usuarios</a>
                  <a class="dropdown-item" href="unidades.php">Unidades</a>
                  <a class="dropdown-item" href="cargos.php">Cargos</a>
                  <a class="dropdown-item" href="firma.php">Firmas</a>
                  <a class="dropdown-item" href="../lib/backupMySQL/index.php" target="_blank">Respaldo BD</a>
                  <a class="dropdown-item" href="roles_usuarios.php">Roles de usuarios </a>
                </div>
            </li>
            <!-- Inventario  -->
            <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS")){ echo 'style="display:none;"';} ?>>
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventario</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="gestionActa.php" <?php if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){ echo 'style="display:none;"';} ?>>Asignación de activos</a>
                <a class="dropdown-item" href="activos.php">Activos</a>
                <a class="dropdown-item" href="categorias.php">Categorías</a>
                <a class="dropdown-item" href="marcas.php">Marcas</a>
                <a class="dropdown-item" href="colores.php">Colores</a>
                <a class="dropdown-item" href="estados.php">Estados</a>
                <a class="dropdown-item" href="custodios.php">Custodios</a>
                <a class="dropdown-item" href="bodegas.php">Bodegas</a>
              </div>
            </li>
            <!-- Credenciales  -->
            <li class="nav-item dropdown" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>
              <a class="nav-link dropdown-toggle" href="gestionActa.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Credenciales</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="actasDigitales.php">Actas digitales</a>
                <a class="dropdown-item" href="sistema.php">Sistemas</a>
              </div>
            </li>
            <!-- Asistencia  -->
            <li class="nav-item dropdown" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>
              <a class="nav-link dropdown-toggle" href="gestionActa.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asistencia</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="registros.asistencia.php">Registro</a>
                <a class="dropdown-item" href="horarios.asistencia.php">Horarios</a>
                <a class="dropdown-item" href="ubicaciones.asistencia.php">Ubicaciones</a>
              </div>
            </li>
            <!-- Reportes  -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
              <div class="dropdown-menu" href="null" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="./reporteActivo.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Activos</a>
                <a class="dropdown-item" href="./historico.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Histórico de activos</a>
                <a class="dropdown-item" href="./movimientoActivo.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Movimientos de activos</a>
                <a class="dropdown-item" href="../view/activosConfirmados.php">Activos confirmados</a>
                <a class="dropdown-item" href="../view/activosNoConfirmados.php">Activos no confirmados</a>
              </div>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <a class="btn btn-success my-2 my-sm-0 btn-success-rc" href="../../index.php?logout=true"><span class="fa fa-sign-out-alt"></span>&nbsp&nbspSalir<span class="sr-only">(current)</span></a>
          </form>
        </div>
      </nav>
</html:5>