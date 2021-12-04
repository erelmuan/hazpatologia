<?php
use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\RadioColumn',
        'width' => '20px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'hidden' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario',
    ]


];
