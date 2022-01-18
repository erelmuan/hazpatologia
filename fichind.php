
<?
/*
session_cache_limiter("must-revalidate");
session_start();
##########################################################################
# Especificaciones de Formato para Ficheros de Texto SDF
# ------------------------------------------------------------------------
# Elemento de Fichero           Formato
# ------------------------------------------------------------------------
# Campos car?cter               Relleno con espacios en blanco finales
# Campos de fecha               aaaammdd
# Campos l?gicos                T o F
# Campos memo                   Se ignora
# Campos num?ricos              Relleno con espacios en blanco iniciales
#                               para ceros
# Separador de campos           Ninguno
# Separador de registros        Retorno de carro/salto de l�nea
# Marcador de fin de fichero    1A hex o CHR(26)
# ------------------------------------------------------------------------
#
# CAMPO 				LONGITUD	DESCRIPCION
#
# 01 Cdgoareap   Numeric                3		Codigo de area (416)
# 02 Nrohc       Numeric                6		Numero de HC
# 03 Estado      Character              1		Estado de la HC
# 04 Apellido    Character             30		Apellido
# 05 Cdgosexo    Character              1		Codigo de Sexo ( F M I )
# 06 Domicilio   Character             46		Domicilio
# 07 Cdgoloc     Numeric                4		Codigo de Localidad
# 08 Fecnac      Date                   8		Fecha de Nacimiento
# 09 Cdgotipdoc  Numeric                1		Tipo de Documento
#        Numeric               10		Numero de Documento
# 11 Cdgoosoc    Numeric                8		Codigo de Obra Social
# 12 Nroafosoc   Character             15		Numero de Afiliado
# 13 Aynmadre    Character             35		Apellido y nombre
# 14 Fecultcons  Date                   8		Fecha de Ultima Consulta o
#														movimiento
# 15 Cdgomov     Numeric                2		Codigo de Ubicacion
# 16 Telef       Character             12		Telefono
# 17 Obra        Numeric                1		Tipo de Obra Social
# 18 Valor       Character             20		Valor Posicional
# 19 Observ      Character             55		Observaciones
# 20 Estudios    Numeric                3		Codigo de Estudio
# 21 Trabajos    Numeric                3		Codigo de Trabajo
# 22 Trabajtxt   Character             40		Ocupacion
# 23 Nrodocmad   Numeric               10		Numero de Doc Madre
# 24 Hcrefer     Numeric                6		HC de referencia
# 25 Ultserv     Character              4		"I" o "C" + Ultimo Servicio
# 26 FecUltServ  Date	     	          8		Valores Posicionales anteriores
# 27 Turnos      Character             48		Campo donde se guardan datos
# 28 Interna	  Character					39				de los turnos solicitados (ver)
# 29 Iter        Numeric                2		Valor Iteracion
##########################################################################*/
$conn =pg_connect("host=localhost port=5432 dbname=patologiahaz user=elias password=123");
$Archivo = "/opt/fichind.txt";
$VarArc = fopen("$Archivo","r");
$i = 0;
$Reg = 1;
$Final=false;
while ($Final == false)
{
 	//echo "Registro: " . $Reg;
	$i = 0;
	//obtiene una linea desde el puntero al fichero
	$Contenido = fgets($VarArc);
	//longitud del string
	if (strlen($Contenido) > 3) {
		//substr devuelve una cadena desde $i (start) hasta el numero que tiene indicado en este caso 3
	$Campo[1] = substr($Contenido, $i, 3);
	$i = $i + 3;
	$Campo[2] = substr($Contenido, $i, 6);
	$i = $i + 6;
	$Campo[3] = substr($Contenido, $i, 1);
	$i = $i + 1;
	$Campo[4] = substr($Contenido, $i, 30);
	$i = $i + 30;
	$Campo[5] = substr($Contenido, $i, 1);
	$i = $i + 1;
	$Campo[6] = substr($Contenido, $i, 45);
	$i = $i + 45;
	$Campo[7] = substr($Contenido, $i, 4);
	$i = $i + 4;
	$Campo[8] = substr($Contenido, $i, 8);
	$i = $i + 8;
	$Campo[9] = substr($Contenido, $i, 1);
	$i = $i + 1;
	$Campo[10] = substr($Contenido, $i, 10);
	$i = $i + 10;
	$Campo[11] = substr($Contenido, $i, 8);
	$i = $i + 8;
	$Campo[12] = substr($Contenido, $i, 15);
	$i = $i + 15;
	$Campo[13] = substr($Contenido, $i, 35);
	$i = $i + 35;
	$Campo[14] = substr($Contenido, $i, 8);
	$i = $i + 8;
	$Campo[15] = substr($Contenido, $i, 2);
	$i = $i + 2;
	$Campo[16] = substr($Contenido, $i, 12);
	$i = $i + 12;
	$Campo[17] = substr($Contenido, $i, 1);
	$i = $i + 1;
	$Campo[18] = substr($Contenido, $i, 20);
	$i = $i + 20;
	$Campo[19] = substr($Contenido, $i, 55);
	$i = $i + 55;
	$Campo[20] = substr($Contenido, $i, 3);
	$i = $i + 3;
	$Campo[21] = substr($Contenido, $i, 3);
	$i = $i + 3;
	$Campo[22] = substr($Contenido, $i, 40);
	$i = $i + 40;
	$Campo[23] = substr($Contenido, $i, 10);
	$i = $i + 10;
	$Campo[24] = substr($Contenido, $i, 6);
	$i = $i + 6;
	$Campo[25] = substr($Contenido, $i, 4);
	$i = $i + 4;
	$Campo[26] = substr($Contenido, $i, 8);
	$i = $i + 8;
	$Campo[27] = substr($Contenido, $i, 48);
	$i = $i + 48;
	$Campo[28] = substr($Contenido, $i, 39);
	$i = $i + 39;
	$Campo[29] = substr($Contenido, $i, 2);
	$i = $i + 2;
	/*
	$o = 0;
	for ($o = 1; $o <= 20; $o++) {
	 echo $Campo[$o] . "\n";
	}
	exit;
   */
	//$Campo[30] = substr($Contenido, $i, 2);
	//$i = $i + 2;
	//---------------------------------------------------------//

	// $RSPac = pg_query($conn,'SELECT * FROM paciente WHERE id=' . intval(trim($Campo[2])));
	$RSPac = pg_query($conn,'SELECT * FROM paciente WHERE num_documento=' ."'" .trim($Campo[10])."'" );

  // while( $obj = pg_fetch_object($RSPac) )
  //                 echo $obj->id." - ".$obj->nombre."<br />";

	if (pg_num_rows($RSPac) == 0 && strlen(trim($Campo[10])) >6)
	{
    // $nomapellido = explode(" ", $Campo[4]);
		// $apellido = str_replace(",", "", $nomapellido[0]);
		// $direccion = str_replace("'", "", $Campo[6]);
		// $documento =intval(trim($Campo[10]));



		$nomapellido = explode(" ", $Campo[4]);

		$apellido = str_replace(",", "", $nomapellido[0]);
		$apellido = str_replace("'", "", $apellido);
		//tiene que estar si o si despues de
		$nomapellido1 =  str_replace("'", "", $nomapellido[1]);
		$nomapellido2 =  str_replace("'", "", $nomapellido[2]);

		$direccion = str_replace("'", "", $Campo[6]);
		$documento ="'".trim($Campo[10])."'";




	//	pg_query("haz", "INSERT INTO hclinicas VALUES(" . intval(trim($Campo[2])) . ",'1900-01-01')");
		$VarCam = "INSERT INTO paciente(";
		$VarDat = "VALUES(";
		$VarCam .= "hc, ";
		$VarDat .= intval($Campo[2]) . ", ";
		$VarCam .= "apellido, ";
		$VarDat .= "'" . utf8_decode($apellido) . "', ";
    $VarCam .= "nombre, ";
    $VarDat .= "'" . utf8_decode($nomapellido1)." " .utf8_decode($nomapellido2). "', ";
		$VarCam .= "direccion, ";
		$VarDat .= "'" . utf8_decode($direccion) . "', ";
		$VarCam .= "num_documento, ";
		$VarDat .=  $documento. ", ";
		$VarCam .= "sexo, ";
		$VarDat .= "'" . $Campo[5] . "', ";
		$VarCam .= "telefono, ";
		$VarDat .= "'" . utf8_decode($Campo[16]) . "', ";
		$VarCam .= "id_tipodoc, ";
		$VarDat .= " 1 , ";
    $VarCam .= "id_localidad, ";
    $VarDat .= " 2845 , ";
    $VarCam .= "id_provincia, ";
    $VarDat .= " 22, ";
		$VarCam .= "id_nacionalidad, ";
    $VarDat .= "1, ";
		$VarCam .= "fecha_nacimiento) ";
		$VarDat .= "'" . substr($Campo[8], 0, 4) . "-" . substr($Campo[8], 4, 2) . "-" . substr($Campo[8], 6, 2) . "') ";
		pg_query($conn, $VarCam . $VarDat);
	}

	pg_free_result($RSPac);
	$Reg = $Reg + 1;
	}
	else
	{ $Final = true; }
}
fclose($VarArc);
echo "######################\n";
echo "# Fin de Importacion #\n";
echo "######################\n";
?>
