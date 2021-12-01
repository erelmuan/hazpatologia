<?php
use yii\helpers\Url;

return [


        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'anio',
        'label'=> "Año"
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'activo',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Año protocolo',
                          'data-confirm-message'=>'¿ Desea borrar este registro ?'],
    ],

];
