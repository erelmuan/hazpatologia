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
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],

    ],

];
