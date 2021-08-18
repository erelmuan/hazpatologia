<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoprofesional */
?>
<div class="tipoprofesional-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profesion',
        ],
    ]) ?>

</div>
