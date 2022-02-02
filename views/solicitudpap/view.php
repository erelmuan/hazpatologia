<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitudpap */
?>
<div class="solicitudpap-view">
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
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento del informe', ['/pap/informe', 'id' => $model->pap->id], [
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
