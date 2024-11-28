var urlController = "./reporteHoras.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlGet = "";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  cargaInicial();
  listarFuncionario();

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const nombrePersonaLbl = document.getElementById("nombrePersonaLbl");
  const nombreOficinaLbl = document.getElementById("nombreOficinaLbl");
  const fechaEAsistenciaLbl = document.getElementById("fechaEAsistenciaLbl");
  const horaEAsistenciaLbl = document.getElementById("horaEAsistenciaLbl");
  const fechaSAsistenciaLbl = document.getElementById("fechaSAsistenciaLbl");
  const horaSAsistenciaLbl = document.getElementById("horaSAsistenciaLbl");
  const tiempoFinalLbl = document.getElementById("tiempoFinalLbl");

  if (isMobile) {
    // Comentar para mantener
    nombrePersonaLbl.style.display = "none";
    // nombreOficinaLbl.style.display = "none";
    // fechaEAsistenciaLbl.style.display = "none";
    horaEAsistenciaLbl.style.display = "none";
    fechaSAsistenciaLbl.style.display = "none";
    horaSAsistenciaLbl.style.display = "none";
    tiempoFinalLbl.style.display = "none";
  } else {
    nombrePersonaLbl.style.display = "table-cell";
    // nombreOficinaLbl.style.display = "table-cell";
    // fechaEAsistenciaLbl.style.display = "table-cell";
    horaEAsistenciaLbl.style.display = "table-cell";
    fechaSAsistenciaLbl.style.display = "table-cell";
    horaSAsistenciaLbl.style.display = "table-cell";
    tiempoFinalLbl.style.display = "table-cell";
  }
}

function cargaInicial() {
  registrosTotales = false;
  $.ajax({
    data: { accion: "CARGA_INICIAL" },
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
        let tiempoTrabajado = calcularHorasTrabajadas(
          data.fecha_e_asistencia,
          data.hora_e_asistencia,
          data.fecha_s_asistencia,
          data.hora_s_asistencia
        );
        let tiempoTotal =
          tiempoTrabajado.horas === 0
            ? `${tiempoTrabajado.minutos}m`
            : `${tiempoTrabajado.horas}h ${tiempoTrabajado.minutos}m`;

        // Formatear datos null
        data = {
          ...data,
          fecha_s_asistencia:
            data.fecha_s_asistencia == null ? "S/R" : data.fecha_s_asistencia,
          hora_s_asistencia:
            data.hora_s_asistencia == null ? "S/R" : data.hora_s_asistencia,
          tiempo_total: tiempoTotal,
        };

        html += "<tr>";
        html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.nombre_oficina + "</td>";
        html += "<td>" + data.fecha_e_asistencia + "</td>";
        html += isMobile ? "" : "<td>" + data.hora_e_asistencia + "</td>";
        html += isMobile ? "" : "<td>" + data.fecha_s_asistencia + "</td>";
        html += isMobile ? "" : "<td>" + data.hora_s_asistencia + "</td>";
        html += isMobile ? "" : "<td>" + tiempoTotal + "</td>";
        html += "<td style='text-align: right;'>";
        html += isMobile
          ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
            JSON.stringify(data) +
            ");'><span class='fa fa-info'></span></button>"
          : "";
        html += "</tr>";
      });

      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
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
      console.log(error.responseText);
    });
}

function consultar() {
  registrosTotales = false;
  idPersona = getValue("idPersona");
  fechaInicio = getValue("fechaInicio");
  fechaFin = getValue("fechaFin");

  if (!idPersona || !fechaInicio || !fechaFin) {
    MostrarAlerta(
      "",
      "Tiene que seleccionar las opciones para la consulta",
      "info"
    );
  } else {
    $.ajax({
      data: { accion: "CONSULTAR", idPersona, fechaInicio, fechaFin },
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
          let tiempoTrabajado = calcularHorasTrabajadas(
            data.fecha_e_asistencia,
            data.hora_e_asistencia,
            data.fecha_s_asistencia,
            data.hora_s_asistencia
          );
          let tiempoTotal =
            tiempoTrabajado.horas === 0
              ? `${tiempoTrabajado.minutos}m`
              : `${tiempoTrabajado.horas}h ${tiempoTrabajado.minutos}m`;

          // Formatear datos null
          data = {
            ...data,
            fecha_s_asistencia:
              data.fecha_s_asistencia == null ? "S/R" : data.fecha_s_asistencia,
            hora_s_asistencia:
              data.hora_s_asistencia == null ? "S/R" : data.hora_s_asistencia,
            tiempo_total: tiempoTotal,
          };

          html += "<tr>";
          html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
          html += "<td>" + data.nombre_oficina + "</td>";
          html += "<td>" + data.fecha_e_asistencia + "</td>";
          html += isMobile ? "" : "<td>" + data.hora_e_asistencia + "</td>";
          html += isMobile ? "" : "<td>" + data.fecha_s_asistencia + "</td>";
          html += isMobile ? "" : "<td>" + data.hora_s_asistencia + "</td>";
          html += isMobile ? "" : "<td>" + tiempoTotal + "</td>";
          html += "<td style='text-align: right;'>";
          html += isMobile
            ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
              JSON.stringify(data) +
              ");'><span class='fa fa-info'></span></button>"
            : "";
          html += "</tr>";
        });

        document.getElementById("datos").innerHTML = html;
      })
      .fail(function (error) {
        console.log(error.responseText);
      });
  }
}

function pdf() {
  urlGet = "";
  idPersona = getValue("idPersona");
  fechaInicio = getValue("fechaInicio");
  fechaFin = getValue("fechaFin");

  $.ajax({
    data: { accion: "CONSULTAR_NOMBRE", idPersona },
    url: urlControllerFuncionario,
    type: "POST",
    dataType: "json",
  })
    .done(function ({ nombre_persona }) {
      accion = "pdf";
      if (!idPersona || !fechaInicio || !fechaFin) {
        MostrarAlerta(
          "",
          "Tiene que seleccionar las opciones para la consulta",
          "info"
        );
      } else {
        if (!registrosTotales) {
          MostrarAlerta(
            "",
            "No se encuentran registros con los parametros ingresados",
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "idPersona=" +
            idPersona +
            "&nombrePersona=" +
            nombre_persona +
            "&fechaInicio=" +
            fechaInicio +
            "&fechaFin=" +
            fechaFin +
            "&accion=" +
            accion;
          window.open(
            "../reportes/reporteHoras.template.php?" + urlGet,
            "_blank"
          );
        }
      }
    })
    .fail(function (error) {
      MostrarAlerta("", "Hubo un error al generar el pdf", "error");
      console.log(error.responseText);
    });
}

function excel() {
  urlGet = "";
  idPersona = getValue("idPersona");
  fechaInicio = getValue("fechaInicio");
  fechaFin = getValue("fechaFin");

  $.ajax({
    data: { accion: "CONSULTAR_NOMBRE", idPersona },
    url: urlControllerFuncionario,
    type: "POST",
    dataType: "json",
  })
    .done(function ({ nombre_persona }) {
      accion = "excel";
      if (!idPersona || !fechaInicio || !fechaFin) {
        MostrarAlerta(
          "",
          "Tiene que seleccionar las opciones para la consulta",
          "info"
        );
      } else {
        if (!registrosTotales) {
          MostrarAlerta(
            "",
            "No se encuentran registros con los parametros ingresados",
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "idPersona=" +
            idPersona +
            "&nombrePersona=" +
            nombre_persona +
            "&fechaInicio=" +
            fechaInicio +
            "&fechaFin=" +
            fechaFin +
            "&accion=" +
            accion;
          window.open(
            "../reportes/reporteHoras.template.php?" + urlGet,
            "_blank"
          );
        }
      }
    })
    .fail(function (error) {
      MostrarAlerta("", "Hubo un error al generar el pdf", "error");
      console.log(error.responseText);
    });
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function calcularHorasTrabajadas(
  fechaIngreso,
  horaIngreso,
  fechaSalida,
  horaSalida
) {
  if (!fechaIngreso || !horaIngreso || !fechaSalida || !horaSalida) {
    return { horas: 0, minutos: 0 };
  } else {
    // Crear objetos Date a partir de las fechas y horas proporcionadas
    const entrada = new Date(`${fechaIngreso}T${horaIngreso}`);
    const salida = new Date(`${fechaSalida}T${horaSalida}`);

    // Verificar que las fechas sean válidas
    if (isNaN(entrada.getTime()) || isNaN(salida.getTime())) {
      throw new Error("Las fechas y/u horas proporcionadas no son válidas.");
    }

    // Calcular la diferencia en milisegundos
    const diferenciaMilisegundos = salida - entrada;

    if (diferenciaMilisegundos < 0) {
      throw new Error(
        "La fecha/hora de salida no puede ser anterior a la de ingreso."
      );
    }

    // Convertir la diferencia a horas y minutos
    const totalMinutos = Math.floor(diferenciaMilisegundos / (1000 * 60));
    const horas = Math.floor(totalMinutos / 60); // Horas completas
    const minutos = totalMinutos % 60; // Minutos restantes

    // Devolver el tiempo trabajado en el formato "Xh Ym"
    return { horas, minutos };
  }
}
