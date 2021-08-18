<?php
use yii\helpers\Url;
use yii\widgets\MaskedInput;

return [

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'protocolo',
    ],
    [
      'class'=>'\kartik\grid\DataColumn',
       'attribute' => 'fechadeingreso',
       'format' => ['date', 'd/M/Y'],
       'filterInputOptions' => [MaskedInput::widget([
        'name' => 'input-31',
        'clientOptions' => [
        'alias' => 'date',
        'clearIncomplete' => true,
        ]
        ])],

   ],
   [
       'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'fecharealizacion',
       'format' => ['date', 'd/M/Y'],
   ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fechadeingreso',
    //    'exportMenuStyle' => ['numberFormat' => ['formatCode' => 'DD-MM-YYYY']] // formats a date
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Nombre Paciente',
        'attribute'=>'paciente.nombre',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Procedencia',
        'attribute'=>'procedencia',
        'value'=>'procedencia.nombre',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Nombre Medico',

        'attribute'=>'medico.nombre',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'idplantillamaterialb',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecharealizacion',
    // ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'estudio',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'estado',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'id_estudio',
        'label' => 'Estudio',
        'value' => 'estudio.descripcion',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'informe',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        // 'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Solicitud',
                          'data-confirm-message'=>'¿ Desea borrar este registro ?'],
    ],

];
