<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
      'attribute'=>'imagen',
        'label'=>'Imagen',
        'value' => function ($model) {
                 return Html::img(Yii::$app->urlManager->baseUrl . '/uploads/firmas/' . $model->imagen, ['width' => '75px', 'height' => '75px', 'style' => 'margin-left: auto; margin-right: auto; position: relative;']);
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
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],
        'options' => ['style' => 'width:7%'],

    ],

];
