var urlController = "./oficina.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  Consultar();
  EscucharConsulta();
  BloquearBotones(true);
});

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
        html += "<td>" + data.id_oficina + "</td>";
        html += "<td>" + data.nombre_oficina + "</td>";
        html += "<td>" + data.descripcion_oficina + "</td>";
        html += "<td>" + data.latitud_oficina + "</td>";
        html += "<td>" + data.longitud_oficina + "</td>";
        html += "<td>" + data.radio_valido_metros + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-info mr-1' onclick='verHorarios(" +
          data.id_oficina +
          ");'><span class='fa fa-calendar'></span></button>";
        html +=
          "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
          data.id_oficina +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
          data.id_oficina +
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
  $("#idOficina").keyup(function () {
    if ($("#idOficina").val()) {
      let idBuscar = $("#idOficina").val();
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
            html += "<td>" + data.id_oficina + "</td>";
            html += "<td>" + data.nombre_oficina + "</td>";
            html += "<td>" + data.descripcion_oficina + "</td>";
            html += "<td>" + data.latitud_oficina + "</td>";
            html += "<td>" + data.longitud_oficina + "</td>";
            html += "<td>" + data.radio_valido_metros + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-info mr-1' onclick='verHorarios(" +
              data.id_oficina +
              ");'><span class='fa fa-calendar'></span></button>";
            html +=
              "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" +
              data.id_oficina +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button class='btn btn-danger ml-1' onclick='Eliminar(" +
              data.id_oficina +
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

function ConsultarPorId(idOficina) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar la oficina?",
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
          data: { idOficina: idOficina, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("idOficina", response.id_oficina);
            setValue("nombreOficina", response.nombre_oficina);
            setValue("descripcionOficina", response.descripcion_oficina);
            setValue("lat", response.latitud_oficina);
            setValue("lng", response.longitud_oficina);
            setValue("radioValidoMetros", response.radio_valido_metros);

            // actualizar marcador google maps
            const pos = {
              lat: parseFloat(response.latitud_oficina),
              lng: parseFloat(response.longitud_oficina),
            };
            map.setCenter(pos);
            marker.setPosition(pos);

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

function verHorarios(idOficina) {
  window.location.href = "horarioOficina.php?idOficina=" + idOficina;
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

function Eliminar(idOficina) {
  var registros = 0;

  $.ajax({
    url: urlController,
    data: { idOficina: idOficina, accion: "CONSULTAR_REGISTROS" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      if (registros == 0) {
        swalWithBootstrapButtons
          .fire({
            title: "¿Estas seguro de eliminar la oficina?",
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
                data: { idOficina: idOficina, accion: "ELIMINAR" },
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
      } else {
        swalWithBootstrapButtons
          .fire({
            title:
              "¿Estas seguro de eliminar la oficina? Contiene registros en las tablas asociadas",
            text: "Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a esta oficina",
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
                data: { idOficina: idOficina, accion: "ELIMINAR" },
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
      }

      Limpiar();
    })
    .fail(function (error) {
      console.log(error);
    });
}

function Validar() {
  nombreOficina = getValue("nombreOficina");
  descripcionOficina = getValue("descripcionOficina");
  lng = getValue("lng");
  lat = getValue("lat");
  radioValidoMetros = getValue("radioValidoMetros");

  if (
    !nombreOficina ||
    !descripcionOficina ||
    !lng ||
    !lat ||
    !radioValidoMetros
  ) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    nombreOficina: getValue("nombreOficina").toUpperCase(),
    descripcionOficina: getValue("descripcionOficina").toUpperCase(),
    lat: getValue("lat").toUpperCase(),
    lng: getValue("lng").toUpperCase(),
    radioValidoMetros: getValue("radioValidoMetros").toUpperCase(),
    idOficina: getValue("idOficina"),
    accion: accion,
  };
}

function Limpiar() {
  clearInput("idOficina");
  clearInput("nombreOficina");
  clearInput("descripcionOficina");
  clearInput("lng");
  clearInput("lat");
  clearInput("radioValidoMetros");
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
  Cancelar();
  Consultar();
  clearInput("idOficina");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
