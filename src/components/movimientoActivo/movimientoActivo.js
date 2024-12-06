var urlController = "./movimientoActivo.controller.php";
var urlGet = "";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  cargarFechaActual();
  Consultar();
  ocultarAlertaDatos();

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const idMovimientoActivoLbl = document.getElementById(
    "idMovimientoActivoLbl"
  );
  const codigoLbl = document.getElementById("codigoLbl");
  const nombreFuncionarioLbl = document.getElementById("nombreFuncionarioLbl");
  const fechaMovimientoLbl = document.getElementById("fechaMovimientoLbl");
  const acciones = document.getElementById("acciones");

  if (isMobile) {
    // Comentar para mantener
    idMovimientoActivoLbl.style.display = "none";
    // codigoLbl.style.display = "none";
    nombreFuncionarioLbl.style.display = "none";
    // fechaMovimientoLbl.style.display = "none";
  } else {
    idMovimientoActivoLbl.style.display = "table-cell";
    // codigoLbl.style.display = "table-cell";
    nombreFuncionarioLbl.style.display = "table-cell";
    // fechaMovimientoLbl.style.display = "table-cell";
    acciones.style.display = "none";
  }
}

function pdf() {
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        urlGet = "";
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        accion = "pdf";
        if (registrosTotales == false) {
          MostrarAlerta(
            "",
            "No se encuentran registros de " + fechaInicio + " a " + fechaFinal,
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "fechaInicio=" +
            fechaInicio +
            "&fechaFinal=" +
            fechaFinal +
            "&accion=" +
            accion;
          window.open(
            "../reportes/movimientoActivo.template.php?" + urlGet,
            "_blank"
          );
        }
      }
    }
  }
}

function excel() {
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        urlGet = "";
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        accion = "excel";
        if (registrosTotales == false) {
          MostrarAlerta(
            "",
            "No se encuentran registros de " + fechaInicio + " a " + fechaFinal,
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "fechaInicio=" +
            fechaInicio +
            "&fechaFinal=" +
            fechaFinal +
            "&accion=" +
            accion;
          window.open(
            "../reportes/movimientoActivo.template.php?" + urlGet,
            "_blank"
          );
        }
      }
    }
  }
}

function comprobarFechas() {
  fechaInicio = getValue("fechaInicio");
  fechaFinal = getValue("fechaFinal");

  if (!fechaInicio && !fechaFinal) {
    return 1;
  } else {
    if (!fechaInicio) {
      return 2;
    } else {
      if (!fechaFinal) {
        return 3;
      }
    }
  }
  return 0;
}

function ConsultarPorFecha() {
  registrosTotales = false;
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        $.ajax({
          data: {
            accion: "CONSULTAR_POR_FECHA",
            fechaInicio: fechaInicio,
            fechaFinal: fechaFinal,
          },
          url: urlController,
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response.length >= 1) {
              registrosTotales = true;
            }
            var html = "";
            $.each(response, function (index, data) {
              html += "<tr>";
              html += isMobile
                ? ""
                : "<td>" + data.id_movimiento_activo + "</td>";
              html += "<td>" + data.codigo + "</td>";
              html += isMobile ? "" : "<td>" + data.nombre_funcionario + "</td>";
              html += "<td>" + data.fecha_movimiento + "</td>";
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
        html += isMobile ? "" : "<td>" + data.id_movimiento_activo + "</td>";
        html += "<td>" + data.codigo + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_funcionario + "</td>";
        html += "<td>" + data.fecha_movimiento + "</td>";
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

function cargarFechaActual() {
  var f = new Date();
  if (f.getMonth() + 1 <= 9) {
    mesFinal = "0" + (f.getMonth() + 1);
  } else {
    mesFinal = f.getMonth() + 1;
  }
  if (f.getDate() <= 9) {
    diaFinal = "0" + f.getDate();
  } else {
    diaFinal = f.getDate();
  }
  setValue("fechaInicio", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
  setValue("fechaFinal", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
