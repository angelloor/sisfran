var urlController = "./activosNoConfirmados.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  consultar();
  ocultarAlertaDatos();
});

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
        html += "<td>" + data.caracteristica + "</td>";
        html += "<td>" + data.nombre_marca + "</td>";
        html += "<td>" + data.modelo + "</td>";
        html += "<td>" + data.serie + "</td>";
        html += "<td>" + data.nombre_estado + "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function pdf() {
  accion = "pdf";
  if (registrosTotales == false) {
    MostrarAlerta("", "No se encuentra activos no confirmados", "info");
    return;
  } else {
    window.open("../reportes/activosNoConfirmados.template.php?accion=" + accion, "_blank");
  }
}

function excel() {
  accion = "excel";
  if (registrosTotales == false) {
    MostrarAlerta("", "No se encuentra activos no confirmados", "info");
    return;
  } else {
    window.open("../reportes/activosNoConfirmados.template.php?accion=" + accion, "_blank");
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
