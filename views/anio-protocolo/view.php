<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AnioProtocolo */
?>
<div class="anio-protocolo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'anio',
            'activo:boolean',
            'id',
        ],
    ]) ?>

</div>
