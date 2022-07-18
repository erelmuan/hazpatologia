<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'biopsia.id',
    ],
    [
        'attribute' => 'protocolo',
        'value' => 'solicitudbiopsia.protocolo',
        'width' => '50px',
    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Paciente',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->solicitudbiopsia->paciente->nombre .' '.$model->solicitudbiopsia->paciente->apellido,['paciente/view',"id"=> $model->solicitudbiopsia->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'DNI o apellido'],
         'format' => 'raw',

    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'value'=> 'solicitudbiopsia.paciente.fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
      'format' => ['date', 'd/M/Y'],

   ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudbiopsia.paciente.sexo',
        'label'=> 'Sexo'

    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudbiopsia.procedencia.nombre',
        'label'=> 'Procedencia'

    ],
      [
            'class'=>'\kartik\grid\DataColumn',
            'label'=> 'Medico',
              'width' => '185px',
            'value' => function($model) {
              return Html::a( $model->solicitudbiopsia->medico->nombre .' '.$model->solicitudbiopsia->medico->apellido,['paciente/view',"id"=> $model->solicitudbiopsia->medico->id]

                ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
               );

             }
             ,

             'filterInputOptions' => ['placeholder' => 'matricula o apellido'],
             'format' => 'raw',

    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'material',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'macroscopia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'microscopia',
    ],
    [
        'class'=>'\kartik\grid\BooleanColumn',
        'attribute'=>'ihq',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
    ],

    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'observacion',
    // ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_estado',
        'value' => 'estado.descripcion',
        'label'=> 'Estado',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Fecha de ingreso',
        'value' => 'solicitudbiopsia.fechadeingreso',
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
          return $model->solicitudbiopsia->calcular_edad(); },
        'label'=> 'Edad al momento del estudio(años)',

    ]

];
