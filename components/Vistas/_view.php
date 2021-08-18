<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
?>
<div class="modelos-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
