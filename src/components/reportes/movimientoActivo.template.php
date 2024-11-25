<?php
require('../../lib/fpdf/wrapper.php');
require('../../lib/connectios/MySQLPDO.php');
require('../../lib/common/utils.php');

$connection = new MySQLPDO();
$nombreReporteTemp = "movimientoActivo";

$fechaInicio = $_GET['fechaInicio'];
$fechaFinal = $_GET['fechaFinal'];
$accion = $_GET['accion'];

if ($accion == "pdf") {
    class PDF extends Wrapper
    {
        function Header()
        {
            $this->Image('../../assets/img/logo_sf_white.png', 25, 10, 40);
            $this->SetFont('Times', 'B', 15);
            $this->Ln(10);
            $this->Cell(60);
            $this->SetTextColor(31, 78, 121);
            $this->MultiCell(115, 5, mb_convert_encoding('SISFRAN - COOPERATIVA DE TRANSPORTE TOURIS SAN FRANCISCO ORIENTAL', 'ISO-8859-1', 'UTF-8'));
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
            $this->Image('../../assets/img/ec.png', 180, 265, 2);
            $this->SetFont('Times', '', 10);
            $this->SetTextColor(0, 0, 0);
            $this->SetY(-15);
            $this->Cell(192, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
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

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 40);
    $pdf->AddPage();
    $pdf->SetTextColor(17, 86, 160);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX(23);
    $pdf->Cell(50, 10, mb_convert_encoding('REPORTE HISTORICO DE ACTIVOS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(23);
    $pdf->MultiCell(0, 5, mb_convert_encoding("Fecha: $dia de $mes del $año", 'ISO-8859-1', 'UTF-8'), 0, 'L');
    $pdf->Ln(5);

    // Cabecera de la tabla
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX(23);
    $pdf->Cell(10, 10, "Id", 1, 0, 'C', 0);
    $pdf->Cell(18, 10, "Codigo", 1, 0, 'C', 0);
    $pdf->Cell(80, 10, "Funcionario", 1, 0, 'C', 0);
    $pdf->Cell(50, 10, "Fecha", 1, 1, 'C', 0);
    //definiar distancias de cada celda
    $pdf->SetWidths(array(10, 18, 80, 50));
    $pdf->SetLineHeight(5);

    $pdf->SetFont('Times', '', 8);

    $stmt = $connection->prepare("select ma.id_movimiento_activo, a.codigo as codigo, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join persona pe on ma.persona_id = pe.id_persona where ma.fecha_movimiento between :fechaInicio and :fechaFinal;");
    $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindValue(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($datos as $row) {
        $pdf->Row(23, 0, array(
            mb_convert_encoding($row['id_movimiento_activo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['codigo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['nombreFuncionario'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['fecha_movimiento'], 'ISO-8859-1', 'UTF-8'),
        ), 'C');
    }
    $nombreReporte = nombreReporte($nombreReporteTemp, "pdf");
    $pdf->Output('', $nombreReporte, true);
} else {
    $nombreReporte = nombreReporte($nombreReporteTemp, "xls");
    header('Content-type:application/xls');
    header('Content-Disposition: attachment; filename='.$nombreReporte);

    $stmt = $connection->prepare("select ma.id_movimiento_activo, a.codigo as codigo, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join persona pe on ma.persona_id = pe.id_persona where ma.fecha_movimiento between :fechaInicio and :fechaFinal;");
    $stmt->bindValue(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
    $stmt->bindValue(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $mostrar_columnas = false;

    foreach ($datos as $row) {
        if (!$mostrar_columnas) {
            echo implode("\t", array_keys($row)) . "\n";
            $mostrar_columnas = true;
        }
        echo implode("\t", array_values($row)) . "\n";
    }
}