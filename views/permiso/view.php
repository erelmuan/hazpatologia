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
              'attribute' => 'Acciones',
                  'format'    => 'html',
                  'value'     => call_user_func(function($model)
                  {
                    $items = "";
                      $index=($model->accion->index)?"verdadero":"falso";
                      $create=($model->accion->create)?"verdadero":"falso";
                      $delete=($model->accion->delete)?"verdadero":"falso";
                      $update=($model->accion->update)?"verdadero":"falso";
                      $listdetalle=($model->accion->listdetalle)?"verdadero":"falso";

                    $items .= "Index/Ver: <b>".$index." </b><br>";
                    $items .= "Crear: <b>".$create." </b><br>";
                    $items .= "Eliminar: <b>".$delete." </b><br>";
                    $items .= "Actualizar: <b>".$update." </b><br>";
                    $items .= "Ver listado: <b>".$listdetalle." </b><br>";

                      return $items;
                  }, $model)

            ],
        ],
    ]) ?>

</div>
