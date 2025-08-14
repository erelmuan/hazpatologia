<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permiso */
?>
<div class="permiso-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'class'=>'\kartik\grid\DataColumn',
              'width' => '170px',
              'attribute'=>'rol.nombre',
              'label'=>'Rol',
              'value' => function($model) {

                return Html::a($model->rol->nombre, ['rol/view',"id"=> $model->rol->id]

                   ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del rol','data-toggle'=>'tooltip']
                 );

               }
               ,
               'format' => 'raw',
            ],
            [
              'class'=>'\kartik\grid\DataColumn',
              'width' => '170px',
              'attribute'=>'modulo.nombre',
              'label'=>'Modulo',

              'value' => function($model) {

                return Html::a($model->modulo->nombre, ['modulo/view',"id"=> $model->modulo->id]

                   ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del modulo','data-toggle'=>'tooltip']
                 );

               }
               ,

               'format' => 'raw',
            ],

            [
              'attribute' => ($model->accion)?'Acciones':"Acceso",
                  'format'    => 'html',
                  'value'     => call_user_func(function($model)
                  {
                    $items = "";
                    if($model->accion){
                      $items .= "Crear: <b>".(($model->accion->create)?"verdadero":"falso")." </b><br>";
                      $items .= "Eliminar: <b>".(($model->accion->delete)?"verdadero":"falso")." </b><br>";
                      $items .= "Actualizar: <b>".(($model->accion->update)?"verdadero":"falso")." </b><br>";
                      $items .= "Ver: <b>".(($model->accion->view)?"verdadero":"falso")." </b><br>";

                    }else {
                      $items .= "<b>".$model->modulo->tipoAcceso->nombre."</b><br>";

                    }

                      return $items;
                  }, $model)

            ],
        ],
    ]) ?>

</div>
