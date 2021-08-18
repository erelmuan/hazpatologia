<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Metodoanticonceptivo */
?>
<div class="metodoanticonceptivo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
        ],
    ]) ?>

</div>
