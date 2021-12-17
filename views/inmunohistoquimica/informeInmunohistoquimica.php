
<?
//$path1 = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
$path2 = Yii::getAlias("@vendor/setasign/fpdf/rotation.php");

//require_once($path1);
require_once($path2);


// $pathqr = Yii::getAlias("@vendor/qrcode/qrcode.class.php");
// require_once($pathqr);
$estado = $model->biopsia->estado->descripcion;
global $estado;

class PDF extends PDF_Rotate
{
  public $estado;
  function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
public function setEstado($e){
  $this->estado = $e;
}
// Cabecera de página
function Header()
{
    ///////////////////MARCA DE AGUA//////////////////////
      // if ($this->estado =='PENDIENTE'){
      //   $this->SetFont('Arial','B',50);
      //   $this->SetTextColor(255,192,203);
      //   $this->RotatedText(35,215,'INFORME PENDIENTE',35);
      // }
    /////////////////////////////////////////////////////
  $this->SetTextColor(245,245,245);
  $this->Image(  Yii::$app->basePath .'/web/img/hospitalzatti.png',18,18,15);
  $this->SetFont('Arial','',6);
  $this->SetTextColor(0,0,0);
  $this->Cell(0,5,'Documento Generado el '.date("d/m/Y - H:i"),0,0,'R');
  $this->Ln(10);
  $this->SetFont('Times','B',13);
  $this->Cell(0,5,'HOSPITAL ARTEMIDES ZATTI',0,0,'C');
  $this->Ln(6);
  $this->SetFont('Times','B',10);
  $this->Cell(0,5,'UNIDAD DE ANATOMIA PATOLOGICA',0,0,'C');
  $this->Ln(6);
  $this->SetFont('Times','BI');
  $this->Cell(0,5,'ESTUDIO INMUNOHISTOQUIMICO - DIAGNOSTICO MOLECULAR',0,0,'C');

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
        $this->SetFont('Arial','',7);
        $this->Cell(0,10,utf8_decode('Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro'),0,0,'C');
        $this->Ln(3);
        $this->Cell(0,10,'Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780',0,0,'C');

}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->setEstado($model->biopsia->estado->descripcion);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',12);

$pdf->SetFont('Courier','B',8);
//$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(0,36,'',1,1,'L',1);

$Inicio = 49;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio,"PACIENTE:");
$pdf->SetFont('Times','',10);
$pdf->Text(35,$Inicio,$model->biopsia->solicitudbiopsia->paciente->nombre.' '.$model->biopsia->solicitudbiopsia->paciente->apellido);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"FECHA:");
$pdf->SetFont('Times','',10);
$pdf->Text(135,$Inicio,date("d/m/Y", strtotime($model->biopsia->solicitudbiopsia->fechadeingreso)));

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROTOCOLO:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,$model->biopsia->solicitudbiopsia->protocolo);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"H. CLINICA:");
$pdf->SetFont('Times','',10);
$pdf->Text(143,$Inicio,$model->biopsia->solicitudbiopsia->paciente->hc);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"MEDICO:");
$pdf->SetFont('Times','',10);
$pdf->Text(30,$Inicio ,$model->biopsia->solicitudbiopsia->medico->nombre.' '.$model->biopsia->solicitudbiopsia->medico->apellido);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"EDAD:");
$pdf->SetFont('Times','',10);
 $pdf->Text(133,$Inicio,$edad);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROCEDENCIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(43,$Inicio ,$model->biopsia->solicitudbiopsia->procedencia->nombre);

$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio ,"SERVICIO:");
$pdf->SetFont('Times','',10);
$pdf->Text(140,$Inicio ,$model->biopsia->solicitudbiopsia->procedencia->nombre);

//////////////////////////////


$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
//En topografia va con el item de material - revisar!!!
$pdf->Text(14,$Inicio ,"MICROSCOPIA:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->microscopia));


$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"DIAGNOSTICO:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->diagnostico));

$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,utf8_decode("OBSERVACIÓN:"));
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->observacion));


$pdf->Ln();

$Inicio = 49;


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
