<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoAcceso */
?>
<div class="tipo-acceso-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
        ],
    ]) ?>

</div>
