var urlController = "./activosNoConfirmados.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  consultar();
  ocultarAlertaDatos();

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const codigoLbl = document.getElementById("codigoLbl");
  const nombreLbl = document.getElementById("nombreLbl");
  const caracteristicaLbl = document.getElementById("caracteristicaLbl");
  const marcaIdLbl = document.getElementById("marcaIdLbl");
  const modeloLbl = document.getElementById("modeloLbl");
  const serieLbl = document.getElementById("serieLbl");
  const estadoIdLbl = document.getElementById("estadoIdLbl");
  const acciones = document.getElementById("acciones");

  if (isMobile) {
    // Comentar para mantener
    // codigoLbl.style.display = "none";
    // nombreLbl.style.display = "none";
    caracteristicaLbl.style.display = "none";
    marcaIdLbl.style.display = "none";
    modeloLbl.style.display = "none";
    serieLbl.style.display = "none";
    estadoIdLbl.style.display = "none";
  } else {
    // codigoLbl.style.display = "table-cell";
    // nombreLbl.style.display = "table-cell";
    caracteristicaLbl.style.display = "table-cell";
    marcaIdLbl.style.display = "table-cell";
    modeloLbl.style.display = "table-cell";
    serieLbl.style.display = "table-cell";
    estadoIdLbl.style.display = "table-cell";
    acciones.style.display = "none";
  }
}

function consultar() {
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
        html += "<td>" + data.codigo + "</td>";
        html += "<td>" + data.nombre_activo + "</td>";
        html += isMobile ? "" : "<td>" + data.caracteristica + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_marca + "</td>";
        html += isMobile ? "" : "<td>" + data.modelo + "</td>";
        html += isMobile ? "" : "<td>" + data.serie + "</td>";
        html += isMobile ? "" : "<td>" + data.nombre_estado + "</td>";
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

function pdf() {
  accion = "pdf";
  if (registrosTotales == false) {
    MostrarAlerta("", "No se encuentra activos no confirmados", "info");
    return;
  } else {
    window.open(
      "../reportes/activosNoConfirmados.template.php?accion=" + accion,
      "_blank"
    );
  }
}

function excel() {
  accion = "excel";
  if (registrosTotales == false) {
    MostrarAlerta("", "No se encuentra activos no confirmados", "info");
    return;
  } else {
    window.open(
      "../reportes/activosNoConfirmados.template.php?accion=" + accion,
      "_blank"
    );
  }
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
