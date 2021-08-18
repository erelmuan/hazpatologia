
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitud-search">
    <?php $form = ActiveForm::begin([
        'id' => 'idmed',
        'action' => ['medico/search'],
        'method' => 'get',
        'options' => [
            'enctype' => 'multipart/form-data',
            'data-pjax' => true
        ],
    ]); ?>

    <?= $form->field($model, 'nombre')->input("text",['style'=>'width:30%'])->label('Nombre',['class'=>'label-class']) ?>
    <?= $form->field($model, 'dni')->input("text",['style'=>'width:30%'])->label('DNI',['class'=>'label-class']) ?>


    <div class="form-group">
       <?//= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
