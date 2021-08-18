<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillapavimentosa */
?>
<div class="plantillapavimentosa-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'pavimentosa:ntext',
        ],
    ]) ?>

</div>
