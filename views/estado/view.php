<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estado */
?>
<div class="estado-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'explicacion',
        ],
    ]) ?>

</div>
