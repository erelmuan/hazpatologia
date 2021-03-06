<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Pap */
?>
<div class="pap-view">

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
              'value'=>$model->solicitudpap->calcular_edad(),
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
        [
          'value'=> $model->solicitudpap->procedencia->nombre ,
          'label'=> 'Procedencia',
       ],

            [
              'value'=> $model->indicepicnotico ,
              'label'=> 'Indice picnotico',
           ],
            'leucocitos',
            'hematies',
            'histiocitos',
            'detritus',
            'citolisis',
            'flora:ntext',
            'aspecto:ntext',
            'pavimentosas:ntext',
            'glandulares:ntext',
            'diagnostico:ntext',
            [
              'value'=> $model->estado->descripcion ,
              'label'=> 'Estado',
           ],
            // 'observacion:ntext',
            'cantidad',
            'frase',
        ],
    ]) ;

        echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe de pap', ['/pap/informe', 'id' => $model->id], [
              'class'=>'btn btn-dark',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);
              ?>

</div>
