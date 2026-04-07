<?php
use yii\helpers\Url;
use app\components\grid\MyActionColumn;
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
        'attribute'=>'id_cie10',
        'value'=>'cie10.codigo',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'verificado',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_usuario',
        'value'=>'usuario.nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_biopsia',
        'value'=>'biopsia.diagnostico',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_estudio',
        'value'=>'estudio.descripcion',
    ],
    [
        'class' => MyActionColumn::class,
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],
];
