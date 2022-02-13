<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Tipodoc;

return [
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
        'attribute'=>'apellido',
    ],

    [
        'attribute' => 'tipodoc',
        'label' => 'Tipo documento',
        'value' => function($model) {
            return $model->tipodoc->documento;
        },

        'filter'=>ArrayHelper::map(Tipodoc::find()->all(), 'id','documento'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'options' => ['prompt' => ''],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'num_documento',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hc',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'sexo',
    // ],
    [
      //nombre
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'fecha_nacimiento',
      'label'=> 'Fecha de nacimiento',
      'value'=>'fecha_nacimiento',
      'format' => ['date', 'd/M/Y'],
      'filterInputOptions' => [
          'id' => 'fecha1',
          'class' => 'form-control',
          'autoclose'=>true,
          'format' => 'dd/mm/yyyy',
          'startView' => 'year',
          'placeholder' => 'd/m/aaaa'

      ]
    ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'idprovincia',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'idlocalidad',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'direccion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cp',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'telefono',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'email',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'afiliado',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'os',
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },

    ],

];
