<?php
use yii\helpers\Url;
use app\components\grid\MyActionColumn;
return [

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class' => MyActionColumn::class,
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'visibleButtons' => [
           'view' => function ($model, $key, $index) {
               // Aquí se verifica si el ID del modelo es 1
               return $model->id != 1;
           },
           'update' => function ($model, $key, $index) {
               // Aquí se verifica si el ID del modelo es 1
               return $model->id != 1;
           },
           'delete' => function ($model, $key, $index) {
               // Aquí se verifica si el ID del modelo es 1
               return $model->id != 1;
           },
       ],

    ],

];
