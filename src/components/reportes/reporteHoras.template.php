<?php
require('../../lib/fpdf/wrapper.php');
require('../../lib/connectios/MySQLPDO.php');
require('../../lib/common/utils.php');

$nombreReporteTemp = "reporteHorasTrabajadas";

$idPersona = $_GET['idPersona'];
$nombrePersona = $_GET['nombrePersona'];
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];
$accion = $_GET['accion'];

if ($accion == "pdf") {
    class PDF extends Wrapper
    {
        function Header()
        {
            $this->Image('../../assets/img/logo_sf_white.png', 25, 10, 40);
            $this->SetFont('Times', '', 15);
            $this->Ln(10);
            $this->Cell(60);
            $this->SetTextColor(17, 86, 160);
            $this->MultiCell(200, 5, mb_convert_encoding('SISFRAN - COOPERATIVA DE TRANSPORTE TOURIS SAN FRANCISCO ORIENTAL', 'ISO-8859-1', 'UTF-8'));
            $this->Ln(5);
        }

        function Footer()
        {
            $this->SetY(-25);
            $this->SetX(30);
            $this->SetTextColor(183, 191, 214);
            $this->SetFont('Times', 'I', 24);
            $this->Cell(0, 10, mb_convert_encoding('Orgullosamente Amazónicos', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
            $this->SetY(-30);
            $this->SetX(0);
            $this->SetTextColor(42, 81, 147);
            $this->SetFont('Times', '', 8);
            $this->SetRightMargin(33);
            $this->MultiCell(0, 3, mb_convert_encoding("Puyo / Ecuador \n tourisanfrancisco.com \n Av. Francisco de Orellana \n Angel Manzano \n Tlf: (593) 2 885 481", 'ISO-8859-1', 'UTF-8'), 0, 'R');
            $this->Image('../../assets/img/ec.png', 265, 178, 2);
            $this->SetFont('Times', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->SetY(-15);
            $this->Cell(280, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
        }

        function parrafo($texto)
        {
            $txt = $texto;
            $this->SetFont('Times', '', 10);
            $this->SetRightMargin(25);
            $this->SetLeftMargin(25);
            $this->MultiCell(0, 5, mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
            $this->Ln();
            $this->SetFont('', 'I');
        }
    }

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 45);
    $pdf->AddPage();
    $pdf->SetTextColor(17, 86, 160);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX(23);
    $pdf->Cell(50, 10, mb_convert_encoding('REPORTE DE HORAS TRABAJADAS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(23);
    $pdf->MultiCell(0, 5, mb_convert_encoding("Funcionario: $nombrePersona", 'ISO-8859-1', 'UTF-8'), 0, 'L');
    $pdf->SetX(23);
    $pdf->MultiCell(0, 5, mb_convert_encoding("Fecha Inicio: $fechaInicio", 'ISO-8859-1', 'UTF-8'), 0, 'L');
    $pdf->SetX(23);
    $pdf->MultiCell(0, 5, mb_convert_encoding("Fecha Fin: $fechaFin", 'ISO-8859-1', 'UTF-8'), 0, 'L');
    $pdf->Ln(5);

    // Cabecera de la tabla
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetX(23);
    $pdf->Cell(50, 10, "Oficina", 1, 0, 'C', 0);
    $pdf->Cell(50, 10, "Fecha Entrada", 1, 0, 'C', 0);
    $pdf->Cell(30, 10, "Hora Entrada", 1, 0, 'C', 0);
    $pdf->Cell(50, 10, "Fecha Salida", 1, 0, 'C', 0);
    $pdf->Cell(30, 10, "Hora Salida", 1, 0, 'C', 0);
    $pdf->Cell(40, 10, "Horas Jornada", 1, 1, 'C', 0);
    // Definiar distancias de cada celda
    $pdf->SetWidths(array(50, 50, 30, 50, 30, 40));
    $pdf->SetLineHeight(5);
    $pdf->SetFont('Times', '', 10);

    // consulta
    $stmt = $connection->prepare("select id_asistencia, persona_id, nombre_persona, nombre_oficina, fecha_e_asistencia, fecha_s_asistencia, hora_e_asistencia, hora_s_asistencia from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id =  o.id_oficina where persona_id = :idPersona and fecha_e_asistencia between :fechaInicio and :fechaFin order by a.fecha_e_asistencia desc;");
    $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
    $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindValue(":fechaFin", $fechaFin, PDO::PARAM_STR);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Reemplazar los valores null por "Sin dato" en todo el array
    $datos = array_map(function ($row) {
        return array_map(function ($value) {
            return $value === null ? "S/R" : $value;
        }, $row);
    }, $datos);

    foreach ($datos as $row) {
        $tiempoTrabajado = calcularHorasYMinutosTrabajados(
            $row['fecha_e_asistencia'],
            $row['hora_e_asistencia'],
            $row['fecha_s_asistencia'],
            $row['hora_s_asistencia']
        );

        // Formatear el tiempo final
        if ($tiempoTrabajado['horas'] === 0) {
            $tiempoFinal = "{$tiempoTrabajado['minutos']}m";
        } else {
            $tiempoFinal = "{$tiempoTrabajado['horas']}h {$tiempoTrabajado['minutos']}m";
        }

        $pdf->Row(23, 0, array(
            mb_convert_encoding($row['nombre_oficina'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['fecha_e_asistencia'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['hora_e_asistencia'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['fecha_s_asistencia'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['hora_s_asistencia'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($tiempoFinal , 'ISO-8859-1', 'UTF-8'),
        ), 'C');
    }

    $nombreReporte = nombreReporte($nombreReporteTemp, "pdf");
    $pdf->Output('', $nombreReporte, true);
} else {
    $nombreReporte = nombreReporte($nombreReporteTemp, "xls");
    header('Content-type:application/xls');
    header('Content-Disposition: attachment; filename=' . $nombreReporte);

    // consulta
    $stmt = $connection->prepare("select id_asistencia, persona_id, nombre_persona, nombre_oficina, fecha_e_asistencia, fecha_s_asistencia, hora_e_asistencia, hora_s_asistencia from asistencia a inner join persona p on a.persona_id = p.id_persona inner join oficina o on a.oficina_id =  o.id_oficina where persona_id = :idPersona and fecha_e_asistencia between :fechaInicio and :fechaFin order by a.fecha_e_asistencia desc;");
    $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
    $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindValue(":fechaFin", $fechaFin, PDO::PARAM_STR);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Reemplazar los valores null por "Sin dato" en todo el array
    $datos = array_map(function ($row) {
        return array_map(function ($value) {
            return $value === null ? "S/R" : $value;
        }, $row);
    }, $datos);

    $mostrar_columnas = false;

    foreach ($datos as $row) {
        if (!$mostrar_columnas) {
            echo implode("\t", array_keys($row)) . "\n";
            $mostrar_columnas = true;
        }
        echo implode("\t", array_values($row)) . "\n";
    }
}
