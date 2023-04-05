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
            'vph:boolean',
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

     if ($model->vph ){ ?>
        <div id="w0ss" class="x_panel">
        <div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO vph  </h2>
          <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
        </div>
        </div>

  <?  if ($model->vph && isset($model->vphEscaneado)){
      echo DetailView::widget([
          'model' => $model,
          'attributes' => [

          [
            'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe vph', ['/vph-escaneado/informe', 'id' => $model->vphEscaneado->id], [
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
           'value'=> $model->vphEscaneado->observacion ,
           'label'=> 'Observacion',
        ] ,

          ],
      ]) ;
    }
    else {
        echo "ESTA ACTIVA LA OPCIÓN VPH PERO NO SE CARGO NINGÚN ESTUDIO";
    }
  ?>
  </div>

  <?    }
        echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe de pap', ['/pap/informe', 'id' => $model->id], [
              'class'=>'btn btn-dark',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);
              ?>

</div>
