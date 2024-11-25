<?php
date_default_timezone_set('America/Lima');
$connection = new MySQLPDO();
$fechaTotal = getdate();

$ciudad = "Puyo";
$dia = date("d");
$mes_inicial = date("F");
$año = date("Y");

function mes_format($mes_inicial)
{
    if ($mes_inicial == "January") $mes = "Enero";
    if ($mes_inicial == "February") $mes = "Febrero";
    if ($mes_inicial == "March") $mes = "Marzo";
    if ($mes_inicial == "April") $mes = "Abril";
    if ($mes_inicial == "May") $mes = "Mayo";
    if ($mes_inicial == "June") $mes = "Junio";
    if ($mes_inicial == "July") $mes = "Julio";
    if ($mes_inicial == "August") $mes = "Agosto";
    if ($mes_inicial == "September") $mes = "Setiembre";
    if ($mes_inicial == "October") $mes = "Octubre";
    if ($mes_inicial == "November") $mes = "Noviembre";
    if ($mes_inicial == "December") $mes = "Diciembre";
    return $mes;
}
$mes = mes_format($mes_inicial);

function nombreReporte($nombre, $ext)
{
    $fechaTotal = getdate();
    if ($fechaTotal['mday'] <= 9) {
        $dia = "0" . $fechaTotal['mday'];
    } else {
        $dia = $fechaTotal['mday'];
    }
    if ($fechaTotal['mon'] <= 9) {
        $mes = "0" . $fechaTotal['mon'];
    } else {
        $mes = $fechaTotal['mon'];
    }
    $fechaFinal = $fechaTotal['year'] . "-" . $mes . "-" . $dia;
    $nombreFinal = $nombre . $fechaFinal . "." . $ext;
    return $nombreFinal;
}

function fechaHora()
{
    $fechaTotal = getdate();
    if ($fechaTotal['mday'] <= 9) {
        $dia = "0" . $fechaTotal['mday'];
    } else {
        $dia = $fechaTotal['mday'];
    }
    if ($fechaTotal['mon'] <= 9) {
        $mes = "0" . $fechaTotal['mon'];
    } else {
        $mes = $fechaTotal['mon'];
    }
    $fechaCompleta = $dia . "/" . $mes . "/" . $fechaTotal['year'] . " - " . $fechaTotal['hours'] . ":" . $fechaTotal['minutes'];
    return $fechaCompleta;
}

function calcularHorasYMinutosTrabajados($fechaIngreso, $horaIngreso, $fechaSalida, $horaSalida)
{
    if ((!$fechaIngreso || !$horaIngreso || !$fechaSalida || !$horaSalida) || ($fechaSalida == 'S/R' || $horaSalida == 'S/R') ) {
        return ['horas' => 0, 'minutos' => 0];
    } else {
        // Combinar las fechas y horas en un formato DateTime
        $entrada = DateTime::createFromFormat('Y-m-d H:i:s', "$fechaIngreso $horaIngreso");
        $salida = DateTime::createFromFormat('Y-m-d H:i:s', "$fechaSalida $horaSalida");

        // Verificar si las fechas son válidas
        if (!$entrada || !$salida) {
            throw new Exception("Las fechas y/u horas proporcionadas no son válidas.");
        }

        // Calcular la diferencia entre las dos fechas
        $diferencia = $entrada->diff($salida);

        // Verificar si la salida es anterior a la entrada
        if ($diferencia->invert === 1) {
            throw new Exception("La fecha/hora de salida no puede ser anterior a la de ingreso.");
        }

        // Obtener horas y minutos de la diferencia
        $horas = $diferencia->h + ($diferencia->days * 24); // Incluir las horas de los días
        $minutos = $diferencia->i;

        // Formatear el resultado
        return ['horas' => $horas, 'minutos' => $minutos];
    }
}
