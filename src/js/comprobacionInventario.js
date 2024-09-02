var urlController = '../controller/comprobacionInventario.controller.php';
var activoComprobacion = 0;

$(document).ready(function () {
    BloquearBotones(true);
    EscucharConsulta();
    listarFuncionario();
    listarEstado();
    document
        .getElementById('codigo')
        .addEventListener('keypress', soloNumeros, false);
});

function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}

function listarFuncionario() {
    $.ajax({
        data: { accion: 'LISTARFUNCIONARIO' },
        url: urlController,
        type: 'POST',
        dataType: 'json',
    })
        .done(function (response) {
            var html = '';
            $.each(response, function (index, data) {
                html += '<option>' + data.nombre_persona + '</option>';
            });
            document.getElementById('funcionario').innerHTML = html;
        })
        .fail(function (response) {
            console.log(response);
        });
}

function listarEstado() {
    $.ajax({
        data: { accion: 'LISTARESTADO' },
        url: urlController,
        type: 'POST',
        dataType: 'json',
    })
        .done(function (response) {
            var html = '';
            $.each(response, function (index, data) {
                html += '<option>' + data.nombre_estado + '</option>';
            });
            document.getElementById('estado').innerHTML = html;
        })
        .fail(function (response) {
            console.log(response);
        });
}

function EscucharConsulta() {
    activoComprobacion = 0;
    $('#codigo').keyup(function () {
        if ($('#codigo').val()) {
            let codigoActivo = $('#codigo').val();
            $.ajax({
                data: { codigoActivo: codigoActivo, accion: 'CONSULTARDATOS' },
                url: urlController,
                type: 'POST',
                dataType: 'json',
            }).done(function (response) {
                if (response == false) {
                    activoComprobacion = 1;
                } else {
                    activoComprobacion = 0;
                    document.getElementById('estado').value = response.nombre_estado;
                    document.getElementById('funcionario').value = response.funcionario;
                    document.getElementById('comentario').value = response.comentario;
                }
            }).fail(function (response) {
                console.log(response);
            });
        }
    });
}

function Guardar() {
    if (activoComprobacion == 1) {
        MostrarAlerta("", "No puede hacer la comprobación del inventario de un activo que no esta asignado", "info")
    } else {
        $.ajax({
            data: retornarDatos('GUARDAR'),
            url: urlController,
            type: 'POST',
            dataType: 'json',
        })
            .done(function (response) {
                if (response == 'OK') {
                    MostrarAlerta('Éxito!', 'Activo verificado', 'success');
                    Cancelar();
                    Limpiar();
                } else {
                    MostrarAlerta('Error!', response, 'error');
                }
            })
            .fail(function (response) {
                console.log(response);
            });
    }
}

function Restablecer() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            cancelButton: 'btn btn-primary mr-2 ml-2',
            confirmButton: 'btn btn-success mr-2 ml-2',
        },
        buttonsStyling: false,
    });
    swalWithBootstrapButtons
        .fire({
            text: '¿Estas seguro de restablecer la comprobación de inventario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: urlController,
                    data: { accion: 'RESTABLECER' },
                    type: 'POST',
                    dataType: 'json',
                })
                    .done(function (response) {
                        if (response == 'OK') {
                            MostrarAlerta(
                                'Éxito!',
                                'Comprobación de inventario restablecido',
                                'success'
                            );
                            Limpiar();
                        } else {
                            MostrarAlerta('Error!', response, 'error');
                        }
                        BloquearBotones(true);
                    })
                    .fail(function (response) {
                        console.log(response);
                    });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('', 'Operación cancelada', 'info');
            }
        });
    Limpiar();
}

function Validar() {
    codigo = document.getElementById('codigo').value;
    estado = document.getElementById('estado').value;
    funcionario = document.getElementById('funcionario').value;
    comentario = document.getElementById('comentario').value;

    if (codigo == '' || estado == '' || funcionario == '' || comentario == '') {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        codigo: document.getElementById('codigo').value,
        estado: document.getElementById('estado').value,
        funcionario: document.getElementById('funcionario').value,
        comentario: document.getElementById('comentario').value,
        accion: accion,
    };
}

function Limpiar() {
    document.getElementById('codigo').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('funcionario').value = '';
    document.getElementById('comentario').value = '';
}

function Nuevo() {
    activoComprobacion = 0;
    console.log(activoComprobacion);
    BloquearBotones(false);
    Limpiar();
}

function Cancelar() {
    BloquearBotones(true);
    Limpiar();
}

function BloquearBotones(guardar) {
    if (guardar) {
        document.getElementById('nuevo').disabled = false;
        document.getElementById('restablecer').disabled = false;
        document.getElementById('guardar').disabled = true;
        document.getElementById('cancelar').disabled = true;
        document.getElementById('codigo').disabled = true;
        document.getElementById('estado').disabled = true;
        document.getElementById('funcionario').disabled = true;
        document.getElementById('comentario').disabled = true;
    } else {
        document.getElementById('nuevo').disabled = true;
        document.getElementById('restablecer').disabled = true;
        document.getElementById('guardar').disabled = false;
        document.getElementById('cancelar').disabled = false;
        document.getElementById('codigo').disabled = false;
        document.getElementById('estado').disabled = false;
        document.getElementById('funcionario').disabled = false;
        document.getElementById('comentario').disabled = false;
        document.getElementById('codigo').focus();
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(titulo, descripcion, tipoAlerta);
}
