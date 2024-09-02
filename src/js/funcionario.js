var urlController = "../controller/funcionario.controller.php";
var registrosTotales = false;

$(document).ready(function () {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
    listarCargo();
    listarUnidad();
    document.getElementById('cedulaFuncionario').addEventListener('keypress', soloNumeros, false);
    document.getElementById('telefonoFuncionario').addEventListener('keypress', soloNumeros, false);
})

function mostrarAlertaDatos() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

function soloNumeros(e) {
    input = document.getElementById('telefonoFuncionario');
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57 || (input.value.length === 13)) {
        e.preventDefault();
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
            html += "<td>" + data.cedula + "</td>";
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.direccion + "</td>";
            html += "<td>" + data.telefono + "</td>";
            html += "<td>" + data.nombre_cargo + "</td>";
            html += "<td>" + data.nombre_unidad + "</td>";
            html += "<td style='text-align: center;'>";
            html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_persona + ");'><span class='fa fa-edit'></span></button>"
            html += "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" + data.id_persona + ");'><span class='fa fa-trash'></span></button>"
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
    $('#idFuncionario').keyup(function () {
        if ($('#idFuncionario').val()) {
            let idBuscar = $('#idFuncionario').val();
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
                    html += "<td>" + data.cedula + "</td>";
                    html += "<td>" + data.nombre_persona + "</td>";
                    html += "<td>" + data.direccion + "</td>";
                    html += "<td>" + data.telefono + "</td>";
                    html += "<td>" + data.nombre_cargo + "</td>";
                    html += "<td>" + data.nombre_unidad + "</td>";
                    html += "<td style='text-align: center;'>";
                    html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_persona + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" + data.id_persona + ");'><span class='fa fa-trash'></span></button>"
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

function listarCargo() {
    $.ajax({
        data: { "accion": "LISTARCARGO" },
        url: urlController,
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        var html = "";
        $.each(response, function (index, data) {
            html += "<option>" + data.nombre_cargo + "</option>";
        });
        document.getElementById("cargoFuncionario").innerHTML = html;
    }).fail(function (response) {
        console.log(response);
    });
}

function listarUnidad() {
    $.ajax({
        data: { "accion": "LISTARUNIDAD" },
        url: urlController,
        type: 'POST',
        dataType: 'json'
    }).done(function (response) {
        var html = "";
        $.each(response, function (index, data) {
            html += "<option>" + data.nombre_unidad + "</option>";
        });
        document.getElementById("unidadFuncionario").innerHTML = html;
    }).fail(function (response) {
        console.log(response);
    });
}

function ConsultarPorId(idFuncionario) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'btn btn-primary mr-2 ml-2',
            confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar al funcionario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlController,
                data: { "idFuncionario": idFuncionario, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function (response) {
                document.getElementById('cedulaFuncionario').value = response.cedula;
                document.getElementById('nombreFuncionario').value = response.nombre_persona;
                document.getElementById('direccionFuncionario').value = response.direccion;
                document.getElementById('telefonoFuncionario').value = response.telefono;
                document.getElementById('cargoFuncionario').value = response.nombre_cargo;
                document.getElementById('unidadFuncionario').value = response.nombre_unidad;
                document.getElementById('idFuncionario').value = response.id_persona;
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

function Eliminar(idFuncionario) {
    var registros = 0;
    $.ajax({
        url: urlController,
        data: { "idFuncionario": idFuncionario, "accion": "CONSULTARREGISTROS" },
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
            title: '¿Estas seguro de eliminar el funcionario? Esta asignado a ' + registros + ' actas de entrega recepción ',
            text: 'Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a este funcionario',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: urlController,
                    data: { "idFuncionario": idFuncionario, "accion": "ELIMINAR" },
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
    cedulaFuncionario = document.getElementById('cedulaFuncionario').value
    nombreFuncionario = document.getElementById('nombreFuncionario').value
    direccionFuncionario = document.getElementById('direccionFuncionario').value
    telefonoFuncionario = document.getElementById('telefonoFuncionario').value
    cargoFuncionario = document.getElementById('cargoFuncionario').value
    unidadFuncionario = document.getElementById('unidadFuncionario').value
    if (cedulaFuncionario == "" || nombreFuncionario == "" || direccionFuncionario == "" || telefonoFuncionario == "" || cargoFuncionario == "" || unidadFuncionario == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "cedulaFuncionario": document.getElementById('cedulaFuncionario').value,
        "nombreFuncionario": (document.getElementById('nombreFuncionario').value).toUpperCase(),
        "direccionFuncionario": (document.getElementById('direccionFuncionario').value).toUpperCase(),
        "telefonoFuncionario": document.getElementById('telefonoFuncionario').value,
        "cargoFuncionario": document.getElementById('cargoFuncionario').value,
        "unidadFuncionario": document.getElementById('unidadFuncionario').value,
        "accion": accion,
        "idFuncionario": document.getElementById("idFuncionario").value
    };
}

function Limpiar() {
    document.getElementById('idFuncionario').value = "";
    document.getElementById('cedulaFuncionario').value = "";
    document.getElementById('nombreFuncionario').value = "";
    document.getElementById('direccionFuncionario').value = "";
    document.getElementById('telefonoFuncionario').value = "";
    document.getElementById('cargoFuncionario').value = "";
    document.getElementById('unidadFuncionario').value = "";
    listarCargo();
    listarUnidad();
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
    document.getElementById('idFuncionario').value = "";
}