<?php
use yii\widgets\ActiveForm;
//
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrasenia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'pass_new')->passwordInput(['maxlength' => true]);?>

    <?php ActiveForm::end(); ?>

</div>
