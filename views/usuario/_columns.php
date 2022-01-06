<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Pantalla;
return [
      [
        'class' => '\kartik\grid\ExpandRowColumn',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
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
        'attribute'=>'usuario',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
          'label'=> 'Contraseña',

          'value' => function($dataProvider,  $widget) {
            return Html::a('Resetear Contraseña', [ "usuario/index","id"=> $dataProvider->id]

            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Sugerencia:ingrese 123','data-toggle'=>'tooltip'

           ]);

           }
           ,

           'filterInputOptions' => ['placeholder' => 'Ingrese Dni o apellido'],
           'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'activo',
        'format'=>'boolean',

    ],
    [
        'attribute' => 'pantalla',
        'label' => 'Pantalla',
        'value' => function($model) {
            if ($model->pantalla)
              return $model->pantalla->descripcion;
            else {
              return "No definido";
            }
        },

        'filter'=>ArrayHelper::map(Pantalla::find()->all(), 'id','descripcion'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
