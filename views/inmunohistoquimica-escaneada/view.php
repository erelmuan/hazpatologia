<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InmunohistoquimicaEscaneada */
?>
<div class="inmunohistoquimica-escaneada-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'documento',
            'id_biopsia',
            'observacion:ntext',
        ],
    ]) ?>

</div>
