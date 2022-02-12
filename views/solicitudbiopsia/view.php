<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitudbiopsia */
if (isset($parametros)){
  var_dump($parametros)  ;
}
?>
<div class="solicitudbiopsia-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'protocolo',
          [
            'value'=> $model->paciente->apellido .' '.$model->paciente->nombre,
            'label'=> 'Paciente',
           ],
           [
            'value'=> $edad,
            'label'=> 'Edad del paciente (años)',
         ],
          [
            'value'=> $model->paciente->sexo,
            'label'=> 'Sexo del paciente',
         ],
          [
            'value'=> $model->medico->apellido .' '.$model->medico->nombre,
            'label'=> 'Medico',
           ],
          [
          'value'=> $model->procedencia->nombre ,
          'label'=> 'Procedencia',
          ],
          [
            'value'=> ($model->fecharealizacion)? date('d/m/Y',strtotime($model->fecharealizacion)):$model->fecharealizacion,
            'label' => 'Fecha de realización'
          ],
          [
            'value'=>  date('d/m/Y',strtotime($model->fechadeingreso)),
            'label' => 'Fecha de ingreso'
          ],
          [
            'value'=> $model->estado->descripcion,
            'label' => 'Estado'
          ],
            'observacion:ntext',
        ],
    ]) ?>
    <?
    if ($model->estado->ver_informe_solicitud)
    {
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento del informe', ['/biopsia/informe', 'id' => $model->biopsia->id], [
            'class'=>'btn btn-danger',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
    }

    else {
      echo "<b>LA SOLICITUD AÚN NO POSEE EL INFORME"; echo ($model->estado->descripcion=='EN PROCESO')?" VERIFICADO":""; echo " DE ".$model->estudio->descripcion." </b>";
    }
     ?>

</div>
<? if (isset($model->biopsia) && $model->biopsia->ihq ){ ?>
<div id="w0ss" class="x_panel">
<div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO INMUNOHISTOQUIMICA  </h2>
<div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
</div>
</div>

<?  if (isset($model->biopsia) && $model->biopsia->ihq && isset($model->biopsia->inmunohistoquimicaEscaneada)){
        if($model->estado->descripcion ==='LISTO'){
          echo DetailView::widget([
              'model' => $model->biopsia,
              'attributes' => [

              [
                'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunostoquimica', ['/inmunohistoquimica-escaneada/informe', 'id' => $model->biopsia->inmunohistoquimicaEscaneada->id], [
                      'class'=>'btn btn-primary',
                      // 'role'=>'modal-remote',
                      'target'=>'_blank',
                      'data-toggle'=>'tooltip',
                      'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
                  ]) ,
                'label'=> 'Documento',
                'format'=>'raw',
             ],
             [
               'value'=> $model->biopsia->inmunohistoquimicaEscaneada->observacion ,
               'label'=> 'Observacion',
            ] ,

              ],
              ]) ;}
              else {
                echo "NO SE PUEDE VISUALIZAR PORQUE EL ESTUDIO NO ESTA LISTO";

              }

    }
    else {
        echo "ESTA ACTIVA LA OPCIÓN IHQ PERO NO SE CARGO NINGÚN ESTUDIO";
    }
    ?>
    </div>
    <?
  }
  ?>
<script language="JavaScript" type="text/javascript">
    // protocolo=document.getElementById("w0").rows[0].cells[1].innerHTML;
    // swal(
    // 'N° de protocolo: '+ protocolo ,
    // 'PRESIONAR OK',
    // 'success'
    // )
  </script>
