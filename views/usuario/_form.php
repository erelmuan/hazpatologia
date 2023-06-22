<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

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
   <div class="col-sm-4 pb-5">
     <?= $form->field($model, 'id_provincia')->dropDownList($provincias, ['id'=>'id_provincia',    'prompt'=>'- Seleccionar provincia'])->label('Provincia') ;?>
     <?//=  $form->field($model, 'id_provincia')->widget(Select2::classname(), ['data' => ArrayHelper::map(Provincia::find()->asArray()->all(), 'id', 'nombre')])->label('Provincia'); ?>

   </div>
   <div class="col-sm-4 pb-5">
 <?      echo $form->field($model, 'id_localidad')->widget(DepDrop::classname(), [
         'data'=> $localidades,
         'options'=>['id'=>'id_localidad'],
         'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
         'pluginOptions'=>[
           'depends'=>['id_provincia'],
            'placeholder'=>'Seleccionar localidad...',
            'url'=>Url::to(['/paciente/subcat'])
         ]
     ])->label('Localidad');

     ?>
 </div>

</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
