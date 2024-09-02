<?php
    require '../model/funcionario.model.php';

    if($_POST){
        $funcionario = new Funcionario();
        switch($_POST['accion']){
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
                $cargoFuncionario = $_POST['cargoFuncionario'];
                $unidadFuncionario = $_POST['unidadFuncionario'];
                if($cedulaFuncionario == ""){
                    echo json_encode("Ingrese el número de cédula");
                    return;
                }
                if($nombreFuncionario == ""){
                    echo json_encode("Ingrese el nombre completo del funcionario");
                    return;
                }
                if($direccionFuncionario == ""){
                    echo json_encode("Ingrese la dirección");
                    return;
                }
                if($telefonoFuncionario == ""){
                    echo json_encode("Ingrese el número de teléfono");
                    return;
                }
                if($cargoFuncionario == ""){
                    echo json_encode("Ingrese el cargo");
                    return;
                }
                if($unidadFuncionario == ""){
                    echo json_encode("Ingrese la unidad");
                    return;
                }
                $respuesta = $funcionario->Guardar($cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $cedulaFuncionario = $_POST['cedulaFuncionario'];
                $nombreFuncionario = $_POST['nombreFuncionario'];
                $direccionFuncionario = $_POST['direccionFuncionario'];
                $telefonoFuncionario = $_POST['telefonoFuncionario'];
                $cargoFuncionario = $_POST['cargoFuncionario'];
                $unidadFuncionario = $_POST['unidadFuncionario'];
                $idFuncionario = $_POST['idFuncionario'];
                if($cedulaFuncionario == ""){
                    echo json_encode("Ingrese el número de cédula");
                    return;
                }
                if($nombreFuncionario == ""){
                    echo json_encode("Ingrese el nombre completo del funcionario");
                    return;
                }
                if($direccionFuncionario == ""){
                    echo json_encode("Ingrese la dirección");
                    return;
                }
                if($telefonoFuncionario == ""){
                    echo json_encode("Ingrese el número de teléfono");
                    return;
                }
                if($cargoFuncionario == ""){
                    echo json_encode("Ingrese el cargo");
                    return;
                }
                if($unidadFuncionario == ""){
                    echo json_encode("Ingrese la unidad");
                    return;
                }
                $respuesta = $funcionario->Modificar($idFuncionario,$cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario);
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
                return;
            break;
            case "LISTARCARGO":
                $respuesta = $funcionario->listarCargo();
                echo json_encode($respuesta);
            break;
            case "LISTARUNIDAD":
                $respuesta = $funcionario->listarUnidad();
                echo json_encode($respuesta);
            break;
            case "CONSULTARREGISTROS":
                $idFuncionario = $_POST['idFuncionario'];
                $respuesta = $funcionario->consultarRegistros($idFuncionario);
                echo json_encode($respuesta);
            break;
        }
    }
?>