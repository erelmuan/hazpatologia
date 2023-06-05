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
            'id_estudio_modelo',
            'modelo',
            'protocolo',
            'fechadeingreso',
            'pacientenomb:ntext',
            'pacienteapel:ntext',
            'tipo_documento',
            'num_documento',
            'procedencia',
            'estudio',
            'estado',
            'mediconomb:ntext',
            'medicoeapel:ntext',
        ],
    ]) ?>

</div>
