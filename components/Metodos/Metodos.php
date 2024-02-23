<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//namespace app\models;
namespace app\components\Metodos;

use yii\helpers\Html;
use Yii;
use DOMDocument;
use yii\web\HttpException;

class Metodos {

public static function obtenerModuloControlador() {

    $arr = explode("/",$_GET["r"]);
    if (count($arr) == 3)
        return  $arr[1].'/';
    else
        return  $arr[0].'/';
}

public static function siguienteID($modelo) {

    //falta hacer el select for update
    $secuencia=Secuencia::model()->find('nombre=\''.$modelo.'\' and id_centro_salud = '.Yii::app()->session->get('id_centro_salud'));
    if ($secuencia===null){
        $secuencia=new Secuencia();
        $secuencia->id_centro_salud=Yii::app()->session->get('id_centro_salud');
        $secuencia->nombre=$modelo;
        $secuencia->id_actual=0;
    }

    $secuencia->id_actual++;
    $secuencia->save();
    return $secuencia->id_centro_salud*1000000000+$secuencia->id_actual;

}

// Metodos de Dominio
public static function cargarDominio($dominio) {
    return Dominio::model()->findAllByAttributes(array('nombre'=>$dominio));
}

public static function descripcionDominio($dominio,$valor) {
    return Dominio::model()->findByAttributes(array('nombre'=>$dominio,'codigo'=>$valor))->descripcion;
}

// Metodos de Fecha
// dateconvert ( fecha a convertir, tipo de conversion )
// 'toSql' dd/mm/yyyy  a  yyyy-mm-dd  ( para guardar en la base )
// 'View' yyyy-mm-dd  a  dd/mm/yyyy  ( para mostrar en la vista )

public static function dateConvert($date,$func) {
            try{
                $date_hs=substr($date,11);
                if (!empty($date_hs))
                   $date_hs=' '.$date_hs;

                $date=substr($date,0,10);
                // valores nulos
                if ($date =='00-00-0000' or $date =='00/00/0000' or $date =='0000-00-00' or $date =='0000/00/00' or  $date ==null)
                        return null;
                if ($func == 'toSql'){ //insert conversion
                        list($day, $month, $year) = preg_split('/[\/.-]/', $date);
                        //si ingresa 10/8/9, pongo 10/08/09, sino me pone 0009 en vez de 2009
                        if (strlen($year)==1) $year='0'.$year;

                        $date = "$year-$month-$day";
                        return $date.$date_hs;
                }
                if ($func == 'View'){ //output conversion
                        list($year, $month, $day) = preg_split('/[-.]/', $date);
                        $date = "$day/$month/$year";
                        return $date.$date_hs;
                }
            }
         catch(Exception $e) {
             throw new HttpException(404, Yii::t('app', 'Error Convirtiendo fecha. dato ingresado='.$date));

         };
 }

// agregarBarras
// recibe fecha de cualquier forma y devuelve dd/mm/yyyy

public static function agregarBarras($date_in) {

        $date_out=$date_in;
        $date_aux = str_replace(array('\'', '-', '.', ','), '/', $date_in);
        $date_arr = explode('/', $date_aux);

        if(count($date_arr) == 1 and strlen($date_arr[0])== 8) // No tokens
            {
                $date_out=substr($date_arr[0], 0, 2).'/'.substr($date_arr[0], 2, 2).'/'.substr($date_arr[0], 4, 4);
            }
        elseif(count($date_arr) == 1 and strlen($date_arr[0])== 6) // No tokens
            {
                $date_out=substr($date_arr[0], 0, 2).'/'.substr($date_arr[0], 2, 2).'/'.substr($date_arr[0], 4, 2);
            }

        return $date_out;

    }

public static function isDate($date)
    {
     try {
        $date = str_replace(array('\'', '-', '.', ','), '/', $date);
        $date = explode('/', $date);

        //no es lo mejor, pero para el 2100 espero estar jubilado
        if (count($date) == 3 and $date[2]==0) $date[2]=2000;

        if(    count($date) == 3
            and    is_numeric($date[0])
            and    is_numeric($date[1])
            and    is_numeric($date[2])
            and    checkdate($date[1], $date[0], $date[2])
            //(    checkdate($date[0], $date[1], $date[2]) //mmddyyyy
            //or   checkdate($date[1], $date[0], $date[2]) //ddmmyyyy
            //or   checkdate($date[1], $date[2], $date[0]))//yyyymmdd
        )
        {
            return true;
        }

        if (count($date) == 1 and strlen($date[0])== 6 and substr($date[0], 4, 2)==0)
            //no es lo mejor, pero para el 2100 espero estar jubilado
            $date[0]=substr($date[0], 0, 4).'2000';


        if(    count($date) == 1 // No tokens  10022006
            and    is_numeric($date[0])
            and    strlen($date[0])== 8 and
            (    checkdate(substr($date[0], 2, 2)
                        , substr($date[0], 0, 2)
                        , substr($date[0], 4, 4)))
        )
        {
            return true;
        }


        if(    count($date) == 1 // No tokens  100206
            and    is_numeric($date[0])
            and    strlen($date[0])== 6 and
            (    checkdate(substr($date[0], 2, 2)
                        , substr($date[0], 0, 2)
                        , substr($date[0], 4, 2)))
        )
        {
            return true;
        }



        return false;
    }
        catch(Exception $e) {return false;};
    }

    // recibe un numero en cualquier formato y lo convierte a float
    // $num = '1.999,369€';
    // tofloat($num)); // float(1999.369)
    // $otherNum = '126,564,789.33 m²';
    // tofloat($otherNum)); // float(126564789.33)

public static function tofloat($num) {
    	$dotPos = strrpos($num, '.');
    	$commaPos = strrpos($num, ',');
    	$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
    	((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    	if (!$sep) {
    		return floatval(preg_replace("/[^0-9]/", "", $num));
    	}

    	return floatval(
    			preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
    			preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    	);
    }

    public static function pluralize($name)
	{
		$rules=array(
			'/(n|l|d)$/i' => '\1es',
                        '/z$/i' => '\1ces',
                        '/í$/i' => '\1es',
                        '/ú$/i' => '\1es',
                        '/(r|t)y$/i' => '\1ies',
                        '/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
                        '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
                        '/(m)an$/i' => '\1en',
                        '/(child)$/i' => '\1ren',
	    );
		foreach($rules as $rule=>$replacement)
		{
			if(preg_match($rule,$name))
				return preg_replace($rule,$replacement,$name);
		}
		return $name.'s';
	}
    public static function mostrarMensaje($codigo,$mensaje,$ok=false) {

            $div_color='<div class="flash-error">';
            if ($ok)
                $div_color='<div class="flash-success">';

            if(Yii::app()->request->isAjaxRequest) {
                $mensaje1='<br><br>'.$div_color.'
                    <span onclick="$(\'#admin-dialog\').dialog(\'close\')">cerrar</span>
                    <br><h4><b>'.$mensaje.'</b></h4>
                    </div>';

                $mensaje2='<span onclick="document.getElementById(\'divError\').style.display=\'none\';document.getElementById(\'divError\').innerHTML=\'\'; ">cerrar</span><br><h4><b>'.$mensaje.'</b></h4>';
                echo CJSON::encode(array(
                    'status'=>'failure',
                    'div'=>$mensaje1,
                    'error'=>true,
                    'divError'=>$mensaje2,
                    ));
                Yii::app()->end();
           }else{
                Yii::import ('application.controllers.SiteController');
                $controller=new SiteController('site', null);
                $controller->render('error',array(
			'code'=>$codigo,
                        'message'=>$mensaje,
                        'ok'=>$ok
                ));
           }

    }

public static function obtenerConsultaSQL($modeloSeleccionado,$datosSeleccionados,$rangosSeleccionados,$ordenSeleccionados)
	 {

                $relAux=array();   // variable usada para guardar las relaciones dobles
                $campos=array();
                $labeles=$modeloSeleccionado::model()->attributeLabels();
                $datosImpresion=$modeloSeleccionado::model()->attributeImpresion();
                $relaciones=$modeloSeleccionado::model()->relations();

                foreach($datosSeleccionados as $datos) {
                    $campos[$datos]=array($labeles[$datos],$datosImpresion[$datos][1]);
                }

                $sel = 'SELECT ';
                $join = '';
                $where = '';
                $order = '';

                if(is_array($rangosSeleccionados) AND is_array($ordenSeleccionados)){

                        foreach($campos as $key=>$value) {

                            // si algun valor de datosImpresion tiene un punto. verifico que es una relacion
                            // cargo en el select tabla.descripcion
                            // y ademas voy armando el from y el where con inner join

                            $campoAuxiliar=explode('.',$datosImpresion[$key][0]);
                            if(array_key_exists($campoAuxiliar[0],$relaciones)){

                                if (count($campoAuxiliar)==4){
                                    // es una relacion triple ( que puto sos !!! )

                                    $tabla1=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $relac1=$relaciones[$campoAuxiliar[0]][1]::model()->relations();
                                    $tabla2=$relac1[$campoAuxiliar[1]][1]::model()->tableName();
                                    $relac2=$relac1[$campoAuxiliar[1]][1]::model()->relations();
                                    $tabla3=$relac2[$campoAuxiliar[2]][1]::model()->tableName();


                                    $sel.=$campoAuxiliar[2].".".$campoAuxiliar[3].' as "'.$value[0].'", ';

                                    // primera relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // segunda relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1].' ON '.$campoAuxiliar[0].'.'.$relac1[$campoAuxiliar[1]][2].'='.
                                        $campoAuxiliar[1].'.'.$relac1[$campoAuxiliar[1]][1]::model()->tableSchema->primaryKey  ;
                                    }

                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla3.' as '.$campoAuxiliar[2]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla3.' as '.$campoAuxiliar[2].' ON '.$campoAuxiliar[1].'.'.$relac2[$campoAuxiliar[2]][2].'='.
                                        $campoAuxiliar[2].'.'.$relac2[$campoAuxiliar[2]][1]::model()->tableSchema->primaryKey  ;
                                    }


                                    // where
                                    if(!empty($rangosSeleccionados[$key]))
                                        $where.=" ".$campoAuxiliar[2].".".$campoAuxiliar[3].' LIKE "%'.$rangosSeleccionados[$key].'%" AND';

                                    // order. verifico si ese campo esta en order
                                    if(array_search($key,$ordenSeleccionados)){
                                        $order.=" ".$campoAuxiliar[2].".".$campoAuxiliar[3].",";
                                    }

                                }elseif (count($campoAuxiliar)==3){
                                    // es una relacion doble...

                                    $tabla1=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $relac1=$relaciones[$campoAuxiliar[0]][1]::model()->relations();
                                    $tabla2=$relac1[$campoAuxiliar[1]][1]::model()->tableName();

                                    $sel.=$campoAuxiliar[1].".".$campoAuxiliar[2].' as "'.$value[0].'", ';

                                    // primera relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // segunda relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1].' ON '.$campoAuxiliar[0].'.'.$relac1[$campoAuxiliar[1]][2].'='.
                                        $campoAuxiliar[1].'.'.$relac1[$campoAuxiliar[1]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // where
                                    if(!empty($rangosSeleccionados[$key]))
                                        $where.=" ".$campoAuxiliar[1].".".$campoAuxiliar[2].' LIKE "%'.$rangosSeleccionados[$key].'%" AND';

                                    // order. verifico si ese campo esta en order
                                    if(array_search($key,$ordenSeleccionados)){
                                        $order.=" ".$campoAuxiliar[1].".".$campoAuxiliar[2].",";
                                    }

                                }else{
                                    // es una relacion simple
                                    $tabla=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $sel.=$campoAuxiliar[0].".".$campoAuxiliar[1].' as "'.$value[0].'", ';
                                    // join

                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // where
                                    if(!empty($rangosSeleccionados[$key]))
                                        $where.=" ".$campoAuxiliar[0].".".$campoAuxiliar[1].' LIKE "%'.$rangosSeleccionados[$key].'%" AND';

                                    // order. verifico si ese campo esta en order
                                    if(array_search($key,$ordenSeleccionados)){
                                        $order.=" ".$campoAuxiliar[0].".".$campoAuxiliar[1].",";
                                    }
                                }
                            }else{
                                // no es una relacion
                                $tipoCampo=$datosImpresion[$key][2];
                                switch ($tipoCampo){

                                    case 1:     // numeric
                                        $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';

                                        if(!empty($rangosSeleccionados['D'.$key]))
                                            $where.=' t.'.$datosImpresion[$key][0].">=".$rangosSeleccionados['D'.$key]." AND";
                                        if(!empty($rangosSeleccionados['H'.$key]))
                                            $where.=' t.'.$datosImpresion[$key][0]."<=".$rangosSeleccionados['H'.$key]." AND";
                                    break;
                                    case 2:     // caracter
                                        $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';
                                        if(!empty($rangosSeleccionados[$key]))
                                            $where.=' t.'.$datosImpresion[$key][0].' LIKE "%'.$rangosSeleccionados[$key].'%" AND';
                                    break;
                                    case 3:     // fecha
                                        $sel.="to_char(t.".$datosImpresion[$key][0].",'DD/MM/YYYY' ) as \"".$value[0]."\", ";
// mysql                                $sel.="date_FORMAT(t.".$datosImpresion[$key][0].",'%d/%m/%Y' ) as '".$value[0]."', ";
                                        if (!empty($rangosSeleccionados['D'.$key]))
                                            $where.=' t.'.$datosImpresion[$key][0].'>="'.Metodos::dateConvert($rangosSeleccionados['D'.$key], 1).'" AND';
                                        if (!empty($rangosSeleccionados['H'.$key]))
                                            $where.=' t.'.$datosImpresion[$key][0].'<="'.Metodos::dateConvert($rangosSeleccionados['H'.$key], 1).'" AND';
                                    break;
                                    case 4:     // campo boolean
// mysql                                $sel.='IF (t.'.$datosImpresion[$key][0].",'Si','No') as '".$value[0]."', ";
                                        $sel.='CASE WHEN t.'.$datosImpresion[$key][0].'=TRUE THEN \'Si\' ELSE \'No\' END as "'.$value[0].'", ';

                                        if(!empty($rangosSeleccionados[$key])){
                                            if(strtoupper($rangosSeleccionados[$key])=='NO'){
                                                $where.=' t.'.$datosImpresion[$key][0].'=FALSE OR t.'.$datosImpresion[$key][0].' IS NULL AND';
                                            }elseif(strtoupper($rangosSeleccionados[$key])=='SI'){
                                                $where.=' t.'.$datosImpresion[$key][0]."=TRUE AND";
                                            }
                                        }
                                    break;
                                    default:
                                        $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';

                                    break;
                                }
                                // order. verifico si ese campo esta en order
                                if(array_search($key,$ordenSeleccionados)!==false){
                                    $order.=' t.'.$datosImpresion[$key][0].",";
                                }
                            }
                        }
                } else {

                    // el where y order ya vienen armados, cuando sale del export del admin
                        foreach($campos as $key=>$value) {
                            // si algun valor de datosImpresion tiene un punto. verifico que es una relacion
                            // cargo en el select tabla.descripcion
                            // y ademas voy armando el from y el where con inner join

                            $campoAuxiliar=explode('.',$datosImpresion[$key][0]);

                            if(array_key_exists($campoAuxiliar[0],$relaciones)){

                                if (count($campoAuxiliar)==4){
                                    // es una relacion triple ( que puto sos !!! )

                                    $tabla1=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $relac1=$relaciones[$campoAuxiliar[0]][1]::model()->relations();
                                    $tabla2=$relac1[$campoAuxiliar[1]][1]::model()->tableName();
                                    $relac2=$relac1[$campoAuxiliar[1]][1]::model()->relations();
                                    $tabla3=$relac2[$campoAuxiliar[2]][1]::model()->tableName();

                                    $sel.=$campoAuxiliar[2].".".$campoAuxiliar[3].' as "'.$value[0].'", ';

                                    // primera relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // segunda relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1].' ON '.$campoAuxiliar[0].'.'.$relac1[$campoAuxiliar[1]][2].'='.
                                        $campoAuxiliar[1].'.'.$relac1[$campoAuxiliar[1]][1]::model()->tableSchema->primaryKey  ;
                                    }

                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla3.' as '.$campoAuxiliar[2]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla3.' as '.$campoAuxiliar[2].' ON '.$campoAuxiliar[1].'.'.$relac2[$campoAuxiliar[2]][2].'='.
                                        $campoAuxiliar[2].'.'.$relac2[$campoAuxiliar[2]][1]::model()->tableSchema->primaryKey  ;
                                    }

                                }elseif (count($campoAuxiliar)==3){
                                    // es una relacion doble...

                                    $tabla1=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $relac1=$relaciones[$campoAuxiliar[0]][1]::model()->relations();

                                    $tabla2=$relac1[$campoAuxiliar[1]][1]::model()->tableName();


                                    $sel.=$campoAuxiliar[1].".".$campoAuxiliar[2].' as "'.$value[0].'", ';
                                    // primera relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla1.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                    // segunda relacion
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla2.' as '.$campoAuxiliar[1].' ON '.$campoAuxiliar[0].'.'.$relac1[$campoAuxiliar[1]][2].'='.
                                        $campoAuxiliar[1].'.'.$relac1[$campoAuxiliar[1]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                }else{
                                    // es una relacion simple

                                    $tabla=$relaciones[$campoAuxiliar[0]][1]::model()->tableName();
                                    $sel.=$campoAuxiliar[0].".".$campoAuxiliar[1].' as "'.$value[0].'", ';
                                    // join
                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla.' as '.$campoAuxiliar[0]);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla.' as '.$campoAuxiliar[0].' ON t.'.$relaciones[$campoAuxiliar[0]][2].'='.
                                            $campoAuxiliar[0].'.'.$relaciones[$campoAuxiliar[0]][1]::model()->tableSchema->primaryKey  ;
                                    }
                                }

                            }else{
                                // no es una relacion

                                // pero puede ser una concatenacion con una relacion adentro.
                                // entonces necesito el JOIN. por ahora solamente relaciones simples
                                // busco adentro del primer elemento.  ( concat(relacion0 .. )
                                $tabla_join = substr($campoAuxiliar[0], 7);
                                if ($tabla_join && array_key_exists($tabla_join,$relaciones)){
                                    $tabla=$relaciones[$tabla_join][1]::model()->tableName();

                                    $encontrado = strpos($join, 'LEFT JOIN '.$tabla.' as '.$tabla_join);
                                    if ($encontrado === false) {
                                    $join.=' LEFT JOIN '.$tabla.' as '.$tabla_join.' ON t.'.$relaciones[$tabla_join][2].'='.
                                            $tabla_join.'.'.$relaciones[$tabla_join][1]::model()->tableSchema->primaryKey  ;
                                    }
                                }
                                // hasta aca el fix de concat

                                $tipoCampo=$datosImpresion[$key][2];
                                switch ($tipoCampo){

                                    case 1:     // numeric
                                        $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';
                                    break;
                                    case 2:     // caracter
                                        if ($tabla_join && array_key_exists($tabla_join,$relaciones) or !(strrpos($datosImpresion[$key][0], "concat")===false)){
                                            // CASO CONCAT CON O SIN RELACION
                                        	$sel.=$datosImpresion[$key][0].' as "'.$value[0].'", ';
                                        }else{
                                            $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';
                                        }
                                    break;
                                    case 3:     // fecha
                                        $sel.="to_char(t.".$datosImpresion[$key][0].",'DD/MM/YYYY' ) as \"".$value[0]."\", ";
// mysql                                $sel.="date_FORMAT(t.".$datosImpresion[$key][0].",'%d/%m/%Y' ) as '".$value[0]."', ";
                                    break;
                                    case 4:     // campo boolean
                                        $sel.='CASE WHEN t.'.$datosImpresion[$key][0].'=TRUE THEN \'Si\' ELSE \'No\' END as "'.$value[0].'", ';
// mysql                                $sel.='IF (t.'.$datosImpresion[$key][0].",'Si','No') as '".$value[0]."', ";
                                    break;
                                    default:
                                        $sel.='t.'.$datosImpresion[$key][0].' as "'.$value[0].'", ';
                                    break;
                                }
                            }
                        }
                }


                $sel= substr($sel, 0, -2);  // saco la ultima coma
                $sel.=" FROM ".$modeloSeleccionado::model()->tableName()." as t";
                $sel.=$join;

                if(!(is_array($rangosSeleccionados) AND is_array($ordenSeleccionados))){
                    if (!empty($rangosSeleccionados))
                        $sel.=" WHERE ".$rangosSeleccionados;
                    if (!empty($ordenSeleccionados))
                        $sel.=" ORDER BY ".$ordenSeleccionados;
                }else{
                    if (!empty($where))
                        $sel.=" WHERE".substr($where, 0, -4);  // saco el ultimo AND
                    if (!empty($order))
                        $sel.=" ORDER BY".substr($order, 0, -1);    // saco la ultima coma
                }

                return $sel;
        }

   public static function obtenerCantidadRegistroSQL($sel)
	 {

            $connection=Yii::app()->db;
            $command=$connection->createCommand($sel);
            $contador=$command->execute();
            return $contador;

         }

   public static function obtenerColumnas($modelo)
        {

                $columnas=array();

                // si existen recupero columnas guardadas, cargo columnas y seleccion
                $vista = \app\models\Vista::findOne(['id_usuario'=>Yii::$app->user->id,'modelo'=>$modelo->className()]);

                if($vista!=null){
                    $columnas=  unserialize($vista->columna);
                }else{
                    // columnas y seleccion por defecto
                    $contador=0;
                    foreach($modelo->attributeColumns() as $key=>$datosAux) {
                        if($contador<7){
                        $columnas[]=$datosAux;
                        }
                        $contador++;
                    }
                }
                return $columnas;
        }

   public static function obtenerAttributosColumnas($columnas)
        {

            $seleccion=array();
            foreach ($columnas as $key=>$datosAux){
                    $seleccion[]=$datosAux['attribute'];
            }
            return $seleccion;

        }
  public static function obtenerRegistros($modelo)
       {
           $registros=array();

           // si existen recupero columnas guardadas, cargo columnas y seleccion
           $vista = \app\models\Vista::findOne(['id_usuario'=>Yii::$app->user->id,'modelo'=>$modelo->className()]);
           $vista =null;
             if($vista!=null){
                 $registros=  unserialize($vista->columna);
           }else{
                 // columnas y seleccion por defecto
                 $contador=0;
               foreach($modelo->valueRows() as $key=>$datosAux) {
                   if($contador<7){
                     $registros[]=$datosAux;
                     }
                   $contador++;
               }
           }
             return $registros;
    }

   public static function obtenerEtiquetasColumnas($modelo,$seleccion)
        {

            $auxiliar=new $modelo;
            $etiquetas=array();

            // primero las etiquetas seleccionadas
            foreach($seleccion as $datos) {
                $etiquetas[$datos]=$auxiliar->getAttributeLabel($datos);
            }

            // luego las etiquetas que faltan
            foreach($auxiliar->attributeColumns() as $datos) {
                if (array_key_exists($datos['attribute'], $etiquetas)===false){
                    $etiquetas[$datos['attribute']]=$auxiliar->getAttributeLabel($datos['attribute']);
                }
            }

            return $etiquetas;
        }

public static function obtenerObjetoXML($seleccion,$campos,$titulo,$subtitulo,$fontSize,$tipo_hoja,$resumen_final){

                    $usuario=Yii::$app->user->identity->username;

                    $imagen="./images/logoImpresion.jpg";
                    $piePagina=date("d/m/Y H:i")." - ".$usuario." - ".Html::encode(Yii::$app->name);

                    $multiplicador_ancho=0.6*$fontSize+0.6;

                    // esto es PHP, objeto DomDocument()
                    $xml = new DomDocument('1.0', 'UTF-8');
                    $jasper = $xml->createElement('jasperReport');

                    // Raiz de nuestro objeto XML
                    $root = $xml->appendChild($jasper);
                        // attributo de objeto jasper
                        $atributo = $xml->createAttribute("name");
                        $atributo->appendChild($xml->createTextNode("Reporte"));
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("pageWidth");
                        if(!$tipo_hoja){
                        $atributo->appendChild($xml->createTextNode("595"));
                        }else{
                        $atributo->appendChild($xml->createTextNode("842"));
                        }
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("pageHeight");
                        if(!$tipo_hoja){
                        $atributo->appendChild($xml->createTextNode("842"));
                        }else{
                        $atributo->appendChild($xml->createTextNode("595"));
                        }
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("orientation");
                        if(!$tipo_hoja){
                        $atributo->appendChild($xml->createTextNode("Portrait"));
                        }else{
                        $atributo->appendChild($xml->createTextNode("Landscape"));
                        }
                        $jasper->appendChild($atributo);

                        $atributo = $xml->createAttribute("leftMargin");
                        $atributo->appendChild($xml->createTextNode("40"));
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("rightMargin");
                        $atributo->appendChild($xml->createTextNode("40"));
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("topMargin");
                        $atributo->appendChild($xml->createTextNode("26"));
                        $jasper->appendChild($atributo);
                        $atributo = $xml->createAttribute("bottomMargin");
                        $atributo->appendChild($xml->createTextNode("22"));
                        $jasper->appendChild($atributo);

                    // etiqueta query ( select )
                    $query=$xml->createElement('queryString',$seleccion);
                    $query=$root->appendChild($query);

                    // etiqueta field (campos resultados del select )
                    foreach($campos as $key=>$value){
                        $field = $xml->createElement('field');
                        $field = $root->appendChild($field);
                            $atributo = $xml->createAttribute("name");
                            $atributo->appendChild($xml->createTextNode($value[0]));
                            $field->appendChild($atributo);
                            $atributo = $xml->createAttribute("class");
                            $atributo->appendChild($xml->createTextNode("java.lang.String"));
                            $field->appendChild($atributo);
                     }

                    // CABECERA
                    $pageHeader=$xml->createElement('pageHeader');
                    $pageHeader=$root->appendChild($pageHeader);

                    $band=$xml->createElement('band');
                    $band=$pageHeader->appendChild($band);
                        $atributo = $xml->createAttribute("height");
                        $atributo->appendChild($xml->createTextNode("40"));
                        $band->appendChild($atributo);

                    // imagen
                    $imagen1=$xml->createElement('image');
                    $imagen1=$band->appendChild($imagen1);

                    $xml=Metodos::atributoReportElement($imagen1,'',0,0,157,27,'','',$xml);

                    $imgExp=$xml->createElement('imageExpression',$imagen);
                    $imgExp=$imagen1->appendChild($imgExp);

                        $atributo = $xml->createAttribute("class");
                        $atributo->appendChild($xml->createTextNode("java.lang.String"));
                        $imgExp->appendChild($atributo);

                    // titulo
                    $static1=$xml->createElement('staticText');

                    $static1=$band->appendChild($static1);

                    $xml=Metodos::atributoReportElement($static1,"Transparent",170,0,300,15,'','',$xml);

                    $text1=$xml->createElement('textElement');
                    $text1=$static1->appendChild($text1);

                        $atributo = $xml->createAttribute("textAlignment");
                        $atributo->appendChild($xml->createTextNode("Left"));
                        $text1->appendChild($atributo);
                        $atributo = $xml->createAttribute("verticalAlignment");
                        $atributo->appendChild($xml->createTextNode("Middle"));
                        $text1->appendChild($atributo);

                    $font1=$xml->createElement('font');
                    $font1=$text1->appendChild($font1);

                        $atributo = $xml->createAttribute("fontName");
                        $atributo->appendChild($xml->createTextNode("Sans Serif"));
                        $font1->appendChild($atributo);
                        $atributo = $xml->createAttribute("size");
                        $atributo->appendChild($xml->createTextNode("12"));
                        $font1->appendChild($atributo);
                        $atributo = $xml->createAttribute("isBold");
                        $atributo->appendChild($xml->createTextNode("true"));
                        $font1->appendChild($atributo);

                    $textValor1=$xml->createElement('text',$titulo);
                    $textValor1=$static1->appendChild($textValor1);

                    // subtitulo
                    $static2=$xml->createElement('staticText');
                    $static2=$band->appendChild($static2);
                    $xml=Metodos::atributoReportElement($static2,"Transparent",170,15,300,15,'','',$xml);

                    $text2=$xml->createElement('textElement');
                    $text2=$static2->appendChild($text2);

                        $atributo = $xml->createAttribute("textAlignment");
                        $atributo->appendChild($xml->createTextNode("Left"));
                        $text2->appendChild($atributo);
                        $atributo = $xml->createAttribute("verticalAlignment");
                        $atributo->appendChild($xml->createTextNode("Middle"));
                        $text2->appendChild($atributo);

                    $font2=$xml->createElement('font');
                    $font2=$text2->appendChild($font2);

                        $atributo = $xml->createAttribute("fontName");
                        $atributo->appendChild($xml->createTextNode("Sans Serif"));
                        $font2->appendChild($atributo);
                        $atributo = $xml->createAttribute("size");
                        $atributo->appendChild($xml->createTextNode("10"));
                        $font2->appendChild($atributo);
                        $atributo = $xml->createAttribute("isBold");
                        $atributo->appendChild($xml->createTextNode("false"));
                        $font2->appendChild($atributo);

                    $textValor2=$xml->createElement('text',$subtitulo);
                    $textValor2=$static2->appendChild($textValor2);

                    // linea
                    $linea=$xml->createElement('line');
                    $linea=$band->appendChild($linea);

                    if(!$tipo_hoja){
                        $xml=Metodos::atributoReportElement($linea,'',0,30,512,1,'','',$xml);
                    }else{
                        $xml=Metodos::atributoReportElement($linea,'',0,30,754,1,'','',$xml);
                    }

                    // DETALLE
                    // column Header de cada Campo del Select
                    $column=$xml->createElement('columnHeader');
                    $column=$root->appendChild($column);

                    $band=$xml->createElement('band');
                    $band=$column->appendChild($band);
                        $atributo = $xml->createAttribute("height");
                        $atributo->appendChild($xml->createTextNode("20"));
                        $band->appendChild($atributo);

                    $posX=0;
                    foreach($campos as $key=>$value){
                        $static[$key] = $xml->createElement('staticText');
                        $static[$key] = $band->appendChild($static[$key]);

                        $xml=Metodos::atributoReportElement($static[$key],'Opaque',$posX,0,$value[1]*$multiplicador_ancho,14,'#000000','#E6E6E6',$xml);

                        $text[$key]=$xml->createElement('textElement');
                        $text[$key]=$static[$key]->appendChild($text[$key]);

                        $atributo = $xml->createAttribute("verticalAlignment");
                        $atributo->appendChild($xml->createTextNode("Bottom"));
                        $text[$key]->appendChild($atributo);

                        $font[$key]=$xml->createElement('font');
                        $font[$key]=$text[$key]->appendChild($font[$key]);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode($fontSize));
                            $font[$key]->appendChild($atributo);

                            $atributo = $xml->createAttribute("isBold");
                            $atributo->appendChild($xml->createTextNode("true"));
                            $font[$key]->appendChild($atributo);
                        $expresion[$key]=$xml->createElement('text',$value[0]);
                        $expresion[$key]=$static[$key]->appendChild($expresion[$key]);

                        $posX=$posX+$value[1]*$multiplicador_ancho;
                    }

                    // Detalle del listado
                    $detalle=$xml->createElement('detail');
                    $detalle=$root->appendChild($detalle);

                    $band=$xml->createElement('band');
                    $band=$detalle->appendChild($band);
                        $atributo = $xml->createAttribute("height");
                        $atributo->appendChild($xml->createTextNode("20"));
                        $band->appendChild($atributo);

                    $posX=0;

                    foreach($campos as $key=>$value){
                        $textfield[$key] = $xml->createElement('textField');
                        $textfield[$key] = $band->appendChild($textfield[$key]);
                            $atributo = $xml->createAttribute("isStretchWithOverflow");
                            $atributo->appendChild($xml->createTextNode('true'));
                            $textfield[$key]->appendChild($atributo);

                        $xml=Metodos::atributoReportElement($textfield[$key],'',$posX,0,$value[1]*$multiplicador_ancho,10,'','',$xml);

                        $text[$key]=$xml->createElement('textElement');
                        $text[$key]=$textfield[$key]->appendChild($text[$key]);

                        $font[$key]=$xml->createElement('font');
                        $font[$key]=$text[$key]->appendChild($font[$key]);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode($fontSize));
                            $font[$key]->appendChild($atributo);

                        $expresion[$key]=$xml->createElement('textFieldExpression');
                        $expresion[$key]=$textfield[$key]->appendChild($expresion[$key]);

                            $cdata[$key]=$xml->createCDATASection('$F{'.$value[0].'}');
                            $cdata[$key]=$expresion[$key]->appendChild($cdata[$key]);

                            $atributo = $xml->createAttribute("class");
                            $atributo->appendChild($xml->createTextNode("java.lang.String"));
                            $expresion[$key]->appendChild($atributo);

                        $posX=$posX+$value[1]*$multiplicador_ancho;

                    }

                    // FOOTER
                    $pageFooter=$xml->createElement('pageFooter');
                    $pageFooter=$root->appendChild($pageFooter);

                    $band=$xml->createElement('band');
                    $band=$pageFooter->appendChild($band);
                        $atributo = $xml->createAttribute("height");
                        $atributo->appendChild($xml->createTextNode("20"));
                        $band->appendChild($atributo);

                    // linea
                    $linea=$xml->createElement('line');
                    $linea=$band->appendChild($linea);

                    if(!$tipo_hoja){
                    $xml=Metodos::atributoReportElement($linea,'',0,0,512,1,'','',$xml);
                    }else{
                    $xml=Metodos::atributoReportElement($linea,'',0,0,754,1,'','',$xml);
                    }

                    $static=$xml->createElement('staticText');
                    $static=$band->appendChild($static);

                    $xml=Metodos::atributoReportElement($static,'',0,0,300,20,'','',$xml);

                    $text=$xml->createElement('textElement');
                    $text=$static->appendChild($text);

                         $fontFoot=$xml->createElement('font');
                         $fontFoot=$text->appendChild($fontFoot);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode("8"));
                            $fontFoot->appendChild($atributo);

                        $atributo = $xml->createAttribute("textAlignment");
                        $atributo->appendChild($xml->createTextNode("Left"));
                        $text->appendChild($atributo);
                        $atributo = $xml->createAttribute("verticalAlignment");
                        $atributo->appendChild($xml->createTextNode("Middle"));
                        $text->appendChild($atributo);

                        $textValor=$xml->createElement('text',$piePagina);
                        $textValor=$static->appendChild($textValor);

                    // numero de pagina
                    $textfield=$xml->createElement('textField');
                    $textfield=$band->appendChild($textfield);

                    if(!$tipo_hoja){
                    $xml=Metodos::atributoReportElement($textfield,'',465,0,50,20,'','',$xml);
                    }else {
                    $xml=Metodos::atributoReportElement($textfield,'',695,0,50,20,'','',$xml);
                    }
                    $text1=$xml->createElement('textElement');
                    $text1=$textfield->appendChild($text1);

                         $fontFoot=$xml->createElement('font');
                         $fontFoot=$text1->appendChild($fontFoot);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode("8"));
                            $fontFoot->appendChild($atributo);

                        $atributo = $xml->createAttribute("textAlignment");
                        $atributo->appendChild($xml->createTextNode("Right"));
                        $text1->appendChild($atributo);

                    $expresion=$xml->createElement('textFieldExpression');
                    $expresion=$textfield->appendChild($expresion);

                        $cdata=$xml->createCDATASection('$V{PAGE_NUMBER}+"/"');
                        $cdata=$expresion->appendChild($cdata);

                        $atributo = $xml->createAttribute("class");
                        $atributo->appendChild($xml->createTextNode("java.lang.String"));
                        $expresion->appendChild($atributo);

                    // total de paginas
                    $textfield=$xml->createElement('textField');
                    $textfield=$band->appendChild($textfield);
                        $atributo = $xml->createAttribute("evaluationTime");
                        $atributo->appendChild($xml->createTextNode("Report"));
                        $textfield->appendChild($atributo);

                    if(!$tipo_hoja){
                    $xml=Metodos::atributoReportElement($textfield,'',510,0,50,20,'','',$xml);
                    }else{
                    $xml=Metodos::atributoReportElement($textfield,'',740,0,50,20,'','',$xml);
                    }
                    $text1=$xml->createElement('textElement');
                    $text1=$textfield->appendChild($text1);

                         $fontFoot=$xml->createElement('font');
                         $fontFoot=$text1->appendChild($fontFoot);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode("8"));
                            $fontFoot->appendChild($atributo);


                        $atributo = $xml->createAttribute("textAlignment");
                        $atributo->appendChild($xml->createTextNode("Left"));
                        $text1->appendChild($atributo);

                    $expresion=$xml->createElement('textFieldExpression');
                    $expresion=$textfield->appendChild($expresion);

                        $cdata=$xml->createCDATASection('$V{PAGE_NUMBER}');
                        $cdata=$expresion->appendChild($cdata);

                        $atributo = $xml->createAttribute("class");
                        $atributo->appendChild($xml->createTextNode("java.lang.String"));
                        $expresion->appendChild($atributo);

                if (!($resumen_final==null || $resumen_final=='')){
                    // SUMMARY
                    $summary=$xml->createElement('summary');
                    $summary=$root->appendChild($summary);

                    $band=$xml->createElement('band');
                    $band=$summary->appendChild($band);
                        $atributo = $xml->createAttribute("height");
                        $atributo->appendChild($xml->createTextNode("100"));
                        $band->appendChild($atributo);
                        $atributo = $xml->createAttribute("splitType");
                        $atributo->appendChild($xml->createTextNode("Stretch"));
                        $band->appendChild($atributo);

                    $textfield=$xml->createElement('textField');
                    $textfield=$band->appendChild($textfield);

                    $xml=Metodos::atributoReportElement($textfield,'',0,20,500,300,'','',$xml);

                    $text1=$xml->createElement('textElement');
                    $text1=$textfield->appendChild($text1);

                        $atributo = $xml->createAttribute("markup");
                        $atributo->appendChild($xml->createTextNode("html"));
                        $text1->appendChild($atributo);

                        $fontFoot=$xml->createElement('font');
                        $fontFoot=$text1->appendChild($fontFoot);

                            $atributo = $xml->createAttribute("size");
                            $atributo->appendChild($xml->createTextNode("8"));
                            $fontFoot->appendChild($atributo);

                        $expresion=$xml->createElement('textFieldExpression');
                        $expresion=$textfield->appendChild($expresion);

                            $atributo = $xml->createAttribute("class");
                            $atributo->appendChild($xml->createTextNode("java.lang.String"));
                            $expresion->appendChild($atributo);

                            $cdata=$xml->createCDATASection('"'.$resumen_final.'"');
                            $cdata=$expresion->appendChild($cdata);
                }

                    $xml->formatOutput = true;

                    return $xml;
                }


 // funcion para crear el objeto reportElement . se usa muchas veces en posicion y color de los otros objetos
 public static function atributoReportElement($objeto,$mode,$x,$y,$width,$height,$forecolor,$backcolor,$xml){

                    $report1=$xml->createElement('reportElement');
                    $report1=$objeto->appendChild($report1);

                    if ($mode<>''){
                        $atributo = $xml->createAttribute("mode");
                        $atributo->appendChild($xml->createTextNode($mode));
                        $report1->appendChild($atributo);
                    }
                    $atributo = $xml->createAttribute("stretchType");
                    $atributo->appendChild($xml->createTextNode("RelativeToTallestObject"));
                    $report1->appendChild($atributo);

                    $atributo = $xml->createAttribute("x");
                    $atributo->appendChild($xml->createTextNode("$x"));
                    $report1->appendChild($atributo);
                    $atributo = $xml->createAttribute("y");
                    $atributo->appendChild($xml->createTextNode("$y"));
                    $report1->appendChild($atributo);
                    $atributo = $xml->createAttribute("width");
                    $atributo->appendChild($xml->createTextNode("$width"));
                    $report1->appendChild($atributo);
                    $atributo = $xml->createAttribute("height");
                    $atributo->appendChild($xml->createTextNode("$height"));
                    $report1->appendChild($atributo);
                    if ($forecolor<>''){
                        $atributo = $xml->createAttribute("forecolor");
                        $atributo->appendChild($xml->createTextNode($forecolor));
                        $report1->appendChild($atributo);
                    }
                    if ($backcolor<>''){
                        $atributo = $xml->createAttribute("backcolor");
                        $atributo->appendChild($xml->createTextNode($backcolor));
                        $report1->appendChild($atributo);
                    }
                return $xml;

                }


public static function obtenerReporteDataProvider($reporte,$modelo,$where,$sort){

            // $datos de impresion, similar a columnas del admin
            $columnasVista=array();
            $seleccion=array();

            $columnasVista=Metodos::obtenerColumnas($modelo);
            $seleccion=Metodos::obtenerAttributosColumnas($columnasVista);

            $datosImpresion=$modelo::model()->attributeImpresion();
            $etiquetasImpresion=$modelo::model()->attributeLabels();

            $sel= Metodos::obtenerConsultaSQL($modelo,$seleccion,$where,$sort);

            $ancho=0;
            $datos=array();

            foreach($columnasVista as $datosAux) {
                if(is_array($datosAux)){
                    $ancho =$ancho+$datosImpresion[$datosAux['name']][1];
                    $datos[$datosAux['name']]=array($etiquetasImpresion[$datosAux['name']],$datosImpresion[$datosAux['name']][1]);
                }else{
                    $ancho =$ancho+$datosImpresion[$datosAux][1];
                    $datos[$datosAux]=array($etiquetasImpresion[$datosAux],$datosImpresion[$datosAux][1]);
                }

            }

            $reporte->id_usuario=$_SESSION['id_usuario'];
            $reporte->modelo=$modelo;
            $reporte->titulo="Listado de ".Metodos::pluralize($modelo);
            $reporte->subtitulo="";
            $reporte->tamano_letra=8;

            $pixeles=$ancho*(0.6*$reporte->tamano_letra+0.6);
            $tipo_hoja=($pixeles>528)?1:0;

            $reporte->tipo_hoja=$tipo_hoja;
            $reporte->ancho_reporte=$ancho;
            $reporte->resumen_final='';
            $reporte->datos=serialize($datos);
            $reporte->seleccion=$sel;

            return $reporte;

}

public static Function obtenerDetalleHTML($model,$relacion,$datos,$idDetalle,$funciones){


    $modelDetalle  = $model->{$relacion};

    $idString=$model->tableSchema->primaryKey;

    $idMaestro=$model->{$idString};

    $relaciones=$model::model()->relations();

    $labeles=$relaciones[$relacion][1]::model()->attributeLabels();

    $stringHTML="<table class='maestroDetalle'><tr class='trMaestroDetalle' style='color:blue;'>";
    foreach($datos as $value){
        if (is_array($value))
            $stringHTML.="<td class='labelMaestroDetalle'>".$labeles[$value[0]]."</td>";
        else
           $stringHTML.="<td class='labelMaestroDetalle'>".$labeles[$value]."</td>";
    }


    if (array_search('agregar', $funciones)!==false)
        $stringHTML.="<td class='labelMaestroDetalle'>".CHtml::link(CHtml::image('./images/agregarDetalle.png',''), '#', array('title'=>'Agregar Registro','onclick'=>"addDetalle($idMaestro)"))."</td>";

    $stringHTML.="</tr>";

    // dibujo las filas
    foreach($modelDetalle as $data)
    {
        $stringHTML.="<tr class='trMaestroDetalle'>";
        foreach($datos as $value){
            if (is_array($value)){
                $value_auxiliar=explode(".",$value[1]);
                $modelRelacion  = $data->{$value_auxiliar[0]};
                if ($modelRelacion)
                    $stringHTML.="<td class='tdMaestroDetalle'>".$modelRelacion->{$value_auxiliar[1]}."</td>";
                else
                 $stringHTML.="<td class='tdMaestroDetalle'>Sin información</td>";

            }else{
               $stringHTML.="<td class='tdMaestroDetalle'>".$data[$value]."</td>";
            }
        }

        // funcion delete
        if (array_search('borrar',$funciones)!==false)
            $stringHTML.="<td class='tdMaestroDetalle'>".CHtml::link(CHtml::image('./images/deleteDetalle.png',''), '#', array('title'=>'Borrar Registro','onclick'=>"delDetalle($idMaestro,$data[$idDetalle])"))."</td>";
        // funcion view
        if (array_search('ver',$funciones)!==false)
            $stringHTML.="<td class='tdMaestroDetalle'>".CHtml::link(CHtml::image('./images/viewDetalle.png',''), '#', array('title'=>'Ver Registro','onclick'=>"viewDetalle($idMaestro,$data[$idDetalle])"))."</td>";
        // funcion update
        if (array_search('actualizar',$funciones)!==false)
            $stringHTML.="<td class='tdMaestroDetalle'>".CHtml::link(CHtml::image('./images/updateDetalle.png',''), '#', array('title'=>'Actualizar Registro','onclick'=>"updateDetalle($idMaestro,$data[$idDetalle])"))."</td>";

        foreach($funciones as $value){
            if (is_array($value)){
                if ($value[0]){   // ajax
                    $stringHTML.="<td class='tdMaestroDetalle'>".CHtml::link(CHtml::image('./images/'.$value[1],''), '#', array('title'=>$value[2],'onclick'=>"$value[3]($idMaestro,$data[$idDetalle])"))."</td>";
                }else{
                    $stringHTML.="<td class='tdMaestroDetalle'>".CHtml::link(CHtml::image('./images/'.$value[1],''), Yii::app()->controller->createUrl($value[3],array('id_maestro'=>$idMaestro,'id_detalle'=>$data[$idDetalle])), array('title'=>$value[2],))."</td>";
                }

            }
        }
        // imagen.png  Actualizar Registro updateDetalle
        $stringHTML.="</tr>";
    }
    $stringHTML.="</table>";

    return $stringHTML;
}

    public static function convertir_imagen($directorio,$file,$tamaño_max){

        // Mime types permitidos
        $allowedImageTypes = array("image/jpeg","image/pjpeg", "image/jpg","image/gif", "image/png","image/x-png");
        $ok=true;  // variable para el return

        $sizefile = filesize($directorio.$file);
        $fp = fopen($directorio . $file, "rb");
        $tamaño_string = strlen(base64_encode(fread($fp, $sizefile)));
        fclose($fp);

        // while de conversion de archivo hasta un tamaño de string < $tamaño_maximo
        while (($tamaño_string>$tamaño_max) and $ok) {

            $datos = getimagesize($directorio.$file);
            $ancho = $datos[0];
            $alto = $datos[1];
            $ratio = $alto/$ancho;

            switch(image_type_to_mime_type($datos[2])) {
                case $allowedImageTypes[0]:
                case $allowedImageTypes[1]:
                case $allowedImageTypes[2]:
                $img = imagecreatefromjpeg($directorio.$file);
                break;
                case $allowedImageTypes[3]:
                $img = imagecreatefromgif($directorio.$file);
                break;
                case $allowedImageTypes[4]:
                case $allowedImageTypes[5]:
                $img = imagecreatefrompng($directorio.$file);
                break;
            }

            $alto = $alto*0.9;    // reduzco 10% pixeles
            $ancho = round($alto/$ratio);

            $img_new = imagecreatetruecolor($ancho, $alto);

            imagecopyresampled($img_new, $img, 0, 0, 0, 0, $ancho, $alto, $datos[0], $datos[1]);

            // Borro temporal file_aux, para crearlo nuevamente
            @unlink($directorio.$file);
            $ok=false;

            switch(image_type_to_mime_type($datos[2])) {
                case $allowedImageTypes[0]:
                case $allowedImageTypes[1]:
                case $allowedImageTypes[2]:
                if (imagejpeg($img_new, $directorio.$file))
                    $ok=true;
                break;
                case $allowedImageTypes[3]:
                if (imagegif($img_new, $directorio.$file))
                    $ok=true;
                break;
                case $allowedImageTypes[4]:
                case $allowedImageTypes[5]:
                if (imagepng($img_new, $directorio.$file))
                    $ok=true;
                break;
            }

            $sizefile = filesize($directorio.$file);
            $fp = fopen($directorio . $file, "rb");
            $tamaño_string = strlen(base64_encode(fread($fp, $sizefile)));
            fclose($fp);

        }

        // return. el resultado quedo guardado en $file_aux;
        return $ok;
    }

    public static function create_thumbnail($directorio,$file,$allowedImageTypes,$alto_max, $ancho_max){

        $datos = getimagesize($directorio.$file);

        switch($datos['mime']) {
            case $allowedImageTypes[0]:
            case $allowedImageTypes[1]:
            case $allowedImageTypes[2]:
                $img = imagecreatefromjpeg($directorio.$file);
                break;
            case $allowedImageTypes[3]:
                $img = imagecreatefromgif($directorio.$file);
                break;
            case $allowedImageTypes[4]:
            case $allowedImageTypes[5]:
                $img = imagecreatefrompng($directorio.$file);
                break;
            default:
        }

        $ratio = ($datos[0]/$ancho_max);
        $alto = round($datos[1]/$ratio);
        $ancho = $ancho_max;

        if ($alto > $alto_max) {
            $ratio = ($datos[1] / $alto_max);
            $ancho = round($datos[0] / $ratio);
            $alto = $alto_max;
        }

        $thumb = imagecreatetruecolor($ancho, $alto);
        imagecopyresampled($thumb, $img, 0, 0, 0, 0, $ancho, $alto, $datos[0], $datos[1]);

        $file="thumb_".$file;
        @unlink($file);
        $ok=false;
        switch($datos['mime']) {
            case $allowedImageTypes[0]:
            case $allowedImageTypes[1]:
            case $allowedImageTypes[2]:
                $ok=imagejpeg($thumb, $directorio.$file);
                break;
            case $allowedImageTypes[3]:
                $ok=imagegif($thumb, $directorio.$file);
                break;
            case $allowedImageTypes[4]:
            case $allowedImageTypes[5]:
                $ok=imagepng($thumb, $directorio.$file);
                break;
        }

        If (!$ok)
            return false;

        return true;

    }


    public static function scriptTicket($comando,$tipo){

	// estos datos dependen de la impresora
    	$f_respuesta='c:\\sistema\\ticket\\datos.ans';  // archivo de respuesta
    	$f_comando='c:\\sistema\\ticket\\datos.txt'; // archivo de comandos

    	// borro comandos anteriores y respuestas
	    exec('c:\sistema\ticket\borrar.bat');

		// creo nuevo archivo de commando
    	$fp = fopen($f_comando,"a+t");

    	fwrite($fp, $comando);   // escribo en el archivo de comando, lo que recibo como parametro
    	fclose($fp);

    	//  ejecuto imprimir comando y espero respuesta
    	exec('c:\sistema\ticket\imprimir.bat');

    	$segundos=20;  //segundos que espero la salida de la impresora, sino ERROR
    	$respuesta="ERROR";  // respuesta que retorna la funcion.

    	$inicio=time();
    	//bucle de reintento, hasta obtener f_respuesta
    	while(true){
    		$fp = fopen($f_respuesta,"r");
    		if($fp){
   				$longitud=filesize($f_respuesta);

    			if($longitud==0){
    				$respuesta = "ERROR";
    			}else{
    				$respuesta = fread($fp, $longitud);
    			}

    		}
    		fclose($fp);
    		if($respuesta<>"ERROR"){
    			break;
    		}
    		if(time()>$inicio+$segundos){
    			break;
    		}
    	}

    	if($respuesta<>'ERROR'){

    		if ($tipo=="FC"){

		    	//HASAR		"C080".chr(28)."0600" // status impresora - status fiscal . Esto indica que esta bien
		    	//HASAR     "C080∟0600∟3245  statu y numero de ticket
                        $posNum1=strpos($respuesta,'1100000010000000|0011011000000000',+1);
                        $posNum2=strpos($respuesta,'1100000010000000|0011011000000000',$posNum1+33);

                        $Num=substr($respuesta,$posNum1+34,$posNum2-1-$posNum1-34-1);

                        $posCAI=strrpos($respuesta,'1100000010000000|0000011000000000',-1);
                        $Num2=substr($respuesta,$posCAI+34,8);

                        // Cuando se hacen dos o tres facturas, el num2 es 1 o 2 mas

                        if ($Num==$Num2 || (int)$Num==((int)$Num2-1) || (int)$Num==((int)$Num2-2)  ){

                                $CAI=substr($respuesta,$posCAI+45);

                                $pos1=strrpos($respuesta,'1100000010000000|0011011000000000',-1);
                                $auxiliar=substr($respuesta,0,$pos1);
                                $pos2=strrpos($auxiliar,'1100000010000000|0011011000000000',-1);
                                $respuesta=$Num2."|".$CAI.substr($auxiliar,$pos2+33);

                        }else{
                                $respuesta="ERROR";
                        }
    		}else if ($tipo=='Z'){

                        if(substr($respuesta,0,33)=='1100000010000000|0011011000000000')
    			   $respuesta="OK";

    		}else if ($tipo=='NC'){

    		$posNum1=strpos($respuesta,'1100000010000000|0010011000000000',+1);
    			$posNum2=strpos($respuesta,'1100000010000000|0010011000000000',$posNum1+33);

    			$Num=substr($respuesta,$posNum1+34,$posNum2-1-$posNum1-34-1);

				$posCAI=strrpos($respuesta,'1100000010000000|0000011000000000',-1);
				$Num2=substr($respuesta,$posCAI+34,8);

                                if ($Num==$Num2 || (int)$Num==((int)$Num2-1) || (int)$Num==((int)$Num2-2)  ){

					$CAI=substr($respuesta,$posCAI+45);
					$respuesta=$Num2."|".$CAI;

				}else{
					$respuesta="ERROR";
				}

    		}
    	}

    	return $respuesta;
    }
    public static function scriptTicketLeer($comando,$tipo){

		// estos datos dependen de la impresora
    	$f_respuesta='c:\\sistema\\ticket\\datos.ans';  // archivo de respuesta


    	$segundos=20;  //segundos que espero la salida de la impresora, sino ERROR
    	$respuesta="ERROR";  // respuesta que retorna la funcion.

    	$inicio=time();
    	//bucle de reintento, hasta obtener f_respuesta
    	while(true){
    		$fp = fopen($f_respuesta,"r");
    		if($fp){
   				$longitud=filesize($f_respuesta);

    			if($longitud==0){
    				$respuesta = "ERROR";
    			}else{
    				$respuesta = fread($fp, $longitud);
    			}

    		}
    		fclose($fp);
    		if($respuesta<>"ERROR"){
    			break;
    		}
    		if(time()>$inicio+$segundos){
    			break;
    		}
    	}

    	if($respuesta<>'ERROR'){

    		if ($tipo=="TK"){

		    	//HASAR		"C080".chr(28)."0600" // status impresora - status fiscal . Esto indica que esta bien
		    	//HASAR     "C080∟0600∟3245  statu y numero de ticket
				$posNum1=strpos($respuesta,'1100000010000000|0011011000000000',+1);
				$posNum2=strpos($respuesta,'1100000010000000|0011011000000000',$posNum1+33);

				$Num=substr($respuesta,$posNum1+34,$posNum2-1-$posNum1-34-1);

				$posCAI=strrpos($respuesta,'1100000010000000|0000011000000000',-1);
				$Num2=substr($respuesta,$posCAI+34,8);

				if ($Num==$Num2){

					$CAI=substr($respuesta,$posCAI+45);

					$pos1=strrpos($respuesta,'1100000010000000|0011011000000000',-1);
					$auxiliar=substr($respuesta,0,$pos1);
					$pos2=strrpos($auxiliar,'1100000010000000|0011011000000000',-1);
					$respuesta=$Num."|".$CAI.substr($auxiliar,$pos2+33);

				}else{
					$respuesta="ERROR";
				}
    		}else if ($tipo=='Z'){
    			if(substr($respuesta,0,33)=='1100000010000000|0011011000000000')
    			   $respuesta="OK";

    		}else if ($tipo=='NC'){

    			$posNum1=strpos($respuesta,'1100000010000000|0010011000000000',+1);
    			$posNum2=strpos($respuesta,'1100000010000000|0010011000000000',$posNum1+33);

    			$Num=substr($respuesta,$posNum1+34,$posNum2-1-$posNum1-34-1);

				$posCAI=strrpos($respuesta,'1100000010000000|0000011000000000',-1);
				$Num2=substr($respuesta,$posCAI+34,8);

				if ($Num==$Num2){

					$CAI=substr($respuesta,$posCAI+45);
					$respuesta=$Num."|".$CAI;

				}else{
					$respuesta="ERROR";
				}

    		}
    	}

    	return $respuesta;
    }


    public static function scriptReset(){

    	// estos datos dependen de la impresora
/*    	$f_comando='comando.txt'; // archivo de comandos
    	$comando='@CIERREX'; // comando de reset de la impresora

    	// borro comandos anteriores y respuestas
    	exec('c:\ticket\borrar.bat');

    	// creo nuevo archivo de commando
    	$fp = fopen("c:\\ticket\\".$f_comando,"a+t");

    	fwrite($fp, $comando);   // escribo en el archivo de comando, lo que recibo como parametro
    	fclose($fp);

    	//  ejecuto imprimir comando
    	exec('c:\ticket\imprimir.bat');
  */
    	return null;
    }

    function validarCUIT($cuit) {
            $cadena = str_split($cuit);

            if (count($cadena)!=11)
                return false;

            $result = $cadena[0]*5;
            $result += $cadena[1]*4;
            $result += $cadena[2]*3;
            $result += $cadena[3]*2;
            $result += $cadena[4]*7;
            $result += $cadena[5]*6;
            $result += $cadena[6]*5;
            $result += $cadena[7]*4;
            $result += $cadena[8]*3;
            $result += $cadena[9]*2;

            $div = intval($result/11);
            $resto = $result - ($div*11);

            if($resto==0){
                if($resto==$cadena[10]){
                    return true;
                }else{
                    return false;
                }
            }elseif($resto==1){
                if($cadena[10]==9 AND $cadena[0]==2 AND $cadena[1]==3){
                    return true;
                }elseif($cadena[10]==4 AND $cadena[0]==2 AND $cadena[1]==3){
                    return true;
                }
            }elseif($cadena[10]==(11-$resto)){
                return true;
            }else{
                return false;
            }
        }



}


?>
