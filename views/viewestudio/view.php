<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Viewestudio */
?>
<div class="viewestudio-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_solicitud',
            'id_biopsia',
            'id_pap',
            'modelo',
            'protocolo',
            'fechadeingreso',
            'paciente:ntext',
            'tipo_documento',
            'num_documento',
            'procedencia',
            'estudio',
            'estado',
            'medico:ntext',
        ],
    ]) ?>

</div>
