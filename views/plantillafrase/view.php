<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plantillafrase */
?>
<div class="plantillafrase-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'frase:ntext',
            [
            'value'=> $model->estudio->descripcion ,
            'label'=> 'Estudio',
             ],
        ],
    ]) ?>

</div>
