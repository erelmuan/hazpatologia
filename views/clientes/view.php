<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
?>
<div class="clientes-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numero',
            'nombres',
            'apellidos',
            'direccion',
            'telefono',
            'fecha_nacim',
            'nro_cuenta',
            'estado',
            'tipocliente',
        ],
    ]) ?>

</div>
