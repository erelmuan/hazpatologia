<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Usuariorol */
?>
<div class="usuariorol-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'class'=>'\kartik\grid\DataColumn',
                'width' => '170px',
                'attribute'=>'usuario.usuario',

                'value' => function($model) {

                  return Html::a($model->usuario->usuario, ['rol/view',"id"=> $model->usuario->id]

                    ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
                   );

                 }
                 ,

                 'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
                 'format' => 'raw',
            ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'width' => '170px',
                'label'=>'Rol',
                'value' => function($model) {

                  return$model->rol->nombre;

                 }
                 ,
                 'format' => 'raw',
            ],
        ],
    ]) ?>

</div>
