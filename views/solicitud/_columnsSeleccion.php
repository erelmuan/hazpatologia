<?php
use yii\helpers\Url;

return [
    [
        'class' => '\kartik\grid\RadioColumn',
        'width' => '20px',
        'radioOptions' => function ($model) {
                      return ['value' => $model->id];
                 }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'hidden' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'protocolo',
    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechadeingreso',
        'label'=> 'Fecha de ingreso',
        'value'=>'fechadeingreso',
        'format' => ['date', 'd/M/Y'],
        'filterInputOptions' => [
            'id' => 'fecha1',
            'class' => 'form-control',
            'autoclose'=>true,
            'format' => 'dd/mm/yyyy',
            'startView' => 'year',
            'placeholder' => 'd/m/aaaa'

        ]

    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'value' => function($model) { return $model->paciente->apellido  . " " . $model->paciente->nombre ;},
        'label'=>'Paciente'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'procedencia.nombre',
        'label'=> 'Procedencia'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value' => function($model) { return $model->medico->apellido  . " " . $model->medico->nombre ;},
        'label'=>'Medico'
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
        // 'attribute'=>'fechadeingreso',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'estudio',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value'=>'estado.descripcion',
        'label'=> 'estado',
        'filter'=> false,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
