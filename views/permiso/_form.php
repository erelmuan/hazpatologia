<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Permiso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="permiso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_rol')->textInput() ?>

    <?= $form->field($model, 'id_modulo')->textInput() ?>

    <?= $form->field($model, 'id_accion')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
