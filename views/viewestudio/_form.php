<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Viewestudio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="viewestudio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_solicitud')->textInput() ?>

    <?= $form->field($model, 'id_biopsia')->textInput() ?>

    <?= $form->field($model, 'id_pap')->textInput() ?>

    <?= $form->field($model, 'modelo')->textInput() ?>

    <?= $form->field($model, 'protocolo')->textInput() ?>

    <?= $form->field($model, 'fechadeingreso')->textInput() ?>

    <?= $form->field($model, 'paciente')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tipo_documento')->textInput() ?>

    <?= $form->field($model, 'num_documento')->textInput() ?>

    <?= $form->field($model, 'procedencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estudio')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'medico')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
