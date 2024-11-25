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
      console.log(error);
    });
}

function listaValor() {
  campo = getValue("campo");
  console.log(campo)

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
      console.log(error);
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
