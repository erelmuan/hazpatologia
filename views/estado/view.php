<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estado */
?>
<div class="estado-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'solicitud:boolean',
            'biopsia:boolean',
            'pap:boolean',
            'ver_informe_solicitud:boolean',
            'ver_informe_estudio:boolean',
        ],
    ]) ?>

</div>
