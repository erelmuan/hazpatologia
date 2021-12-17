<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
///////////////////
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\TypeaheadBasic;
///////////////
///////////////
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
//////////////
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Inmunohistoquimica */
/* @var $form yii\widgets\ActiveForm */
CrudAsset::register($this);

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);

?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA INMUNOHISTOQUIMICA" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR INMUNOHISTOQUIMICA" ; ?> </h2>
  <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
  <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
  </ul>
  <div class="x_panel" >

  <legend class="text-info"><small>Datos de la solicitud</small></legend>
  <div class="x_content" style="display: block;">
  <?
  echo Form::widget([ // fields with labels
    //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
      'model'=>$model,
      'form'=>$form,
       'columns'=>5,
       'attributes'=>[
       'Protocolo'=>['label'=>'Protocolo', 'options'=>['value'=>$model->biopsia->solicitudbiopsia->protocolo ,'readonly'=> true ],'columnOptions'=>['class'=>'col-dm-1',],],
       'Paciente'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Paciente', ['paciente/view' ,'id'=> $model->biopsia->solicitudbiopsia->id_paciente],
         ['role'=>'modal-remote','title'=> 'Ver paciente']), 'options'=>['value'=>$model->biopsia->solicitudbiopsia->paciente->apellido." ". $model->biopsia->solicitudbiopsia->paciente->nombre ,'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
       'DNI'=>['label'=>'DNI', 'options'=>['value'=>$model->biopsia->solicitudbiopsia->paciente->num_documento, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
       'Edad'=>['label'=>'Edad', 'options'=>['value'=>$edadDelPaciente, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],
       'Medico'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Medico', ['medico/view' ,'id'=> $model->biopsia->solicitudbiopsia->id_medico],
        ['role'=>'modal-remote','title'=> 'Ver medico']), 'options'=>['value'=>$model->biopsia->solicitudbiopsia->medico->apellido ." ". $model->biopsia->solicitudbiopsia->medico->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
       'id_solicitudbiopsia'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$model->biopsia->solicitudbiopsia->id ]],

      ]
  ]);

    // echo '<div class="text-right" style="margin-right: 100px;">' . Html::resetButton('Limpiar', ['class'=>'btn btn-warning']) . '</div>';

?>
</div>
</div>

<legend class="text-info"><small style="margin-left: 18px;">Datos del estudio Inmunostoquimica</small></legend>

<div class="inmunohistoquimica-form">
    <?= $form->field($model, 'microscopia')->textarea(['style'=>'width: 570px; height: 100px;'  ]) ?>
    <?= $form->field($model, 'diagnostico')->textarea(['style'=>'width: 570px; height: 100px;']) ?>
    <?= $form->field($model, 'observacion')->textarea(['style'=>'width: 570px; height: 100px;']) ?>
    <?= $form->field($model, 'id_biopsia')->hiddenInput()->label(false); ?>
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <? if (!$model->isNewRecord){
               echo  Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Ir los informes',['/biopsia/view', 'id'=>$model->biopsia->id], ['class'=>'btn btn-success grid-button']);
            }
            ?>

        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
</div>
