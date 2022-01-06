<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AnioProtocolo */
/* @var $form yii\widgets\ActiveForm */
?>
<div id="w0" class="x_panel">
  <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= $model->isNewRecord ? "" :Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/anio-protocolo/index'], ['class'=>'btn btn-danger grid-button']) ?></div>

<div class="anio-protocolo-form">

    <?php $form = ActiveForm::begin(); ?>
    <? if($model->estudios()){
                echo  $form->field($model, 'anio')->input("text",['readonly' => true])->label('Nombre');
              }else {
                echo  $form->field($model, 'anio')->input("text",['style'=> 'width:100%; text-transform:uppercase;'])->label('Nombre');
              }
            ?>
    <? if (!$model->isNewRecord){
    echo $form->field($model, 'activo')->checkbox(['readOnly' => true]); }?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
</div>
