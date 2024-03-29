<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Estudiocie10 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estudiocie10-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cie10')->textInput() ?>

    <?= $form->field($model, 'verificado')->checkbox() ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_estudio')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
