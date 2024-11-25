var urlController = "./actaDigital.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlControllerSistema = "../sistema/sistema.controller.php";

var vacio = 0;
var checkInput = 0;
var urlGet = "";
var idSistemas = "";

// Precarga del Script
$(document).ready(function () {
  cargarSistemas();
  listarFuncionario();
  document
    .getElementById("periodo")
    .addEventListener("keypress", soloNumeros, false);
});

function soloNumeros(e) {
  input = document.getElementById("periodo");
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57 || input.value.length === 4) {
    e.preventDefault();
  }
}

function Generar() {
  idSistemas = "";
  vacio = 0;
  checkInput = 0;
  urlGet = "";
  $.ajax({
    data: { accion: "LISTAR_SISTEMAS" },
    url: urlControllerSistema,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      $.each(response, function (index, data) {
        var checkbox = document.getElementById(data.nombre_sistema);
        var checked = checkbox.checked;
        if (checked) {
          checkInput = checkInput + 1;
          var usuario = getValue("usuario" + data.nombre_sistema);
          var clave = getValue("clave" + data.nombre_sistema);

          if (!usuario || !clave) {
            vacio = vacio + 1;
          }
          urlGet =
            urlGet +
            "sistema" +
            (index + 1) +
            "=" +
            data.nombre_sistema +
            "&url" +
            (index + 1) +
            "=" +
            data.direccion_sistema +
            "&usuario" +
            (index + 1) +
            "=" +
            usuario +
            "&clave" +
            (index + 1) +
            "=" +
            clave +
            "&";
          idSistemas = idSistemas + (index + 1) + ",";
        }
      });
      if (checkInput == 0) {
        MostrarAlerta("", "No se ha seleccionado ningún sistema", "info");
      } else {
        if (vacio >= 1) {
          MostrarAlerta("", "Complete el usuario y contraseña", "info");
        } else {
          idPersona = getValue("idPersona");
          periodo = getValue("periodo");

          if (!periodo) {
            MostrarAlerta("", "Ingrese el año laboral", "info");
            return;
          }
          urlGet =
            urlGet +
            "totalSistemas=" +
            checkInput +
            "&idPersona=" +
            idPersona +
            "&periodo=" +
            periodo +
            "&idSistemas=" +
            idSistemas;
          window.open(
            "./actaDigital.template.php?" + urlGet,
            "_blank"
          );
        }
      }
    })
    .fail(function (error) {
      console.log(error);
    });
}

function validarCheckbox(idCheck) {
  var checkbox = document.getElementById(idCheck.id);
  if (checkbox) {
    checkbox.addEventListener("change", validar, false);
  }
  function validar() {
    var checked = checkbox.checked;
    if (checked) {
      document.getElementById("usuario" + idCheck.id).disabled = false;
      document.getElementById("clave" + idCheck.id).disabled = false;
      document.getElementById("usuario" + idCheck.id).focus();
    } else {
      clearInput("usuario" + idCheck.id);
      clearInput("clave" + idCheck.id);
      document.getElementById("usuario" + idCheck.id).disabled = true;
      document.getElementById("clave" + idCheck.id).disabled = true;
    }
  }
}

function cargarSistemas() {
  $.ajax({
    data: { accion: "LISTAR_SISTEMAS" },
    url: urlControllerSistema,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += '<div class="row">';
        html += '<div class="col-md-2 pl-5 mt-4">';
        html += '<div class="form-check">';
        html +=
          '<input class="form-check-input" type="checkbox" value="" id="' +
          data.nombre_sistema +
          '" onclick="validarCheckbox(this);" >';
        html += '<label class="form-check-label" for="flexCheckDefault">';
        html += data.nombre_sistema;
        html += "</label>";
        html += "</div>";
        html += "</div>";
        html += '<div class="col-md-4">';
        html += '<label for="nombres">Nombre de usuario</label>';
        html +=
          '<input id="usuario' +
          data.nombre_sistema +
          '" type="text" class="form-control" placeholder="Ingrese el nombre del usuario" disabled="true">';
        html += "</div>";
        html += '<div class="col-md-4">';
        html += '<label for="nombres">Contraseña</label>';
        html +=
          '<input id="clave' +
          data.nombre_sistema +
          '" type="text" class="form-control" placeholder="1600###### o Numero Cédula" disabled="true">';
        html += "</div>";
        html += "</div>";
      });
      document.getElementById("sistemas").innerHTML = html;
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
