<?php
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitud',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'biopsia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pap',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ver_informe_solicitud',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ver_informe_estudio',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
