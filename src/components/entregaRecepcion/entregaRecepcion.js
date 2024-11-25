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
});

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
      console.log(error);
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
        html += "<option>" + data.activo + "</option>";
      });
      document.getElementById("activo").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
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
        html += "<td>" + data.fecha + "</td>";
        html += "<td>" + data.comentario + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
          data.id_entrega_recepcion +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
          data.id_entrega_recepcion +
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
            html += "<td>" + data.fecha + "</td>";
            html += "<td>" + data.comentario + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
              data.id_entrega_recepcion +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
              data.id_entrega_recepcion +
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
          data: { idEntregaRecepcion: idEntregaRecepcion, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            console.log(response)
            setValue("idPersona", response.persona_id);
            setValue("codigoActivo", response.codigo);
            setValue("fecha", response.fecha);
            setValue("comentario", response.comentario);
            setValue("idEntregaRecepcion", response.id_entrega_recepcion);
            document.getElementById("codigoActivo").disabled = true;
            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function Guardar() {
  console.log(retornarDatos("GUARDAR"))
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
        console.log(error);
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
  document.getElementById("codigoActivo").disabled = false;
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
