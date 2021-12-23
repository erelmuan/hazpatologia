<?php
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
///////////////////
///////////////
///////////////
//////////////
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
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

  <legend class="text-info"><small>Datos de la solicitud</small></legend>
  <div class="x_content" style="display: block;">

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

    ]
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
