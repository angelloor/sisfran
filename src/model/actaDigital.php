<?php
    require('../lib/fpdf/wrapper.php');
    require('../lib/connectios/MySQLPDO.php');

    $totalSistemas = $_GET['totalSistemas'];    
    $idSistemas = explode(',', $_GET['idSistemas']);
    $periodo = $_GET['periodo'];
    $nombreFuncionario = $_GET['funcionario'];

    $connection = new MySQLPDO();
    //TRAER DATOS DEL FUNCIONARIO QUE ENTREGA
    $stmt = $connection->prepare("select f.denominacion ,p.nombre_persona, c.nombre_cargo from firma f inner join persona p on f.persona_id = p.id_persona inner join cargo c on p.cargo_id = c.id_cargo where f.id_firma = 1;");
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $nombreEntregaCompleto = $results['nombre_persona'];
    $cargoEntrega = $results['nombre_cargo'];
    $denominacion = $results['denominacion'];

    function nombreMasDenominacion($nombreEntregaCompleto,$denominacion){
        $separarNombres = explode(" ", $nombreEntregaCompleto);
        return $denominacion.". ".$separarNombres[0]." ".$separarNombres[1];
    }

    $nombreEntrega = nombreMasDenominacion($nombreEntregaCompleto,$denominacion);


    $stmt = $connection->prepare("select p.cedula, c.nombre_cargo from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.nombre_persona = :nombrePersona;");
    $stmt->bindValue(":nombrePersona", $nombreFuncionario, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $cedula = $results['cedula'];
    $nombreCargo = $results['nombre_cargo'];
    
    $sistemas = "";
    $credenciales = "";

    $ciudad="Puyo";
    $dia=date("d");
    $mes_inicial=date("F");
    $año=date("Y");
    function mes_format($mes_inicial){
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

    $totalSistemas = $_GET['totalSistemas'];

    class PDF extends Wrapper
    {
        function Header()
        {
            $this->Image('../assets/img/logo_sf_white.png',25,10,40);
            $this->SetFont('Times','B',15);
            $this->Ln(10);
            $this->Cell(45);
            $this->SetTextColor(31,78,121);
            $this->MultiCell(115,5,utf8_decode('SISFRAN - COOPERATIVA DE TRANSPORTE TOURIS SAN FRANCISCO ORIENTAL'));
            $this->Ln(5);
        }
        
        function Footer()
        {
            $this->SetY(-25);
            $this->SetX(30);
            $this->SetTextColor(183,191,214);
            $this->SetFont('Times','I',24);
            $this->Cell(0,10,utf8_decode('Orgullosamente Amazónicos'),0,1,'L');
            $this->SetY(-30);
            $this->SetX(0);
            $this->SetTextColor(42,81,147);
            $this->SetFont('Times','',8);
            $this->SetRightMargin(33);
            $this->MultiCell(0,3,utf8_decode("Puyo / Ecuador \n tourisanfrancisco.com \n Av. Francisco de Orellana \n Angel Manzano \n Tlf: (593) 2 885 481"),0,'R');
            $this->Image('../assets/img/ec.png',180,265,2);
            $this->SetFont('Times','',10);
            $this->SetTextColor(0,0,0);
            $this->Cell(165,10,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'C');
            $this->Cell(-123,10,'FO-01(DG-SM-AD-09)',0,0,'R');

        }
        
        function parrafo($texto)
        {
            $txt = $texto;
            $this->SetFont('Times','',10);  
            $this->MultiCell(0,5,utf8_decode($txt)  );
            $this->SetFont('','I');
        }
    }
    
    $pdf = new PDF();
    $pdf->SetRightMargin(25);
    $pdf->SetLeftMargin(25);  
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true,35);
    $pdf->AddPage();
    $pdf->SetTextColor(31,78,121);
    $pdf->SetFont('Times','B',12);
    $pdf->Ln();
    $pdf->Cell(0,10,utf8_decode('ACTA ENTREGA RECEPCION DE CREDENCIALES DIGITALES'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->parrafo("La presente acta de entrega recepción tiene por objeto otorgar credenciales para el manejo de los siguientes sistemas: ");
    $pdf->Ln();

    // Cabecera de la tabla
    $pdf->SetFont('Times','B',10);
    $pdf->SetX(25);
    $pdf->Cell(40,6, "SISTEMA", 1,0,'C',0);
    $pdf->Cell(40,6, "URL", 1,0,'C',0);
    $pdf->Cell(40,6, "USUARIO", 1,0,'C',0);
    $pdf->Cell(40,6, "CLAVE", 1,1,'C',0);
    //definiar distancias de cada celda
    $pdf->SetWidths(Array(40,40,40,40));
    $pdf->SetLineHeight(5);
    $pdf->SetFont('Times','',8);


    for ($i = 0; $i < $totalSistemas ; $i++) {
        $id = $idSistemas[$i];
        $sistema = $_GET['sistema'.$id];
        $url = $_GET['url'.$id];
        $usuario = $_GET['usuario'.$id];
        $clave = $_GET['clave'.$id];
        $pdf->Row(25, 0,Array(
            utf8_decode($sistema),
            utf8_decode($url),
            utf8_decode($usuario),
            utf8_decode($clave),
        ), 'C');
    }

    $pdf->Ln();
    $pdf->parrafo("a $nombreFuncionario con numero de cedula $cedula, cuyo cargo es $nombreCargo para uso laboral del año $periodo, El funcionario receptor de las credenciales está obligado al complimiento de:");
    $pdf->Ln();
    $pdf->parrafo("1. Las credenciales entregadas al funcionario para el manejo de los sistemas antes mencionados son para uso institucional e intransferible, y su utilización es de exclusiva responsabilidad del funcionario.\n2. El funcionario $nombreFuncionario, se compromete a la no divulgación y buen uso de la información facilitada por la institución con total confidencialidad, de incumplir con este compromiso será responsable de las consecuencias establecida en el artículo 190.- 'Apropiación fraudulenta por medios electrónicos' del COIP.\n3. En caso de pérdida, olvido o sustracción del usuario y/o clave de acceso para el manejo de los sistemas, el funcionario deberá comunicar al área de tecnología de la Cooperativa De Transporte Touris San Francisco Oriental, de manera inmediata. \n4. Las credenciales de acceso serán entregadas de manera persona al funcionario responsable de la misma.");
    $pdf->Ln();
    $pdf->parrafo("Para la constancia de la actuado y en fe de conformidad y aceptación, se suscribe la presente acta en dos originales de igual valor y efecto para las personas que intervienen en esta diligencia, en la ciudad de $ciudad, a los $dia días del mes de $mes del $año.");
    $pdf->SetTextColor(0,0,0);
    //Firmas de las actas
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(0,10,utf8_decode('ENTREGAN CONFORME'),0,1,'C');
    $pdf->SetFont('Times','',10);
    $pdf->ln(10);
    $pdf->MultiCell(0,5,utf8_decode("$nombreEntrega \n$cargoEntrega"),0,'C');

    $pdf->ln(5);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(0,10,utf8_decode('RECIBÍ CONFORME'),0,1,'C');
    $pdf->SetFont('Times','',10);
    $pdf->ln(10);
    $pdf->MultiCell(0,5,utf8_decode("$nombreFuncionario \n$nombreCargo"),0,'C');

    $nombrePdf = "actaDigital".$nombreFuncionario;
    $pdf->Output('',nombrePdf($nombrePdf),true);

    function nombrePdf($nombre){
        $fechaTotal = getdate();
        if($fechaTotal['wday'] <= 9){
            $dia = "0".$fechaTotal['wday'];
        }
        if($fechaTotal['mon'] <= 9){
            $mes = "0".$fechaTotal['mon'];
        }
        $fechaFinal = $fechaTotal['year']."-".$mes."-".$dia;
        $nombreFinal = $nombre.$fechaFinal.".pdf";
        return $nombreFinal;
    }
?>