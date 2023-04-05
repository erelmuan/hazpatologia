<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
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
        'attribute'=>'microscopia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_biopsia',
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
