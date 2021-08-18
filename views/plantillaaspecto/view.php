<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillaaspecto */
?>
<div class="plantillaaspecto-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'aspecto:ntext',
        ],
    ]) ?>

</div>
