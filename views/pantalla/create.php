<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pantalla */

$this->title = Yii::t('app', 'Create Pantalla');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pantallas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pantalla-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
