<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Registrosesion */
?>
<div class="registrosesion-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_usuario',
            'inicio_sesion',
            'ip',
            'informacion_usuario',
            'cookie',
            'cierre_sesion',
        ],
    ]) ?>

</div>
