<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Papcie10 */
?>
<div class="papcie10-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_cie10',
            'verificado:boolean',
            'id_usuario',
            'id_pap',
            'id_estudio',
        ],
    ]) ?>

</div>
