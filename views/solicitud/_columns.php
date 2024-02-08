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

    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Paciente',
        'value' => function($model) {
          return $model->paciente->apellido .', '.$model->paciente->nombre;
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
          return $model->medico->apellido .', '.$model->medico->nombre;
         }
         ,
    ],

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
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'edad',
        'value'=>function($model) {
          return $model->calcular_edad(); },
        'label'=> 'Edad al momento del estudio(años)',

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',

        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
