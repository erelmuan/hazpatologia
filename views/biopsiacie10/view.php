<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsiacie10 */
?>
<div class="biopsiacie10-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
            'value'=> ($model->cie10)?$model->cie10->codigo:'No definido',
            'label'=> 'Código cie10',
            ],
            'verificado:boolean',
            [
            'value'=> $model->usuario->nombre,
            'label'=> 'Usuario',
            ],
            [
            'value'=> $model->biopsia->diagnostico,
            'label'=> 'Diagnostico',
            ],
            [
            'value'=> $model->estudio->descripcion,
            'label'=> 'Estudio',
            ],
        ],
    ]) ?>

</div>
