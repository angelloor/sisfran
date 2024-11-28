var urlController = "./personaHorarioOficina.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";

// Extraer el valor del parámetro 'id'
let idPersona;
let rolUsuario;
let person;
let idPersonaHorarioOficinaModify;

let timeoutID;

// Precarga del Script
$(document).ready(function () {
  idPersona = params.get("idPersona");
  rolUsuario = params.get("rolUsuario");

  ConsultarPersonPorId(idPersona);

  BloquearBotones(true);

  ConsultarPorIdPerson(idPersona);

  listarOficina();

  EscucharConsulta();

  // Detectar el cambio de oficina
  document.getElementById("idOficina").addEventListener("change", function () {
    let idOficina = this.value;
    listarHorarioOficina(idOficina);
  });

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const fechaLbl = document.getElementById("fechaLbl");
  const oficinaLbl = document.getElementById("oficinaLbl");
  const horarioLbl = document.getElementById("horarioLbl");
  const notaLbl = document.getElementById("notaLbl");

  if (isMobile) {
    // Comentar para mantener
    // fechaLbl.style.display = "none";
    // oficinaLbl.style.display = "none";
    horarioLbl.style.display = "none";
    notaLbl.style.display = "none";
  } else {
    // fechaLbl.style.display = "table-cell";
    // oficinaLbl.style.display = "table-cell";
    horarioLbl.style.display = "table-cell";
    notaLbl.style.display = "table-cell";
  }
}

function ConsultarPersonPorId(idPersona) {
  $.ajax({
    url: urlControllerFuncionario,
    data: { idFuncionario: idPersona, accion: "CONSULTAR_ID" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      person = response;
      document.getElementById("nombrePersona").innerText =
        response.nombre_persona;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function ConsultarPorIdPerson(idPersona) {
  registrosTotales = false;
  $.ajax({
    url: urlController,
    data: { id_persona: idPersona, accion: "CONSULTAR_POR_ID_PERSONA" },
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
        html +=
          "<td>" +
          ajustarFecha(
            data.fecha_persona_horario_oficina
          ).toLocaleDateString() +
          "</td>";
        html += "<td>" + data.nombre_oficina + "</td>";
        html += isMobile
          ? ""
          : "<td>" + data.hora_entrada + " - " + data.hora_salida + "</td>";
        html += isMobile
          ? ""
          : "<td>" + data.nota_persona_horario_oficina + "</td>";
        html += "<td style='text-align: right;'>";
        html += isMobile
          ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
            JSON.stringify(data) +
            ");'><span class='fa fa-info'></span></button>"
          : "";
        if (rolUsuario != "ASISTENTE") {
          html +=
            "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
            data.id_persona_horario_oficina +
            ");'><span class='fa fa-edit'></span></button>";
          html +=
            "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
            data.id_persona_horario_oficina +
            ");'><span class='fa fa-trash'></span></button>";
          html += "</td>";
        }
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function listarOficina() {
  $.ajax({
    data: { accion: "LISTAR_OFICINA" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        if (index === 0) {
          listarHorarioOficina(data.id_oficina);
        }
        html +=
          "<option value=" +
          data.id_oficina +
          ">" +
          data.nombre_oficina +
          "</option>";
      });
      document.getElementById("idOficina").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function listarHorarioOficina(idOficina) {
  $.ajax({
    data: { id_oficina: idOficina, accion: "LISTAR_HORARIO_OFICINA" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_horario_oficina +
          ">" +
          data.hora_entrada +
          " - " +
          data.hora_salida +
          "</option>";
      });
      document.getElementById("idHorarioOficina").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
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
        ConsultarPorIdPerson(idPersona);
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

function ConsultarPorId(idPersonaHorarioOficina) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar este horario?",
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
            id_persona_horario_oficina: idPersonaHorarioOficina,
            accion: "CONSULTAR_ID",
          },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            // establecer el id a editar
            idPersonaHorarioOficinaModify = response.id_persona_horario_oficina;
            setValue(
              "fechaPersonaHorarioOficina",
              response.fecha_persona_horario_oficina
            );
            setValue(
              "notaPersonaHorarioOficina",
              response.nota_persona_horario_oficina
            );
            setValue("idOficina", response.id_oficina);

            listarHorarioOficina(response.id_oficina);

            timeoutID = setTimeout(function () {
              setValue("idHorarioOficina", response.horario_oficina_id);
            }, 10);

            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  clearTimeout(timeoutID);
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

        ConsultarPorIdPerson(idPersona);
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

function Eliminar(idPersonaHorarioOficina) {
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
            id_persona_horario_oficina: idPersonaHorarioOficina,
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
            ConsultarPorIdPerson(idPersona);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function EscucharConsulta() {
  registrosTotales = false;
  $("#idPersonaHorarioOficina").change(function () {
    if ($("#idPersonaHorarioOficina").val()) {
      let fecha = $("#idPersonaHorarioOficina").val();
      $.ajax({
        data: {
          id_persona: idPersona,
          fecha: fecha,
          accion: "CONSULTAR_ID_ROW",
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
            html +=
              "<td>" +
              ajustarFecha(
                data.fecha_persona_horario_oficina
              ).toLocaleDateString() +
              "</td>";
            html += "<td>" + data.nombre_oficina + "</td>";
            html += isMobile
              ? ""
              : "<td>" + data.hora_entrada + " - " + data.hora_salida + "</td>";
            html += isMobile
              ? ""
              : "<td>" + data.nota_persona_horario_oficina + "</td>";
            html += "<td style='text-align: right;'>";
            html += isMobile
              ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
                JSON.stringify(data) +
                ");'><span class='fa fa-info'></span></button>"
              : "";
            if (rolUsuario != "ASISTENTE") {
              html +=
                "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
                data.id_persona_horario_oficina +
                ");'><span class='fa fa-edit'></span></button>";
              html +=
                "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
                data.id_persona_horario_oficina +
                ");'><span class='fa fa-trash'></span></button>";
              html += "</td>";
            }
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

function Validar() {
  fecha_persona_horario_oficina = getValue("fechaPersonaHorarioOficina");
  horario_oficina_id = getValue("idHorarioOficina");
  nota_persona_horario_oficina = getValue("notaPersonaHorarioOficina");

  if (!fecha_persona_horario_oficina || !horario_oficina_id) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    persona_id: idPersona,
    fecha_persona_horario_oficina: getValue("fechaPersonaHorarioOficina"),
    oficina_id: getValue("idOficina"),
    horario_oficina_id: getValue("idHorarioOficina"),
    nota_persona_horario_oficina: getValue("notaPersonaHorarioOficina"),
    accion: accion,
    id_persona_horario_oficina: idPersonaHorarioOficinaModify,
  };
}

function Limpiar() {
  clearInput("idPersonaHorarioOficina");
  clearInput("fechaPersonaHorarioOficina");
  clearInput("notaPersonaHorarioOficina");
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
  ConsultarPorIdPerson(idPersona);
  Limpiar();
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function regresarFuncionario() {
  window.location.href = "../funcionario/funcionario.php";
}

function regresarMain() {
  window.location.href = "../main/main.php";
}
