<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Auditoria */
?>
<div class="auditoria-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_usuario',
            'accion',
            'tabla',
            'fecha',
            'hora',
            'ip',
            'informacion_usuario',

            [
              'attribute'=>'cambios',
                'label'=>'Cambios',
                'format'=>'raw',
         ],
        ],
    ]) ?>

</div>
