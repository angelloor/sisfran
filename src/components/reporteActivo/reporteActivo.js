var urlController = "./reporteActivo.controller.php";
var urlGet = "";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  document
    .getElementById("campo")
    .addEventListener("change", listaValor, false);

  document.getElementById("valor").addEventListener("change", consultar, false);
  ocultarAlertaDatos();
  cargarValor();
  cargaInicial();

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const codigoLbl = document.getElementById("codigoLbl");
  const nombreActivoLbl = document.getElementById("nombreActivoLbl");
  const caracteristicaLbl = document.getElementById("caracteristicaLbl");
  const nombreMarcaLbl = document.getElementById("nombreMarcaLbl");
  const modeloLbl = document.getElementById("modeloLbl");
  const serieLbl = document.getElementById("serieLbl");
  const nombreEstadoLbl = document.getElementById("nombreEstadoLbl");
  const acciones = document.getElementById("acciones");

  if (isMobile) {
    // Comentar para mantener
    // codigoLbl.style.display = "none";
    // nombreActivoLbl.style.display = "none";
    caracteristicaLbl.style.display = "none";
    nombreMarcaLbl.style.display = "none";
    modeloLbl.style.display = "none";
    serieLbl.style.display = "none";
    nombreEstadoLbl.style.display = "none";
  } else {
    // codigoLbl.style.display = "table-cell";
    // nombreActivoLbl.style.display = "table-cell";
    caracteristicaLbl.style.display = "table-cell";
    nombreMarcaLbl.style.display = "table-cell";
    modeloLbl.style.display = "table-cell";
    serieLbl.style.display = "table-cell";
    nombreEstadoLbl.style.display = "table-cell";
    acciones.style.display = "none";
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

function cargarValor() {
  $.ajax({
    data: { accion: "CARGAR_VALOR" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "<option>" + " *  " + "</option>";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre + "</option>";
      });
      document.getElementById("valor").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function listaValor() {
  campo = getValue("campo");
  console.log(campo);

  $.ajax({
    data: { accion: "LISTAR_VALOR", campo: campo },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "<option>" + " *  " + "</option>";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre + "</option>";
      });
      document.getElementById("valor").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function consultar() {
  registrosTotales = false;
  campo = getValue("campo");
  valor = getValue("valor");

  if (!valor) {
    MostrarAlerta("", "Tiene que seleccionar un campo para continuar", "info");
  } else {
    $.ajax({
      data: { accion: "CONSULTAR", campo: campo, valor: valor },
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
}

function pdf() {
  urlGet = "";
  campo = getValue("campo");
  valor = getValue("valor");

  accion = "pdf";
  if (!valor) {
    MostrarAlerta("", "Tiene que seleccionar un campo para continuar", "info");
  } else {
    if (!registrosTotales) {
      MostrarAlerta(
        "",
        "No se encuentran registros de " + valor + " en " + campo,
        "info"
      );
      return;
    } else {
      urlGet =
        urlGet + "campo=" + campo + "&valor=" + valor + "&accion=" + accion;
      window.open("../reportes/reporteActivo.template.php?" + urlGet, "_blank");
    }
  }
}

function excel() {
  urlGet = "";
  campo = getValue("campo");
  valor = getValue("valor");

  accion = "excel";
  if (!valor) {
    MostrarAlerta("", "Tiene que seleccionar un campo para continuar", "info");
  } else {
    if (!registrosTotales) {
      MostrarAlerta(
        "",
        "No se encuentran registros de " + valor + " en " + campo,
        "info"
      );
      return;
    } else {
      urlGet =
        urlGet + "campo=" + campo + "&valor=" + valor + "&accion=" + accion;
      window.open("../reportes/reporteActivo.template.php?" + urlGet, "_blank");
    }
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
