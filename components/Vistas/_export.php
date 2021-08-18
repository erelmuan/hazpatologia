<script type="text/javascript">
function actualizarDatos(nRegistros){
    var nTamano=document.getElementById("reporte-tamano_letra").value;
    var nAncho=document.getElementById("ancho_caracteres").innerHTML;
    var nPaginas=document.getElementById("paginas").innerHTML;
    
    var nLineas=0;
    
    nPixeles=Math.floor(nAncho*(0.6*nTamano+0.6));
    document.getElementById("ancho_pixeles").innerHTML=nPixeles;
    if (nPixeles<=528){
    document.getElementById("orientacion_hoja").innerHTML="<b>normal</b>";       
    }else{
    document.getElementById("orientacion_hoja").innerHTML="<b>apaisada</b>";       
    }

    if (nTamano>=8){
        if (nPixeles<=528){
            nLineas=Math.floor((-4.12)*nTamano+101);
        }else{
            nLineas=Math.floor((-2.87)*nTamano+69);
        }
    }else{
        if ($pixeles<=528){
            nLineas=68;
        }else{
            nLineas=46;
        }
    }

    nPaginas=Math.floor(nRegistros/nLineas)+1;
    document.getElementById("paginas").innerHTML=nPaginas;
    
}
</script>


<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="export-form">

    <?php $form = ActiveForm::begin(['id'=>'export-form']); ?>

    <?= $form->field($model, 'titulo')->textInput() ?>

    <?= $form->field($model, 'subtitulo')->textInput() ?>

    <?= $form->field($model, 'resumen')->textarea(array('rows' => 2, 'cols' => 48,'maxlength'=>5000))?>

<div style='float: left;width: 120px'>
    <?= $form->field($model, 'tamano_letra',['options' => ['onchange' => "actualizarDatos($totalRegistros)"]]
        )->dropDownList(array(4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11,'11',12=>'12',13=>'13',14=>'14',15=>'15',16=>'16'),
        ['style' => 'width:60px'])
    ?>

</div>
<div style='float: left;width: 220px'>
    <?= $form->field($model, 'tipo_hoja',['options' => ['onchange' => "actualizarDatos($totalRegistros)"]])->radioList(array(
        0=>Html::img('./images/normal.png'),
        1=>Html::img('./images/apaisada.png')),
            ['separator'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'encode'=>false]
            ) ?>
</div>
<div>
<label class="control-label" for="tipo_archivo">Tipo de Archivo</label>
    <?= Html::radioList('tipo_archivo', $tipo_archivo, array(
        1=>Html::img('./images/pdfex.png',['style' => 'width:40px']),
        2=>Html::img('./images/csvex.png',['style' => 'width:40px']),
        3=>Html::img('./images/htmex.png',['style' => 'width:40px'])),
            ['separator'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'encode'=>false]
            ) ?>
</div>

    <?= $form->field($model, 'descripcion')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'datos')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'seleccion')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'id_usuario')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'ancho_reporte')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'modelo')->hiddenInput()->label(false) ?>
    
<?php 

// calculo inicial de datos del reporte, para mostrar info al usuario
// pixeles de ancho del reporte, para saber si es normal o apaisada
$pixeles=(int)($model->ancho_reporte*(0.6*$model->tamano_letra+0.6));

// calculo del total de paginas, con unas formulas segun el tamaño de la letra
if ($model->tamano_letra>=8){
    if ($pixeles<=528)      // normal
        $lineas=(int)((-4.12)*$model->tamano_letra+101 );
    else                   // apaisada
        $lineas=(int)((-2.87)*$model->tamano_letra+69);
    
}else{
    if ($pixeles<=528)      // normal
        $lineas=68;
    else                   // apaisada
        $lineas=46;
}

$paginas=(int)($totalRegistros/$lineas)+1;

// segun cantidad de paginas muestro mensaje
if ($paginas>50)
    echo '<div class="alert-danger"><center>';
else
    echo '<div class="alert-success"><center>';

echo '<b>Datos del Reporte</b><br>';
echo '<a href="#" style="float:right;position:relative;top:-18px;" onclick="actualizarDatos('.$totalRegistros.')"><img title="Actualizar" src="./images/actualizar.png"></a>';
echo 'Ancho<b>&nbsp;<div id="ancho_caracteres" style="display:inline;">'.$model->ancho_reporte.'</div>&nbsp;</b>';
echo 'Caracteres (<div id="ancho_pixeles" style="display:inline;">'.$pixeles.'</div>px). ';
echo 'Se recomienda orientación <b><div id="orientacion_hoja" style="display:inline;">';
echo (($pixeles<=528)?'normal':'apaisada').'</div></b><br>';
echo 'Aproximadamente <b><div id="paginas" style="display:inline;">'.$paginas.'</div></b> páginas';
echo '</center></div>';

?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
