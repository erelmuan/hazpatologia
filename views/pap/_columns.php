<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],

    [
        'attribute' => 'protocolo',
        'value' => 'solicitudpap.protocolo',
        'width' => '50px',
    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Paciente',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->solicitudpap->paciente->apellido .', '.$model->solicitudpap->paciente->nombre,['paciente/view',"id"=> $model->solicitudpap->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'DNI o apellido'],
         'format' => 'raw',

    ],

    [
      'class'=>'\kartik\grid\DataColumn',
      'value'=> 'solicitudpap.paciente.fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
      'format' => ['date', 'd/M/Y'],

   ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudpap.paciente.sexo',
        'label'=> 'Sexo'

    ],

    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudpap.procedencia.nombre',
        'label'=> 'Procedencia'

    ],
    [
          'class'=>'\kartik\grid\DataColumn',
          'label'=> 'Medico',
            'width' => '185px',
          'value' => function($model) {
            return Html::a( $model->solicitudpap->medico->apellido .', '.$model->solicitudpap->medico->nombre,['paciente/view',"id"=> $model->solicitudpap->medico->id]

              ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
             );

           }
           ,

           'filterInputOptions' => ['placeholder' => 'matricula o apellido'],
           'format' => 'raw',

  ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_calificacion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'calificacion',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'flora',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'aspecto',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pavimentosas',
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'glandulares',
     ],

     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'id_estado',
         'value' => 'estado.descripcion',
         'label'=> 'Estado',

     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'label'=> 'Fecha de ingreso',
         'value' => 'solicitudpap.fechadeingreso',
         'format' => ['date', 'd/M/Y'],
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'label'=> 'Fecha de informe listo',
         'attribute'=>'fechalisto',
         'format' => ['date', 'd/M/Y'],
     ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'edad',
        'value'=>function($model) {
          return $model->solicitudpap->calcular_edad(); },
        'label'=> 'Edad al momento del estudio(años)',

    ],


];
