<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipodoc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipodoc-form">

    <?php $form = ActiveForm::begin(); ?>
    <!--si existen pacientes asociados no se puede modificar el nombre  -->
    <? if($model->pacientes){
            echo  $form->field($model, 'documento')->input("text",['readonly' => true])->label('Documento');
          }else {
            echo  $form->field($model, 'documento')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Documento');
        }
    ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
