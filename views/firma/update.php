<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Firma */
?>
<div class="firma-update">

    <?= $this->render('_form', [
      'searchModelUsu' => $searchModelUsu,
      'dataProviderUsu' => $dataProviderUsu,
        'model' => $model,
    ]) ?>

</div>
