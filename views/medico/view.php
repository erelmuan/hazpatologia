<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */
?>
<div class="medico-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'apellido',
            'nombre',
            'tipodoc.documento',
            'num_documento',
            'matricula',
            'tipoprofesional.profesion',
        ],
    ]) ?>

</div>
