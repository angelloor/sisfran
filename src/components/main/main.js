var urlController = "./main.controller.php";
var urlGet = "";

// Precarga del Script
$(document).ready(function () {
  cargarCategoria();
  listarActivo();
  document
    .getElementById("SelectCategoriaDos")
    .addEventListener("change", listarFuncionarioPorCategoria, false);
  document
    .getElementById("saltoLineaDos")
    .addEventListener("keypress", soloNumeros, false);
  document
    .getElementById("saltoLineaTres")
    .addEventListener("keypress", soloNumeros, false);
  document
    .getElementById("codigoActivo")
    .addEventListener("keypress", soloNumeros, false);
});

function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}

function cargarCategoria() {
  $.ajax({
    data: { accion: "LISTAR_CATEGORIA_MAIN" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre_categoria + "</option>";
      });
      document.getElementById("SelectCategoria").innerHTML = html;
      document.getElementById("SelectCategoriaDos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarFuncionarioPorCategoria() {
  categoria = getValue("SelectCategoriaDos");

  $.ajax({
    data: { accion: "LISTAR_FUNCIONARIO_POR_CATEGORIA_MAIN", categoria: categoria },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<option>" + data.nombre_persona + "</option>";
      });
      document.getElementById("SelectFuncionario").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarActivo() {
  $.ajax({
    data: { accion: "LISTAR_ACTIVO_MAIN" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<option>" + data.activo + "</option>";
      });
      document.getElementById("activo").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function GenerarTodasActas() {
  urlGet = "";
  categoriaUno = getValue("SelectCategoria");
  urlGet = urlGet + "categoria=" + categoriaUno;
  window.open("../reportes/actaGlobal.template.php?" + urlGet, "_blank");
  close();
  clear();
}

function GenerarPorFuncionario() {
  urlGet = "";
  funcionario = getValue("SelectFuncionario");
  categoriaDos = getValue("SelectCategoriaDos");
  saltoLinea = getValue("saltoLineaDos");
  urlGet =
    urlGet +
    "categoria=" +
    categoriaDos +
    "&funcionario=" +
    funcionario +
    "&saltoLinea=" +
    saltoLinea;
  window.open("../reportes/actaPorFuncionario.template.php?" + urlGet, "_blank");
  clearInput("saltoLineaDos");
  close();
  clear();
}

function GenerarPorActivo() {
  urlGet = "";
  activo = getValue("codigoActivo");
  saltoLinea = getValue("saltoLineaTres");

  if (!activo) {
    MostrarAlerta("", "Seleccione un activo", "info");
    return;
  } else {
    urlGet = urlGet + "activo=" + activo + "&saltoLinea=" + saltoLinea;
    window.open("../reportes/actaPorActivo.template.php?" + urlGet, "_blank");
    clearInput("codigoActivo");
    clearInput("saltoLineaTres");
    close();
    clear();
  }
}