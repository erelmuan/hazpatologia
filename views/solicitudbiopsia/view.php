<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitudbiopsia */
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
          'id_materialsolicitud',
          [
            'value'=>  date('d/m/Y',strtotime($model->fecharealizacion)),
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
            'sitio_prec_toma',
            'datos_clin_interes',
            'diagnostico_presuntivo:ntext',
            'biopsia_anterior_resultado',
            'id_materialginecologico',
        ],
    ]) ?>
    <?
    if ($model->estado=="LISTO")
    {
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento del informe', ['/biopsia/informe', 'id' => $model->biopsia->id], [
            'class'=>'btn btn-danger',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
    }

    else {
      echo "<b>LA SOLICITUD AÚN NO POSEE EL INFORME DE ".$model->estudio->descripcion." </b>";
    }
    echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento de la solicitud', ['/solicitudbiopsia/documento', 'id' => $model->id], [
      'class'=>'btn btn-info',
      'target'=>'_blank',
      'data-toggle'=>'tooltip',
      'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
  ]);
     ?>

</div>
<script language="JavaScript" type="text/javascript">
    // protocolo=document.getElementById("w0").rows[0].cells[1].innerHTML;
    // swal(
    // 'N° de protocolo: '+ protocolo ,
    // 'PRESIONAR OK',
    // 'success'
    // )
  </script>
