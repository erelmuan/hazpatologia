<?php
use yii\helpers\Url;

return [

    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'index',
        'label'=>'Index/ver'
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'create',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'delete',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'update',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'export',
    // ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'listdetalle',
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
