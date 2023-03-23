<?php
use yii\helpers\Url;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_solicitud',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
       'attribute'=>'id_estudio_modelo',
         ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'modelo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'protocolo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechadeingreso',
    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'pacientenomb',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'pacienteapel',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'tipo_documento',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'num_documento',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'procedencia',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'estudio',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'estado',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'mediconomb',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'medicoeapel',
  ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
