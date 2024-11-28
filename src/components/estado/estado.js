var urlController = "./estado.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  Consultar();
  EscucharConsulta();
  BloquearBotones(true);
});

function soloLetras() {
  $("#nombre").keypress(function (event) {
    if (event.which < 65 || event.which > 122) {
      return false;
    }
  });
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
        html += "<td>" + data.nombre_estado + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_estado +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
          data.id_estado +
          ");'><span class='fa fa-trash'></span></button>";
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
  $("#idEstado").keyup(function () {
    if ($("#idEstado").val()) {
      let idBuscar = $("#idEstado").val();
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
            html += "<td>" + data.nombre_estado + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
              data.id_estado +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
              data.id_estado +
              ");'><span class='fa fa-trash'></span></button>";
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

function ConsultarPorId(idEstado) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar el estado?",
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
          data: { idEstado: idEstado, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("nombre", response.nombre_estado);
            setValue("idEstado", response.id_estado);
            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
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
}

function Eliminar(idEstado) {
  var registros = 0;
  $.ajax({
    url: urlController,
    data: { idEstado: idEstado, accion: "CONSULTAR_REGISTROS" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      swalWithBootstrapButtons
        .fire({
          title:
            "¿Estas seguro de eliminar el estado? Contiene " +
            registros +
            " activos registrados",
          text: "Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a este estado",
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
              data: { idEstado: idEstado, accion: "ELIMINAR" },
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
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function Validar() {
  nombreEstado = getValue("nombre");

  if (!nombreEstado) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    nombreEstado: getValue("nombre").toUpperCase(),
    accion: accion,
    idEstado: getValue("idEstado"),
  };
}

function Limpiar() {
  clearInput("idEstado");
  clearInput("nombre");
  BloquearBotones(true);
}

function Cancelar() {
  BloquearBotones(false);
  Limpiar();
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
  clearInput("idEstado");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
