<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Firma */

?>
<div class="firma-create">
    <?= $this->render('_form', [
        'model' => $model,
        'searchModelUsu' => $searchModelUsu,
        'dataProviderUsu' => $dataProviderUsu,
        'imagen'=> $imagen,

    ]) ?>
</div>
