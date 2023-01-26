<?
$path2 = Yii::getAlias("@vendor/setasign/fpdf/fpdf.php");
require_once($path2);
use app\models\Solicitudpap;
use app\models\Solicitudbiopsia;
class PDF extends Fpdf
{

}
// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', array(217.5 , 304.3));
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(8, 13 , 6);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,13,'ANEXO II',0,0,'L');
$pdf->Ln(9);
$pdf->Text(8.5,28.5,utf8_decode("COMPROBANTE DE ATENCIÓN"));
$pdf->Text(8.5,34.5,utf8_decode("DE BENEFICIARIOS DE OBRAS SOCIALES"));
$pdf->SetFont('Arial','B',10);
$pdf->Text(190,75,$solicitud->paciente->num_documento);
$pdf->Text(13,75,utf8_decode(trim($solicitud->paciente->apellido).", ".trim($solicitud->paciente->nombre)));
$pdf->Text(80,110,"LABORATORIO");
$pdf->Text(80,115,utf8_decode("ANATOMIA PATOLÓGICA"));

$pdf->SetFont('Arial','B',8);
$pdf->Text(48,127,utf8_decode("DIAGNOSTICO DE EGRESO"));
$pdf->Text(63,130.5,utf8_decode("CIE 10"));
$pdf->Text(50,110.5,"Especialidad");
$pdf->Text(103,127.5,utf8_decode("CÓDIGO"));

$pdf->Text(126,129,utf8_decode($solicitud->estudio->codigo));
$pdf->Text(101,130.5,"PRINCIPAL");
$pdf->Text(148,127,"OTROS");
$pdf->Text(146.5,130.5,utf8_decode("CÓDIGOS"));
$pdf->SetFont('Arial','B',7);
$pdf->Text(15.5,135.5,utf8_decode("N. HPGD: NOMENCLADOR HOSPITALES DE GESTIOS DESCENTRALIZADA - CIE 10: Clasificación Internacional de Enfermedad"));
$pdf->Text(15.5,145.5,utf8_decode( $solicitud->estudio->descripcion));
$pdf->Text(77.5,163.5,utf8_decode("Firma de Médico y sello con Nº de matricula"));

$pdf->SetFont('Arial','B',8);
$pdf->Text(10.5,218,"NOMBRE O RAZON SOCIAL");
$pdf->Text(10.5,236,utf8_decode("DIRECCIÓN DE LA EMPRESA"));
$pdf->Text(173,235,"CUIT DE LA EMPRESA");
$pdf->SetFont('Arial','',8);
$pdf->Text(169,219,"Ultimo recibo");
$pdf->Text(171,225,"de sueldo");
$pdf->Cell(173,6,'','LTR',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(32,6,utf8_decode('Fecha'),1,1,'C');
$pdf->Cell(173,8,'','LR',0,'L');
$pdf->SetFont('Arial','B',10);
//fecha del turno
$modelo=$solicitud->estudio->modelo;

$pdf->Cell(10,7.5,date("d", strtotime($solicitud->$modelo->fechalisto)),1,0,'C');
$pdf->Cell(10,7.5,date("m", strtotime($solicitud->$modelo->fechalisto)),1,0,'C');
$pdf->Cell(12,7.5,date("Y", strtotime($solicitud->$modelo->fechalisto)),1,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(205,5,"",1,1,'C');
$pdf->Cell(165,6,"HOSPITAL: Artemides Zatti",1,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,6,utf8_decode('Código de HPGD'),"BR",1,'C');
$pdf->Cell(165,6,utf8_decode("CENTRO DE SALUD Nº"),"RL",0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,6,"10620072170018","R",1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(205,7,utf8_decode("DATOS DEL BENEFICIARIO"),"TRL",1,'C');
$pdf->Cell(205,3.5,"",1,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(157,5.5,"Apellidos y Nombres",1,0,'L');
$pdf->Cell(2.7,5.5,"",'L',0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,5.5,"DNI",1,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(8,5.5,"X",1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30.3,5.5,utf8_decode("Nº de Documento"),1,1,'C');
$pdf->Cell(157,5,"",'LR',0,'L');//Nombre y apellido
$pdf->Cell(2.7,5,'','L',0,'L');
$pdf->Cell(7,5,"LE",1,0,'C');
$pdf->Cell(8,5,'',1,0,'C');
$pdf->Cell(30.3,5,"","LR",1,'C');//DNI
$pdf->Cell(157,5,"",'LBR',0,'R');//Asociado a nombre y apellido
$pdf->Cell(2.7,5,"",'LB',0,'C');
$pdf->Cell(7,5,"LC",1,0,'C');
$pdf->Cell(8,5,"",1,0,'C');
$pdf->Cell(30.3,5,'',"LRB",1,'L');//Asociado al DNI
$pdf->Cell(205,5.3,"",'LR',1,'C');
$pdf->Cell(63.5,4.3,'Tipo de Beneficiario',1,0,'C');
$pdf->Cell(70.5,4.3,"Parentesco",1,0,'C');
$pdf->Cell(50,4.3,"Sexo",1,0,'C');
$pdf->Cell(21,4.3,"Edad",1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(13,7.5,'Titular',1,0,'C');
$pdf->Cell(6.5,7.5,'',1,0,'C');
$pdf->Cell(16.5,7.5,'No Titular',1,0,'C');
$pdf->Cell(6.5,7.5,'',1,0,'C');
$pdf->Cell(14.5,7.5,'Adhere',1,0,'C');
$pdf->Cell(6.5,7.5,'',1,0,'C');
$pdf->Cell(19.5,7.5,'Conyugue',1,0,'C');
$pdf->Cell(6.5,7.5,'',1,0,'C');
$pdf->Cell(16.5,7.5,'Hijo',1,0,'C');
$pdf->Cell(6.5,7.5,'',1,0,'C');
$pdf->Cell(14.5,7.5,'Otro',1,0,'C');
$pdf->Cell(7,7.5,'',1,0,'C');
$pdf->Cell(18,7.5,'Masculino',1,0,'C');
if($solicitud->paciente->sexo =="M"){
  $pdf->Cell(7,7.5,'X',1,0,'C');
}else {
  $pdf->Cell(7,7.5,'',1,0,'C');
}
$pdf->Cell(18,7.5,'Femenino',1,0,'C');
if($solicitud->paciente->sexo =="F"){
  $pdf->Cell(7,7.5,'X',1,0,'C');
}else {
  $pdf->Cell(7,7.5,'',1,0,'C');
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(21,7.5,$solicitud->calcular_edad(),1,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(205,3.5,'','LBR',1,'C');
$pdf->Cell(187,6,utf8_decode('TIPO DE ATENCIÓN.'),'LB',0,'C');
$pdf->Cell(18,6,utf8_decode('Fecha'),'LBR',1,'C');
$pdf->Cell(22,5,utf8_decode('CONSULTA'),'LR',0,'C');
$pdf->Cell(8,5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(6,5,utf8_decode(''),'L',0,'C');
$pdf->Cell(32,5,"",'LR',0,'C');
$pdf->Cell(107,5,"",'LR',0,'C');//Especialidad
$pdf->Cell(10,5,date("d", strtotime($solicitud->$modelo->fechalisto)),'LR',0,'C');
$pdf->Cell(10,5,date("m", strtotime($solicitud->$modelo->fechalisto)),'LR',0,'C');
$pdf->Cell(10,5,date("Y", strtotime($solicitud->$modelo->fechalisto)),'LR',1,'C');
$pdf->Cell(22,0.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(8,0.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(6,0.5,utf8_decode(''),'L',0,'C');
$pdf->Cell(32,0.5,utf8_decode(''),'LR',0,'C');//vinculado con especialidad
$pdf->Cell(107,0.5,utf8_decode(''),'L',0,'C');//vinculado con la desc. de especialidad
$pdf->Cell(10,0.5,'','LR',0,'C');
$pdf->Cell(10,0.5,'','LR',0,'C');
$pdf->Cell(10,0.5,'','L R',1,'C');
$pdf->Cell(22,6.5,utf8_decode('PRACTICA'),'LBR',0,'C');
$pdf->Cell(8,6.5,utf8_decode('x'),'LBR',0,'C');
$pdf->Cell(6,6.5,utf8_decode(''),'L',0,'C');
$pdf->Cell(32,6.5,utf8_decode(''),'LBR',0,'C'); //vinculado con especialidad
$pdf->Cell(107,6.5,utf8_decode(''),'LB',0,'C');//vinculado con la desc. de especialidad
$pdf->Cell(30,6.5,'','TBR',1,'C'); //abajo de fecha
$pdf->Cell(22,6.5,utf8_decode('INTERNAC'),'LBR',0,'C');
$pdf->Cell(8,6.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(6,6.5,utf8_decode(''),'L',0,'C');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(32,6.5,utf8_decode('Códigos   N.HPGD'),'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(15,6.5,"",'LBR',0,'C');
$pdf->Cell(17,6.5,"",'LBR',1,'C');
$pdf->Cell(22,8.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(8,8.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(6,8.5,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(53,8.5,"",'LBR',0,'C');
$pdf->Cell(21.5,8.5,"",'LBR',0,'C');//codigos principal
$pdf->Cell(24,8.5,"",'LBR',0,'C');
$pdf->Cell(20,8.5,"",'LBR',0,'C');//Otros codigos
$pdf->Cell(17,8.5,"",'LBR',0,'C');
$pdf->Cell(18,8.5,"",'LBR',0,'C');
$pdf->Cell(15.5,8.5,"",'BR',1,'C');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(205,34,"",'LBR',1,'C');//N. HPGD: NOMENCLADOR HOSPITALES DE GESTIOS DESCENTRALIZADA - CIE 10: Clasificación Int
$pdf->Cell(173,6,utf8_decode('DATOS DE LA OBRA SOCIAL: Nombre Completo'),1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(32,6,utf8_decode('Código'),1,1,'C');
$pdf->Cell(173,9,"",1,0,'C');
$pdf->SetFont('Arial','B',10);
//codigo obra social
$pdf->Cell(32,9,$carnet->obrasocial->codigo,1,1,'C');
$pdf->Cell(205,8.5,"",'LBR',1,'C');
$pdf->Cell(205,3.3,"",'LBR',1,'C');
//nombre de la obra social
$pdf->SetFont('Arial','B',9);
$pdf->Text(27.5,177.5,utf8_decode($carnet->obrasocial->denominacion));
// OBRA SOCIAL
$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,3.5,"",'L',0,'C');
$pdf->Cell(92,3.5,utf8_decode('Nº de Carnet de Obra Social'),'B',0,'C');
$pdf->Cell(8.5,3.5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(38,3.5,utf8_decode('Fecha Emisión'),'LBR',0,'C');
$pdf->Cell(7.5,3.5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(35,3.5,utf8_decode('Vencimiento'),'LRB',1,'C');
$pdf->Cell(24,6.5,"",'LR',0,'C');
$pdf->SetFont('Arial','B',12);
// Numero de afiliado
$pdf->Cell(92,7,$carnet->nroafiliado,'LBR',0,'C');
$pdf->Cell(8.5,7,utf8_decode(''),'LR',0,'C');
$pdf->Cell(5.2,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5.2,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5.2,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5.2,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(5.2,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(6,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(6,7,utf8_decode(''),'LBR',0,'C');
$pdf->Cell(7.5,7,utf8_decode(''),'LR',0,'C');
$pdf->Cell(6,7,"",'LBR',0,'C');
$pdf->Cell(6,7,"",'BR',0,'C');
$pdf->Cell(6,7,"",'BR',0,'C');
$pdf->Cell(5.5,7,"",'BR',0,'C');
$pdf->Cell(5.5,7,"",'BR',0,'C');
$pdf->Cell(6,7,"",'BR',1,'C');
$pdf->Cell(116,3,"",'LBR',0,'C');
$pdf->Cell(7,3,"",'LB',0,'C');
$pdf->Cell(39.5,3,"",'BR',0,'C');
$pdf->Cell(7.5,3,"",'LBR',0,'C');
$pdf->Cell(35,3,"",'LBR',1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(205,7,"DATOS DE LA EMPRESA",'LBR',1,'C');
$pdf->Cell(158,7,"",'LBR',0,'L'); //NOMBRE O RAZON SOCIAL
$pdf->Cell(22,14,"",'LBR',0,'C'); //Ultimo recibo
$pdf->SetFont('Arial','',8);
$pdf->Cell(12,7,"Mes",'LBR',0,'C');
$pdf->Cell(13,7,utf8_decode('Año'),'LBR',1,'C');
$pdf->Cell(180,7,"",'LR',0,'C');
$pdf->Cell(6,7,"",'LBR',0,'C');
$pdf->Cell(6,7,"",'LBR',0,'C');
$pdf->Cell(6.5,7,"",'LBR',0,'C');
$pdf->Cell(6.5,7,"",'LBR',1,'C');
$pdf->Cell(158,4,"",'LBR',0,'C');
$pdf->Cell(47,4,"",'LR',1,'C'); //vinculado al CUIL DE LA EMPRESA
$pdf->Cell(158,8,"",'LBR',0,'L'); //DIRECCION DE LA EMPRESA
$pdf->Cell(47,8,"",'LBR',1,'L'); //CUIT DE LA EMPRESA
$pdf->Cell(158,15,"",'LBR',0,'L');
$pdf->Cell(47,15,"",'LBR',1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(66,8,"FIRMA DEL RESPONSABLE",'LBR',0,'C');
$pdf->Cell(71,8,"ACLARACION DE FIRMA",'LBR',0,'C');
$pdf->Cell(68,8,"FIRMA DEL BENEFICIARIO",'LBR',1,'C');
$pdf->Cell(66,18,"",'LBR',0,'L');
$pdf->Cell(71,18,"",'LBR',0,'L');
$pdf->Cell(68,18,"",'LBR',0,'L');
$pdf->Ln(7);
$Inicio = 49;
 $pdf->Output("I","FOS --- ".utf8_decode($solicitud->paciente->apellido." ".$solicitud->paciente->nombre).".pdf");

exit;

?>
