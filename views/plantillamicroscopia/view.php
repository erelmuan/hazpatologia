<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillamicroscopia */
?>
<div class="plantillamicroscopia-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'microscopia:ntext',
        ],
    ]) ?>

</div>
