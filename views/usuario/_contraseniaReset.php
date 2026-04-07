<?php
use yii\widgets\ActiveForm;
//
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrasenia-form">

    <?php $form = ActiveForm::begin(); ?>
    <p class="help-block" style="font-size: 10px !important;">
        <strong>Para establecer su contraseña:</strong><br>
        - Debe tener al menos 8 caracteres.<br>
        - Incluir al menos una letra mayúscula.<br>
        - Incluir al menos un número.<br>
        - Incluir al menos un caracter especial (! @ # $ % ^ & * - _ + =).<br>
        - Evitar usar palabras comunes o información personal.
    </p>
    <?= $form->field($model, 'pass_new')->widget(PasswordInput::classname(), [
        'pluginOptions' => [
            'toggleTitle' => 'Mostrar/Ocultar contraseña',
            'toggleMask' => true,
            'showMeter' => false,
        ],
    ]) ?>
    <?php ActiveForm::end(); ?>

</div>
