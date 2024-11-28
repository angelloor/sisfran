<?php
require './funcionario.model.php';

if ($_POST) {
    $funcionario = new Funcionario();
    switch ($_POST['accion']) {
        case "CONSULTAR":
            echo json_encode($funcionario->ConsultarTodo());
            break;
        case "CONSULTAR_ID":
            echo json_encode($funcionario->ConsultarPorId($_POST['idFuncionario']));
            break;
        case "GUARDAR":
            $cedulaFuncionario = $_POST['cedulaFuncionario'];
            $nombreFuncionario = $_POST['nombreFuncionario'];
            $direccionFuncionario = $_POST['direccionFuncionario'];
            $telefonoFuncionario = $_POST['telefonoFuncionario'];
            $cargoId = $_POST['cargoId'];
            $unidadId = $_POST['unidadId'];
            $tipoContrato = $_POST['tipoContrato'];
            $salarioBase = $_POST['salarioBase'];

            if (!$cedulaFuncionario) {
                echo json_encode("Ingrese el número de cédula");
                return;
            }
            if (!$nombreFuncionario) {
                echo json_encode("Ingrese el nombre completo del funcionario");
                return;
            }
            if (!$direccionFuncionario) {
                echo json_encode("Ingrese la dirección");
                return;
            }
            if (!$telefonoFuncionario) {
                echo json_encode("Ingrese el número de teléfono");
                return;
            }
            if (!$cargoId) {
                echo json_encode("Ingrese el cargo");
                return;
            }
            if (!$unidadId) {
                echo json_encode("Ingrese la unidad");
                return;
            }
            if (!$tipoContrato) {
                echo json_encode("Seleccione el tipo de contrato");
                return;
            }
            if (!$salarioBase) {
                echo json_encode("Ingrese el salario base");
                return;
            }
            $respuesta = $funcionario->Guardar($cedulaFuncionario, $nombreFuncionario, $direccionFuncionario, $telefonoFuncionario, $cargoId, $unidadId, $tipoContrato, $salarioBase);
            echo json_encode($respuesta);
            break;
        case "MODIFICAR":
            $cedulaFuncionario = $_POST['cedulaFuncionario'];
            $nombreFuncionario = $_POST['nombreFuncionario'];
            $direccionFuncionario = $_POST['direccionFuncionario'];
            $telefonoFuncionario = $_POST['telefonoFuncionario'];
            $cargoId = $_POST['cargoId'];
            $unidadId = $_POST['unidadId'];
            $tipoContrato = $_POST['tipoContrato'];
            $salarioBase = $_POST['salarioBase'];
            $idFuncionario = $_POST['idFuncionario'];

            if (!$cedulaFuncionario) {
                echo json_encode("Ingrese el número de cédula");
                return;
            }
            if (!$nombreFuncionario) {
                echo json_encode("Ingrese el nombre completo del funcionario");
                return;
            }
            if (!$direccionFuncionario) {
                echo json_encode("Ingrese la dirección");
                return;
            }
            if (!$telefonoFuncionario) {
                echo json_encode("Ingrese el número de teléfono");
                return;
            }
            if (!$cargoId) {
                echo json_encode("Ingrese el cargo");
                return;
            }
            if (!$unidadId) {
                echo json_encode("Ingrese la unidad");
                return;
            }
            if (!$tipoContrato) {
                echo json_encode("Seleccione el tipo de contrato");
                return;
            }
            if (!$salarioBase) {
                echo json_encode("Ingrese el salario base");
                return;
            }
            $respuesta = $funcionario->Modificar($idFuncionario, $cedulaFuncionario, $nombreFuncionario, $direccionFuncionario, $telefonoFuncionario, $cargoId, $unidadId, $tipoContrato, $salarioBase);
            echo json_encode($respuesta);

            break;
        case "ELIMINAR":
            $idFuncionario = $_POST['idFuncionario'];
            $respuesta = $funcionario->Eliminar($idFuncionario);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_ID_ROW":
            $idFuncionario = $_POST['idBuscar'];
            $respuesta = $funcionario->ConsultarPorIdRow($idFuncionario);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_REGISTROS":
            $idFuncionario = $_POST['idFuncionario'];
            $respuesta = $funcionario->consultarRegistros($idFuncionario);
            echo json_encode($respuesta);
            break;
        case "CONSULTAR_NOMBRE":
            $idPersona = $_POST['idPersona'];
            $respuesta = $funcionario->consultarNombre($idPersona);
            echo json_encode($respuesta);
            break;
        case "LISTAR_FUNCIONARIO":
            $respuesta = $funcionario->listarFuncionario();
            echo json_encode($respuesta);
            break;
    }
}
