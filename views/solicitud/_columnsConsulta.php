<?php
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use yii\helpers\Html;
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
          return $model->paciente->apellido .', '.$model->paciente->nombre;
         }
         ,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'paciente.tipodoc.documento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'paciente.num_documento',
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
        'attribute' => 'estudio',
        'label' => 'Estudio',
        'contentOptions' => ['style' => 'font-weight:bold;'],
        'value' => 'estudio.descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'estado',
        'label' => 'Estado',
        'format' => 'raw',
         'value' => function ($model) {
             return '<div style="text-align:center;">' . $model->estado->descripcion . '</div>';
         },
         'contentOptions' => function ($model, $key, $index, $column) {
            switch($model->id_estado){
              case 1:
              $color =  'background-color:#2e99b3;';
              break;
              case 2:
              $color =  'background-color:#5dc271;';
              break;
              case 5:
              $color =  'background-color:#a4d149;';
              break;
            }
              return ['style' => $color .' text-align:center; font-weight:bold;','class' =>'badge badge-secondary',];
          },

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'buttons'=>[
          'view' => function ($url, $model, $key) {
            return Html::a(
              "Ver", ['solicitud/viewconsulta', 'id' => $model->id],
               ['data-pjax'=>"0",'role'=>'modal-remote',
               'title'=>"Ver",'class' => 'btn btn-primary', // Personaliza la clase del botón
]) ;
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
         ],

];
