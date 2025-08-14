<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Materialsolicitud */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="materialsolicitud-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if($model->materialsolicitudSolicituds){ ?>
      <span style="color:red">  No se puede cambiar la descripcion y estudio porque ya están asocidados a una solicitud</b>.</span>
    <? } ?>
    <?= $form->field($model, 'descripcion')->textInput(['readonly' => !empty($model->materialsolicitudSolicituds)]); ?>
    <?= $form->field($model, 'id_estudio')->dropDownList(
            $model->getEstudios(),
            [
              'prompt' => 'Seleccione un estudio...',
              'disabled' => !empty($model->materialsolicitudSolicituds) // bloquea si tiene materiales asociados
            ]
        )
        ->label('Estudios') ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
