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
        'label'=>'Paciente',
        'value' => function($model) {
          return $model->paciente->nombre .' '.$model->paciente->apellido;
         }
         ,
    ],
  

    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Procedencia',
        'attribute'=>'procedencia',
        'value'=>'procedencia.nombre',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Medico',
        'value' => function($model) {
          return $model->medico->nombre .' '.$model->medico->apellido;
         }
         ,
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

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'estudio',
        'label' => 'Estudio',
        'value' => 'estudio.descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'estado',
        'label' => 'Estado',
        'value' => 'estado.descripcion',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view,update}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],

    ],

];
