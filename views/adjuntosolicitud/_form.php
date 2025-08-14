
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adjuntosolicitud */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adjuntosolicitud-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_asignado')->textInput() ?>

    <?= $form->field($model, 'nombre_archivo')->textInput(['readOnly'=>true]) ?>

    <?= $form->field($model, 'baja_logica')->hiddenInput(['value' => 0])->label(false) ?>

    <?= $form->field($model, 'id_solicitud')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'observacion')->textInput() ?>


    <?php if (!Yii::$app->request->isAjax){ ?>
          <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
