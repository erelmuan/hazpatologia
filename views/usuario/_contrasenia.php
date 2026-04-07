<?php
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrasenia-form-container">
    <div class="contrasenia-form">

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <p class="help-block" style="font-size: 10px !important;">
                <strong>Para establecer su contraseña:</strong><br>
                - Debe tener al menos 8 caracteres.<br>
                - Incluir al menos una letra mayúscula.<br>
                - Incluir al menos un número.<br>
                - Incluir al menos un caracter especial (! @ # $ % ^ & * - _ + =).<br>
                - Evitar usar palabras comunes o información personal.
            </p>
        </div>

        <!-- Campo para la contraseña actual -->
        <?= $form->field($model, 'pass_ctrl')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'toggleTitle' => 'Mostrar/Ocultar contraseña',
                'toggleMask' => true,
                'showMeter' => false,
            ],
        ]) ?>

        <!-- Campo para la nueva contraseña -->
        <?= $form->field($model, 'pass_new')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'toggleTitle' => 'Mostrar/Ocultar contraseña',
                'toggleMask' => true,
                'showMeter' => false,
            ],
        ]) ?>

        <!-- Campo para la confirmación de la nueva contraseña -->
        <?= $form->field($model, 'pass_new_check')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'toggleTitle' => 'Mostrar/Ocultar contraseña',
                'toggleMask' => true,
                'showMeter' => false,
            ],
        ]) ?>

        <?php if (!Yii::$app->request->isAjax): ?>
            <?= Html::button('Confirmar', ['class' => 'btn btn-primary', 'id'=> 'submit-btn', 'type' => "submit"]) ?>
        <?php endif; ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
