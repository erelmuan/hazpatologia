<?php
use yii\helpers\Url;

return [


     [
       'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'id',
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'explicacion',
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
