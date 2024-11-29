var urlController = "./firma.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var idFirmaActualizar = 0;

// Precarga del Script
$(document).ready(function () {
  BloquearBotones(true);
  listarFuncionario();
  Consultar();
});

function Cancelar() {
  clearInput("denominacion");
  listarFuncionario();
  BloquearBotones(true);
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
      console.log(error.responseText);
    });
}

function Consultar() {
  $.ajax({
    data: { accion: "CONSULTAR" },
    url: urlController,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html += "<tr>";
        html += "<td>" + data.nombre_persona + "</td>";
        html += "<td>" + data.denominacion + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1 min-btn-action' onclick='ConsultarPorId(" +
          data.id_firma +
          ");'><span class='fa fa-edit'></span></button>";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function ConsultarPorId(idFirma) {
  idFirmaActualizar = idFirma;
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar la firma?",
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
          data: { idFirma: idFirma, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            BloquearBotones(false);
            setValue("personaId", response.id_persona);
            setValue("denominacion", response.denominacion);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function Validar() {
  personaId = getValue("personaId");
  denominacion = getValue("denominacion");

  if (!personaId || !denominacion) {
    return false;
  }

  return true;
}

function Modificar() {
  if (Validar()) {
    personaId = getValue("personaId");
    denominacion = getValue("denominacion").toUpperCase();

    $.ajax({
      url: urlController,
      data: {
        idFirma: idFirmaActualizar,
        personaId: personaId,
        denominacion: denominacion,
        accion: "MODIFICAR",
      },
      type: "POST",
      dataType: "json",
    })
      .done(function (response) {
        if (response == "OK") {
          MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
          Consultar();
          Cancelar();
        } else {
          MostrarAlerta("Error!", response, "error");
        }
      })
      .fail(function (error) {
        console.log(error.responseText);
      });
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
}

function BloquearBotones(guardar) {
  if (guardar) {
    disabledInput("modificar");
    disabledInput("cancelar");
    disabledInput("personaId");
    disabledInput("denominacion");
  } else {
    enabledInput("modificar");
    enabledInput("cancelar");
    enabledInput("personaId");
    enabledInput("denominacion");
  }
}