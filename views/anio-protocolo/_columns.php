<?php
use yii\helpers\Url;
use app\components\grid\MyActionColumn;
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
        'class' => MyActionColumn::class,
        'updateOptions'=>[
            'title' => 'Actualizar',
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-primary btn-circle btn-sm',
            'icon' => "<i class='fas fa-pen'></i>", // 👈 solo ícono
        ],
    ],

];
