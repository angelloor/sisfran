<?php
require('../../lib/fpdf/wrapper.php');
require('../../lib/connectios/MySQLPDO.php');
require('../../lib/common/utils.php');

$totalSistemas = $_GET['totalSistemas'];
$idSistemas = explode(',', $_GET['idSistemas']);
$periodo = $_GET['periodo'];
$idPersona = $_GET['idPersona'];

//TRAER DATOS DEL FUNCIONARIO QUE ENTREGA
$stmt = $connection->prepare("select f.denominacion ,p.nombre_persona, c.nombre_cargo from firma f inner join persona p on f.persona_id = p.id_persona inner join cargo c on p.cargo_id = c.id_cargo where f.id_firma = 1;");
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreEntregaCompleto = $results['nombre_persona'];
$cargoEntrega = $results['nombre_cargo'];
$denominacion = $results['denominacion'];

function nombreMasDenominacion($nombreEntregaCompleto, $denominacion)
{
    $separarNombres = explode(" ", $nombreEntregaCompleto);
    return $denominacion . ". " . $separarNombres[0] . " " . $separarNombres[1];
}

$nombreEntrega = nombreMasDenominacion($nombreEntregaCompleto, $denominacion);

$stmt = $connection->prepare("select p.cedula, c.nombre_cargo, p.nombre_persona from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.id_persona = :idPersona;");
$stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$cedula = $results['cedula'];
$nombreCargo = $results['nombre_cargo'];
$nombrePersona = $results['nombre_persona'];

$sistemas = "";
$credenciales = "";

$totalSistemas = $_GET['totalSistemas'];

class PDF extends Wrapper
{
    function Header()
    {
        $this->Image('../../assets/img/logo_sf_white.png', 25, 10, 40);
        $this->SetFont('Times', 'B', 15);
        $this->Ln(10);
        $this->Cell(45);
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
        $this->Cell(165, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
        $this->Cell(-123, 10, 'FO-01(DG-SM-AD-09)', 0, 0, 'R');
    }

    function parrafo($texto)
    {
        $txt = $texto;
        $this->SetFont('Times', '', 10);
        $this->MultiCell(0, 5, mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
        $this->SetFont('', 'I');
    }
}

$pdf = new PDF();
$pdf->SetRightMargin(25);
$pdf->SetLeftMargin(25);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->SetTextColor(31, 78, 121);
$pdf->SetFont('Times', 'B', 12);
$pdf->Ln();
$pdf->Cell(0, 10, mb_convert_encoding('ACTA ENTREGA RECEPCION DE CREDENCIALES DIGITALES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
$pdf->parrafo("La presente acta de entrega recepción tiene por objeto otorgar credenciales para el manejo de los siguientes sistemas: ");
$pdf->Ln();

// Cabecera de la tabla
$pdf->SetFont('Times', 'B', 10);
$pdf->SetX(25);
$pdf->Cell(40, 6, "SISTEMA", 1, 0, 'C', 0);
$pdf->Cell(40, 6, "URL", 1, 0, 'C', 0);
$pdf->Cell(40, 6, "USUARIO", 1, 0, 'C', 0);
$pdf->Cell(40, 6, "CLAVE", 1, 1, 'C', 0);
//definiar distancias de cada celda
$pdf->SetWidths(array(40, 40, 40, 40));
$pdf->SetLineHeight(5);
$pdf->SetFont('Times', '', 8);


for ($i = 0; $i < $totalSistemas; $i++) {
    $id = $idSistemas[$i];
    $sistema = $_GET['sistema' . $id];
    $url = $_GET['url' . $id];
    $usuario = $_GET['usuario' . $id];
    $clave = $_GET['clave' . $id];
    $pdf->Row(25, 0, array(
        mb_convert_encoding($sistema, 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($url, 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($usuario, 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($clave, 'ISO-8859-1', 'UTF-8'),
    ), 'C');
}

$pdf->Ln();
$pdf->parrafo("a $nombrePersona con numero de cedula $cedula, cuyo cargo es $nombreCargo para uso laboral del año $periodo, El funcionario receptor de las credenciales está obligado al complimiento de:");
$pdf->Ln();
$pdf->parrafo("1. Las credenciales entregadas al funcionario para el manejo de los sistemas antes mencionados son para uso institucional e intransferible, y su utilización es de exclusiva responsabilidad del funcionario.\n2. El funcionario $nombrePersona, se compromete a la no divulgación y buen uso de la información facilitada por la institución con total confidencialidad, de incumplir con este compromiso será responsable de las consecuencias establecida en el artículo 190.- 'Apropiación fraudulenta por medios electrónicos' del COIP.\n3. En caso de pérdida, olvido o sustracción del usuario y/o clave de acceso para el manejo de los sistemas, el funcionario deberá comunicar al área de tecnología de la Cooperativa De Transporte Touris San Francisco Oriental, de manera inmediata. \n4. Las credenciales de acceso serán entregadas de manera persona al funcionario responsable de la misma.");
$pdf->Ln();
$pdf->parrafo("Para la constancia de la actuado y en fe de conformidad y aceptación, se suscribe la presente acta en dos originales de igual valor y efecto para las personas que intervienen en esta diligencia, en la ciudad de $ciudad, a los $dia días del mes de $mes del $año.");
$pdf->SetTextColor(0, 0, 0);
//Firmas de las actas
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 10, mb_convert_encoding('ENTREGAN CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->ln(10);
$pdf->MultiCell(0, 5, mb_convert_encoding("$nombreEntrega \n$cargoEntrega", 'ISO-8859-1', 'UTF-8'), 0, 'C');

$pdf->ln(5);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 10, mb_convert_encoding('RECIBÍ CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->SetFont('Times', '', 10);
$pdf->ln(10);
$pdf->MultiCell(0, 5, mb_convert_encoding("$nombrePersona \n$nombreCargo", 'ISO-8859-1', 'UTF-8'), 0, 'C');

$nombreReporteTemp = "actaDigital";
$nombreReporte = nombreReporte($nombreReporteTemp, "pdf");
$pdf->Output('', $nombreReporte, true);
