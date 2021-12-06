<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
      'attribute'=>'imagen',
        'label'=>'Imagen',
        'value' => function($model) {
            return '<img src=uploads/avatar/'.$model->imagen.' width="90px" height="90px" style="margin-left: auto;margin-right: auto;;position:relative;" >';
          },
        'format'=>'raw',

 ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usuario.usuario',
        'width' => '170px',
        'value' => function($model) {

          return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
           );

         }
         ,

         'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
         'format' => 'raw',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
