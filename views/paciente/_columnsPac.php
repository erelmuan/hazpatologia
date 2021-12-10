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
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'num_documento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sexo',
    ],
    [
      //nombre
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
      'value'=>'fecha_nacimiento',
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
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'Direccion',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'localidad',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'CP',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'telefono',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'Afiliado',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'OS',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'Plan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'Notas',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'Ult_Fecha',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eiminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
