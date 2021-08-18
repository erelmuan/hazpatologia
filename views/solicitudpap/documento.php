
<?
$path = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
require_once($path);

// $pathqr = Yii::getAlias("@vendor/qrcode/qrcode.class.php");
// require_once($pathqr);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{ 
  $this->SetTextColor(245,245,245);
  //$this->RotatedText(65,180,'H. A. Z.',45);
 // $this->Image('http://localhost/patologiahaz/web/img/hospitalzatti.png',18,18,15);
  $this->SetFont('Arial','',6);
  $this->SetTextColor(0,0,0);
    $this->Line(10, 25, 210-10, 25);

  $this->Cell(0,5,'Documento Generado el '.date("d/m/Y - H:i"),0,0,'R');
  $this->Ln(10);
  $this->SetFont('Arial','B',13);
  $this->Cell(0,5,'Hospital "Artemides Zatti"',0,0,'L');
  $this->Ln(6);
  $this->SetFont('Times','B',9);
  $this->Cell(0,5,'Rivadavia 391',0,0,'L');
  $this->Cell(0,5,'Correo:   hazpatologia@gmail.com',0,0,'R');
  $this->Ln(6);
  $this->SetFont('Times','B',9);
  $this->Cell(0,5,'8500 Viedma(RN)',0,0,'L');
  $this->Cell(0,5,'Tel 02920-423393       interno 132',0,0,'R');
  $this->Ln(6);
  $this->SetFont('Arial','BU',13);
  $this->Cell(0,5,'SOLICITUD DE PAPANICOLAOU',0,0,'C');

//  $this->Cell(0,10,'Orden de Compra -- N� ' . substr($_GET['Ord'],0,strlen($_GET['Ord'])-2) . " / " . substr($_GET['Ord'],strlen($_GET['Ord'])-2,2),0,0,'C');
  $this->Ln(11);
}

// Pie de página
function Footer()
{
  // Posición: a 1,5 cm del final
        //  $this->SetY(-15);
          // Arial italic 8
        //  $this->SetFont('Arial','I',8);
          /* Cell(ancho, alto, txt, border, ln, alineacion)
           * ancho=0, extiende el ancho de celda hasta el margen de la derecha
           * alto=10, altura de la celda a 10
           * txt= Texto a ser impreso dentro de la celda
           * border=T Pone margen en la posición Top (arriba) de la celda
           * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
           * alineación=C Texto alineado al centro
           */
        //  $this->Cell(0,10,utf8_decode ('Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro'),'T',0,'C');


        //Posici�n: a 3,5 cm del final
        $this->SetY(-20);
        //Arial italic 7
        $this->SetFont('Arial','',7);
        //N�mero de p�gina
        $this->Ln(2);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
        $this->Ln(4);
        // $this->SetFont('Arial','',7);
        // $this->Cell(0,10,utf8_decode('Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro'),0,0,'C');
        // $this->SetFont('Times','B',10);
        // $this->Ln(3);
        // $this->Cell(0,10,'Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780',0,0,'C');
      //  $this->Ln(5);
      //  $this->SetTextColor(150,150,150);
      //  $this->SetFont('Times','I','7');
    //    $this->Cell(0,10,'Desarrollado por: ',0,0,'C');







}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->SetFont('Courier','B',8);
//$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
//$pdf->Cell(0,36,'',1,1,'L',1);

$Inicio = 53;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio,"Fecha:");
$pdf->SetFont('Times','',10);
$pdf->Text(28,$Inicio,date("d/m/Y", strtotime($model->fecharealizacion)));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"Inclusion:");
$pdf->SetFont('Times','',10);
$pdf->Text(136,$Inicio,$model->protocolo);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"Perteneciente a:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,$model->paciente->nombre.' '.$model->paciente->apellido);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"Edad:");
$pdf->SetFont('Times','',10);
$pdf->Text(132,$Inicio,$edad);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"DNI:");
$pdf->SetFont('Times','',10);
$pdf->Text(32,$Inicio ,$model->paciente->num_documento);
$pdf->SetFont('Times','B',10);
$pdf->Text(65,$Inicio,"Obra social:");
$pdf->SetFont('Times','',10);
$pdf->Text(85,$Inicio,

call_user_func(function($model)
                {
                    $items = "";
                    foreach ($model->paciente->carnetOs as $carnet) {
                        $items .= $carnet->obrasocial->sigla." / ";

                    }
                    return $items;
                }, $model)



);
$pdf->SetFont('Times','B',10);
$pdf->Text(157,$Inicio,"HC N:");
$pdf->SetFont('Times','',10);
$pdf->Text(170,$Inicio,$model->paciente->hc);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"Fecha de nacimiento:");
$pdf->SetFont('Times','',10);
$pdf->Text(47,$Inicio ,date("d/m/Y", strtotime($model->paciente->fecha_nacimiento)));
$pdf->SetFont('Times','B',10);
$pdf->Text(100,$Inicio,"Domicilio:");
$pdf->SetFont('Times','',10);
$pdf->Text(120,$Inicio,$model->paciente->direccion);


$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"Servicio:");
$pdf->SetFont('Times','',10);
$pdf->Text(32,$Inicio ,$model->procedencia->nombre);
$pdf->SetFont('Times','B',10);
$pdf->Text(85,$Inicio,"Internacion:");
$pdf->SetFont('Times','',10);
$pdf->Text(107,$Inicio,$edad);
$pdf->SetFont('Times','B',10);
$pdf->Text(157,$Inicio,"C. Ext:");
$pdf->SetFont('Times','',10);
$pdf->Text(170,$Inicio,$edad);

$Inicio=$Inicio +18;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"Material:");
$pdf->SetFont('Times','',10);
$pdf->Text(32,$Inicio ,$model->medico->nombre.' '.$model->medico->apellido);


$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"Tipo de muestra:");
$pdf->SetFont('Times','',10);
$pdf->Text(42,$Inicio ,($model->tipoMuestra)?$model->tipoMuestra->descripcion:"(No definido)");


$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"PAP PREVIO:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,($model->pap_previo)?"SI":"NO");
$pdf->SetFont('Times','BU',10);
$pdf->Text(85,$Inicio,"RESULTADO PAP PREVIO:");
$pdf->SetFont('Times','',10);
$pdf->Text(140,$Inicio,$model->resultado_pap_previo);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"BIOPSIA PREVIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(47,$Inicio ,($model->biopsia_previa)?"SI":"NO");
$pdf->SetFont('Times','BU',10);
$pdf->Text(85,$Inicio,"RESULTADO BIOPSIA PREVIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(140,$Inicio,$model->resultado_biopsia_previo);

$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"FUM:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,$model->fum);
$pdf->SetFont('Times','BU',10);
$pdf->Text(85,$Inicio,"Embarazo actual:");
$pdf->SetFont('Times','',10);
$pdf->Text(115,$Inicio,($model->embarazo_actual)?"SI":"NO");


$Inicio=$Inicio +8;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"Menospausia:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,($model->metodoAnticonceptivo)?"SI":"NO");
$pdf->SetFont('Times','BU',10);
$pdf->Text(85,$Inicio,"Fecha ultima parto:");
$pdf->SetFont('Times','',10);
$pdf->Text(118,$Inicio, date('d/m/Y',strtotime($model->fecha_ult_parto)));



$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"METODO ANTICONCEPTIVO:");
$pdf->SetFont('Times','',10);
$pdf->Text(67,$Inicio,($model->metodoAnticonceptivo)?$model->metodoAnticonceptivo->descripcion:"(No definido)");

$Inicio=$Inicio +8;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"CIRUGIAS PREVIAS:");
$pdf->SetFont('Times','',10);
$pdf->Text(53,$Inicio ,($model->cirugiaPrevia)?$model->cirugiaPrevia->descripcion:"(No definido)");


$Inicio=$Inicio +8;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"TRATAMIENTO RADIANTE:");
$pdf->SetFont('Times','',10);
$pdf->Text(66,$Inicio ,($model->tratamiento_radiante)?"SI":"NO");
$pdf->SetFont('Times','BU',10);
$pdf->Text(120,$Inicio,"QUIMIOTERAPIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(155,$Inicio,($model->quimioterapia)?"SI":"NO");



$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"DATOS CLINICOS DE INTERES:");
$pdf->SetFont('Times','',10);
$pdf->Text(75,$Inicio ,$model->datos_clinicos_de_interes);



$Inicio=$Inicio +13;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"COLPOSCOPIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(43,$Inicio ,($model->colposcopia)?"SI":"NO");

$Inicio=$Inicio +30;
$pdf->SetFont('Times','BU',10);
$pdf->Text(14,$Inicio ,"CONCLUSION:");
$pdf->SetFont('Times','',10);
$pdf->Text(50,$Inicio ,$model->conclusion);



$Inicio=$Inicio +15;
$pdf->Text(147,$Inicio ,"..........................................................");

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(150,$Inicio ,"Firma del medico y aclaracion");


// $Inicio=$Inicio +40;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"PROCEDENCIA:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(42,$Inicio ,$model->procedencia->nombre);

// //////////////////////////////



// $Inicio = $pdf->GetY() + 40;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"DESCRIPCION:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->descripcion));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"CALIFICACION:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->calificacion));


// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"INDICE CEPICNOTICO:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->indicepicnotico));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"INDICE DE MADURACION:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->indicedemaduracion));


// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"PLEGAMIENTO:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->plegamiento));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"AGRUPAMIENTO:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->agrupamiento));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"LEUCOCITOS:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->leucocitos));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"HEMATIES:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->hematies))0;

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"HISTIOCITOS:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->histiocitos));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"DETRITUS:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->detritus));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"CITOLISIS:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->citolisis));


// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// //En topografia va con el item de material - revisar!!!
// $pdf->Text(14,$Inicio ,"FLORA:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio +5);
// //$pdf->MultiCell(0,5, utf8_decode($model->flora));

// $Inicio = $pdf->GetY() + 10 ;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"ASPECTO:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio);
// //$pdf->MultiCell(0,5, utf8_decode($model->aspecto));

// $Inicio = $pdf->GetY() + 10 ;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"PAVIMENTOSA:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio);
// //$pdf->MultiCell(0,5, utf8_decode($model->pavimentosas));

// $Inicio = $pdf->GetY() + 10 ;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"GLANDULARES:");
// $pdf->SetFont('Times','',10);
// $pdf->SetXY(30, $Inicio);
// //$pdf->MultiCell(0,5, utf8_decode($model->glandulares));

// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"DIAGNOSTICO:");
// $pdf->SetFont('Times','',10);
//    // Imprimimos el texto justificado
// $pdf->SetXY(30, $Inicio );
// //$pdf->MultiCell(0,5, utf8_decode($model->diagnostico));
// $pdf->Ln();

// $Inicio = 49;


// $qrcode = new QRcode('PACIENTE: '.$model->paciente->nombre." ".
// 'DIAGNOSTICO:'.$model->Diagnostico, 'L'); // error level : L, M, Q, H
$x = 100;
$y = 200;
$s = 50;
$background = array(250,250,250);
$color = array(0,0,0);
// $qrcode->displayFPDF($pdf, $x, $y, $s, $background, $color);

$pdf->Output();


exit;
?>
