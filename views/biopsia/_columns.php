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
        'value' => 'solicitudbiopsia.protocolo',
        'width' => '50px',
    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'value'=> 'solicitudbiopsia.paciente.fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
      'format' => ['date', 'php:d/m/Y'],

   ],

    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Nombre y apellido',
        'width' => '170px',
        'value' => function($model) {
          return Html::a( $model->solicitudbiopsia->paciente->nombre.', '. $model->solicitudbiopsia->paciente->apellido ,['paciente/view',"id"=> $model->solicitudbiopsia->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'DNI o apellido'],
         'format' => 'raw',
         'contentOptions' => ['style' => 'white-space: nowrap;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Fecha de informe listo',
        'attribute'=>'fechalisto',
        'format' => ['date', 'php:d/m/Y'],
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Lugar de origen de paciente',
        'value' => function ($model) {
            // Accedemos al primer domicilio si existe
            $primerDomicilio = $model->solicitudbiopsia->paciente->domicilios[0] ?? null;

            // Si existe el domicilio y tiene localidad, devolvemos el nombre
            return $primerDomicilio && $primerDomicilio->localidad
                ? $primerDomicilio->localidad->nombre
                : 'Sin especificar';
        },
    ],

    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudbiopsia.paciente.num_documento',
        'label'=> 'Documento'

    ],

    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'solicitudbiopsia.paciente.sexo',
        'label'=> 'Sexo'

    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'material',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
    ],

    [
      'class' => '\kartik\grid\DataColumn',
      'label' => 'Procedencia',
      'value' => function ($model) {
          // Accedemos de forma segura a la procedencia
          $procedencia = $model->solicitudbiopsia->procedencia ?? null;
          if (!$procedencia) {
              return 'Sin especificar';
          }
          // Evaluamos si el tipo es Hospitalaria (ajusta 'Hospitalaria' al valor exacto de tu BD)
          if ($procedencia->tipoprocedencia === 'Hospitalaria') {
              return 'HOSPITAL ZATTI';
          }
          // Si no es Hospitalaria, devuelve el nombre de la procedencia
          return $procedencia->nombre;
      },
      ],

      [
            'class'=>'\kartik\grid\DataColumn',
            'label'=> 'Medico',
              'width' => '185px',
            'value' => function($model) {
              return Html::a( $model->solicitudbiopsia->medico->apellido .', '.$model->solicitudbiopsia->medico->nombre,['paciente/view',"id"=> $model->solicitudbiopsia->medico->id]

                ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
               );

             }
             ,

             'filterInputOptions' => ['placeholder' => 'matricula o apellido'],
             'format' => 'raw',
             'contentOptions' => ['style' => 'white-space: nowrap;'],
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
        'trueLabel' => 'Sí',
        'falseLabel' => 'No',
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
        'format' => ['date', 'php:d/m/Y'],
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'edad',
        'value'=>function($model) {
          return $model->solicitudbiopsia->calcular_edad(); },
        'label'=> 'Edad al momento del estudio(años)',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario',
        'label'=> 'Patólogo',
        'value'=>'usuario.nombre'
    ],

];
