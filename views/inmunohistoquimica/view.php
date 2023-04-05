<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inmunohistoquimica */
?>
<div class="inmunohistoquimica-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'microscopia:ntext',
            'diagnostico:ntext',
            'observacion:ntext',
            'id_biopsia',
        ],
    ]) ?>

</div>
