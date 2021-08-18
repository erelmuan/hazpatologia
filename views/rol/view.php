<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */
?>
<div class="rol-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion:ntext',
        ],
    ]) ?>

</div>
