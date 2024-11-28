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

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const cedulaFuncionarioLbl = document.getElementById("cedulaFuncionarioLbl");
  const nombreFuncionarioLbl = document.getElementById("nombreFuncionarioLbl");
  const direccionFuncionarioLbl = document.getElementById(
    "direccionFuncionarioLbl"
  );
  const telefonoFuncionarioLbl = document.getElementById(
    "telefonoFuncionarioLbl"
  );
  const cargoIdLbl = document.getElementById("cargoIdLbl");
  const unidadIdLbl = document.getElementById("unidadIdLbl");
  const tipoContratoLbl = document.getElementById("tipoContratoLbl");
  const salarioBaseLbl = document.getElementById("salarioBaseLbl");

  if (isMobile) {
    // Comentar para mantener
    // cedulaFuncionarioLbl.style.display = "none";
    // nombreFuncionarioLbl.style.display = "none";
    direccionFuncionarioLbl.style.display = "none";
    telefonoFuncionarioLbl.style.display = "none";
    cargoIdLbl.style.display = "none";
    unidadIdLbl.style.display = "none";
    tipoContratoLbl.style.display = "none";
    salarioBaseLbl.style.display = "none";
  } else {
    // cedulaFuncionarioLbl.style.display = "table-cell";
    // nombreFuncionarioLbl.style.display = "table-cell";
    direccionFuncionarioLbl.style.display = "table-cell";
    telefonoFuncionarioLbl.style.display = "table-cell";
    cargoIdLbl.style.display = "table-cell";
    unidadIdLbl.style.display = "table-cell";
    tipoContratoLbl.style.display = "table-cell";
    salarioBaseLbl.style.display = "table-cell";
  }
}

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
        // Mobile Display Table
        html += "<tr>";
        html += "<td>" + data.cedula + "</td>";
        html += "<td>" + data.nombre_persona + "</td>";
        html += isMobile ? "" : "<td>" + data.direccion + "</td>";
        html += isMobile ? "" : "<td>" + data.telefono + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_cargo + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_unidad + "</td>";
        html += isMobile ? "" : "<td>" + data.tipo_contrato + "</td>";
        html += isMobile ? "" : "<td>" + data.salario_base + "</td>";
        html += isMobile
          ? "<td style='text-align: right;'>"
          : "<td style='text-align: center;'>";
        html +=
          "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verHorarios(" +
          data.id_persona +
          ");'><span class='fa fa-calendar'></span></button>";
        html +=
          "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_persona +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
          data.id_persona +
          ");'><span class='fa fa-trash'></span></button>";
        // Mobile Display Table
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
            // Mobile Display Table
            html += "<tr>";
            html += "<td>" + data.cedula + "</td>";
            html += "<td>" + data.nombre_persona + "</td>";
            html += isMobile ? "" : "<td>" + data.direccion + "</td>";
            html += isMobile ? "" : "<td>" + data.telefono + "</td>";
            html += isMobile ? "" : "<td>" + data.nombre_cargo + "</td>";
            html += isMobile ? "" : "<td>" + data.nombre_unidad + "</td>";
            html += isMobile ? "" : "<td>" + data.tipo_contrato + "</td>";
            html += isMobile ? "" : "<td>" + data.salario_base + "</td>";
            html += isMobile
              ? "<td style='text-align: right;'>"
              : "<td style='text-align: center;'>";
            html +=
              "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verHorarios(" +
              data.id_persona +
              ");'><span class='fa fa-calendar'></span></button>";
            html +=
              "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
              data.id_persona +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
              data.id_persona +
              ");'><span class='fa fa-trash'></span></button>";
            // Mobile Display Table
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

function verHorarios(idPersona) {
  window.location.href =
    "../personaHorarioOficina/personaHorarioOficina.php?idPersona=" + idPersona;
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
        html +=
          "<option value=" +
          data.id_cargo +
          ">" +
          data.nombre_cargo +
          "</option>";
      });
      document.getElementById("cargoId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
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
        html +=
          "<option value=" +
          data.id_unidad +
          ">" +
          data.nombre_unidad +
          "</option>";
      });
      document.getElementById("unidadId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
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
            console.log(response);
            setValue("cedulaFuncionario", response.cedula);
            setValue("nombreFuncionario", response.nombre_persona);
            setValue("direccionFuncionario", response.direccion);
            setValue("telefonoFuncionario", response.telefono);
            setValue("cargoId", response.cargo_id);
            setValue("unidadId", response.unidad_id);
            setValue("tipoContrato", response.tipo_contrato);
            setValue("salarioBase", response.salario_base);
            setValue("idFuncionario", response.id_persona);

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
  cedulaFuncionario = getValue("cedulaFuncionario");
  nombreFuncionario = getValue("nombreFuncionario");
  direccionFuncionario = getValue("direccionFuncionario");
  telefonoFuncionario = getValue("telefonoFuncionario");
  cargoId = getValue("cargoId");
  unidadId = getValue("unidadId");
  tipoContrato = getValue("tipoContrato");
  salarioBase = getValue("salarioBase");

  if (
    !cedulaFuncionario ||
    !nombreFuncionario ||
    !direccionFuncionario ||
    !telefonoFuncionario ||
    !cargoId ||
    !unidadId ||
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
    cargoId: getValue("cargoId"),
    unidadId: getValue("unidadId"),
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
  clearInput("cargoId");
  clearInput("unidadId");
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
  Limpiar();
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
