var urlController = "./horarioOficina.controller.php";
var urlControllerOficina = "../oficina/oficina.controller.php";

// Extraer el valor del parámetro 'id'
let idOficina;
let oficina;

// Precarga del Script
$(document).ready(function () {
  idOficina = params.get("idOficina");
  ConsultarOficinaPorId(idOficina);
  ConsultarHorariosPorIdOficina(idOficina);
  BloquearBotones(true);

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const idOficinaLbl = document.getElementById("idOficinaLbl");
  const horaEntradaLbl = document.getElementById("horaEntradaLbl");
  const horaSalidaLbl = document.getElementById("horaSalidaLbl");
  const saltoDiaLbl = document.getElementById("saltoDiaLbl");

  if (isMobile) {
    // Comentar para mantener
    // idOficinaLbl.style.display = "none";
    // horaEntradaLbl.style.display = "none";
    // horaSalidaLbl.style.display = "none";
    saltoDiaLbl.style.display = "none";
  } else {
    // idOficinaLbl.style.display = "table-cell";
    // horaEntradaLbl.style.display = "table-cell";
    // horaSalidaLbl.style.display = "table-cell";
    saltoDiaLbl.style.display = "table-cell";
  }
}

function ConsultarOficinaPorId(idOficina) {
  $.ajax({
    url: urlControllerOficina,
    data: { idOficina, accion: "CONSULTAR_ID" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      oficina = response;
      document.getElementById("nombreOficina").innerText =
        response.nombre_oficina;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function ConsultarHorariosPorIdOficina(idOficina) {
  registrosTotales = false;
  $.ajax({
    data: {
      id_oficina: idOficina,
      accion: "CONSULTAR_HORARIOS_POR_ID_OFICINA",
    },
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
        html += "<td>" + data.id_horario_oficina + "</td>";
        html += "<td>" + data.hora_entrada + "</td>";
        html += "<td>" + data.hora_salida + "</td>";
        html += isMobile ? "" : "<td>" + data.salto_dia + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_horario_oficina +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
          data.id_horario_oficina +
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

function ConsultarPorId(idHorarioOficina) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar la oficina?",
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
            id_horario_oficina: idHorarioOficina,
            accion: "CONSULTAR_ID",
          },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("idHorarioOficina", response.id_horario_oficina);
            setValue("horaEntrada", response.hora_entrada);
            setValue("horaSalida", response.hora_salida);
            setValue("saltoDia", response.salto_dia);
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
        ConsultarHorariosPorIdOficina(idOficina);
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
        ConsultarHorariosPorIdOficina(idOficina);
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

function Eliminar(idHorarioOficina) {
  var registros = 0;

  $.ajax({
    url: urlController,
    data: {
      id_horario_oficina: idHorarioOficina,
      accion: "CONSULTAR_REGISTROS",
    },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      if (registros == 0) {
        swalWithBootstrapButtons
          .fire({
            title: "¿Estas seguro de eliminar la oficina?",
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
                  id_horario_oficina: idHorarioOficina,
                  accion: "ELIMINAR",
                },
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
                  ConsultarHorariosPorIdOficina(idOficina);
                })
                .fail(function (error) {
                  console.log(error.responseText);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
            }
          });
      } else {
        swalWithBootstrapButtons
          .fire({
            title:
              "¿Estas seguro de eliminar la oficina? Contiene registros en las tablas asociadas",
            text: "Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a esta oficina",
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
                  id_horario_oficina: idHorarioOficina,
                  accion: "ELIMINAR",
                },
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
                  ConsultarHorariosPorIdOficina(idOficina);
                })
                .fail(function (error) {
                  console.log(error.responseText);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
            }
          });
      }

      Limpiar();
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function Validar() {
  hora_entrada = getValue("horaEntrada");
  hora_salida = getValue("horaSalida");
  salto_dia = getValue("saltoDia");

  if (!hora_entrada || !hora_salida || !salto_dia) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    id_oficina: idOficina,
    hora_entrada: getValue("horaEntrada"),
    hora_salida: getValue("horaSalida"),
    salto_dia: getValue("saltoDia"),
    accion: accion,
    id_horario_oficina: getValue("idHorarioOficina"),
  };
}

function Limpiar() {
  clearInput("horaEntrada");
  clearInput("horaSalida");
  clearInput("saltoDia");
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
  ConsultarHorariosPorIdOficina(idOficina);
}

function regresarOficinas() {
  window.location.href = "../oficina/oficina.php";
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
