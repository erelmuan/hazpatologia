<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillamacroscopia */
?>
<div class="plantillamacroscopia-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'macroscopia:ntext',
        ],
    ]) ?>

</div>
