<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillatopografia */
?>
<div class="plantillatopografia-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'topografia:ntext',
        ],
    ]) ?>

</div>
