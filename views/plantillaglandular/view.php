<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillaglandular */
?>
<div class="plantillaglandular-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'glandular:ntext',
        ],
    ]) ?>

</div>
