var urlController = "./activo.controller.php";
var urlControllerCategoria = "../categoria/categoria.controller.php";
var urlControllerMarca = "../marca/marca.controller.php";
var urlControllerEstado = "../estado/estado.controller.php";
var urlControllerColor = "../color/color.controller.php";
var urlControllerBodega = "../bodega/bodega.controller.php";
var registrosTotales = false;

// Precarga del Script
$(document).ready(function () {
  Consultar();
  EscucharConsulta();
  BloquearBotones(true);
  listarCategoria();
  listarMarca();
  listarEstado();
  listarColor();
  listarBodega();
  cargarFechaActual();
  document
    .getElementById("codigo")
    .addEventListener("keypress", soloNumeros, false);
  document
    .getElementById("valorCompra")
    .addEventListener("keypress", soloNumerosPunto, false);
  document
    .getElementById("campoBuscar")
    .addEventListener("change", limpiarIdBuscar, false);
});

function listarCategoria() {
  $.ajax({
    data: { accion: "LISTAR_CATEGORIA" },
    url: urlControllerCategoria,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_categoria +
          ">" +
          data.nombre_categoria +
          "</option>";
      });
      document.getElementById("categoriaId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarMarca() {
  $.ajax({
    data: { accion: "LISTAR_MARCA" },
    url: urlControllerMarca,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_marca +
          ">" +
          data.nombre_marca +
          "</option>";
      });
      document.getElementById("marcaId").innerHTML = html;
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
      console.log(error);
    });
}

function listarColor() {
  $.ajax({
    data: { accion: "LISTAR_COLOR" },
    url: urlControllerColor,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_color +
          ">" +
          data.nombre_color +
          "</option>";
      });
      document.getElementById("colorId").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error);
    });
}

function listarBodega() {
  $.ajax({
    data: { accion: "LISTAR_BODEGA" },
    url: urlControllerBodega,
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      var html = "";
      $.each(response, function (index, data) {
        html +=
          "<option value=" +
          data.id_bodega +
          ">" +
          data.nombre_bodega +
          "</option>";
      });
      document.getElementById("bodegaId").innerHTML = html;
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
        html += "<td>" + data.codigo + "</td>";
        html += "<td>" + data.nombre_activo + "</td>";
        html += "<td>" + data.nombre_categoria + "</td>";
        html += "<td>" + data.caracteristica + "</td>";
        html += "<td>" + data.nombre_marca + "</td>";
        html += "<td>" + data.modelo + "</td>";
        html += "<td>" + data.serie + "</td>";
        html += "<td>" + data.nombre_estado + "</td>";
        html += "<td>" + data.comprobacion_inventario + "</td>";
        html += "<td class='btn-center-objet'>";
        html +=
          "<button class='btn btn-success' onclick='ConsultarPorId(" +
          data.id_activo +
          ");'><span class='fa fa-edit'></span></button>";
        html +=
          "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" +
          data.id_activo +
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
  $("#idActivo").keyup(function () {
    if ($("#idActivo").val()) {
      $.ajax({
        data: retornarDatosConsulta("CONSULTAR_ID_ROW"),
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
            html += "<td>" + data.nombre_categoria + "</td>";
            html += "<td>" + data.caracteristica + "</td>";
            html += "<td>" + data.nombre_marca + "</td>";
            html += "<td>" + data.modelo + "</td>";
            html += "<td>" + data.serie + "</td>";
            html += "<td>" + data.nombre_estado + "</td>";
            html += "<td>" + data.comprobacion_inventario + "</td>";
            html += "<td class='btn-center-objet'>";
            html +=
              "<button class='btn btn-success' onclick='ConsultarPorId(" +
              data.id_activo +
              ");'><span class='fa fa-edit'></span></button>";
            html +=
              "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" +
              data.id_activo +
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

function ConsultarPorId(idActivo) {
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
          data: { idActivo: idActivo, accion: "CONSULTAR_ID" },
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            setValue("categoriaId", response.categoria_id);
            setValue("marcaId", response.marca_id);
            setValue("estadoId", response.estado_id);
            setValue("colorId", response.color_id);
            setValue("caracteristica", response.caracteristica);
            setValue("bodegaId", response.bodega_id);
            setValue("codigo", response.codigo);
            setValue("nombre", response.nombre_activo);
            setValue("modelo", response.modelo);
            setValue("serie", response.serie);
            setValue("ubicacionIngreso", response.ubicacion_ingreso);
            setValue("fechaIngreso", response.fecha_ingreso);
            setValue("valorCompra", response.valor_compra);
            setValue("comentario", response.comentario);
            setValue(
              "comprobacionInventario",
              response.comprobacion_inventario
            );
            setValue("idActivo", response.id_activo);
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

function Eliminar(idActivo) {
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
  var registros = 0;
  let mensaje = "";
  $.ajax({
    url: urlController,
    data: { idActivo: idActivo, accion: "CONSULTAR_REGISTROS" },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      registros = response.registros;
      if (registros == 1) {
        mensaje =
          "El activo se encuentra asignado a un funcionario    Nota: la entrega recepción se eliminará si usted continua con esta acción";
      }
      var fechaEliminar = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
      swalWithBootstrapButtons
        .fire({
          title: "¿Estas seguro de eliminar el activo?",
          text: mensaje,
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
                accion: "ELIMINAR",
                fechaEliminar: fechaEliminar,
              },
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
  categoriaId = getValue("categoriaId");
  marcaId = getValue("marcaId");
  estadoId = getValue("estadoId");
  colorId = getValue("colorId");
  caracteristica = getValue("caracteristica");
  bodegaId = getValue("bodegaId");
  codigo = getValue("codigo");
  nombre = getValue("nombre");
  modelo = getValue("modelo");
  serie = getValue("serie");
  ubicacionIngreso = getValue("ubicacionIngreso");
  fechaIngreso = getValue("fechaIngreso");
  valorCompra = getValue("valorCompra");
  comentario = getValue("comentario");
  comprobacionInventario = getValue("comprobacionInventario");

  if (
    !categoriaId ||
    !marcaId ||
    !estadoId ||
    !colorId ||
    !caracteristica ||
    !bodegaId ||
    !codigo ||
    !nombre ||
    !modelo ||
    !serie ||
    !ubicacionIngreso ||
    !fechaIngreso ||
    !valorCompra ||
    !comentario ||
    !comprobacionInventario
  ) {
    return false;
  }

  return true;
}

function retornarDatosConsulta(accion) {
  return {
    campoBuscar: getValue("campoBuscar"),
    accion: accion,
    idActivo: getValue("idActivo"),
  };
}
function retornarDatos(accion) {
  return {
    categoriaId: getValue("categoriaId"),
    marcaId: getValue("marcaId"),
    estadoId: getValue("estadoId"),
    colorId: getValue("colorId"),
    caracteristica: getValue("caracteristica"),
    bodegaId: getValue("bodegaId"),
    codigo: getValue("codigo"),
    nombre: getValue("nombre"),
    modelo: getValue("modelo"),
    serie: getValue("serie"),
    ubicacionIngreso: getValue("ubicacionIngreso"),
    fechaIngreso: getValue("fechaIngreso"),
    valorCompra: getValue("valorCompra"),
    comentario: getValue("comentario"),
    comprobacionInventario: getValue("comprobacionInventario"),
    accion: accion,
    idActivo: getValue("idActivo"),
  };
}

function Limpiar() {
  clearInput("idActivo");
  clearInput("caracteristica");
  clearInput("codigo");
  clearInput("nombre");
  clearInput("modelo");
  clearInput("serie");
  clearInput("ubicacionIngreso");
  clearInput("fechaIngreso");
  clearInput("valorCompra");
  clearInput("comentario");
  listarCategoria();
  listarMarca();
  listarEstado();
  listarColor();
  listarBodega();
  cargarFechaActual();
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
  Consultar();
  clearInput("idActivo");
}

function limpiarIdBuscar() {
  clearInput("idActivo");
  document.getElementById("idActivo").focus();
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function soloNumeros(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
}

function soloNumerosPunto(e) {
  var key = window.event ? e.which : e.keyCode;
  if (key < 46 || key > 57) {
    e.preventDefault();
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
  setValue("fechaIngreso", f.getFullYear() + "-" + mesFinal + "-" + diaFinal);
}
