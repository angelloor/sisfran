var urlController = "./reporteHoras.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlGet = "";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  cargaInicial();
  listarFuncionario();
});

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
        let tiempoFinal =
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
        };

        html += "<tr>";
        html += "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.nombre_oficina + "</td>";
        html += "<td>" + data.fecha_e_asistencia + "</td>";
        html += "<td>" + data.hora_e_asistencia + "</td>";
        html += "<td>" + data.fecha_s_asistencia + "</td>";
        html += "<td>" + data.hora_s_asistencia + "</td>";
        html += "<td>" + tiempoFinal + "</td>";
        html += "</tr>";
      });

      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
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
          let tiempoFinal =
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
          };

          html += "<tr>";
          html += "<td>" + data.nombre_persona + "</td>";
          html += "<td>" + data.nombre_oficina + "</td>";
          html += "<td>" + data.fecha_e_asistencia + "</td>";
          html += "<td>" + data.hora_e_asistencia + "</td>";
          html += "<td>" + data.fecha_s_asistencia + "</td>";
          html += "<td>" + data.hora_s_asistencia + "</td>";
          html += "<td>" + tiempoFinal + "</td>";
          html += "</tr>";
        });

        document.getElementById("datos").innerHTML = html;
      })
      .fail(function (error) {
        console.log(error);
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
          window.open("../reportes/reporteHoras.template.php?" + urlGet, "_blank");
        }
      }
    })
    .fail(function (error) {
      MostrarAlerta("", "Hubo un error al generar el pdf", "error");
      console.log(error);
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
          window.open("../reportes/reporteHoras.template.php?" + urlGet, "_blank");
        }
      }
    })
    .fail(function (error) {
      MostrarAlerta("", "Hubo un error al generar el pdf", "error");
      console.log(error);
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
