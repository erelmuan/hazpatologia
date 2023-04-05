
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

// $resultado = str_replace("?", "Ñ", $cadena);


	$RSPac = pg_query($conn,"SELECT * FROM paciente WHERE apellido like '%?%'" );

 while( $obj = pg_fetch_object($RSPac) ){
                 echo $obj->id." - ".$obj->apellido."<br />";
                 $apellido="'". str_replace("?", "Ñ",$obj->apellido)  ."'";
                  pg_query($conn,"UPDATE paciente SET apellido=". $apellido." WHERE id=".$obj->id);

}
	// if (pg_num_rows($RSPac) == 0 )
	// {
  //   // $nomapellido = explode(" ", $Campo[4]);
	// 	// $apellido = str_replace(",", "", $nomapellido[0]);
	// 	// $direccion = str_replace("'", "", $Campo[6]);
	// 	// $documento =intval(trim($Campo[10]));
  //
  //
  //
	// 	$nomapellido = explode(" ", $Campo[4]);
  //
	// 	$apellido = str_replace(",", "", $nomapellido[0]);
	// 	$apellido = str_replace("'", "", $apellido);
	// 	//tiene que estar si o si despues de
	// 	$nomapellido =  str_replace("'", "", $nomapellido[1]);
  //
	// 	$direccion = str_replace("'", "", $Campo[6]);
	// 	$documento ="'".trim($Campo[10])."'";
  //
  //
  //
  //
	// //	pg_query("haz", "INSERT INTO hclinicas VALUES(" . intval(trim($Campo[2])) . ",'1900-01-01')");
	// 	$VarCam = "INSERT INTO paciente(";
	// 	$VarDat = "VALUES(";
	// 	$VarCam .= "hc, ";
	// 	$VarDat .= intval($Campo[2]) . ", ";
	// 	$VarCam .= "apellido, ";
	// 	$VarDat .= "'" . utf8_decode($apellido) . "', ";
  //   $VarCam .= "nombre, ";
  //   $VarDat .= "'" . utf8_decode($nomapellido) . "', ";
	// 	$VarCam .= "direccion, ";
	// 	$VarDat .= "'" . utf8_decode($direccion) . "', ";
	// 	$VarCam .= "num_documento, ";
	// 	$VarDat .=  $documento. ", ";
	// 	$VarCam .= "sexo, ";
	// 	$VarDat .= "'" . $Campo[5] . "', ";
	// 	$VarCam .= "telefono, ";
	// 	$VarDat .= "'" . utf8_decode($Campo[16]) . "', ";
	// 	$VarCam .= "id_tipodoc, ";
	// 	$VarDat .= " 1 , ";
  //   $VarCam .= "id_localidad, ";
  //   $VarDat .= " 2845 , ";
  //   $VarCam .= "id_provincia, ";
  //   $VarDat .= " 22, ";
	// 	$VarCam .= "id_nacionalidad, ";
  //   $VarDat .= "1, ";
	// 	$VarCam .= "fecha_nacimiento) ";
	// 	$VarDat .= "'" . substr($Campo[8], 0, 4) . "-" . substr($Campo[8], 4, 2) . "-" . substr($Campo[8], 6, 2) . "') ";
	// 	pg_query($conn, $VarCam . $VarDat);
	// }
  //
	// pg_free_result($RSPac);
	// $Reg = $Reg + 1;
	// }


// fclose($VarArc);
echo "######################\n";
echo "# Fin de correccion #\n";
echo "######################\n";
?>
