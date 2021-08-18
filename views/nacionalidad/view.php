<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nacionalidad */
?>
<div class="nacionalidad-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'gentilicio',
            'pais',
        ],
    ]) ?>

</div>
