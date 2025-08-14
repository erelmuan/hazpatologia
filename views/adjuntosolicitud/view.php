<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Adjuntosolicitud */
?>
<div class="adjuntosolicitud-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre_asignado',
            'nombre_archivo',
            'observacion',
        ],
    ]) ?>

</div>
