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
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'explicacion',
    ],
    [
        'class' => MyActionColumn::class,
        'dropdown' => false,
        'template' => '{view}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
