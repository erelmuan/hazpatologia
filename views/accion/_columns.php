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
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
