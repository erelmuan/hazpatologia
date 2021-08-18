<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomuestra */
?>
<div class="tipomuestra-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion',
            'id',
        ],
    ]) ?>

</div>
