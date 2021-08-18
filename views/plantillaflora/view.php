<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillaflora */
?>
<div class="plantillaflora-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'flora:ntext',
        ],
    ]) ?>

</div>
