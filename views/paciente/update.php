<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paciente */
?>
<div class="paciente-update">

    <?= $this->render('_form', [
        'model' => $model,
        'provincias'=> $provincias,
        'localidades'=> $localidades,
        'obrasociales'=> $obrasociales,
        'valorObrasocial'=>$valorObrasocial,
        'afiliado'=>$afiliado,


    ]) ?>

</div>
