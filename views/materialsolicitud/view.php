<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Materialsolicitud */
?>
<div class="materialsolicitud-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'id_estudio',
        ],
    ]) ?>

</div>
