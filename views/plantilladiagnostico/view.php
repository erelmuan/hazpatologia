<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantilladiagnostico */
?>
<div class="plantilladiagnostico-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'diagnostico:ntext',
            [
                'value'=> $model->estudio->descripcion ,
                'label'=> 'Estudio',
             ],
             [
                 'value'=> $model->cie10->codigo ,
                 'label'=> 'CODIGO CIE10',
              ],
        ],
    ]) ?>

</div>
