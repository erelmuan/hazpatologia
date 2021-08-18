<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Provincia */
?>
<div class="provincia-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'codigo',
        ],
    ]) ?>

</div>
