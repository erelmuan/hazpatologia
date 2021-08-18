<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */
?>
<div class="procedencia-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'contacto',
            'direccion', 
        ],
    ]) ?>

</div>
