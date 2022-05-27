
<?
$path2 = Yii::getAlias("@vendor/setasign/fpdf/rotation.php");

require_once($path2);

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

}


}

// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', array(217.5 , 304.3));
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(8, 13 , 6);
$pdf->setEstado($model->estado->descripcion);
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,18,'ANEXO II',0,0,'L');
$pdf->Ln(11);
$pdf->Text(9,31,utf8_decode("COMPROBANTE DE ATENCIÓN"));
$pdf->Text(9,37,utf8_decode("DE BENEFICIARIOS DE OBRAS SOCIALES"));
$pdf->Cell(168,6,'','LTR',0,'L');
$pdf->SetFont('Arial','B',9);

$pdf->Cell(30,6,utf8_decode('Fecha'),1,1,'C');
$pdf->Cell(168,8,'','LBR',0,'L');
$pdf->SetFont('Times','B',10);
$pdf->Cell(10,8,'30',1,0,'C');
$pdf->Cell(10,8,'3',1,0,'C');
$pdf->Cell(10,8,'2022',1,1,'C');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(198,5,"",1,1,'C');
$pdf->Cell(163,6,"HOSPITAL",1,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,6,utf8_decode('Código de HPGD'),1,1,'C');
$pdf->Cell(163,6,utf8_decode("CENTRO DE SALUD Nº"),1,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,6,"",1,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(198,7,utf8_decode("DATOS DEL BENEFICIARIO"),1,1,'C');
$pdf->Cell(198,3.5,"",1,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(155,5.5,"Apellidos y Nombres",'LBR',0,'L');
$pdf->Cell(3,5.5,"",'LR',0,'L');
$pdf->Cell(7,5.5,"",1,0,'L');

$pdf->Cell(8,5.5,"",1,0,'L');
$pdf->SetFont('Arial','B',8);

$pdf->Cell(25,5.5,utf8_decode("Nº de Documento"),1,1,'L');
$pdf->Cell(155,5,utf8_decode("BELMAR, MIRTA HAYDEE-DISCAPAC-"),'LRB',0,'L');
$pdf->Cell(3,5,'4','L',0,'L');
$pdf->Cell(7,5,"5",1,0,'C');
$pdf->Cell(8,5,'',1,0,'C');
$pdf->Cell(25,5,"18721221",1,1,'C');

$pdf->Cell(155,5,"S",'LBTR',0,'R');
$pdf->Cell(3,5,"t",'LBR',0,'C');

$pdf->Cell(7,5,"",1,0,'C');
$pdf->Cell(8,5,"",1,0,'C');

$pdf->Cell(25,5,'IDH',1,1,'L');
$pdf->Cell(198,6,"",'LBR',1,'C');
$pdf->Cell(60,5,'Tipo de Beneficiario',1,0,'C');
$pdf->Cell(65,5,"Parentesco",1,0,'C');
$pdf->Cell(50,5,"Sexo",1,0,'C');
$pdf->Cell(23,5,"Edad",1,1,'C');

$pdf->SetFont('Times','B',7);
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,0,'C');
$pdf->Cell(15,8,'CALIDAD',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(198,4,'',1,1,'C');
$pdf->Cell(180,6,utf8_decode('TIPO DE ATENCIÓN.'),'LBR',0,'C');
$pdf->Cell(18,6,utf8_decode('Fecha'),'LBR',1,'C');
$pdf->Cell(18,6,utf8_decode('CONSULTA'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(8,6,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(25,6,utf8_decode('Especialidad'),'LBR',0,'C');
$pdf->Cell(90,6,utf8_decode('OTORRINOLARINGOLOGIA'),'LBR',0,'C');
$pdf->Cell(10,8,'30',1,0,'C');
$pdf->Cell(10,8,'3',1,0,'C');
$pdf->Cell(10,8,'2022',1,1,'C');
$pdf->Cell(18,6,utf8_decode('PRACTICA'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(8,6,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(35,6,utf8_decode('Especialidad'),'LBR',0,'C');
$pdf->Cell(90,6,utf8_decode('OTORRINOLARINGOLOGIA'),'LBR',0,'C');
$pdf->Cell(47,6,'2022',1,1,'C');
$pdf->Cell(18,6,utf8_decode('INTERNAC'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(8,6,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(30,6,utf8_decode('Códigos   N.HPGD'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(10,6,utf8_decode('x'),'LBR',1,'C');
$pdf->Cell(18,8,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(10,8,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(8,8,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(30,8,utf8_decode('Códigos   N.HPGD'),'LBR',0,'C');
$pdf->Cell(10,8,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(20,8,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(20,8,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(20,8,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(60,8,utf8_decode('x'),'LBR',1,'C');
$pdf->Cell(199,32,utf8_decode('xss'),'LBR',1,'C');
$pdf->Cell(150,6,utf8_decode('DATOS DE LA OBRA SOCIAL: Nombre Completo'),1,0,'C');
$pdf->Cell(49,6,utf8_decode('Código'),1,1,'C');
$pdf->Cell(150,9,utf8_decode('MINISTERIO DE SALUD DE RÍO NEGRO'),1,0,'C');
$pdf->Cell(49,9,'',1,1,'C');
$pdf->Cell(199,7,utf8_decode('x'),'LBR',1,'C');
$pdf->Cell(199,4,utf8_decode('x'),'LBR',1,'C');
// OBRA SOCIAL
$pdf->Cell(34,4,utf8_decode(''),'L',0,'C');
$pdf->Cell(85,4,utf8_decode('Nº de Carnet de Obra Social'),'B',0,'C');
$pdf->Cell(7,4,utf8_decode(''),'LR',0,'C');
$pdf->Cell(35,4,utf8_decode('Fecha Emisión'),'LBR',0,'C');
$pdf->Cell(8,4,utf8_decode(''),'LR',0,'C');
$pdf->Cell(30,4,utf8_decode('Vencimiento'),'LRB',1,'C');
$pdf->Cell(34,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(85,6.5,utf8_decode('17858152'),'LBR',0,'C');
$pdf->Cell(7,6.5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(8,6.5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',0,'C');
$pdf->Cell(5,6.5,"",'LBR',1,'C');
$pdf->Cell(119,2.5,"",'LBR',0,'C');
$pdf->Cell(7,2.5,"",'LB',0,'C');
$pdf->Cell(35,2.5,"",'BR',0,'C');
$pdf->Cell(8,2.5,"",'LBR',0,'C');
$pdf->Cell(30,2.5,"",'LBR',1,'C');
$pdf->Cell(199,7,"DATOS DE LA EMPRESA",'LBR',1,'C');
$pdf->Cell(145,8,"NOMBRE O RAZON SOCIAL",'LBR',0,'L');
$pdf->Cell(26,6,"",'LBR',0,'C');
$pdf->Cell(13,6,"",'LBR',0,'C');
$pdf->Cell(13,6,"",'LBR',1,'C');
$pdf->Cell(200,6,"",'LBR',1,'C');
$pdf->Cell(200,6,"",'LBR',1,'C');
$pdf->Cell(145,8,"DIRECCION DE LA EMPRESA",'LBR',1,'L');
$pdf->Cell(145,15,"",'LBR',0,'L');
$pdf->Cell(50,15,"",'LBR',1,'L');
$pdf->Cell(66,8,"",'LBR',0,'L');
$pdf->Cell(66,8,"",'LBR',0,'L');
$pdf->Cell(66,8,"",'LBR',1,'L');
$pdf->Cell(66,10,"",'LBR',0,'L');
$pdf->Cell(66,10,"",'LBR',0,'L');
$pdf->Cell(66,10,"",'LBR',0,'L');



$pdf->Ln(7);


$Inicio = 49;


$pdf->Output("I","BIOPSIA --- ".utf8_decode($model->solicitudbiopsia->paciente->apellido." ". $model->solicitudbiopsia->paciente->nombre));
// $pdf->Output("F","BIOPSIA --- ".utf8_decode($model->solicitudbiopsia->paciente->apellido." ". $model->solicitudbiopsia->paciente->nombre));


exit;
?>
