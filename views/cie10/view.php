<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cie10 */
?>
<div class="cie10-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'codigo',
        ],
    ]) ?>

</div>
