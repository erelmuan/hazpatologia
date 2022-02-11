<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\models\Usuario;

/* @var $this yii\web\View */
/* @var $model app\models\Inmunohistoquimica */
/* @var $form yii\widgets\ActiveForm */
?>

<?
$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'],'type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);
?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA INMUNOHISTOQUIMICA" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR INMUNOHISTOQUIMICA" ; ?> </h2>
  <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
  <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
  </ul>
  <div class="x_panel" >

  <legend class="text-info"><small>Datos del paciente</small></legend>
  <div class="x_content" style="display: block;">
    <?
    echo Form::widget([ // fields with labels
      //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
        'model'=>$model,
        'form'=>$form,
         'columns'=>5,
         'attributes'=>[
         'Paciente'=>['label'=> "Paciente" ,'options'=>['value'=>$model->biopsia->solicitudbiopsia->paciente->apellido." ". $model->biopsia->solicitudbiopsia->paciente->nombre ,'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
           'DNI'=>['label'=>'DNI', 'options'=>['value'=>$model->biopsia->solicitudbiopsia->paciente->num_documento, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
           'Fecha_nacimiento'=>['label'=>'Fecha de nac.', 'options'=>['value'=> date("d/m/Y",strtotime("'".$model->biopsia->solicitudbiopsia->paciente->fecha_nacimiento."'")), 'placeholder'=>'Fecha de nacimiento...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],

           'Edad'=>['label'=>'Edad', 'options'=>['value'=>$edadDelPaciente, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],

        ]
    ]);
    ?>

</div>
</div>

<legend class="text-info"><small style="margin-left: 18px;">Datos del estudio Inmunostoquimica</small></legend>

<div class="inmunohistoquimica-escaneada-form">
    <?//= $form->field($model, 'documento')->textInput() ?>
    <div class='row'>

    <div class="col-sm-6 col-sm-8 col-sm-8 form-group">

    <?
    echo $form->field($model, 'documento')->widget(FileInput::classname(), [
    'options' => ['multiple' => false, 'accept' => 'application/pdf',
   ],
    'pluginOptions' => ['previewFileType' => 'pdf',
            'allowedFileExtensions' => [ 'pdf'],

            // 'initialPreview' =>
            // [ Html::img('@web/uploads/inmunohistoquimicas/'. $model->documento, ['width' => 200, 'height' => 250, 'class' => 'file-preview-image'])]
            //         ,

    ],
    'disabled'=> ($model->biopsia->estado->descripcion=="LISTO" && !Usuario::isPatologo()),

]);?>
    </div>
    <div class="col-sm-6 col-sm-8 col-dm-9 form-group">
      <label> Estudio cargado </label>
      <p>
          <? if (isset($model->documento )&& !empty($model->documento)){ ?>
            <iframe src=<?=Url::base().'/uploads/inmunohistoquimicas/'. $model->documento ?> height="400" width="300"></iframe>
          <? }else {
              echo "NO TIENE ESTUDIO CARGADO";
          }?>


        </p>
      </div>
    </div>
    <?= $form->field($model, 'observacion')->textarea(['style'=>'width: 500px; height: 100px;']) ?>
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
