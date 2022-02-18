<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Medico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medico-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if($model->estudios()){ ?>
      <span style="color:red">  Advertencia: La modificacion del nombre o apellido impactara en todos los estudios donde se registro al medico <b>(NO CAMBIE LA IDENTIDAD DEL MISMO)</b>.</span>
    <? } ?>
    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tipodoc')->dropDownList($model->getTipodocs())->label('Tipo de documento') ;?>

    <?= $form->field($model, 'num_documento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'matricula')->textInput() ?>

    <?= $form->field($model, 'id_tipoprofesional')->dropDownList($model->getTipoprofesionales())->label('Profesion') ;?>



	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
