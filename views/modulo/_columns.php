<?php
use yii\helpers\Url;

return [

        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
      'class'=> '\kartik\grid\DataColumn',
      'label'=> 'Tipo de acceso',
      'attribute'=>'tipo_acceso',
      'value'=>'tipoAcceso.nombre',
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
