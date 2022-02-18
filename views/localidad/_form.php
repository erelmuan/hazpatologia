<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Provincia;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Localidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="localidad-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'id_provincia')->dropDownList(ArrayHelper::map(Provincia::find()->all(), 'id','nombre'))->label('Provincia') ;?>

    <!--si existen pacientes asociados no se puede modificar el nombre  -->
    <? if($model->pacientes){
            echo  $form->field($model, 'nombre')->input("text",['readonly' => true])->label('Nombre');
          }else {
            echo  $form->field($model, 'nombre')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre');
        }
    ?>

    <?= $form->field($model, 'codigopostal')->textInput() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
