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
});

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
        html += "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.nombre_usuario + "</td>";
        html +=
          "<td style='-webkit-text-security: disc;'>" + data.clave + "</td>";
        html += "<td>" + data.nombre_rol_usuario + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
          data.id_usuario +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
          data.id_usuario +
          ");'><span class='fa fa-trash'></span></button>";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
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
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.nombre_usuario + "</td>";
            html +=
              "<td style='-webkit-text-security: disc;'>" +
              data.clave +
              "</td>";
            html += "<td>" + data.nombre_rol_usuario + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
              data.id_usuario +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
              data.id_usuario +
              ");'><span class='fa fa-trash'></span></button>";
            html += "</td>";
            html += "</tr>";
          });
          document.getElementById("datos").innerHTML = html;
        })
        .fail(function (error) {
          console.log(error);
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
      document.getElementById("idPersona").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
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
        html += "<option>" + data.nombre_rol_usuario + "</option>";
      });
      document.getElementById("rol").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
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
            setValue("idPersona", response.nombre_persona);
            setValue("nombre", response.nombre_usuario);
            setValue("clave", response.clave);
            setValue("rol", response.nombre_rol_usuario);
            setValue("idUsuario", response.id_usuario);

            if (response.nombre_rol_usuario == "ADMINISTRADOR") {
              document.getElementById("rol").disabled = true;
            }
            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  document.getElementById("rol").disabled = false;
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
  document.getElementById("rol").disabled = false;
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
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  Limpiar();
}

function Validar() {
  idPersona = getValue("idPersona");
  nombre = getValue("nombre");
  clave = getValue("clave");
  rol = getValue("rol");

  if (!idPersona || !nombre || !clave || !rol) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    idPersona: getValue("idPersona"),
    nombre: getValue("nombre"),
    clave: getValue("clave"),
    rol: getValue("rol"),
    accion: accion,
    idUsuario: getValue("idUsuario"),
  };
}

function Limpiar() {
  clearInput("idUsuario");
  clearInput("idPersona");
  clearInput("nombre");
  clearInput("clave");
  clearInput("rol");
  listarRoles();
  BloquearBotones(true);
}

function Cancelar() {
  BloquearBotones(false);
  Limpiar();
  listarFuncionario();
  document.getElementById("rol").disabled = false;
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
