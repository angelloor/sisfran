var urlController = "./usuario.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlControllerRolUsuario = "../rolUsuario/rolUsuario.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  BloquearBotones(true);
  Consultar();
  EscucharConsulta();
  listarFuncionario();
  listarRoles();

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const personaIdLbl = document.getElementById("personaIdLbl");
  const nombreLbl = document.getElementById("nombreLbl");
  const claveLbl = document.getElementById("claveLbl");
  const rolUsuarioIdLbl = document.getElementById("rolUsuarioIdLbl");

  if (isMobile) {
    // Comentar para mantener
    personaIdLbl.style.display = "none";
    // nombreLbl.style.display = "none";
    claveLbl.style.display = "none";
    rolUsuarioIdLbl.style.display = "none";
  } else {
    personaIdLbl.style.display = "table-cell";
    // nombreLbl.style.display = "table-cell";
    claveLbl.style.display = "table-cell";
    rolUsuarioIdLbl.style.display = "table-cell";
  }
}

function Consultar() {
  registrosTotales = false;
  $.ajax({
    data: { accion: "CONSULTAR" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      if (response.length >= 1) {
        registrosTotales = true;
        ocultarAlertaDatos();
      } else {
        mostrarAlertaDatos();
      }
      var html = "";
      $.each(response, function (index, data) {
        html += "<tr>";
        html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.nombre_usuario + "</td>";
        html += isMobile
          ? ""
          : "<td style='-webkit-text-security: disc;'>" + data.clave + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_rol_usuario + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_usuario +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
          data.id_usuario +
          ");'><span class='fa fa-trash'></span></button>";
        html += isMobile
          ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
            JSON.stringify(data) +
            ");'><span class='fa fa-info'></span></button>"
          : "";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function EscucharConsulta() {
  registrosTotales = false;
  $("#idUsuario").keyup(function () {
    if ($("#idUsuario").val()) {
      let idBuscar = $("#idUsuario").val();
      $.ajax({
        data: { idBuscar: idBuscar, accion: "CONSULTAR_ID_ROW" },
        url: urlController,
        type: "POST",
        dataType: "json",
      })
        .done(function (response) {
          if (response.length >= 1) {
            registrosTotales = true;
            ocultarAlertaDatos();
          } else {
            mostrarAlertaDatos();
          }
          var html = "";
          $.each(response, function (index, data) {
            html += "<tr>";
            html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.nombre_usuario + "</td>";
            html += isMobile
              ? ""
              : "<td style='-webkit-text-security: disc;'>" +
                data.clave +
                "</td>";
            html += isMobile ? "" : "<td>" + data.nombre_rol_usuario + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
              data.id_usuario +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
              data.id_usuario +
              ");'><span class='fa fa-trash'></span></button>";
            html += isMobile
              ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
                JSON.stringify(data) +
                ");'><span class='fa fa-info'></span></button>"
              : "";
            html += "</td>";
            html += "</tr>";
          });
          document.getElementById("datos").innerHTML = html;
        })
        .fail(function (error) {
          console.log(error.responseText);
        });
    }
  });
}

function listarFuncionario() {
  $.ajax({
    data: { accion: "LISTAR_FUNCIONARIO" },
    url: urlControllerFuncionario,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_persona +
          ">" +
          data.nombre_persona +
          "</option>";
      });
      document.getElementById("personaId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function listarRoles() {
  $.ajax({
    data: { accion: "LISTAR_ROLES" },
    url: urlControllerRolUsuario,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_rol_usuario +
          ">" +
          data.nombre_rol_usuario +
          "</option>";
      });
      document.getElementById("rolUsuarioId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function ConsultarPorId(idUsuario) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar el usuario?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: urlController,
          data: { idUsuario: idUsuario, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("personaId", response.persona_id);
            setValue("nombre", response.nombre_usuario);

            // contraseña temporal
            // setValue("clave", "12345");

            setValue("rolUsuarioId", response.rol_usuario_id);
            setValue("idUsuario", response.id_usuario);

            if (response.nombre_rol_usuario == "ADMINISTRADOR") {
              disabledInput("rolUsuarioId");
            }
            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  enabledInput("rolUsuarioId");
}

function Guardar() {
  if (Validar()) {
    $.ajax({
      url: urlController,
      data: retornarDatos("GUARDAR"),
      type: "POST",
      dataType: "json",
    })
      .done(function (response) {
        if (response == "OK") {
          MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
          Limpiar();
        } else {
          MostrarAlerta("Error!", response, "error");
        }
        Consultar();
      })
      .fail(function (error) {
        console.log(error.responseText);
      });
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
}

function Modificar() {
  if (Validar()) {
    $.ajax({
      url: urlController,
      data: retornarDatos("MODIFICAR"),
      type: "POST",
      dataType: "json",
    })
      .done(function (response) {
        if (response == "OK") {
          MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
          Limpiar();
        } else {
          MostrarAlerta("Error!", response, "error");
        }
        Consultar();
      })
      .fail(function (error) {
        console.log(error.responseText);
      });
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
  enabledInput("rolUsuarioId");
}

function Eliminar(idUsuario) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de eliminar el usuario?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: urlController,
          data: { idUsuario: idUsuario, accion: "ELIMINAR" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response == "OK") {
              swalWithBootstrapButtons.fire(
                "",
                "Registro eliminado",
                "success"
              );
            } else {
              swalWithBootstrapButtons.fire("", response, "error");
            }
            Consultar();
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  Limpiar();
}

function Validar() {
  personaId = getValue("personaId");
  nombre = getValue("nombre");
  clave = getValue("clave");
  rolUsuarioId = getValue("rolUsuarioId");

  if (!personaId || !nombre || !clave || !rolUsuarioId) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    personaId: getValue("personaId"),
    nombre: getValue("nombre"),
    clave: getValue("clave"),
    rolUsuarioId: getValue("rolUsuarioId"),
    accion: accion,
    idUsuario: getValue("idUsuario"),
  };
}

function Limpiar() {
  clearInput("idUsuario");
  clearInput("nombre");
  clearInput("clave");
  clearInput("rolUsuarioId");
  listarRoles();
  BloquearBotones(true);
}

function Cancelar() {
  BloquearBotones(false);
  Limpiar();
  listarFuncionario();
  enabledInput("rolUsuarioId");
}

function BloquearBotones(guardar) {
  if (guardar) {
    enabledInput("guardar");
    disabledInput("modificar");
    disabledInput("cancelar");
  } else {
    disabledInput("guardar");
    enabledInput("modificar");
    enabledInput("cancelar");
  }
}

function mostrarTodo() {
  Consultar();
  clearInput("idUsuario");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
