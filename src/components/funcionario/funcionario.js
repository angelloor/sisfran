var urlController = "./funcionario.controller.php";
var urlControllerCargo = "../cargo/cargo.controller.php";
var urlControllerUnidad = "../unidad/unidad.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  Consultar();
  EscucharConsulta();
  BloquearBotones(true);
  listarCargo();
  listarUnidad();
  document
    .getElementById("cedulaFuncionario")
    .addEventListener("keypress", soloNumeros, false);
  document
    .getElementById("telefonoFuncionario")
    .addEventListener("keypress", soloNumeros, false);
});

function soloNumeros(e) {
  input = document.getElementById("telefonoFuncionario");
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57 || input.value.length === 13) {
    e.preventDefault();
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
        html += "<td>" + data.cedula + "</td>";
        html += "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.direccion + "</td>";
        html += "<td>" + data.telefono + "</td>";
        html += "<td>" + data.nombre_cargo + "</td>";
        html += "<td>" + data.nombre_unidad + "</td>";
        html += "<td>" + data.tipo_contrato + "</td>";
        html += "<td>" + data.salario_base + "</td>";
        html += "<td style='text-align: center;'>";
        html +=
          "<button class='btn btn-info mr-1' onclick='verHorarios(" +
          data.id_persona +
          ");'><span class='fa fa-calendar'></span></button>";
        html +=
          "<button class='btn btn-success' onclick='ConsultarPorId(" +
          data.id_persona +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" +
          data.id_persona +
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
  $("#idFuncionario").keyup(function () {
    if ($("#idFuncionario").val()) {
      let idBuscar = $("#idFuncionario").val();
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
            html += "<td>" + data.cedula + "</td>";
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.direccion + "</td>";
            html += "<td>" + data.telefono + "</td>";
            html += "<td>" + data.nombre_cargo + "</td>";
            html += "<td>" + data.nombre_unidad + "</td>";
            html += "<td>" + data.tipo_contrato + "</td>";
            html += "<td>" + data.salario_base + "</td>";
            html += "<td style='text-align: center;'>";
            html +=
              "<button class='btn btn-info mr-1' onclick='verHorarios(" +
              data.id_persona +
              ");'><span class='fa fa-calendar'></span></button>";
            html +=
              "<button class='btn btn-success' onclick='ConsultarPorId(" +
              data.id_persona +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" +
              data.id_persona +
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

function verHorarios(idPersona) {
  window.location.href = "../personaHorarioOficina/personaHorarioOficina.php?idPersona=" + idPersona;
}

function listarCargo() {
  $.ajax({
    data: { accion: "LISTAR_CARGO" },
    url: urlControllerCargo,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre_cargo + "</option>";
      });
      document.getElementById("cargoFuncionario").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarUnidad() {
  $.ajax({
    data: { accion: "LISTAR_UNIDAD" },
    url: urlControllerUnidad,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre_unidad + "</option>";
      });
      document.getElementById("unidadFuncionario").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function ConsultarPorId(idFuncionario) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar al funcionario?",
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
          data: { idFuncionario: idFuncionario, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("cedulaFuncionario", response.cedula);
            setValue("nombreFuncionario", response.nombre_persona);
            setValue("direccionFuncionario", response.direccion);
            setValue("telefonoFuncionario", response.telefono);
            setValue("cargoFuncionario", response.nombre_cargo);
            setValue("unidadFuncionario", response.nombre_unidad);
            setValue("tipoContrato", response.tipo_contrato);
            setValue("salarioBase", response.salario_base);
            setValue("idFuncionario", response.id_persona);

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

function Eliminar(idFuncionario) {
  var registros = 0;
  $.ajax({
    url: urlController,
    data: { idFuncionario: idFuncionario, accion: "CONSULTAR_REGISTROS" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      swalWithBootstrapButtons
        .fire({
          title:
            "¿Estas seguro de eliminar el funcionario? Esta asignado a " +
            registros +
            " actas de entrega recepción ",
          text: "Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a este funcionario",
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
              data: { idFuncionario: idFuncionario, accion: "ELIMINAR" },
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
    })
    .fail(function (error) {
      console.log(error);
    });
}

function Validar() {
  cedulaFuncionario = getValue("cedulaFuncionario");
  nombreFuncionario = getValue("nombreFuncionario");
  direccionFuncionario = getValue("direccionFuncionario");
  telefonoFuncionario = getValue("telefonoFuncionario");
  cargoFuncionario = getValue("cargoFuncionario");
  unidadFuncionario = getValue("unidadFuncionario");
  tipoContrato = getValue("unidadFuncionario");
  salarioBase = getValue("unidadFuncionario");

  if (
    !cedulaFuncionario ||
    !nombreFuncionario ||
    !direccionFuncionario ||
    !telefonoFuncionario ||
    !cargoFuncionario ||
    !unidadFuncionario ||
    !tipoContrato ||
    !salarioBase
  ) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    cedulaFuncionario: getValue("cedulaFuncionario"),
    nombreFuncionario: getValue("nombreFuncionario").toUpperCase(),
    direccionFuncionario: getValue("direccionFuncionario").toUpperCase(),
    telefonoFuncionario: getValue("telefonoFuncionario"),
    cargoFuncionario: getValue("cargoFuncionario"),
    unidadFuncionario: getValue("unidadFuncionario"),
    tipoContrato: getValue("tipoContrato"),
    salarioBase: getValue("salarioBase"),
    idFuncionario: getValue("idFuncionario"),
    accion: accion,
  };
}

function Limpiar() {
  clearInput("idFuncionario");
  clearInput("cedulaFuncionario");
  clearInput("nombreFuncionario");
  clearInput("direccionFuncionario");
  clearInput("telefonoFuncionario");
  clearInput("cargoFuncionario");
  clearInput("unidadFuncionario");
  clearInput("tipoContrato");
  clearInput("salarioBase");
  listarCargo();
  listarUnidad();
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
  clearInput("idFuncionario");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
