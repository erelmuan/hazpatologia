<?php
use yii\helpers\Url;

return [

    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'create',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'delete',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'update',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'view',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
