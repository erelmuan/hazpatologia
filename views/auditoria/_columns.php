<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\grid\MyActionColumn;
return [

        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]
            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );
         }
         ,
         'filterInputOptions' => ['class' => 'form-control','placeholder' => 'Ingrese Dni,HC o nombre'],
         'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'accion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registro',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tabla',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hora',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ip',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'informacion_usuario',
    ],
    [
        'class' => MyActionColumn::class,
        'template' => '{view}',
    ],

];
