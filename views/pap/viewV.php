<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Pap */
?>
<div class="pap-view">
  <div id="w0s" class="x_panel">
    <div class="x_title"><h2><i class="fa fa-table"></i> PAP  </h2>
      <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a paps', ['/pap/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
  </div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          [
          'value'=> $model->solicitudpap->protocolo,
          'label'=> 'Protocolo',
         ],
         [
           'value'=> $model->solicitudpap->paciente->apellido .' '.$model->solicitudpap->paciente->nombre,
           'label'=> 'Paciente',
        ],
        [
          'value'=> $edad,
          'label'=> 'Edad del paciente (años)',
       ],
       [
         'value'=> $model->solicitudpap->paciente->sexo,
         'label'=> 'Sexo del paciente',
      ],
      [
        'value'=> $model->solicitudpap->medico->apellido .' '.$model->solicitudpap->medico->nombre,
        'label'=> 'Medico',
     ],
     [
       'value'=> $model->solicitudpap->fechadeingreso ,
       'label'=> 'Fecha de ingreso',
       'format' => ['date', 'd/M/Y'],

    ],
        // 'eosinofilas',
        // 'cianofilas',
        // 'intermedias',
        // 'parabasales',
        // 'descripcion:ntext',
        // 'calificacion:ntext',
        [
          'value'=> $model->indicepicnotico ,
          'label'=> 'Indice picnotico',
       ],
      //  [
      //    'value'=> $model->indicedemaduracion ,
      //    'label'=> 'Indice de maduracion',
      // ],
        // 'plegamiento',
        // 'agrupamiento',
        'leucocitos',
        'hematies',
        'histiocitos',
        'detritus',
        'citolisis',
        'flora:ntext',
        'aspecto:ntext',
        'pavimentosas:ntext',
        'glandulares:ntext',
        // 'id_plantilladiagnostico',
        'diagnostico:ntext',
        [
          'value'=> $model->estado->descripcion ,
          'label'=> 'Estado',
       ],
        // 'observacion:ntext',
        'cantidad',
        'frase',
        ],
    ]);

        echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Generar documento', ['/pap/informe', 'id' => $model->id], [
              'class'=>'btn btn-info',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);
          

    ?>
</div>
</div>
