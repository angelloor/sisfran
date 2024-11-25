var urlController = "./historico.controller.php";
var urlGet = "";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  cargarFechaActual();
  consultar();
  ocultarAlertaDatos();
});

function pdf() {
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        urlGet = "";
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        accion = "pdf";
        if (registrosTotales == false) {
          MostrarAlerta(
            "",
            "No se encuentran registros de " + fechaInicio + " a " + fechaFinal,
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "fechaInicio=" +
            fechaInicio +
            "&fechaFinal=" +
            fechaFinal +
            "&accion=" +
            accion;
          window.open("../reportes/reporteHistorico.template.php?" + urlGet, "_blank");
        }
      }
    }
  }
}

function excel() {
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        urlGet = "";
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        accion = "excel";
        if (registrosTotales == false) {
          MostrarAlerta(
            "",
            "No se encuentran registros de " + fechaInicio + " a " + fechaFinal,
            "info"
          );
          return;
        } else {
          urlGet =
            urlGet +
            "fechaInicio=" +
            fechaInicio +
            "&fechaFinal=" +
            fechaFinal +
            "&accion=" +
            accion;
          window.open("../reportes/reporteHistorico.template.php?" + urlGet, "_blank");
        }
      }
    }
  }
}

function comprobarFechas() {
  fechaInicio = getValue("fechaInicio");
  fechaFinal = getValue("fechaFinal");

  if (!fechaInicio && !fechaFinal) {
    return 1;
  } else {
    if (!fechaInicio) {
      return 2;
    } else {
      if (!fechaFinal) {
        return 3;
      }
    }
  }
  return 0;
}

function ConsultarPorFecha() {
  registrosTotales = false;
  if (comprobarFechas() == 1) {
    MostrarAlerta("", "Ingrese el rango de las fechas", "info");
  } else {
    if (comprobarFechas() == 2) {
      MostrarAlerta("", "Ingrese la fecha inicial", "info");
    } else {
      if (comprobarFechas() == 3) {
        MostrarAlerta("", "Ingrese la fecha final", "info");
      } else {
        fechaInicio = getValue("fechaInicio");
        fechaFinal = getValue("fechaFinal");

        $.ajax({
          data: {
            accion: "CONSULTAR_POR_FECHA",
            fechaInicio: fechaInicio,
            fechaFinal: fechaFinal,
          },
          url: urlController,
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response.length >= 1) {
              registrosTotales = true;
            }
            var html = "";
            $.each(response, function (index, data) {
              html += "<tr>";
              html += "<td>" + data.codigo + "</td>";
              html += "<td>" + data.nombre_activo + "</td>";
              html += "<td>" + data.nombre_marca + "</td>";
              html += "<td>" + data.modelo + "</td>";
              html += "<td>" + data.serie + "</td>";
              html += "<td>" + data.fecha_historico + "</td>";
              html += "<td style='text-align: center;'>";
              html +=
                "<button class='btn btn-success' onclick='ConsultarPorId(" +
                data.id_activo +
                ");'><span class='fa fa-undo-alt'></span></button>";
              html += "</td>";
              html += "</tr>";
            });
            document.getElementById("datos").innerHTML = html;
          })
          .fail(function (error) {
            console.log(error);
          });
      }
    }
  }
}

function cargarFechaActual() {
  var f = new Date();
  if (f.getMonth() + 1 <= 9) {
    mesFinal = "0" + (f.getMonth() + 1);
  } else {
    mesFinal = f.getMonth();
  }
  if (f.getDate() <= 9) {
    diaFinal = "0" + f.getDate();
  } else {
    diaFinal = f.getDate();
  }
  setValue("fechaInicio", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
  setValue("fechaFinal", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
}

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
        html += "<td>" + data.nombre_marca + "</td>";
        html += "<td>" + data.modelo + "</td>";
        html += "<td>" + data.serie + "</td>";
        html += "<td>" + data.fecha_historico + "</td>";
        html += "<td style='text-align: center;'>";
        html +=
          "<button class='btn btn-success' onclick='ConsultarPorId(" +
          data.id_activo +
          ");'><span class='fa fa-undo-alt'></span></button>";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function ConsultarPorId(idActivo) {
  var f = new Date();
  var fechaHistorico = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar el activo?",
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
          data: {
            idActivo: idActivo,
            accion: "CONSULTAR_ID",
            fechaHistorico: fechaHistorico,
          },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response == "OK") {
              MostrarAlerta(
                "",
                "El activo se ha devuelto al inventario",
                "info"
              );
              consultar();
            } else {
              MostrarAlerta("", response, "info");
            }
          })
          .fail(function (error) {
            console.log(error);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}
