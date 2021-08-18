<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
?>
<div class="localidad-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            // 'id_provincia',
          [
              'attribute'=>'provincia.nombre',
              'label'=> 'Provincia',
           ],

            'nombre',
            'codigopostal',
        ],
    ]) ?>

</div>
