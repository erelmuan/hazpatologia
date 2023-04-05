<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VphEscaneado */
?>
<div class="vph-escaneado-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'documento',
            'id_pap',
            'observacion:ntext',
            'nombre_archivo',
            'baja_logica:boolean',

        ],
    ]) ?>

</div>
