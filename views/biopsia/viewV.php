<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsia */

?>
<div class="biopsia-view">
    <div id="w0s" class="x_panel">
      <div class="x_title"><h2><i class="fa fa-table"></i> BIOPSIA  </h2>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a biopsias', ['/biopsia/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
      </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          [
          'value'=> $model->solicitudbiopsia->protocolo,
          'label'=> 'Protocolo',
         ],
          [
            'value'=> $model->solicitudbiopsia->paciente->apellido .' '.$model->solicitudbiopsia->paciente->nombre,
            'label'=> 'Paciente',
         ],
         [
           'value'=> $edad,
           'label'=> 'Edad del paciente (años)',
        ],
        [
          'value'=> $model->solicitudbiopsia->paciente->sexo,
          'label'=> 'Sexo del paciente',
       ],
         [
           'value'=> $model->solicitudbiopsia->medico->apellido .' '.$model->solicitudbiopsia->medico->nombre,
           'label'=> 'Medico',
        ],
        [
          'value'=> $model->solicitudbiopsia->fecharealizacion ,
          'label'=> 'Fecha de realizacion',
          'format' => ['date', 'd/M/Y'],

       ],
       [
         'value'=> $model->solicitudbiopsia->procedencia->nombre ,
         'label'=> 'Procedencia',
      ],
          // 'idplantillatopografia',
          'topografia:ntext',
          'macroscopia:ntext',
          'microscopia:ntext',
          'ihq:ntext',
          'id_plantilladiagnostico',
          'diagnostico:ntext',
          'ubicacion',
          'observacion:ntext',
          [
            'value'=> $model->estado->descripcion ,
            'label'=> 'Estado',
         ] ,
         [
          'value'=> $model->fechalisto ,
          'label'=> 'Fecha de listo',
          'format' => ['date', 'd/M/Y'],

       ],
          'frase',
        ],
    ]) ;

    if ($model->estado->descripcion== 'EN_PROCESO'){
      echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Generar documento', ['/biopsia/informe', 'id' => $model->id], [
            'class'=>'btn btn-info',
            'role'=>'modal-remote',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
        ]);
      }
      else {
        echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Generar documento', ['/biopsia/informe', 'id' => $model->id], [
              'class'=>'btn btn-info',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);
          }
    ?>
  </div>
</div>
