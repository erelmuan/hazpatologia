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
          'value'=> $model->solicitudbiopsia->fechadeingreso ,
          'label'=> 'Fecha de ingreso',
          'format' => ['date', 'd/M/Y'],

       ],
       [
         'value'=> $model->solicitudbiopsia->procedencia->nombre ,
         'label'=> 'Procedencia',
      ],
          'material:ntext',
          'macroscopia:ntext',
          'microscopia:ntext',
          'ihq:boolean',
          'diagnostico:ntext',
          // 'observacion:ntext',
          [
            'value'=> $model->estado->descripcion ,
            'label'=> 'Estado',
         ] ,

          'frase',
        ],
    ]) ; ?>

    </div>
    <? if ($model->ihq ){ ?>
    <div id="w0ss" class="x_panel">
    <div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO INMUNOHISTOQUIMICA  </h2>
      <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
    </div>
    </div>
    <?
      if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)){
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [

            [
              'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunostoquimica', ['/inmunohistoquimica-escaneada/informe', 'id' => $model->inmunohistoquimicaEscaneada->id], [
                    'class'=>'btn btn-primary',
                    'role'=>'modal-remote',
                    'target'=>'_blank',
                    'data-toggle'=>'tooltip',
                    'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
                ]) ,
              'label'=> 'Documento',
              'format'=>'raw',
           ],
           [
             'value'=> $model->inmunohistoquimicaEscaneada->observacion ,
             'label'=> 'Observacion',
          ] ,

            ],
        ]) ;
      }
      else {
          echo "ESTA ACTIVA LA OPCIÓN IHQ PERO NO SE CARGO NINGÚN ESTUDIO";
      }

   ?>
   </div>
  <?
      }

        echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe biopsia', ['/biopsia/informe', 'id' => $model->id], [
              'class'=>'btn btn-dark',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);

    ?>
</div>
