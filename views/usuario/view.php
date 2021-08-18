<?php

use yii\widgets\DetailView;

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
                'value'=> '<img src=uploads/avatar/'.$model->imagen.' width="75px" height="75px" style="margin-left: auto;margin-right: auto;;position:relative;" >',

                'format'=>'raw',

         ],

        ],
    ]) ?>

</div>
