
<?
//$path1 = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
$path2 = Yii::getAlias("@vendor/setasign/fpdf/rotation.php");

//require_once($path1);
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
      //  $this->Ln(5);
      //  $this->SetTextColor(150,150,150);
      //  $this->SetFont('Times','I','7');
    //    $this->Cell(0,10,'Desarrollado por: ',0,0,'C');

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
$pdf->Text(35,$Inicio,utf8_decode($model->solicitudbiopsia->paciente->apellido).' '.utf8_decode($model->solicitudbiopsia->paciente->nombre));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"FECHA:");
$pdf->SetFont('Times','',10);
$pdf->Text(135,$Inicio,date("d/m/Y", strtotime($model->solicitudbiopsia->fechadeingreso)));

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROTOCOLO:");
$pdf->SetFont('Times','',10);
$pdf->Text(40,$Inicio ,$model->solicitudbiopsia->protocolo);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"H. CLINICA:");
$pdf->SetFont('Times','',10);
$pdf->Text(143,$Inicio,$model->solicitudbiopsia->paciente->hc);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"MEDICO:");
$pdf->SetFont('Times','',10);
$pdf->Text(31,$Inicio ,utf8_decode($model->solicitudbiopsia->medico->apellido).' '.utf8_decode($model->solicitudbiopsia->medico->nombre));
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"DNI:");
$pdf->SetFont('Times','',10);
 $pdf->Text(129,$Inicio,$model->solicitudbiopsia->paciente->num_documento);

$Inicio=$Inicio +8;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"PROCEDENCIA:");
$pdf->SetFont('Times','',10);
$pdf->Text(43,$Inicio ,$model->solicitudbiopsia->procedencia->nombre);
$pdf->SetFont('Times','B',10);
$pdf->Text(120,$Inicio,"EDAD:");
$pdf->SetFont('Times','',10);
 $pdf->Text(133,$Inicio,$edad);
//////////////////////////////


$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"MATERIAL:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->material));


$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"EXAMEN MACROSCOPICO:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->macroscopia));

$Inicio = $pdf->GetY() + 10 ;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"EXAMEN MICROSCOPICO:");
$pdf->SetFont('Times','',10);
$pdf->SetXY(30, $Inicio +1);
$pdf->MultiCell(0,5, utf8_decode($model->microscopia));


$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
$pdf->Text(14,$Inicio ,"DIAGNOSTICO:");
$pdf->SetFont('Times','',10);
   // Imprimimos el texto justificado
$pdf->SetXY(30, $Inicio +1 );
$pdf->MultiCell(0,5, utf8_decode($model->diagnostico));

// 				$pdf->Image($Fir->firma,151,$Inicio - 18,49 ); 250
$Inicio = $pdf->GetY() + 2;

if($model->firmado){
  $pdf->Image( Yii::$app->basePath .'/web/uploads/avatar/'.$model->usuario->firma->imagen,151,$Inicio ,49 ,45 ,'PNG' );

}

$Inicio = $pdf->GetY() + 10;
$pdf->SetFont('Times','B',10);
$pdf->SetFont('Times','',10);
   // Imprimimos el texto justificado
$pdf->SetXY(30, $Inicio +1 );


$pdf->MultiCell(0,5, utf8_decode($model->frase));


$pdf->Ln();

$Inicio = 49;



$x = 100;
$y = 200;
$s = 50;
$background = array(250,250,250);
$color = array(0,0,0);
// $qrcode->displayFPDF($pdf, $x, $y, $s, $background, $color);

$pdf->Output("I","BIOPSIA --- ".utf8_decode($model->solicitudbiopsia->paciente->apellido." ". $model->solicitudbiopsia->paciente->nombre));


exit;
?>
