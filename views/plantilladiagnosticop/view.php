<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantilladiagnosticop */
?>
<div class="plantilladiagnosticop-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'diagnostico:ntext',
        ],
    ]) ?>

</div>
