<?php
use yii\helpers\Url;
use yii\widgets\MaskedInput;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
      'class'=>'\kartik\grid\DataColumn',
       'attribute' => 'fechadeingreso',
       'label'=> 'Fecha de ingreso',
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
        'label'=>'Paciente',
        'value' => function($model) {
          return $model->pacienteapel .', '.$model->pacientenomb;
         }
         ,
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
        'label'=>'Medico',
        'value' => function($model) {
          return $model->medicoeapel .', '.$model->mediconomb;
         }
         ,
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
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',

        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
         ],

];
