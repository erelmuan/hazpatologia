<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estudiocie10 */
?>
<div class="estudiocie10-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_cie10',
            'verificado:boolean',
            'id_usuario',
            'id_estudio',
        ],
    ]) ?>

</div>
