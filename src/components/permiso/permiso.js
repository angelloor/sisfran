var urlController = "./permiso.controller.php";
var registrosTotales = false;
var idPersona;
var documentacion;

// Precarga del Script
$(document).ready(function () {
  idPersona = params.get("idPersona");
  rolUsuario = params.get("rolUsuario");

  if (rolUsuario === "ADMINISTRADOR") {
    Consultar();
  } else {
    ConsultarPorIdPersona(idPersona);
  }

  EscucharConsulta();
  BloquearBotones(true);

  // Mobile Display Table
  displayLabels(isMobile);
});

// Mobile Display Table
function displayLabels(isMobile) {
  const idPermisoLbl = document.getElementById("idPermisoLbl");
  const fechaInicioPermisoLbl = document.getElementById(
    "fechaInicioPermisoLbl"
  );
  const fechaFinPermisoLbl = document.getElementById("fechaFinPermisoLbl");
  const nombrePersonaLbl = document.getElementById("nombrePersonaLbl");
  const estadoPermisoLbl = document.getElementById("estadoPermisoLbl");
  const observacionesPermisoLbl = document.getElementById(
    "observacionesPermisoLbl"
  );
  const documentacionPermisoLbl = document.getElementById(
    "documentacionPermisoLbl"
  );

  if (isMobile) {
    // Comentar para mantener
    idPermisoLbl.style.display = "none";
    // fechaInicioPermisoLbl.style.display = "none";
    // fechaFinPermisoLbl.style.display = "none";
    nombrePersonaLbl.style.display = "none";
    estadoPermisoLbl.style.display = "none";
    observacionesPermisoLbl.style.display = "none";
    documentacionPermisoLbl.style.display = "none";
  } else {
    idPermisoLbl.style.display = "table-cell";
    // fechaInicioPermisoLbl.style.display = "table-cell";
    // fechaFinPermisoLbl.style.display = "table-cell";
    nombrePersonaLbl.style.display = "table-cell";
    estadoPermisoLbl.style.display = "table-cell";
    observacionesPermisoLbl.style.display = "table-cell";
    documentacionPermisoLbl.style.display = "table-cell";
  }
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
        html += isMobile ? "" : "<td>" + data.id_permiso + "</td>";
        html += "<td>" + data.fecha_inicio_permiso + "</td>";
        html += "<td>" + data.fecha_fin_permiso + "</td>";

        if (rolUsuario === "ADMINISTRADOR") {
          html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
        }

        html += isMobile ? "" : "<td>" + data.estado_permiso + "</td>";
        html += isMobile ? "" : "<td>" + data.observaciones_permiso + "</td>";
        html += isMobile ? "" : "<td>" + data.documentacion_permiso + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-info mr-1 min-btn-action' onclick='descargarDocumentacion(\"" +
          String(data.documentacion_permiso) + // Convertir a string
          "\");'><span class='fa fa-download'></span></button>";

        if (rolUsuario === "ADMINISTRADOR") {
          html +=
            "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
            data.id_permiso +
            ");'><span class='fa fa-edit'></span></button>";
          html +=
            "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
            data.id_permiso +
            ");'><span class='fa fa-trash'></span></button>";
        }
        html += isMobile
          ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
            JSON.stringify(data) +
            ");'><span class='fa fa-info'></span></button>"
          : "";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function EscucharConsulta() {
  registrosTotales = false;
  $("#idPermiso").keyup(function () {
    if ($("#idPermiso").val()) {
      let idBuscar = $("#idPermiso").val();
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
            html += isMobile ? "" : "<td>" + data.id_permiso + "</td>";
            html += "<td>" + data.fecha_inicio_permiso + "</td>";
            html += "<td>" + data.fecha_fin_permiso + "</td>";

            if (rolUsuario === "ADMINISTRADOR") {
              html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
            }

            html += isMobile ? "" : "<td>" + data.estado_permiso + "</td>";
            html += isMobile
              ? ""
              : "<td>" + data.observaciones_permiso + "</td>";
            html += isMobile
              ? ""
              : "<td>" + data.documentacion_permiso + "</td>";
            html += "<td style='text-align: right;'>";
            html +=
              "<button class='btn btn-info mr-1 min-btn-action' onclick='descargarDocumentacion(\"" +
              String(data.documentacion_permiso) + // Convertir a string
              "\");'><span class='fa fa-download'></span></button>";

            if (rolUsuario === "ADMINISTRADOR") {
              html +=
                "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
                data.id_permiso +
                ");'><span class='fa fa-edit'></span></button>";
              html +=
                "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
                data.id_permiso +
                ");'><span class='fa fa-trash'></span></button>";
            }
            html += isMobile
              ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
                JSON.stringify(data) +
                ");'><span class='fa fa-info'></span></button>"
              : "";
            html += "</td>";
            html += "</tr>";
          });
          document.getElementById("datos").innerHTML = html;
        })
        .fail(function (error) {
          console.log(error.responseText);
        });
    }
  });
}

function ConsultarPorIdPersona(idPersona) {
  registrosTotales = false;
  $.ajax({
    data: { accion: "CONSULTAR_ID_PERSONA", idPersona },
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
        html += isMobile ? "" : "<td>" + data.id_permiso + "</td>";
        html += "<td>" + data.fecha_inicio_permiso + "</td>";
        html += "<td>" + data.fecha_fin_permiso + "</td>";

        if (rolUsuario === "ADMINISTRADOR") {
          html += isMobile ? "" : "<td>" + data.nombre_persona + "</td>";
        }

        html += isMobile ? "" : "<td>" + data.estado_permiso + "</td>";
        html += isMobile ? "" : "<td>" + data.observaciones_permiso + "</td>";
        html += isMobile ? "" : "<td>" + data.documentacion_permiso + "</td>";
        html += "<td style='text-align: right;'>";
        html +=
          "<button class='btn btn-info mr-1 min-btn-action' onclick='descargarDocumentacion(\"" +
          String(data.documentacion_permiso) + // Convertir a string
          "\");'><span class='fa fa-download'></span></button>";

        if (rolUsuario === "ADMINISTRADOR") {
          html +=
            "<button class='btn btn-success mr-1 mt-1 min-btn-action' onclick='ConsultarPorId(" +
            data.id_permiso +
            ");'><span class='fa fa-edit'></span></button>";
          html +=
            "<button class='btn btn-danger mr-1 mt-1 min-btn-action' onclick='Eliminar(" +
            data.id_permiso +
            ");'><span class='fa fa-trash'></span></button>";
        }
        html += isMobile
          ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
            JSON.stringify(data) +
            ");'><span class='fa fa-info'></span></button>"
          : "";
        html += "</td>";
        html += "</tr>";
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function ConsultarPorId(idPermiso) {
  swalWithBootstrapButtons
    .fire({
      text: "¿Estas seguro de modificar la permiso?",
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
          data: { idPermiso: idPermiso, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("idPermiso", response.id_permiso);
            setValue("fechaInicio", response.fecha_inicio_permiso);
            setValue("fechaFin", response.fecha_fin_permiso);
            setValue("estado", response.estado_permiso);
            setValue("observaciones", response.observaciones_permiso);

            if ((documentacion = response.documentacion_permiso)) {
              desactivarDocumentacion();
            }

            BloquearBotones(false);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function Guardar() {
  if (Validar()) {
    // Subida de la documentación al sevidor
    const formData = new FormData();
    const file = $("#documentacion")[0].files[0];
    formData.append("file", file);
    // Enviar el archivo al servidor
    $.ajax({
      url: "../../lib/fileStorage/upload.php", // Ruta al archivo PHP que procesa la subida
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (uploadFile) {
        // Si recibimos la confirmación de subida continuamos con el proceso
        $.ajax({
          url: urlController,
          data: { ...retornarDatos("GUARDAR"), documentacion: uploadFile },
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
            if (rolUsuario === "ADMINISTRADOR") {
              Consultar();
            } else {
              ConsultarPorIdPersona(idPersona);
            }
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      },
      error: function (error) {
        alert(error);
      },
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
        if (rolUsuario === "ADMINISTRADOR") {
          Consultar();
        } else {
          ConsultarPorIdPersona(idPersona);
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

function Eliminar(idPermiso) {
  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro de eliminar el permiso?",
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
          data: { idPermiso: idPermiso, accion: "ELIMINAR" },
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
            if (rolUsuario === "ADMINISTRADOR") {
              Consultar();
            } else {
              ConsultarPorIdPersona(idPersona);
            }
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function descargarDocumentacion(documentacionPermiso) {
  window.location.href = `../../lib/fileStorage/download.php?file=${encodeURIComponent(
    documentacionPermiso
  )}`;
}

function Validar() {
  fechaInicio = getValue("fechaInicio");
  fechaFin = getValue("fechaFin");
  estado = getValue("estado");
  observaciones = getValue("observaciones");

  if (!fechaInicio || !fechaFin || !estado || !observaciones) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    fechaInicio: getValue("fechaInicio"),
    fechaFin: getValue("fechaFin"),
    estado: getValue("estado").toUpperCase(),
    observaciones: getValue("observaciones").toUpperCase(),
    documentacion: getValue("documentacion"),
    accion: accion,
    idPermiso: getValue("idPermiso"),
    idPersona,
  };
}

function Limpiar() {
  clearInput("idPermiso");
  clearInput("fechaInicio");
  clearInput("fechaFin");
  setValue("estado", "EMITIDO");
  clearInput("observaciones");
  clearInput("documentacion");
  BloquearBotones(true);
}

function Cancelar() {
  BloquearBotones(false);
  Limpiar();
  activarDocumentacion();
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
  if (rolUsuario === "ADMINISTRADOR") {
    Consultar();
  } else {
    ConsultarPorIdPersona(idPersona);
  }
  clearInput("idPermiso");
  activarDocumentacion();
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function desactivarDocumentacion() {
  hiddenInput("documentacion");
  hiddenInput("cabeceraDocumentacion");
}

function activarDocumentacion() {
  visibleInput("documentacion");
  visibleInput("cabeceraDocumentacion");
}
