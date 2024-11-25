var urlController = "./asistencia.controller.php";
var urlControllerPersonaHorarioOficina = "../personaHorarioOficina/personaHorarioOficina.controller.php";
var registrosTotales = false;

// Obtener la fecha actual
const hoy = new Date();
var personaId;
var htmlList = "";
let timeoutID;
let MarcacionesDiariasPorOficina = 1;
let contadorInterno = 0;

ActualizarParametros = () => {
  // Formatear la fecha en el formato "YYYY-MM-DD"
  const año = hoy.getFullYear();
  const mes = String(hoy.getMonth() + 1).padStart(2, "0"); // Los meses van de 0 a 11
  const dia = String(hoy.getDate()).padStart(2, "0");

  // Formatear la hora en formato "HH:MM"
  const horas = String(hoy.getHours()).padStart(2, "0");
  const minutos = String(hoy.getMinutes()).padStart(2, "0");

  const fechaFormateada = `${año}-${mes}-${dia}`;
  const horaFormateada = `${horas}:${minutos}`;

  setValue("fechaAsistencia", fechaFormateada);
  setValue("horaAsistencia", horaFormateada);

  return fechaFormateada;
};

// Precarga del Script
$(document).ready(function () {
  personaId = params.get("personaId");

  ConsultarTodo(personaId);
  fechaActual = ActualizarParametros();
  listarOficina(personaId, fechaActual);
  ocultarAlertaTrabajo();
  EscucharConsulta();
});

function listarOficina(personaId, fechaActual) {
  $.ajax({
    data: { accion: "LISTAR_OFICINA_BY_FUNCIONARIO_DATE", personaId, fechaActual },
    url: urlControllerPersonaHorarioOficina,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      if (response.length == 0) {
        mostrarAlertaTrabajo();
      }

      $.each(response, function (index, data) {
        countAsistencia(
          personaId,
          data.id_oficina,
          fechaActual,
          data.nombre_oficina
        );
      });

      timeoutID = setTimeout(function () {
        document.getElementById("oficinaId").innerHTML = htmlList;
        if (contadorInterno === 0) {
          document.getElementById("registrarEntrada").disabled = true;
          mostrarAlertaTrabajo();
        }
      }, 1000);
    })
    .fail(function (error) {
      console.log(error);
    });
  clearTimeout(timeoutID);
}

function ConsultarTodo(personaId) {
  registrosTotales = false;
  $.ajax({
    data: { accion: "CONSULTAR_TODO", id_persona: personaId },
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
        // Formatear datos null
        if (data.fecha_s_asistencia == null) {
          data = {
            ...data,
            fecha_s_asistencia: "S/R",
            hora_s_asistencia: "S/R",
            latitud_s_asistencia: "S/R",
            longitud_s_asistencia: "S/R",
            observaciones_s_asistencia: "S/R",
          };
        }

        html += "<tr>";
        html += "<td>" + data.id_asistencia + "</td>";
        html += "<td>" + data.nombre_oficina + "</td>";
        html += "<td>" + "Entrada" + "</td>";
        html += "<td>" + data.fecha_e_asistencia + "</td>";
        html += "<td>" + data.hora_e_asistencia + "</td>";
        html += "<td>" + data.latitud_e_asistencia + "</td>";
        html += "<td>" + data.longitud_e_asistencia + "</td>";
        html += "<td>" + data.observaciones_e_asistencia + "</td>";
        html += "<td style='text-align: center;'>";
        html += `<button class='btn btn-info mr-1' onclick='registrarSalida(${
          data.id_asistencia
        });' ${
          data.fecha_s_asistencia === "S/R" ? "" : "disabled"
        } ><span class='fa fa-save'></span>&nbsp&nbspR. Salida</button>`;
        html += "</td>";
        html += "</tr>";
        // datos de salida
        html += "<tr>";
        html += "<td>" + "" + "</td>";
        html += "<td>" + "" + "</td>";
        html += "<td>" + "Salida" + "</td>";
        html += "<td>" + data.fecha_s_asistencia + "</td>";
        html += "<td>" + data.hora_s_asistencia + "</td>";
        html += "<td>" + data.latitud_s_asistencia + "</td>";
        html += "<td>" + data.longitud_s_asistencia + "</td>";
        html += "<td>" + data.observaciones_s_asistencia + "</td>";
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
  $("#idAsistenciaQuery").change(function () {
    if ($("#idAsistenciaQuery").val()) {
      let fecha = $("#idAsistenciaQuery").val();
      $.ajax({
        data: {
          id_persona: personaId,
          fecha: fecha,
          accion: "CONSULTAR_ID_PERSONA_FECHA",
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
            // Formatear datos null
            if (data.fecha_s_asistencia == null) {
              data = {
                ...data,
                fecha_s_asistencia: "S/R",
                hora_s_asistencia: "S/R",
                latitud_s_asistencia: "S/R",
                longitud_s_asistencia: "S/R",
                observaciones_s_asistencia: "S/R",
              };
            }

            html += "<tr>";
            html += "<td>" + data.id_asistencia + "</td>";
            html += "<td>" + data.nombre_oficina + "</td>";
            html += "<td>" + "Entrada" + "</td>";
            html += "<td>" + data.fecha_e_asistencia + "</td>";
            html += "<td>" + data.hora_e_asistencia + "</td>";
            html += "<td>" + data.latitud_e_asistencia + "</td>";
            html += "<td>" + data.longitud_e_asistencia + "</td>";
            html += "<td>" + data.observaciones_e_asistencia + "</td>";
            html += "<td style='text-align: center;'>";
            html += `<button class='btn btn-info mr-1' onclick='registrarSalida(${
              data.id_asistencia
            });' ${
              data.fecha_s_asistencia === "S/R" ? "" : "disabled"
            } ><span class='fa fa-save'></span>&nbsp&nbspR. Salida</button>`;
            html += "</td>";
            html += "</tr>";
            // datos de salida
            html += "<tr>";
            html += "<td>" + "" + "</td>";
            html += "<td>" + "" + "</td>";
            html += "<td>" + "Salida" + "</td>";
            html += "<td>" + data.fecha_s_asistencia + "</td>";
            html += "<td>" + data.hora_s_asistencia + "</td>";
            html += "<td>" + data.latitud_s_asistencia + "</td>";
            html += "<td>" + data.longitud_s_asistencia + "</td>";
            html += "<td>" + data.observaciones_s_asistencia + "</td>";
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

function registrarEntrada() {
  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro de registrar tu entrada?",
      text: "Esta acción no se puede revertir",
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
          data: retornarDatos("REGISTRAR_ENTRADA"),
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response == "OK") {
              listarOficina(personaId, fechaActual);
              MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
              Limpiar();
            } else {
              MostrarAlerta("Error!", response, "error");
            }
            ConsultarTodo();
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function registrarSalida(idAsistencia) {
  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro de registrar tu salida?",
      text: "Esta acción no se puede revertir",
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
          data: { ...retornarDatos("REGISTRAR_SALIDA"), idAsistencia },
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
            ConsultarTodo();
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function countAsistencia(personaId, oficinaId, fechaActual, nombreOficina) {
  $.ajax({
    url: urlController,
    data: {
      accion: "COUNT_ASISTENCIA",
      personaId,
      oficinaId,
      fechaActual,
    },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      let contador = response[0].contador;
      if (contador <= MarcacionesDiariasPorOficina) {
        htmlList +=
          "<option value=" + oficinaId + ">" + nombreOficina + "</option>";
        contadorInterno = +1;
      }
    })
    .fail(function (error) {
      console.log(error);
    });
}

function Validar() {
  iOficina = getValue("iOficina");
  fechaAsistencia = getValue("fechaAsistencia");
  horaAsistencia = getValue("horaAsistencia");
  observacionesAsistencia = getValue("observacionesAsistencia");
  lat = getValue("lat");
  lng = getValue("lng");

  if (
    !iOficina ||
    !fechaAsistencia ||
    !horaAsistencia ||
    !observacionesAsistencia ||
    !lat ||
    !lng
  ) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    personaId,
    oficinaId: getValue("oficinaId"),
    fechaAsistencia: getValue("fechaAsistencia"),
    horaAsistencia: getValue("horaAsistencia"),
    observacionesAsistencia: getValue("observacionesAsistencia"),
    lat: getValue("lat"),
    lng: getValue("lng"),
    accion: accion,
  };
}

function Limpiar() {}

function mostrarTodo() {
  ConsultarTodo();
  clearInput("oficinaId");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function mostrarAlertaTrabajo() {
  var alertaTrabajo = document.getElementById("alertaTrabajo");
  var cabecera = document.getElementById("cabecera");
  alertaTrabajo.style.display = "block";
  cabecera.style.display = "none";
}

function ocultarAlertaTrabajo() {
  var alertaTrabajo = document.getElementById("alertaTrabajo");
  var cabecera = document.getElementById("cabecera");
  alertaTrabajo.style.display = "none";
  cabecera.style.display = "flex";
}
