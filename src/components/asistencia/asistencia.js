var urlController = "./asistencia.controller.php";
var urlControllerOficina = "../oficina/oficina.controller.php";
var urlControllerPersonaHorarioOficina =
  "../personaHorarioOficina/personaHorarioOficina.controller.php";
var registrosTotales = false;

// Obtener la fecha actual
const hoy = new Date();
var personaId;
var htmlList = "";
let timeoutID;
let MarcacionesDiariasPorOficina = 1;
let contadorInterno = 0;
let oficinasConHorarioList = [];
let inRange = false;

//Google Maps
let map; // Variable global para el mapa
let officeCircle; // Variable global para el círculo de la oficina
let officeMarker; // Variable global para el marcador de la oficina
let marker; // Variable global para el marcador del usuario
let userLocation = null; // Variable global para almacenar la última ubicación conocida

// Precarga del Script
$(document).ready(function () {
  personaId = params.get("idPersona");

  ConsultarTodo(personaId);
  fechaActual = ActualizarParametros();
  listarOficina(personaId, fechaActual);
  displayCabecera(true);
  displayMap(true)
  AlertaInfo(false);
  EscucharConsulta();

  if (!inRange) {
    disabledInput("registrarEntrada");
  }

  // Mobile Display Table
  displayLabels(isMobile);
});

// Funcion para cambiar el radio valido
function handleChangeOficina(oficinaId) {
  const oficinaSelect = oficinasConHorarioList.find(
    (oficina) => oficina.id_oficina == oficinaId
  );

  let radioValidoInicial = oficinaSelect.radio_valido_metros;

  setValue("radioValidoMetros", radioValidoInicial);
  initMap(oficinaSelect);
}

function initMap(oficina = {}) {
  // Oficina Matriz (ubicación predeterminada o de la oficina seleccionada)
  const defaultLocationOrSelectOficina = {
    lat: oficina.latitud_oficina
      ? parseFloat(oficina.latitud_oficina)
      : -1.4868878508099954,
    lng: oficina.longitud_oficina
      ? parseFloat(oficina.longitud_oficina)
      : -78.00130909493816,
    radius: oficina.radio_valido_metros
      ? parseInt(oficina.radio_valido_metros)
      : 10,
  };

  // Si el mapa no ha sido inicializado, crear un nuevo mapa
  if (!map) {
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 20,
      center: defaultLocationOrSelectOficina,
      disableDefaultUI: true,
    });
  } else {
    // Actualizar el centro del mapa
    map.setCenter(defaultLocationOrSelectOficina);
  }

  // Eliminar y redibujar círculo y marcador de la oficina
  if (officeCircle) officeCircle.setMap(null);
  officeCircle = new google.maps.Circle({
    strokeColor: "#FF0000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#FF0000",
    fillOpacity: 0.35,
    map: map,
    center: defaultLocationOrSelectOficina,
    radius: defaultLocationOrSelectOficina.radius,
  });

  if (officeMarker) officeMarker.setMap(null);
  officeMarker = new google.maps.Marker({
    position: defaultLocationOrSelectOficina,
    map: map,
    title: "Oficina",
  });

  // Si ya tenemos una ubicación del usuario, verificar si está en el rango
  if (userLocation) {
    verificarRango(userLocation, defaultLocationOrSelectOficina);
  }

  // Activar la geolocalización
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(
      function (position) {
        userLocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };

        // Actualiza los inputs
        setValue("lat", userLocation.lat);
        setValue("lng", userLocation.lng);

        // Crear o actualizar el marcador del usuario
        if (!marker) {
          const customIcon = {
            url: "../../assets/img/avatarMaps.png",
            scaledSize: new google.maps.Size(40, 70),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(20, 40),
          };

          marker = new google.maps.Marker({
            position: userLocation,
            map: map,
            title: "Tu ubicación",
            icon: customIcon,
            draggable: false,
          });
        } else {
          marker.setPosition(userLocation);
        }

        // Verificar si está dentro del rango
        verificarRango(userLocation, defaultLocationOrSelectOficina);

        // Centrar el mapa en la ubicación actual del usuario
        map.setCenter(userLocation);
      },
      function () {
        handleLocationError(true, map.getCenter());
      }
    );
  } else {
    handleLocationError(false, map.getCenter());
  }
}

function verificarRango(userLocation, oficinaLocation) {
  const distance = google.maps.geometry.spherical.computeDistanceBetween(
    new google.maps.LatLng(userLocation),
    new google.maps.LatLng(oficinaLocation)
  );

  if (distance <= oficinaLocation.radius) {
    AlertaInfo(
      true,
      `Estás dentro del rango (${Math.round(distance)}m). Puedes registrarte.`
    );

    inRange = true;
    enabledInput("registrarEntrada");
  } else {
    AlertaInfo(
      true,
      `Estás fuera del rango (${Math.round(distance)}m). No puedes registrarte.`
    );

    inRange = false;
    disabledInput("registrarEntrada");
  }
}

function handleLocationError(browserHasGeolocation, pos) {
  alert(
    browserHasGeolocation
      ? "Error: La geolocalización falló."
      : "Error: Tu navegador no soporta la geolocalización."
  );
}

ActualizarParametros = () => {
  // Formatear la fecha en el formato "YYYY-MM-DD"
  const año = hoy.getFullYear();
  const mes = String(hoy.getMonth() + 1).padStart(2, "0"); // Los meses van de 0 a 11
  const dia = String(hoy.getDate()).padStart(2, "0");

  // Formatear la hora en formato "HH:MM"
  const horas = String(hoy.getHours()).padStart(2, "0");
  const minutos = String(hoy.getMinutes()).padStart(2, "0");

  const fechaFormateada = `${año}-${mes}-${dia}`;
  const horaFormateada = `${horas}:${minutos}`;

  setValue("fechaAsistencia", fechaFormateada);
  setValue("horaAsistencia", horaFormateada);

  return fechaFormateada;
};

// Mobile Display Table
function displayLabels(isMobile) {
  const asistenciaIdLbl = document.getElementById("asistenciaIdLbl");
  const nombreOficinaLbl = document.getElementById("nombreOficinaLbl");
  const tipoLbl = document.getElementById("tipoLbl");
  const fechaLbl = document.getElementById("fechaLbl");
  const horaLbl = document.getElementById("horaLbl");
  const latitudLbl = document.getElementById("latitudLbl");
  const longitudLbl = document.getElementById("longitudLbl");
  const observacionesLbl = document.getElementById("observacionesLbl");

  if (isMobile) {
    // Comentar para mantener
    // asistenciaIdLbl.style.display = "none";
    // nombreOficinaLbl.style.display = "none";
    tipoLbl.style.display = "none";
    fechaLbl.style.display = "none";
    horaLbl.style.display = "none";
    latitudLbl.style.display = "none";
    longitudLbl.style.display = "none";
    observacionesLbl.style.display = "none";
  } else {
    // asistenciaIdLbl.style.display = "table-cell";
    // nombreOficinaLbl.style.display = "table-cell";
    tipoLbl.style.display = "table-cell";
    fechaLbl.style.display = "table-cell";
    horaLbl.style.display = "table-cell";
    latitudLbl.style.display = "table-cell";
    longitudLbl.style.display = "table-cell";
    observacionesLbl.style.display = "table-cell";
  }
}

function listarOficina(personaId, fechaActual) {
  $.ajax({
    data: {
      accion: "LISTAR_OFICINA_BY_FUNCIONARIO_DATE",
      idPersona: personaId,
      fechaActual,
    },
    url: urlControllerPersonaHorarioOficina,
    type: "POST",
    dataType: "json",
  })
    .done(function (oficinasConHorario) {
      console.log(oficinasConHorario)
      oficinasConHorarioList = oficinasConHorario;
      if (oficinasConHorario.length == 0) {
        displayCabecera(false);
        displayMap(false);
        AlertaInfo(true, "No hay un horario asignado");
      }

      // Crear la lista de options para el select
      $.each(oficinasConHorario, function (index, data) {
        countAsistencia(
          personaId,
          data.id_oficina,
          fechaActual,
          data.nombre_oficina
        );
      });

      let radioValidoInicial = (oficinasConHorario[0]) ? oficinasConHorario[0].radio_valido_metros : 0 ;

      // Renderizar la lista despues de 1/10 de segundo para evitar la no carga
      timeoutID = setTimeout(function () {
        document.getElementById("oficinaId").innerHTML = htmlList;
        if (contadorInterno === 0) {
          disabledInput("registrarEntrada");
          AlertaInfo(true, "No hay un horario asignado");
        } else {
          // Establecer el valor del radio valido
          setValue("radioValidoMetros", radioValidoInicial);
          // Renderizar el mapa con la oficina en posicion 0
          initMap(oficinasConHorarioList[0]);
        }
      }, 100);
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
  clearTimeout(timeoutID);
}

function ConsultarTodo(personaId) {
  registrosTotales = false;
  $.ajax({
    data: { accion: "CONSULTAR_TODO", id_persona: personaId },
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
      let orden = true;
      let ordenKeys = [
        "id_asistencia",
        "nombre_persona",
        "nombre_oficina",
        "tipo_1",
        "fecha_e_asistencia",
        "hora_e_asistencia",
        "latitud_e_asistencia",
        "longitud_e_asistencia",
        "observaciones_e_asistencia",
        "tipo_2",
        "fecha_s_asistencia",
        "hora_s_asistencia",
        "latitud_s_asistencia",
        "longitud_s_asistencia",
        "observaciones_s_asistencia",
        "oficina_id",
        "persona_id",
      ];
      $.each(response, function (index, data) {
        // Formatear datos null
        if (data.fecha_s_asistencia == null) {
          data = {
            ...data,
            tipo_1: "Entrada",
            tipo_2: "Salida",
            fecha_s_asistencia: "S/R",
            hora_s_asistencia: "S/R",
            latitud_s_asistencia: "S/R",
            longitud_s_asistencia: "S/R",
            observaciones_s_asistencia: "S/R",
          };
        }

        if (isMobile) {
          html += "<tr>";
          html += "<td>" + data.id_asistencia + "</td>";
          html += "<td>" + data.nombre_oficina + "</td>";
          html += "<td style='text-align: center;'>";
          html += isMobile
            ? "<button class='btn btn-info mr-1 mt-1 min-btn-action' onclick='verMas(" +
              JSON.stringify(data) +
              ", " +
              orden +
              ", " +
              JSON.stringify(ordenKeys) +
              ");'><span class='fa fa-info'></span></button>"
            : "";
          html += `<button class='btn btn-info mr-1 mt-1' onclick='registrarSalida(${
            data.id_asistencia
          }, ${data.oficina_id});' ${
            data.fecha_s_asistencia === "S/R" ? "" : "disabled"
          } ><span class='fa-solid fa-right-from-bracket'></span></button>`;
        } else {
          html += "<tr>";
          html += "<td>" + data.id_asistencia + "</td>";
          html += "<td>" + data.nombre_oficina + "</td>";
          html += "<td>" + "Entrada" + "</td>";
          html += "<td>" + data.fecha_e_asistencia + "</td>";
          html += "<td>" + data.hora_e_asistencia + "</td>";
          html += "<td>" + data.latitud_e_asistencia + "</td>";
          html += "<td>" + data.longitud_e_asistencia + "</td>";
          html += "<td>" + data.observaciones_e_asistencia + "</td>";
          html += "<td style='text-align: center;'>";

          // Boton de registro salida
          html += `<button class='btn btn-info mr-1' onclick='registrarSalida(${
            data.id_asistencia
          }, ${data.oficina_id});' ${
            data.fecha_s_asistencia === "S/R" ? "" : "disabled"
          } ><span class='fa-solid fa-right-from-bracket'></span></button>`;
          // Boton de registro salida

          html += "</td>";
          html += "</tr>";
          // datos de salida
          html += "<tr>";
          html += "<td>" + "" + "</td>";
          html += "<td>" + "" + "</td>";
          html += "<td>" + "Salida" + "</td>";
          html += "<td>" + data.fecha_s_asistencia + "</td>";
          html += "<td>" + data.hora_s_asistencia + "</td>";
          html += "<td>" + data.latitud_s_asistencia + "</td>";
          html += "<td>" + data.longitud_s_asistencia + "</td>";
          html += "<td>" + data.observaciones_s_asistencia + "</td>";
          html += "</tr>";
        }
      });
      document.getElementById("datos").innerHTML = html;
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function EscucharConsulta() {
  registrosTotales = false;
  $("#idAsistencia").change(function () {
    if ($("#idAsistencia").val()) {
      let fecha = $("#idAsistencia").val();
      $.ajax({
        data: {
          id_persona: personaId,
          fecha: fecha,
          accion: "CONSULTAR_ID_PERSONA_FECHA",
        },
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
            // Formatear datos null
            if (data.fecha_s_asistencia == null) {
              data = {
                ...data,
                fecha_s_asistencia: "S/R",
                hora_s_asistencia: "S/R",
                latitud_s_asistencia: "S/R",
                longitud_s_asistencia: "S/R",
                observaciones_s_asistencia: "S/R",
              };
            }

            html += "<tr>";
            html += "<td>" + data.id_asistencia + "</td>";
            html += "<td>" + data.nombre_oficina + "</td>";
            html += "<td>" + "Entrada" + "</td>";
            html += "<td>" + data.fecha_e_asistencia + "</td>";
            html += "<td>" + data.hora_e_asistencia + "</td>";
            html += "<td>" + data.latitud_e_asistencia + "</td>";
            html += "<td>" + data.longitud_e_asistencia + "</td>";
            html += "<td>" + data.observaciones_e_asistencia + "</td>";
            html += "<td style='text-align: center;'>";
            html += `<button class='btn btn-info mr-1' onclick='registrarSalida(${
              data.id_asistencia
            }, ${data.oficina_id});' ${
              data.fecha_s_asistencia === "S/R" ? "" : "disabled"
            } ><span class='fa-solid fa-right-from-bracket'></span></button>`;
            html += "</td>";
            html += "</tr>";
            // datos de salida
            html += "<tr>";
            html += "<td>" + "" + "</td>";
            html += "<td>" + "" + "</td>";
            html += "<td>" + "Salida" + "</td>";
            html += "<td>" + data.fecha_s_asistencia + "</td>";
            html += "<td>" + data.hora_s_asistencia + "</td>";
            html += "<td>" + data.latitud_s_asistencia + "</td>";
            html += "<td>" + data.longitud_s_asistencia + "</td>";
            html += "<td>" + data.observaciones_s_asistencia + "</td>";
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

function registrarEntrada() {
  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro de registrar tu entrada?",
      text: "Esta acción no se puede revertir",
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
          data: retornarDatos("REGISTRAR_ENTRADA"),
          type: "POST",
          dataType: "json",
        })
          .done(function (response) {
            if (response == "OK") {
              listarOficina(personaId, fechaActual);
              MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
              Limpiar();
            } else {
              MostrarAlerta("Error!", response, "error");
            }
            ConsultarTodo(personaId);
          })
          .fail(function (error) {
            console.log(error.responseText);
          });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}

function registrarSalida(idAsistencia, oficinaId) {
  // Verificar que el usuario se encuentre en el rango
  $.ajax({
    url: urlControllerOficina,
    data: { idOficina: oficinaId, accion: "CONSULTAR_ID" },
    type: "POST",
    dataType: "json",
  })
    .done(function (oficina) {
      const officeLocation = {
        lat: parseFloat(oficina.latitud_oficina),
        lng: parseFloat(oficina.longitud_oficina),
        radius: parseInt(oficina.radio_valido_metros),
      };

      verificarRango(userLocation, officeLocation)

      if (inRange) {
        console.log('Dentro del rango');
      } else {
        console.log('Fuera dentro del rango');
      }
    })
    .fail(function (error) {
      console.log(error.responseText);
    });

  swalWithBootstrapButtons
    .fire({
      title: "¿Estas seguro de registrar tu salida?",
      text: "Esta acción no se puede revertir",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        if (inRange) {
          $.ajax({
            url: urlController,
            data: { ...retornarDatos("REGISTRAR_SALIDA"), idAsistencia },
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
              ConsultarTodo(personaId);
            })
            .fail(function (error) {
              console.log(error.responseText);
            });
        } else {
          MostrarAlerta(
            "Esto es una advertencia!",
            "No estás dentro del rango para registrar tu salida",
            "warning"
          );
        }
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("", "Operación cancelada", "info");
      }
    });
}
// funcion para verificar
function countAsistencia(personaId, oficinaId, fechaActual, nombreOficina) {
  $.ajax({
    url: urlController,
    data: {
      accion: "COUNT_ASISTENCIA",
      personaId,
      oficinaId,
      fechaActual,
    },
    type: "POST",
    dataType: "json",
  })
    .done(function (response) {
      let contador = response[0].contador;
      if (contador <= MarcacionesDiariasPorOficina) {
        htmlList +=
          "<option value=" + oficinaId + ">" + nombreOficina + "</option>";
        contadorInterno = +1;
      }
    })
    .fail(function (error) {
      console.log(error.responseText);
    });
}

function Validar() {
  iOficina = getValue("iOficina");
  fechaAsistencia = getValue("fechaAsistencia");
  horaAsistencia = getValue("horaAsistencia");
  observacionesAsistencia = getValue("observacionesAsistencia");
  lat = getValue("lat");
  lng = getValue("lng");

  if (
    !iOficina ||
    !fechaAsistencia ||
    !horaAsistencia ||
    !observacionesAsistencia ||
    !lat ||
    !lng
  ) {
    return false;
  }

  return true;
}

function retornarDatos(accion) {
  return {
    personaId,
    oficinaId: getValue("oficinaId"),
    fechaAsistencia: getValue("fechaAsistencia"),
    horaAsistencia: getValue("horaAsistencia"),
    observacionesAsistencia: getValue("observacionesAsistencia"),
    lat: getValue("lat"),
    lng: getValue("lng"),
    accion: accion,
  };
}

function Limpiar() {}

function mostrarTodo() {
  ConsultarTodo(personaId);
  clearInput("oficinaId");
}

function mostrarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "block";
}

function ocultarAlertaDatos() {
  var alerta = document.getElementById("alertaDatos");
  alerta.style.display = "none";
}

function AlertaInfo(display = true, mensajeText = "") {
  var alertaInfo = document.getElementById("alertaInfo");

  if (display) {
    var mensaje = document.getElementById("mensaje");
    mensaje.innerHTML = mensajeText;
    alertaInfo.style.display = "block";
  } else {
    var alertaInfo = document.getElementById("alertaInfo");

    alertaInfo.style.display = "none";
  }
}

function displayCabecera(display = true) {
  var cabecera = document.getElementById("cabecera");
  if (display) {
    cabecera.style.display = "flex";
  } else {
    cabecera.style.display = "none";
  }
}

function displayMap(display = true) {
  var map = document.getElementById("map");
  if (display) {
    map.style.display = "flex";
  } else {
    map.style.display = "none";
  }
}
