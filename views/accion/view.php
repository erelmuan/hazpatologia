<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Accion */
?>
<div class="accion-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'attribute'=>'index',
                'label'=>'Index',
                'format'=>'boolean',
              ],
            'create:boolean',
            'delete:boolean',
            'update:boolean',
            'export:boolean',
            'view:boolean',

        ],
    ]) ?>

</div>
