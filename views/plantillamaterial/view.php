<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillamaterialb */
?>
<div class="plantillamaterialb-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'material',
            'materialdiagnostico',
        ],
    ]) ?>

</div>
