var urlController = "../controller/sistema.controller.php";
var registrosTotales = false;

$(document).ready(function () {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
    $("#nombre").keyup(function () {
        var ta = $("#nombre");
        letras = ta.val().replace(/ /g, "");
        ta.val(letras)
    });
})

function mostrarAlertaDatos() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta() {
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
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
            html += "<td>" + data.nombre_sistema + "</td>";
            html += "<td>" + data.direccion_sistema + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_sistema + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_sistema + ");'><span class='fa fa-trash'></span></button>"
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
    $('#idSistema').keyup(function () {
        if ($('#idSistema').val()) {
            let idBuscar = $('#idSistema').val();
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
                    html += "<td>" + data.nombre_sistema + "</td>";
                    html += "<td>" + data.direccion_sistema + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_sistema + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_sistema + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idSistema) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'btn btn-primary mr-2 ml-2',
            confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar el sistema?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlController,
                data: { "idSistema": idSistema, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function (response) {
                document.getElementById('nombre').value = response.nombre_sistema;
                document.getElementById('direccion').value = response.direccion_sistema;
                document.getElementById('idSistema').value = response.id_sistema;
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

function Eliminar(idSistema) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'btn btn-primary mr-2 ml-2',
            confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar el sistema?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlController,
                data: { "idSistema": idSistema, "accion": "ELIMINAR" },
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
}

function Validar() {
    nombresistema = document.getElementById('nombre').value
    direccion = document.getElementById('direccion').value
    if (nombresistema == "" || direccion == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "nombreSistema": (document.getElementById('nombre').value).toUpperCase(),
        "direccion": document.getElementById('direccion').value,
        "accion": accion,
        "idSistema": document.getElementById("idSistema").value
    };
}

function Limpiar() {
    document.getElementById('idSistema').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('direccion').value = "";
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
    document.getElementById('idSistema').value = "";
}