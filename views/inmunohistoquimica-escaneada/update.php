<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InmunohistoquimicaEscaneada */
?>
<div class="inmunohistoquimica-escaneada-update">

  <?= $this->render('_form', [
      'model' => $model,
      'edadDelPaciente'=>$edadDelPaciente
  ]) ?>

</div>
