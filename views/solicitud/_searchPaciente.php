
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SolicitudSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

#agregar{
  justify-content: center;
  width: auto;
  display: inline-block;
  top:5px;
   margin: auto;
     line-height: 100px;
     top: 200px;
     position:absolute;

}
#buscar{

  width: 500px;
  border: 1px;
     display: inline-block;

}
</style>

<div class="solicitud-searchMODIFICADO">
<div class="row">
   <div id="buscar">
      <?php $form = ActiveForm::begin([
            'id' => 'my-form-id',
          'action' => ['paciente/search'],
          'method' => 'get',
          'enableAjaxValidation' => false,
          'validationUrl' => 'validation-rul',
          'options' => [
              'data-pjax' => 1
          ],
      ]); ?>

      <?= $form->field($model, 'nombre')->input("text",['style'=>'width:60%'])->label('Paciente',['class'=>'label-class'])?>
      <?= $form->field($model, 'dni')->input("text",['style'=>'width:30%'])->label('DNI',['class'=>'label-class'])?>


      <div class="form-group">
          <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
          <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>
      </div>

      <?php ActiveForm::end(); ?>

   </div>
   <div id="agregar">

     <?   echo  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['paciente/create'],
      ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-default']); ?>
      <span> Agregar Paciente </span>
   </div>

</div>
</div>
