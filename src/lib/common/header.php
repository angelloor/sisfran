<html:5>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="../main/main.php">
      <img src="../../assets/img/logo_dark.svg" class="card-img-top img-nav" alt="Imagen">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <!-- Administración  -->
        <li class="nav-item dropdown" <?php if (($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "INVITADO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") || ($_SESSION['rolUsuario'] == "ASISTENTE")) {
                                        echo 'style="display:none;"';
                                      } ?>>
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administración</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="../funcionario/funcionario.php">Funcionario</a>
            <a class="dropdown-item" href="../usuario/usuario.php">Usuarios</a>
            <a class="dropdown-item" href="../unidad/unidad.php">Unidades</a>
            <a class="dropdown-item" href="../cargo/cargo.php">Cargos</a>
            <a class="dropdown-item" href="../firma/firma.php">Firmas</a>
            <!-- <a class="dropdown-item" href="../lib/backupMySQL/index.php" target="_blank">Respaldo BD</a> -->
            <a class="dropdown-item" href="../rolUsuario/rolUsuario.php">Roles de usuarios </a>
          </div>
        </li>
        <!-- Inventario  -->
        <li class="nav-item dropdown" <?php if (($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") || ($_SESSION['rolUsuario'] == "ASISTENTE")) {
                                        echo 'style="display:none;"';
                                      } ?>>
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Inventario</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="../entregaRecepcion/entregaRecepcion.php" <?php if ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") {
                                                              echo 'style="display:none;"';
                                                            } ?>>Entrega Recepción</a>
            <a class="dropdown-item" href="../activo/activo.php">Activos</a>
            <a class="dropdown-item" href="../categoria/categoria.php">Categorías</a>
            <a class="dropdown-item" href="../marca/marca.php">Marcas</a>
            <a class="dropdown-item" href="../color/color.php">Colores</a>
            <a class="dropdown-item" href="../estado/estado.php">Estados</a>
            <a class="dropdown-item" href="../bodega/bodega.php">Bodegas</a>
          </div>
        </li>
        <!-- Credenciales  -->
        <li class="nav-item dropdown" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || ($_SESSION['rolUsuario'] == "ASISTENTE")) {
                                        echo 'style="display:none;"';
                                      } ?>>
          <a class="nav-link dropdown-toggle" href="../entregaRecepcion/entregaRecepcion.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Credenciales</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="../actaDigital/actaDigital.php">Actas digitales</a>
            <a class="dropdown-item" href="../sistema/sistema.php">Sistemas</a>
          </div>
        </li>
        <!-- Asistencia  -->
        <li class="nav-item dropdown" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") {
                                        echo 'style="display:none;"';
                                      } ?>>
          <a class="nav-link dropdown-toggle" href="../entregaRecepcion/entregaRecepcion.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asistencia</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="../oficina/oficina.php" <?php if ($_SESSION['rolUsuario'] == "ASISTENTE") {
                                                          echo 'style="display:none;"';
                                                        } ?>>Oficinas</a>
            <a class="dropdown-item" href="../personaHorarioOficina/personaHorarioOficina.php?idPersona=<?php echo $_SESSION['idPersona'] ?>&rolUsuario=<?php echo $_SESSION['rolUsuario'] ?>" <?php if ($_SESSION['rolUsuario'] != "ASISTENTE") {
                                                                                                                                                                  echo 'style="display:none;"';
                                                                                                                                                                } ?>>Horarios</a>
            <a class="dropdown-item" href="../asistencia/asistencia.php?idPersona=<?php echo $_SESSION['idPersona'] ?>">Registro de asistencia</a>
            <a class="dropdown-item" href="../permiso/permiso.php?idPersona=<?php echo $_SESSION['idPersona'] ?>&rolUsuario=<?php echo $_SESSION['rolUsuario'] ?>">Permisos</a>
          </div>
        </li>
        <!-- Reportes  -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
          <div class="dropdown-menu" href="null" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="../reporteActivo/reporteActivo.php" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                  echo 'style="display:none;"';
                                                                } ?>>Activos</a>
            <a class="dropdown-item" href="../historico/historico.php" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                              echo 'style="display:none;"';
                                                            } ?>>Histórico de activos</a>
            <a class="dropdown-item" href="../movimientoActivo/movimientoActivo.php" <?php if ($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO" || $_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                      echo 'style="display:none;"';
                                                                    } ?>>Movimientos de activos</a>
            <a class="dropdown-item" href="../activosConfirmados/activosConfirmados.php" <?php if ($_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                              echo 'style="display:none;"';
                                                                            } ?>>Activos confirmados</a>
            <a class="dropdown-item" href="../activosNoConfirmados/activosNoConfirmados.php" <?php if ($_SESSION['rolUsuario'] == "ASISTENTE") {
                                                                                echo 'style="display:none;"';
                                                                              } ?>>Activos no confirmados</a>
            <a class="dropdown-item" href="../reporteHoras/reporteHoras.php">Reporte de horas</a>
          </div>
        </li>
      </ul>
      <!-- Mostrar datos usuario -->
      <div style="display: flex; flex-direction: column; color: white;">
        <h5 class="mb-0" style="font-size: 12px;"><?php echo $_SESSION['user'] ?> </h5>
        <h5 class="mb-0" style="font-size: 12px;"><?php echo $_SESSION['rolUsuario'] ?> </h5>
      </div>
      <form class="form-inline my-2 my-lg-0">
        <a class="btn btn-success my-2 my-sm-0 btn-success-rc" href="../../../index.php?logout=true"><span class="fa fa-sign-out-alt"></span>&nbsp&nbspSalir<span class="sr-only">(current)</span></a>
      </form>
    </div>
  </nav>
</html:5>