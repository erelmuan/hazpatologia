<?php
use yii\helpers\Url;
use kartik\grid\GridView;
return [
    [
      'class' => '\kartik\grid\ExpandRowColumn',
      'value' => function ($model) {
        //id=1 administrador
          if ($model->id ==1){
            return false;
            }
            else {
              return GridView::ROW_COLLAPSED;
            }

      },
      'detailUrl' => Url::to(['listdetalle']),   //  action mostrarDetalle con POST expandRowKey como ID
      'detailRowCssClass' => 'expanded-row',
      'expandIcon' => '<i class="glyphicon glyphicon-plus" style="color:black"></i>',
      'collapseIcon' => '<i class="glyphicon glyphicon-minus" style="color:black"></i>',
      'expandOneOnly' => true,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Rol',
                          'data-confirm-message'=>'Desea borrar este registro?'],
    ],


];
