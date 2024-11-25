<?php
require('../../lib/fpdf/wrapper.php');
require('../../lib/connectios/MySQLPDO.php');
require('../../lib/common/utils.php');

$accion = $_GET['accion'];
$nombreReporteTemp = 'activosConfirmados';

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
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 45);
    $pdf->SetTextColor(17, 86, 160);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX(23);
    $pdf->Cell(50, 10, mb_convert_encoding('REPORTE DE ACTIVOS CONFIRMADOS', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->SetX(23);
    $pdf->MultiCell(0, 5, mb_convert_encoding("Fecha: $dia de $mes del $año", 'ISO-8859-1', 'UTF-8'), 0, 'L');

    $stmt = $connection->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.comprobacion_inventario = 'SI') and (a.historico = 1) order by a.codigo asc;");
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdf->Ln(5);

    // Cabecera de la tabla
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX(23);
    $pdf->Cell(18, 10, "Codigo", 1, 0, 'C', 0);
    $pdf->Cell(65, 10, "Nombre", 1, 0, 'C', 0);
    $pdf->Cell(50, 10, "Caracteristica", 1, 0, 'C', 0);
    $pdf->Cell(30, 10, "Marca", 1, 0, 'C', 0);
    $pdf->Cell(30, 10, "Modelo", 1, 0, 'C', 0);
    $pdf->Cell(35, 10, "Serie", 1, 0, 'C', 0);
    $pdf->Cell(20, 10, "Estado", 1, 1, 'C', 0);
    //definiar distancias de cada celda
    $pdf->SetWidths(array(18, 65, 50, 30, 30, 35, 20));
    $pdf->SetLineHeight(5);

    $pdf->SetFont('Times', '', 10);

    // datos de la tabla
    foreach ($datos as $row) {
        $pdf->Row(23, 0, array(
            mb_convert_encoding($row['codigo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['nombre_activo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['caracteristica'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['nombre_marca'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['modelo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['serie'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['nombre_estado'], 'ISO-8859-1', 'UTF-8'),
        ), 'C');
    }

    $nombreReporte = nombreReporte($nombreReporteTemp, "pdf");
    $pdf->Output('', $nombreReporte, true);
} else {
    $nombreReporte = nombreReporte($nombreReporteTemp, "xls");
    header('Content-type:application/xls');
    header('Content-Disposition: attachment; filename='.$nombreReporte);

    $stmt = $connection->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.comprobacion_inventario = 'SI') and (a.historico = 1) order by a.codigo asc;");
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