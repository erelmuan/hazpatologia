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
            'id_localidad',
            'paginaweb',
            'correoelectronico',
            'observaciones:ntext',

        ],
    ]) ?>

</div>
