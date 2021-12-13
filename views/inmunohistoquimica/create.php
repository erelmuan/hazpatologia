<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Inmunohistoquimica */

?>
<div class="inmunohistoquimica-create">
    <?= $this->render('_form', [
        'model' => $model,
        'edadDelPaciente'=>$edadDelPaciente
    ]) ?>
</div>
