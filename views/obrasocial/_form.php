<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Obrasocial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obrasocial-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--si existen pacientes asociados no se puede modificar el sigla  -->
    <? if($model->carnetOs){
            echo  $form->field($model, 'sigla')->input("text",['readonly' => true])->label('Nombre');
          }else {
            echo  $form->field($model, 'sigla')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Sigla');
        }
    ?>
    <!--si existen pacientes asociados no se puede modificar el denominacion  -->
    <? if($model->carnetOs){
            echo  $form->field($model, 'denominacion')->input("text",['readonly' => true])->label('Nombre');
          }else {
            echo  $form->field($model, 'denominacion')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Denominación');
        }
    ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?= $form->field($model, 'id_localidad')->textInput() ?>

    <?= $form->field($model, 'paginaweb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correoelectronico')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>



	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
