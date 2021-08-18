<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\FileInput;

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> PERFIL  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="usuario-misdatos">

    <?php if (Yii::$app->session->hasFlash('misDatosSubmitted')): ?>

        <div class="alert alert-success">
            Datos Guardados correctamente.
        </div>

    <?php else: ?>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#general" role="tab" data-toggle="tab">Datos del usuario</a></li>
        <li><a href="#photo" role="tab" data-toggle="tab">Subir o actualizar foto</a></li>
      </ul>




        <div class="perfil-form">
          <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']]); ?>

          <div class="tab-content">
            <div class="tab-pane active vertical-pad" id="general">
              <div class="row">
                <div class="col-sm-7">
                    <div class="x_panel">
                        <?php echo $form->field($model, 'usuario')->textInput(['maxlength' =>true,'readonly'=>true, 'style'=>'width:50%']);?>

                        <?php echo $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style'=>'width:50%']);?>

                        <?php echo $form->field($model, 'email')->textInput(['maxlength' => true, 'style'=>'width:50%']);?>

                        <?php echo $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'style'=>'width:50%']);?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="x_panel">
                      <?php  if (true) {
                         echo '<img src=uploads/avatar/sqr_'.Yii::$app->user->identity->imagen.' class="img-circle profile_img"   alt="..." >';

                              }?>
                    </div>
                </div>
              </div>

                  <!-- Tab panes -->
                  <div class="form-group">
                      <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary pull-left', 'name' => 'Aceptar']) ?>
                      <?= Html::button('Cambiar Contraseña', ['class' => 'btn btn-primary', 'role'=>'modal-remote','name' => 'Contrasenia','style'=>'margin-left: 337px;' ]) ?>
                  </div>
           </div>
              <div class="tab-pane vertical-pad" id="photo">

                <? echo $form->field($model, 'imagen')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'imagen/*'],
                     'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']],
                ]);   ?>
              </div> <!-- end of upload photo tab -->

          </div>

          <?php ActiveForm::end(); ?>

        </div>



    <?php endif; ?>

</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
