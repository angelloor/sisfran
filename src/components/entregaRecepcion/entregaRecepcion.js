var urlController = "./entregaRecepcion.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlControllerActivo = "../activo/activo.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  BloquearBotones(true);
  Consultar();
  EscucharConsulta();
  listarFuncionario();
  listarActivo();
  cargarFechaActual();
  document
    .getElementById("codigoActivo")
    .addEventListener("keypress", soloNumeros, false);

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const idPersonaLbl = document.getElementById("idPersonaLbl");
  const codigoActivoLbl = document.getElementById("codigoActivoLbl");
  const fechaLbl = document.getElementById("fechaLbl");
  const comentarioLbl = document.getElementById("comentarioLbl");

  if (isMobile) {
    // Comentar para mantener
    // idPersonaLbl.style.display = "none";
    // codigoActivoLbl.style.display = "none";
    fechaLbl.style.display = "none";
    comentarioLbl.style.display = "none";
  } else {
    // idPersonaLbl.style.display = "table-cell";
    // codigoActivoLbl.style.display = "table-cell";
    fechaLbl.style.display = "table-cell";
    comentarioLbl.style.display = "table-cell";
  }
}

function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}

function cargarFechaActual() {
  var f = new Date();
  if (f.getMonth() + 1 <= 9) {
    mesFinal = "0" + (f.getMonth() + 1);
  } else {
    mesFinal = f.getMonth();
  }
  if (f.getDate() <= 9) {
    diaFinal = "0" + f.getDate();
  } else {
    diaFinal = f.getDate();
  }
  setValue("fecha", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
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
      console.log(error.responseText);
    });
}

function listarActivo() {
  $.ajax({
    data: { accion: "LISTAR_ACTIVO" },
    url: urlControllerActivo,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" + data.activo + ">" + data.activo + "</option>";
      });
      document.getElementById("activo").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
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
        html += "<td>" + data.funcionario + "</td>";
        html += "<td>" + data.codigo + "</td>";
        html += isMobile ? "" : "<td>" + data.fecha + "</td>";
        html += isMobile ? "" : "<td>" + data.comentario + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_entrega_recepcion +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
          data.id_entrega_recepcion +
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
  $("#idEntregaRecepcion").keyup(function () {
    if ($("#idEntregaRecepcion").val()) {
      $.ajax({
        data: retornarDatosConsulta("CONSULTAR_ID_ROW"),
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
            html += "<td>" + data.funcionario + "</td>";
            html += "<td>" + data.codigo + "</td>";
            html += isMobile ? "" : "<td>" + data.fecha + "</td>";
            html += isMobile ? "" : "<td>" + data.comentario + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
              data.id_entrega_recepcion +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
              data.id_entrega_recepcion +
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

function ConsultarPorId(idEntregaRecepcion) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar el registro?",
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
          data: {
            idEntregaRecepcion: idEntregaRecepcion,
            accion: "CONSULTAR_ID",
          },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("idPersona", response.persona_id);
            setValue("codigoActivo", response.codigo);
            setValue("fecha", response.fecha);
            setValue("comentario", response.comentario);
            setValue("idEntregaRecepcion", response.id_entrega_recepcion);
            disabledInput("codigoActivo");
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

function Eliminar(idEntregaRecepcion) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de eliminar el registro?",
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
          data: { idEntregaRecepcion: idEntregaRecepcion, accion: "ELIMINAR" },
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
  idPersona = getValue("idPersona");
  codigoActivo = getValue("codigoActivo");
  fecha = getValue("fecha");
  comentario = getValue("comentario");

  if (!idPersona || !codigoActivo || !fecha || !comentario) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    idPersona: getValue("idPersona"),
    codigoActivo: getValue("codigoActivo"),
    fecha: getValue("fecha"),
    comentario: getValue("comentario"),
    accion: accion,
    idEntregaRecepcion: getValue("idEntregaRecepcion"),
  };
}

function retornarDatosConsulta(accion) {
  return {
    campoBuscar: getValue("campoBuscar"),
    accion: accion,
    idEntregaRecepcion: getValue("idEntregaRecepcion"),
  };
}

function Limpiar() {
  clearInput("idEntregaRecepcion");
  clearInput("codigoActivo");
  enabledInput("codigoActivo");
  listarFuncionario();
  cargarFechaActual();
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
  clearInput("idEntregaRecepcion");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
