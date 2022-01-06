<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '170px',
        'attribute'=>'usuario.usuario',

        'value' => function($model) {
          return $model->usuario->usuario;
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',

        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
