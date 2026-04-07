<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\grid\MyActionColumn;
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
        'class' => MyActionColumn::class,
        'updateOptions'=>[
            'title' => 'Actualizar',
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-primary btn-circle btn-sm',
            'icon' => "<i class='fas fa-pen'></i>", // 👈 solo ícono
        ],
    ],

];
