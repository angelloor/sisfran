var urlController = "./categoria.controller.php";
var urlControllerFuncionario = "../funcionario/funcionario.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  Consultar();
  EscucharConsulta();
  listarFuncionario();
  BloquearBotones(true);
});

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
        html += "<td>" + data.nombre_categoria + "</td>";
        html += "<td>" + data.descripcion_categoria + "</td>";
        html += "<td>" + data.nombre_persona + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
          data.id_categoria +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
          data.id_categoria +
          ");'><span class='fa fa-trash'></span></button>";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function EscucharConsulta() {
  registrosTotales = false;
  $("#idCategoria").keyup(function () {
    if ($("#idCategoria").val()) {
      let idBuscar = $("#idCategoria").val();
      $.ajax({
        data: { idBuscar: idBuscar, accion: "CONSULTAR_ID_ROW" },
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
            html += "<td>" + data.nombre_categoria + "</td>";
            html += "<td>" + data.descripcion_categoria + "</td>";
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
              data.id_categoria +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
              data.id_categoria +
              ");'><span class='fa fa-trash'></span></button>";
            html += "</td>";
            html += "</tr>";
          });
          document.getElementById("datos").innerHTML = html;
        })
        .fail(function (error) {
          console.log(error);
        });
    }
  });
}

function ConsultarPorId(idCategoria) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar la categoria?",
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
          data: { idCategoria: idCategoria, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("nombre", response.nombre_categoria);
            setValue("descripcion", response.descripcion_categoria);
            setValue("personaId", response.persona_id);
            setValue("idCategoria", response.id_categoria);
            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function Guardar() {
  if (Validar()) {
    $.ajax({
      url: urlController,
      data: retornarDatos("GUARDAR"),
      type: "POST",
      dataType: "json",
    })
      .done(function (response) {
        if (response == "OK") {
          MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
          Limpiar();
        } else {
          MostrarAlerta("Error!", response, "error");
        }
        Consultar();
      })
      .fail(function (error) {
        console.log(error);
      });
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
}

function Modificar() {
  if (Validar()) {
    $.ajax({
      url: urlController,
      data: retornarDatos("MODIFICAR"),
      type: "POST",
      dataType: "json",
    })
      .done(function (response) {
        if (response == "OK") {
          MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
          Limpiar();
        } else {
          MostrarAlerta("Error!", response, "error");
        }
        Consultar();
      })
      .fail(function (error) {
        console.log(error);
      });
  } else {
    swalWithBootstrapButtons.fire(
      "",
      "Es posible que algunos campos no se han llenado",
      "warning"
    );
  }
}

function Eliminar(idCategoria) {
  var registros = 0;
  $.ajax({
    url: urlController,
    data: { idCategoria: idCategoria, accion: "CONSULTAR_REGISTROS" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      swalWithBootstrapButtons
        .fire({
          title:
            "¿Estas seguro de eliminar la categoría? Contiene " +
            registros +
            " activos registrados",
          text: "Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a esta categoría",
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
              data: { idCategoria: idCategoria, accion: "ELIMINAR" },
              type: "POST",
              dataType: "json",
            })
              .done(function (response) {
                if (response == "OK") {
                  swalWithBootstrapButtons.fire(
                    "",
                    "Registro eliminado",
                    "success"
                  );
                } else {
                  swalWithBootstrapButtons.fire("", response, "error");
                }
                Consultar();
              })
              .fail(function (error) {
                console.log(error);
              });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
          }
        });
      Limpiar();
    })
    .fail(function (error) {
      console.log(error);
    });
}

function Validar() {
  nombreCategoria = getValue("nombre");
  descripcionCategoria = getValue("descripcion");
  personaId = getValue("personaId");

  if (!nombreCategoria || !descripcionCategoria || !personaId) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    nombreCategoria: getValue("nombre").toUpperCase(),
    descripcionCategoria: getValue("descripcion").toUpperCase(),
    personaId: getValue("personaId").toUpperCase(),
    accion: accion,
    idCategoria: getValue("idCategoria"),
  };
}

function Limpiar() {
  clearInput("idCategoria");
  clearInput("nombre");
  clearInput("descripcion");
  BloquearBotones(true);
}

function Cancelar() {
  BloquearBotones(false);
  Limpiar();
}

function BloquearBotones(guardar) {
  if (guardar) {
    enabledInput("guardar");
    disabledInput("modificar");
    disabledInput("cancelar");
  } else {
    disabledInput("guardar");
    enabledInput("modificar");
    enabledInput("cancelar");
  }
}

function mostrarTodo() {
  Limpiar();
  Consultar();
  clearInput("idCategoria");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}