<?php
require('../../lib/fpdf/wrapper.php');
require('../../lib/connectios/MySQLPDO.php');
require('../../lib/common/utils.php');

$activo = $_GET['activo'];
$saltoLinea = $_GET['saltoLinea'];

if (!$saltoLinea) {
    $saltoLinea = 5;
}

//CONSULTAR EL ID DE CATEGORIA DEL ACTIVO
$stmt = $connection->prepare("select a.categoria_id, c.nombre_categoria from activo a inner join categoria c on a.categoria_id = c.id_categoria where a.codigo = :codigoActivo;");
$stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$categoria_id = $results['categoria_id'];

//TRAER DATOS DEL FUNCIONARIO QUE ENTREGA
$stmt = $connection->prepare("select f.denominacion ,p.nombre_persona, c.nombre_cargo, u.nombre_unidad from firma f inner join persona p on f.persona_id = p.id_persona inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad  where f.id_firma = :categoria_id;");
$stmt->bindValue(":categoria_id", $categoria_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreEntregaCompleto = $results['nombre_persona'];
$cargoEntregaUno = $results['nombre_cargo'];
$denominacion = $results['denominacion'];
$nombreUnidadUno = $results['nombre_unidad'];

function nombreMasDenominacion($nombreEntregaCompleto, $denominacion)
{
    $separarNombres = explode(" ", $nombreEntregaCompleto);
    return $denominacion . ". " . $separarNombres[0] . " " . $separarNombres[1];
}

$nombreEntregaUno = nombreMasDenominacion($nombreEntregaCompleto, $denominacion);

$stmt = $connection->prepare("select f.denominacion ,p.nombre_persona, c.nombre_cargo, u.nombre_unidad from firma f inner join persona p on f.persona_id = p.id_persona inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad  where f.id_firma = 2;");
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreEntregaCompletoDos = $results['nombre_persona'];
$cargoEntregaDos = $results['nombre_cargo'];
$denominacionDos = $results['denominacion'];
$nombreUnidadDos = $results['nombre_unidad'];

$nombreEntregaDos = nombreMasDenominacion($nombreEntregaCompletoDos, $denominacionDos);

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
        $fechaHora = fechaHora();
        $this->Cell(-130, 10, $fechaHora, 0, 0, 'R');
    }

    function parrafo($texto)
    {
        $txt = $texto;
        $this->SetFont('Times', '', 10);
        $this->MultiCell(0, 5, mb_convert_encoding($txt, 'ISO-8859-1', 'UTF-8'));
        $this->SetFont('', 'I');
    }
}

$stmt = $connection->prepare("select c.nombre_categoria from activo a inner join categoria c on a.categoria_id = c.id_categoria where a.codigo = :codigoActivo;");
$stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$categoria = $results['nombre_categoria'];

$stmt = $connection->prepare("select nombre_categoria from categoria where id_categoria= 1;");
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreCategoriaInformatica = $results['nombre_categoria'];

$stmt = $connection->prepare("select nombre_categoria from categoria where id_categoria= 2;");
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);
$nombreCategoriaInmubeles = $results['nombre_categoria'];


if ($categoria == $nombreCategoriaInmubeles) {
    $pdf = new PDF();
    $pdf->SetRightMargin(25);
    $pdf->SetLeftMargin(25);
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 35);

    //Sacar el Id de la persona segun el codigo del activo
    $stmt = $connection->prepare("select er.persona_id from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.codigo = :codigoActivo;");
    $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $idPersona = $results['persona_id'];

    //datos del funcionario
    $stmt = $connection->prepare("select p.nombre_persona, p.cedula, c.nombre_cargo from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.id_persona = :idPersona;");
    $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreFuncionario = $results['nombre_persona'];
    $cedula = $results['cedula'];
    $cargoFuncionario = $results['nombre_cargo'];

    $pdf->AddPage();
    $pdf->SetTextColor(31, 78, 121);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Ln();
    $pdf->Cell(0, 10, mb_convert_encoding('ACTA ENTREGA RECEPCIÓN', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->parrafo("En la ciudad de Puyo, a los $dia días del mes de $mes del $año, se procede a realizar el acta de entrega entre $nombreEntregaDos, $cargoEntregaDos, $nombreUnidadDos y $nombreFuncionario con C.I. $cedula, $cargoFuncionario,  del siguiente bien inmueble:");

    $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.caracteristica, a.serie from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca where a.codigo = :codigoActivo;");
    $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
    $stmt->execute();
    $datosActivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Cabecera de la tabla
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetX(25);
    $pdf->ln(5);

    $pdf->Cell(30, 6, mb_convert_encoding("CODIGO", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
    $pdf->Cell(90, 6, mb_convert_encoding("DESCRIPCIÓN DEL BIEN", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
    $pdf->Cell(40, 6, "SERIE", 1, 1, 'C', 0);
    //definiar distancias de cada celda
    $pdf->SetWidths(array(30, 90, 40));
    $pdf->SetLineHeight(5);
    $pdf->SetFont('Times', '', 8);

    foreach ($datosActivos as $row) {
        $pdf->Row(25, 0, array(
            mb_convert_encoding($row['codigo'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['nombre_activo'] . " " . $row['nombre_marca'] . " " . $row['modelo'] . " " . $row['caracteristica'], 'ISO-8859-1', 'UTF-8'),
            mb_convert_encoding($row['serie'], 'ISO-8859-1', 'UTF-8'),
        ), 'C');
    }

    $pdf->ln(5);
    $pdf->parrafo("Bien inmueble que se encuentra en perfectas condiciones de funcionamiento en caso de pérdida, daño o deterioro de los mismos quedarán a su entera responsabilidad. \n\nPara lo actuado las partes firman en duplicado de igual valor y contenido.");

    $pdf->SetFont('Times', 'B', 10);
    $pdf->ln($saltoLinea);
    $pdf->Cell(0, 10, mb_convert_encoding('ENTREGAN CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->ln(10);
    $pdf->Cell(160, 6, mb_convert_encoding("$nombreEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
    $pdf->Cell(160, 6, mb_convert_encoding("$cargoEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
    $pdf->ln(5);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(0, 10, mb_convert_encoding('RECIBÍ CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    $pdf->SetFont('Times', '', 10);
    $pdf->ln(10);
    $pdf->MultiCell(0, 5, mb_convert_encoding("$nombreFuncionario \n $cargoFuncionario", 'ISO-8859-1', 'UTF-8'), 0, 'C');
} else {
    if ($categoria == $nombreCategoriaInformatica) {
        $pdf = new PDF();
        $pdf->SetRightMargin(25);
        $pdf->SetLeftMargin(25);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 35);

        //Sacar el Id de la persona segun el codigo del activo
        $stmt = $connection->prepare("select er.persona_id from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.codigo = :codigoActivo;");
        $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idPersona = $results['persona_id'];

        //datos del funcionario
        $stmt = $connection->prepare("select p.nombre_persona, p.cedula, c.nombre_cargo from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.id_persona = :idPersona;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreFuncionario = $results['nombre_persona'];
        $cedula = $results['cedula'];
        $cargoFuncionario = $results['nombre_cargo'];

        $pdf->AddPage();
        $pdf->SetTextColor(31, 78, 121);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(0, 10, mb_convert_encoding('ACTA ENTREGA RECEPCIÓN', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->parrafo("En la ciudad de Puyo, a los $dia días del mes de $mes del $año, se procede a realizar el acta de entrega entre $nombreEntregaUno, $cargoEntregaUno, $nombreUnidadUno y $nombreFuncionario con C.I. $cedula, $cargoFuncionario,  del siguiente equipo  informático:");

        $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.caracteristica, a.serie from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca where a.codigo = :codigoActivo;");
        $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
        $stmt->execute();
        $datosActivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Cabecera de la tabla
        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetX(25);
        $pdf->ln(5);

        $pdf->Cell(30, 6, mb_convert_encoding("CODIGO", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(90, 6, mb_convert_encoding("DESCRIPCIÓN DEL BIEN", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(40, 6, "SERIE", 1, 1, 'C', 0);
        //definiar distancias de cada celda
        $pdf->SetWidths(array(30, 90, 40));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Times', '', 8);

        foreach ($datosActivos as $row) {
            $pdf->Row(25, 0, array(
                mb_convert_encoding($row['codigo'], 'ISO-8859-1', 'UTF-8'),
                mb_convert_encoding($row['nombre_activo'] . " " . $row['nombre_marca'] . " " . $row['modelo'] . " " . $row['caracteristica'], 'ISO-8859-1', 'UTF-8'),
                mb_convert_encoding($row['serie'], 'ISO-8859-1', 'UTF-8'),
            ), 'C');
        }

        $pdf->ln(5);
        $pdf->parrafo("Equipo informático que se encuentra en perfectas condiciones de funcionamiento en caso de pérdida, daño o deterioro de los mismos quedaran a su entera responsabilidad. \n\nPara lo actuado las partes firman en duplicado de igual valor y contenido.");

        $pdf->SetFont('Times', 'B', 10);
        $pdf->ln($saltoLinea);
        $pdf->Cell(0, 10, mb_convert_encoding('ENTREGAN CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->ln(10);
        $pdf->Cell(80, 6, mb_convert_encoding("$nombreEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', 0);
        $pdf->Cell(80, 6, mb_convert_encoding("$nombreEntregaDos", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
        $pdf->Cell(80, 6, mb_convert_encoding("$cargoEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', 0);
        $pdf->Cell(80, 6, mb_convert_encoding("$cargoEntregaDos", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
        $pdf->ln(5);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 10, mb_convert_encoding('RECIBÍ CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->ln(10);
        $pdf->MultiCell(0, 5, mb_convert_encoding("$nombreFuncionario \n $cargoFuncionario", 'ISO-8859-1', 'UTF-8'), 0, 'C');
    } else {
        $pdf = new PDF();
        $pdf->SetRightMargin(25);
        $pdf->SetLeftMargin(25);
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true, 35);

        //Sacar el Id de la persona segun el codigo del activo
        $stmt = $connection->prepare("select er.persona_id from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.codigo = :codigoActivo;");
        $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idPersona = $results['persona_id'];

        //datos del funcionario
        $stmt = $connection->prepare("select p.nombre_persona, p.cedula, c.nombre_cargo from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.id_persona = :idPersona;");
        $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $nombreFuncionario = $results['nombre_persona'];
        $cedula = $results['cedula'];
        $cargoFuncionario = $results['nombre_cargo'];

        $pdf->AddPage();
        $pdf->SetTextColor(31, 78, 121);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Ln();
        $pdf->Cell(0, 10, mb_convert_encoding('ACTA ENTREGA RECEPCIÓN', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->parrafo("En la ciudad de Puyo, a los $dia días del mes de $mes del $año, se procede a realizar el acta de entrega entre $nombreEntregaUno, $cargoEntregaUno, $nombreUnidadUno y $nombreFuncionario con C.I. $cedula, $cargoFuncionario,  del siguiente activo:");

        $stmt = $connection->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.caracteristica, a.serie from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca where a.codigo = :codigoActivo;");
        $stmt->bindValue(":codigoActivo", $activo, PDO::PARAM_STR);
        $stmt->execute();
        $datosActivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Cabecera de la tabla
        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetX(25);
        $pdf->ln(5);

        $pdf->Cell(30, 6, mb_convert_encoding("CODIGO", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(90, 6, mb_convert_encoding("DESCRIPCIÓN DEL BIEN", 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', 0);
        $pdf->Cell(40, 6, "SERIE", 1, 1, 'C', 0);
        //definiar distancias de cada celda
        $pdf->SetWidths(array(30, 90, 40));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Times', '', 8);

        foreach ($datosActivos as $row) {
            $pdf->Row(25, 0, array(
                mb_convert_encoding($row['codigo'], 'ISO-8859-1', 'UTF-8'),
                mb_convert_encoding($row['nombre_activo'] . " " . $row['nombre_marca'] . " " . $row['modelo'] . " " . $row['caracteristica'], 'ISO-8859-1', 'UTF-8'),
                mb_convert_encoding($row['serie'], 'ISO-8859-1', 'UTF-8'),
            ), 'C');
        }

        $pdf->ln(5);
        $pdf->parrafo("Activo que se encuentra en perfectas condiciones de funcionamiento en caso de pérdida, daño o deterioro de los mismos quedarán a su entera responsabilidad. \n\nPara lo actuado las partes firman en duplicado de igual valor y contenido.");

        $pdf->SetFont('Times', 'B', 10);
        $pdf->ln($saltoLinea);
        $pdf->Cell(0, 10, mb_convert_encoding('ENTREGAN CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->ln(10);
        $pdf->Cell(160, 6, mb_convert_encoding("$nombreEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
        $pdf->Cell(160, 6, mb_convert_encoding("$cargoEntregaUno", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', 0);
        $pdf->ln(5);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 10, mb_convert_encoding('RECIBÍ CONFORME', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->ln(10);
        $pdf->MultiCell(0, 5, mb_convert_encoding("$nombreFuncionario \n $cargoFuncionario", 'ISO-8859-1', 'UTF-8'), 0, 'C');
    }
}

$nombreReporteTemp = $categoria . $nombreFuncionario;
$nombreReporte = nombreReporte($nombreReporteTemp, "pdf");
$pdf->Output('', $nombreReporte, true);