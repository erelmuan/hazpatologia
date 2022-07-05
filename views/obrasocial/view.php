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
            'paginaweb',
            'correoelectronico',
            'observaciones:ntext',
             'codigo',

        ],
    ]) ?>

</div>
