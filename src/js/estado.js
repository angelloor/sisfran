var urlController = "../controller/estado.controller.php";
var registrosTotales = false;

$(document).ready(function () {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
})

function mostrarAlertaDatos() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

function soloLetras() {
    $('#nombre').keypress(function (event) {
        if (event.which < 65 || event.which > 122) {
            return false;
        }
    });
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
            html += "<td>" + data.nombre_estado + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_estado + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_estado + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function (response) {
        console.log(response);
    });
}

function EscucharConsulta() {
    registrosTotales = false;
    $('#idEstado').keyup(function () {
        if ($('#idEstado').val()) {
            let idBuscar = $('#idEstado').val();
            $.ajax({
                data: { "idBuscar": idBuscar, "accion": "CONSULTAR_ID_ROW" },
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
                    html += "<td>" + data.nombre_estado + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_estado + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_estado + ");'><span class='fa fa-trash'></span></button>"
                    html += "</td>";
                    html += "</tr>";
                });
                document.getElementById("datos").innerHTML = html;
            }).fail(function (response) {
                console.log(response);
            });
        }
    });
}

function ConsultarPorId(idEstado) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'btn btn-primary mr-2 ml-2',
            confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar el estado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlController,
                data: { "idEstado": idEstado, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function (response) {
                document.getElementById('nombre').value = response.nombre_estado;
                document.getElementById('idEstado').value = response.id_estado;
                BloquearBotones(false);
            }).fail(function (response) {
                console.log(response);
            });
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire('', 'Operación cancelada', 'info')
        }
    })
}

function Guardar() {
    $.ajax({
        url: urlController,
        data: retornarDatos("GUARDAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
            Limpiar();
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Consultar();
    }).fail(function (response) {
        console.log(response);
    });
}

function Modificar() {
    $.ajax({
        url: urlController,
        data: retornarDatos("MODIFICAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
            Limpiar();
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Consultar();
    }).fail(function (response) {
        console.log(response);
    });
}

function Eliminar(idEstado) {
    var registros = 0;
    $.ajax({
        url: urlController,
        data: { "idEstado": idEstado, "accion": "CONSULTARREGISTROS" },
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        registros = response.registros;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                cancelButton: 'btn btn-primary mr-2 ml-2',
                confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '¿Estas seguro de eliminar el estado? Contiene ' + registros + ' activos registrados',
            text: 'Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a este estado',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: urlController,
                    data: { "idEstado": idEstado, "accion": "ELIMINAR" },
                    type: 'POST',
                    dataType: 'json'
                }).done(function (response) {
                    if (response == "OK") {
                        swalWithBootstrapButtons.fire('', 'Registro eliminado', 'success')
                    } else {
                        swalWithBootstrapButtons.fire('', response, 'error')
                    }
                    Consultar();
                }).fail(function (response) {
                    console.log(response);
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire('', 'Operación cancelada', 'info')
            }
        })
        Limpiar();
    }).fail(function (response) {
        console.log(response);
    });
}

function Validar() {
    nombreEstado = document.getElementById('nombre').value
    if (nombreEstado == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "nombreEstado": (document.getElementById('nombre').value).toUpperCase(),
        "accion": accion,
        "idEstado": document.getElementById("idEstado").value
    };
}

function Limpiar() {
    document.getElementById('idEstado').value = "";
    document.getElementById('nombre').value = "";
    BloquearBotones(true);
}

function Cancelar() {
    BloquearBotones(false);
    Limpiar();
}

function BloquearBotones(guardar) {
    if (guardar) {
        document.getElementById('guardar').disabled = false;
        document.getElementById('modificar').disabled = true;
        document.getElementById('cancelar').disabled = true;
    } else {
        document.getElementById('guardar').disabled = true;
        document.getElementById('modificar').disabled = false;
        document.getElementById('cancelar').disabled = false;
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}

function mostrarTodo() {
    Consultar();
    document.getElementById('idEstado').value = "";
}