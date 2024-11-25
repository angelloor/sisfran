var urlController = "./comprobacionInventario.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var urlControllerEstado = "../estado/estado.controller.php";
var activoComprobacion = 0;

// Precarga del Script
$(document).ready(function () {
  BloquearBotones(true);
  EscucharConsulta();
  listarFuncionario();
  listarEstado();
  document
    .getElementById("codigo")
    .addEventListener("keypress", soloNumeros, false);
});

function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
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
      document.getElementById("personaId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarEstado() {
  $.ajax({
    data: { accion: "LISTAR_ESTADO" },
    url: urlControllerEstado,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_estado +
          ">" +
          data.nombre_estado +
          "</option>";
      });
      document.getElementById("estadoId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function EscucharConsulta() {
  activoComprobacion = 0;
  $("#codigo").keyup(function () {
    if ($("#codigo").val()) {
      let codigoActivo = $("#codigo").val();
      $.ajax({
        data: { codigoActivo: codigoActivo, accion: "CONSULTAR_DATOS" },
        url: urlController,
        type: "POST",
        dataType: "json",
      })
        .done(function (response) {
          console.log(response);
          if (response == false) {
            activoComprobacion = 1;
          } else {
            activoComprobacion = 0;
            setValue("estadoId", response.estado_id);
            setValue("personaId", response.id_persona);
            setValue("comentario", response.comentario);
          }
        })
        .fail(function (error) {
          console.log(error.responseText);
        });
    }
  });
}

function Guardar() {
  if (Validar()) {
    if (activoComprobacion == 1) {
      MostrarAlerta(
        "",
        "No puede hacer la comprobación del inventario de un activo que no esta asignado",
        "info"
      );
    } else {
      $.ajax({
        data: retornarDatos("GUARDAR"),
        url: urlController,
        type: "POST",
        dataType: "json",
      })
        .done(function (response) {
          if (response == "OK") {
            MostrarAlerta("Éxito!", "Activo verificado", "success");
            Cancelar();
            Limpiar();
          } else {
            MostrarAlerta("Error!", response, "error");
          }
        })
        .fail(function (error) {
          console.log(error.responseText);
        });
    }
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
}

function Restablecer() {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de restablecer la comprobación de inventario?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: urlController,
          data: { accion: "RESTABLECER" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response == "OK") {
              MostrarAlerta(
                "Éxito!",
                "Comprobación de inventario restablecido",
                "success"
              );
              Limpiar();
            } else {
              MostrarAlerta("Error!", response, "error");
            }
            BloquearBotones(true);
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
  Limpiar();
}

function Validar() {
  codigo = getValue("codigo");
  estadoId = getValue("estadoId");
  personaId = getValue("personaId");
  comentario = getValue("comentario");

  if (!codigo || !estadoId || !personaId || !comentario) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    codigo: getValue("codigo"),
    estadoId: getValue("estadoId"),
    personaId: getValue("personaId"),
    comentario: getValue("comentario"),
    accion: accion,
  };
}

function Limpiar() {
  clearInput("codigo");
  clearInput("estadoId");
  clearInput("personaId");
  clearInput("comentario");
}

function Nuevo() {
  activoComprobacion = 0;
  BloquearBotones(false);
  Limpiar();
}

function Cancelar() {
  BloquearBotones(true);
  Limpiar();
}

function BloquearBotones(guardar) {
  if (guardar) {
    enabledInput("nuevo");
    enabledInput("restablecer");

    disabledInput("guardar");
    disabledInput("cancelar");
    disabledInput("codigo");
    disabledInput("estadoId");
    disabledInput("personaId");
    disabledInput("comentario");
  } else {
    disabledInput("nuevo");
    disabledInput("restablecer");

    enabledInput("guardar");
    enabledInput("cancelar");
    enabledInput("codigo");
    enabledInput("estadoId");
    enabledInput("personaId");
    enabledInput("comentario");
    document.getElementById("codigo").focus();
  }
}
