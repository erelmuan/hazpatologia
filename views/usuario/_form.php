<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuario')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;']) ?>

    <?= $form->field($model, 'contrasenia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;']) ?>

    <?= $form->field($model, 'activo')->checkbox()  ?>

   <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

   <?= $form->field($model, 'id_pantalla')->dropDownList($model->getPantallas())->label('Pantallas') ;?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
