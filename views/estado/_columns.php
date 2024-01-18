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
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'solicitud',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'biopsia',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'pap',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'ver_informe_solicitud',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'ver_informe_estudio',
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
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
