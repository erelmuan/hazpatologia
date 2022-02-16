<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Firma */
?>
<div class="firma-view">
  <div class="biopsia-view">
      <div id="w0s" class="x_panel">
        <div class="x_title"><h2><i class="fa fa-table"></i> FIRMA  </h2>


          <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a firmas', ['/firma/index'], ['class'=>'btn btn-danger grid-button']) ?></div>

      </div>
        </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'attribute'=>'imagen',
                'label'=>'Imagen',
                'value'=> '<img src=uploads/firmas/'.$model->imagen.' width="90px" height="90px" style="margin-left: auto;margin-right: auto;;position:relative;" >',

                'format'=>'raw',

         ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'usuario.usuario',
                'width' => '170px',
                'value' => function($model) {

                  return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]

                    ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
                   );

                 }
                 ,

                 'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
                 'format' => 'raw',
            ],

        ],
    ]) ?>

</div>
</div>
