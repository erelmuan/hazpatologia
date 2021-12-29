<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Procedencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procedencia-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if($model->estudios()){
                echo  $form->field($model, 'nombre')->input("text",['readonly' => true])->label('Nombre');
              }else {
                echo  $form->field($model, 'nombre')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre');
              }
            ?>
    <?= $form->field($model, 'contacto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
