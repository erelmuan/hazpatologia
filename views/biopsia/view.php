<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsia */
$isAjax = Yii::$app->request->isAjax;

?>
<div class="biopsia-view">
    <div id="w0" >
        <?  if (!$isAjax) { ?>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a biopsias', ['/biopsia/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
        <? } ?>
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
           'value'=>$model->solicitudbiopsia->calcular_edad(),
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
          'format' => ['date', 'php:d/m/Y'],

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
    <?php if ($model->ihq ):?>
    <div id="w0ss" class="x_panel">
    <div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO INMUNOHISTOQUIMICA  </h2>
      <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
    </div>
    </div>
    <?php  if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)){
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [

            [
              'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunostoquimica', ['/inmunohistoquimica-escaneada/informe', 'id' => $model->inmunohistoquimicaEscaneada->id], [
                    'class'=>'btn btn-primary',
                    'target'=>'_blank', // Abrir en nueva pestaña
                    'data-toggle'=>'tooltip',
                    'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña',
                    'data-pjax' => '0' // Evitar el manejo de PJAX
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

 <?php  endif   ?>


<?php  if (isset($model->informeComplementario) &&  !$model->informeComplementario->estaAnulado()): ?>
<div id="w0ss" class="x_panel">
<div class="x_title"><h2><i class="fa fa-table"></i> INFORME COMPLEMENTARIO  </h2>
  <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
</div>
</div>
<?php
  if ($model->informeComplementario->estaListo()){
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [

        [
          'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe complementario', ['/informe-complementario/documento-pdf', 'id' => $model->informeComplementario->id], [
                'class'=>'btn btn-primary',
                'target'=>'_blank', // Abrir en nueva pestaña
                'data-toggle'=>'tooltip',
                'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña',
                'data-pjax' => '0' // Evitar el manejo de PJAX
            ]) ,
          'label'=> 'Informe complementario',
          'format'=>'raw',
       ],
       [
         'value'=> $model->informeComplementario->descripcion ,
         'label'=> 'Descripciòn',
      ] ,

        ],
    ]) ;
  }else {
    echo "EL INFORME COMPLEMENTARIO NO ESTA LISTO.";

  }

?>
</div>

<?php  endif   ?>



<?php

       echo Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe de biopsia', ['/biopsia/informe', 'id' => $model->id], [
              'class'=>'btn btn-dark',
              'target'=>'_blank',
              'data-toggle'=>'tooltip',
              'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
          ]);

    ?>
</div>
