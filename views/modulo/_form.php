<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use nex\chosen\Chosen;
use app\models\TipoAcceso;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Modulo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modulo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:lowercase;']) ?>
    <? $mapacceso = ArrayHelper::map(TipoAcceso::find()->all() , 'id',  'nombre'  ); ?>

    <?

    echo $form->field($model, 'id_tipo_acceso')->widget(
      Chosen::className(), [
       'items' => $mapacceso,
        'placeholder' => 'Selecciona una opción',
       'clientOptions' => [
         'language' => 'es',
         'rtl'=> true,
           'search_contains' => true,
           'single_backstroke_delete' => false,
       ],])->label("Tipo de acceso"); ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
