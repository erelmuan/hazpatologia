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
       ] ,
     //   [
     //    'value'=> $model->fechalisto ,
     //    'label'=> 'Fecha de listo',
     //    'format' => ['date', 'd/M/Y'],
     //
     // ],
        'frase',
      ],
  ]) ; ?>

  </div>
  <div id="w0ss" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO INMUNOHISTOQUIMICA  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
  </div>
  </div>
  <? if ($model->ihq){
  echo DetailView::widget([
      'model' => $model,
      'attributes' => [

       [
         'value'=> $model->inmunohistoquimica->microscopia ,
         'label'=> 'Microscopia',
      ],
      [
        'value'=> $model->inmunohistoquimica->diagnostico ,
        'label'=> 'Microscopia',
     ],
          'observacion:ntext',


      ],
  ]) ;
  }
 ?>
 </div>
<?
  if ($model->estado->descripcion== 'EN_PROCESO'){
    echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe biopsia', ['/biopsia/informe', 'id' => $model->id], [
          'class'=>'btn btn-dark',
          'role'=>'modal-remote',
          'target'=>'_blank',
          'data-toggle'=>'tooltip',
          'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
      ]);
      if ($model->ihq){
        echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunohistoquimica', ['/inmunohistoquimica/informe', 'id' => $model->inmunohistoquimica->id], [
              'class'=>'btn btn-Primary',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);
      }
    }
    else {
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe biopsia', ['/biopsia/informe', 'id' => $model->id], [
            'class'=>'btn btn-dark',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
        ]);
        if ($model->ihq){
          echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunohistoquimica', ['/inmunohistoquimica/informe', 'id' => $model->inmunohistoquimica->id], [
                'class'=>'btn btn-primary',
                'target'=>'_blank',
                'data-toggle'=>'tooltip',
                'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
            ]);
        }
    }


  ?>


</div>
