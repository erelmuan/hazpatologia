
<?
use yii\helpers\Url;
use yii\helpers\Html;
// $path = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
$path2 = Yii::getAlias("@vendor/setasign/fpdf/rotation.php");

require_once($path2);

// $pathqr = Yii::getAlias("@vendor/qrcode/qrcode.class.php");
// require_once($pathqr);
$estado = $model->estado->descripcion;
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
   if ($this->estado =='EN PROCESO'){
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,203);
    $this->RotatedText(35,215,'INFORME EN PROCESO',35);
  }
/////////////////////////////////////////////////////
  $this->SetTextColor(245,245,245);
  //$this->RotatedText(65,180,'H. A. Z.',45);

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
  $this->Cell(0,5,'Informe Anatomo Patologico',0,0,'C');

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
        $this->SetFont('Arial','',7);
        $this->Cell(0,10,utf8_decode('Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro'),0,0,'C');
        $this->Ln(3);
        $this->Cell(0,10,'Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780',0,0,'C');

}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->setEstado($model->estado->descripcion);
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
$pdf->Text(35,$Inicio,utf8_decode($model->solicitudpap->paciente->apellido).' '.utf8_decode($model->solicitudpap->paciente->nombre));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"FECHA:");
$pdf->SetFont('Times','',10);
$pdf->Text(135,$Inicio,date("d/m/Y", strtotime($model->solicitudpap->fechadeingreso)));

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROTOCOLO:");
$pdf->SetFont('Times','',10);
$pdf->Text(39,$Inicio ,$model->solicitudpap->protocolo);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"H. CLINICA:");
$pdf->SetFont('Times','',10);
$pdf->Text(142,$Inicio,$model->solicitudpap->paciente->hc);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"MEDICO:");
$pdf->SetFont('Times','',10);
$pdf->Text(31,$Inicio ,utf8_decode($model->solicitudpap->medico->apellido).' '.utf8_decode($model->solicitudpap->medico->nombre));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"DNI:");
$pdf->SetFont('Times','',10);
 $pdf->Text(129,$Inicio,$model->solicitudpap->paciente->num_documento);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROCEDENCIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(43,$Inicio ,utf8_decode($model->solicitudpap->procedencia->nombre));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"EDAD:");
$pdf->SetFont('Times','',10);
 $pdf->Text(133,$Inicio,$edad);
//////////////////////////////


// $Inicio = $pdf->GetY() + 10;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(80,$Inicio ,"EOSINOFILAS:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(107,$Inicio ,$model->eosinofilas." %" );

$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"INDICE CEPICNOTICO:");
$pdf->SetFont('Times','',10);
$pdf->Text(56,$Inicio,$model->indicepicnotico);

 // $Inicio = $pdf->GetY() + 10;
 // $pdf->SetFont('Times','B',10);
 // $pdf->Text(140,$Inicio ,"CIANOFILAS:");
 // $pdf->SetFont('Times','',10);
 // $pdf->Text(165,$Inicio,$model->cianofilas." %");

// $Inicio = $pdf->GetY() + 20;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"INDICE DE MADURACION:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(61,$Inicio,$model->indicepicnotico);

// $Inicio = $pdf->GetY() + 20;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(140,$Inicio ,"INTERMEDIAS:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(168,$Inicio,$model->intermedias." %");

// $Inicio = $pdf->GetY() + 20;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(80,$Inicio ,"PARABASALES:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(109,$Inicio,$model->parabasales." %");

// $Inicio = $pdf->GetY() + 30;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(14,$Inicio ,"PLEGAMIENTO:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(45,$Inicio,$model->plegamiento);

// $Inicio = $pdf->GetY() + 30;
// $pdf->SetFont('Times','B',10);
// $pdf->Text(60,$Inicio ,"AGRUPAMIENTO:");
// $pdf->SetFont('Times','',10);
// $pdf->Text(92,$Inicio,$model->agrupamiento);

// $Inicio = $pdf->GetY() + 30;
$pdf->SetFont('Times','B',10);
$pdf->Text(82,$Inicio ,"LEUCOCITOS:");
$pdf->SetFont('Times','',10);
$pdf->Text(110,$Inicio,$model->leucocitos);

// $Inicio = $pdf->GetY() + 30;
$pdf->SetFont('Times','B',10);
$pdf->Text(145,$Inicio ,"HEMATIES:");
$pdf->SetFont('Times','',10);
$pdf->Text(168,$Inicio,$model->hematies);

$Inicio = $pdf->GetY() + 20;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"HISTIOCITOS:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio,$model->histiocitos);

$Inicio = $pdf->GetY() + 20;
$pdf->SetFont('Times','B',10);
$pdf->Text(82,$Inicio ,"DETRITUS:");
$pdf->SetFont('Times','',10);
$pdf->Text(105,$Inicio,$model->detritus);

$Inicio = $pdf->GetY() + 20;
$pdf->SetFont('Times','B',10);
$pdf->Text(145,$Inicio ,"CITOLISIS:");
$pdf->SetFont('Times','',10);
$pdf->Text(166,$Inicio,$model->citolisis);

$Inicio = $pdf->GetY() + 40;
$pdf->SetFont('Times','B',10);
//En topografia va con el item de material - revisar!!!
$pdf->Text(14,$Inicio ,"FLORA:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +2);
$pdf->MultiCell(0,5, utf8_decode($model->flora));

$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"ASPECTO:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio+2);
$pdf->MultiCell(0,5, utf8_decode($model->aspecto));

$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PAVIMENTOSA:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio+2);
$pdf->MultiCell(0,5, utf8_decode($model->pavimentosas));

$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"GLANDULARES:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio+2);
$pdf->MultiCell(0,5, utf8_decode($model->glandulares));

$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"DIAGNOSTICO:");
$pdf->SetFont('Times','',10);
   // Imprimimos el texto justificado
$pdf->SetXY(30, $Inicio+2 );
$pdf->MultiCell(0,5, utf8_decode($model->diagnostico));

$Inicio = $pdf->GetY() + 2;

if($model->firmado){
  $pdf->Image( Yii::$app->basePath .'/web/uploads/firmas/'.$model->usuario->firma->imagen,151,$Inicio ,49 ,45 ,'PNG' );

}

// $pdf->Ln();
$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','',10);
   // Imprimimos el texto justificado
$pdf->SetXY(30, $Inicio+2 );
$pdf->MultiCell(0,5, utf8_decode($model->frase));
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

$pdf->Output("I","PAP --- ".utf8_decode($model->solicitudpap->paciente->apellido." ".$model->solicitudpap->paciente->nombre));

exit;
?>
