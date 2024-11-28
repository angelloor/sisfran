// Only file have absolute path
var urlController = "src/components/index/index.controller.php";

// Precarga del Script
$(document).ready(function () {});

function enter(valor) {
  if (valor == 1) {
    input = document.getElementById("usuario");
    input.addEventListener("keypress", logKey);
  } else {
    input = document.getElementById("clave");
    input.addEventListener("keypress", logKey);
  }
  function logKey(e) {
    var keycode = e.keyCode ? e.keyCode : e.which;
    if (keycode == 13) {
      iniciarSesion();
    }
  }
}

function iniciarSesion() {
  let usuario, clave;
  usuario = getValue("usuario");
  clave = getValue("clave");

  if (!usuario) {
    Swal.fire("", "Ingrese el usuario", "info");
    return;
  }
  if (!clave) {
    Swal.fire("", "Ingrese la contraseña", "info");
    return;
  }
  $.ajax({
    data: { accion: "LOGIN", usuario: usuario, clave: clave },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      if (response == "OK") {
        window.location.href = "src/components/main/main.php";
      } else {
        MostrarAlerta("", response, "error");
      }
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}