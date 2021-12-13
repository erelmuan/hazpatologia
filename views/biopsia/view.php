<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsia */

?>
<div class="biopsia-view">

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
            'value'=> $model->solicitudbiopsia->fechadeingreso ,
            'label'=> 'Fecha de ingreso',
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
            'ihq:boolean',
            // 'id_plantilladiagnostico',
            'diagnostico:ntext',
            'observacion:ntext',
            [
              'value'=> $model->estado->descripcion ,
              'label'=> 'Estado',
           ],
         //   [
         //    'value'=> $model->fechalisto ,
         //    'label'=> 'Fecha de listo',
         //    'format' => ['date', 'd/M/Y'],
         //
         // ],
         'frase',

        ],
    ]) ;
    

    if (($model->estado->descripcion == 'EN_PROCESO')){
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe', ['/biopsia/informe', 'id' => $model->id], [
            'class'=>'btn btn-danger',
            'role'=>'modal-remote',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
      }
      else {
        echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe', ['/biopsia/informe', 'id' => $model->id], [
              'class'=>'btn btn-danger',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
          ]);
          }

    ?>


</div>
