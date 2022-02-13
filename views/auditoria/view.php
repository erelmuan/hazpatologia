<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Auditoria */
?>
<div class="auditoria-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',

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
            'accion',
            [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'registro',
            ],
            'tabla',
            'fecha',
            'hora',
            'ip',
            'informacion_usuario',

            [
              'attribute'=>'cambios',
                'label'=>'Cambios',
                'format'=>'raw',
         ],
        ],
    ]) ?>

</div>
