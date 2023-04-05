<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsiacie10 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biopsiacie10-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_cie10')->dropDownList($model->getCie10s())->label('CIE 10') ;?>

    <?= $form->field($model, 'verificado')->checkbox() ?>

    <?= $form->field($model, 'id_usuario')->hiddenInput(['value'=>Yii::$app->user->identity->getId()])->label(false) ;?>

    <?= $form->field($model, 'usuario')->textInput(['value'=>($model->usuario)?$model->usuario->nombre:Yii::$app->user->identity->nombre, 'readOnly'=>true])->label("Usuario") ;?>


    <?= $form->field($model, 'id_biopsia')->hiddenInput()->label(false) ;?>

    <?= $form->field($model, 'biopsia')->textInput(['value'=>($model->biopsia)?$model->biopsia->diagnostico:'sds', 'readOnly'=>true])->label("Diagnóstico") ;?>

    <?= $form->field($model, 'id_estudio')->hiddenInput()->label(false) ;?>

    <?= $form->field($model, 'estudio')->textInput(['value'=>'', 'readOnly'=>true])->label("Estudio") ;?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
