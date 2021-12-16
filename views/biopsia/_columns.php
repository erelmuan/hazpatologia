<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'id',
    // ],
    [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'idsolicitud',
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'solicitud.protocolo',
        'attribute' => 'protocolo',
        'value' => 'solicitudbiopsia.protocolo',
        'width' => '50px',
    ],
    [
        //nombre
        'class'=>'\kartik\grid\DataColumn',
        'label'=> 'Paciente',
        'width' => '170px',
        //creo que no hacer falta ni key ni indez tampoco widget
        'value' => function($dataProvider, $key, $index, $widget) {
            $key = str_replace("[","",$key);
            $key = str_replace("]","",$key);
          return Html::a( $dataProvider->solicitudbiopsia->paciente->nombre .' '.$dataProvider->solicitudbiopsia->paciente->apellido,['paciente/view',"id"=> $dataProvider->solicitudbiopsia->paciente->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido'],
         'format' => 'raw',

    ],
    [
      'class'=>'\kartik\grid\DataColumn',
      'value'=> 'solicitudbiopsia.paciente.fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
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
        //nombre
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'solicitud.medico.nombre',
        // 'label'=> 'Medico'
        [
            //nombre
            'class'=>'\kartik\grid\DataColumn',
            'label'=> 'Medico',
            'width' => '170px',
            'value' => function($model, $key, $index, $widget) {
                $key = str_replace("[","",$key);
                $key = str_replace("]","",$key);
                //var_dump ($key);
              return Html::a( $model->solicitudbiopsia->medico->nombre .' '.$model->solicitudbiopsia->medico->apellido,['paciente/view',"id"=> $model->solicitudbiopsia->medico->id]

                ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
               );

             }
             ,

             'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido'],
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
        'attribute'=>'id_plantilladiagnostico',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diagnostico',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'observacion',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_estado',
        'value' => 'estado.descripcion',
        'label'=> 'Estado',

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechalisto',
        'format' => ['date', 'd/M/Y'],
    ],

];
