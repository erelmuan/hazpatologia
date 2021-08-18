<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
?>
<div class="solicitud-update">

    <?= $this->render('_form', [
        'model' => $model,
        'searchModelPac' => $searchModelPac,
        'dataProviderPac' => $dataProviderPac,
        'modelPac' => $modelPac,
        'searchModelMed' => $searchModelMed,
        'dataProviderMed' => $dataProviderMed,
        'modelMed' => $modelMed,
    ]) ?>

</div>
