<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Obrasocial */
?>
<div class="obrasocial-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sigla',
            'denominacion',
            'direccion',
            'telefono',
            [
            'value'=> ($model->localidad)?$model->localidad->nombre:'No definido',
            'label'=> 'Localidad',
           ],
            'paginaweb',
            'correoelectronico',
            'observaciones:ntext',

        ],
    ]) ?>

</div>
