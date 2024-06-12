<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="usuario-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'usuario',
            'nombre',
            'email:email',
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'activo',
                'format'=>'boolean',

            ],

            'descripcion:ntext',

            [
            'value'=> ($model->pantalla)?$model->pantalla->descripcion:'No definido',
            'label'=> 'Pantalla',
           ],
            [
              'attribute'=>'imagen',
              'label'=>'Imagen',
              'value' => function ($model) {
                       return Html::img(Yii::$app->urlManager->baseUrl . '/uploads/avatar/' . $model->imagen, ['width' => '75px', 'height' => '75px', 'style' => 'margin-left: auto; margin-right: auto; position: relative;']);
                   },
              'format'=>'raw',
         ],
         [
         'value'=> ($model->localidad)?$model->localidad->nombre:'No definido',
         'label'=> 'Localidad',
        ],
        [
        'value'=> ($model->localidad)?$model->localidad->provincia->nombre:'No definido',
        'label'=> 'Provincia',
       ],

        ],
    ]) ?>

</div>
