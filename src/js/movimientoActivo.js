var urlController = "../controller/movimientoActivo.controller.php";
var urlGet = "";
var registrosTotales = false;

$(document).ready(function () {
    cargarFechaActual();
    Consultar();
    ocultarAlerta();
})

function mostrarAlertaDatos() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

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
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                accion = "pdf";
                if (registrosTotales == false) {
                    MostrarAlerta("", "No se encuentran registros de " + fechaInicio + " a " + fechaFinal, "info");
                    return;
                } else {
                    urlGet = urlGet + "fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal + "&accion=" + accion;
                    window.open('../model/movimientoActivo.php?' + urlGet, '_blank');
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
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                accion = "excel";
                if (registrosTotales == false) {
                    MostrarAlerta("", "No se encuentran registros de " + fechaInicio + " a " + fechaFinal, "info");
                    return;
                } else {
                    urlGet = urlGet + "fechaInicio=" + fechaInicio + "&fechaFinal=" + fechaFinal + "&accion=" + accion;
                    window.open('../model/movimientoActivo.php?' + urlGet, '_blank');
                }
            }
        }
    }
}

function comprobarFechas() {
    fechaInicio = document.getElementById('fechaInicio').value;
    fechaFinal = document.getElementById('fechaFinal').value;
    if (fechaInicio == "" && fechaFinal == "") {
        return 1;
    } else {
        if (fechaInicio == "") {
            return 2;
        } else {
            if (fechaFinal == "") {
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
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                $.ajax({
                    data: { "accion": "CONSULTARPORFECHA", "fechaInicio": fechaInicio, "fechaFinal": fechaFinal },
                    url: urlController,
                    type: 'POST',
                    dataType: 'json'
                }).done(function (response) {
                    if (response.length >= 1) {
                        registrosTotales = true;
                    }
                    var html = "";
                    $.each(response, function (index, data) {
                        html += "<tr>";
                        html += "<td>" + data.id_movimiento_activo + "</td>";
                        html += "<td>" + data.codigo + "</td>";
                        html += "<td>" + data.nombreCustodio + "</td>";
                        html += "<td>" + data.nombreFuncionario + "</td>";
                        html += "<td>" + data.fecha_movimiento + "</td>";
                        html += "</tr>";
                    });
                    document.getElementById("datos").innerHTML = html;
                }).fail(function (response) {
                    console.log(response);
                });
            }
        }
    }
}

function Consultar() {
    registrosTotales = false;
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: urlController,
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (response.length >= 1) {
            registrosTotales = true;
            ocultarAlerta();
        } else {
            mostrarAlertaDatos();
        }
        var html = "";
        $.each(response, function (index, data) {
            html += "<tr>";
            html += "<td>" + data.id_movimiento_activo + "</td>";
            html += "<td>" + data.codigo + "</td>";
            html += "<td>" + data.nombreCustodio + "</td>";
            html += "<td>" + data.nombreFuncionario + "</td>";
            html += "<td>" + data.fecha_movimiento + "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function (response) {
        console.log(response);
    });
}

function cargarFechaActual() {
    var f = new Date();
    if ((f.getMonth() + 1) <= 9) {
        mesFinal = "0" + (f.getMonth() + 1);
    } else {
        mesFinal = f.getMonth();
    }
    if ((f.getDate()) <= 9) {
        diaFinal = "0" + (f.getDate());
    } else {
        diaFinal = f.getDate();
    }
    document.getElementById('fechaInicio').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
    document.getElementById('fechaFinal').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}
