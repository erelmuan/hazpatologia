<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0" class="x_panel">
  <h2><i class="fa fa-table"></i> PERFIL  </h2>
<div class="usuario-misdatos">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#general" role="tab" data-toggle="tab">Datos del usuario</a></li>
        <li><a href="#photo" role="tab" data-toggle="tab">Subir o actualizar foto</a></li>
      </ul>
        <div class="perfil-form">
          <?php $form = ActiveForm::begin(); ?>

          <div class="tab-content">
            <div class="tab-pane active vertical-pad" id="general">
              <div class="row">
                <div class="col-sm-7">
                    <div class="x_panel">
                        <?= $form->field($model, 'usuario')->textInput(['maxlength' => true, 'readonly' => true, 'style' => 'width:50%']); ?>

                        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style' => 'width:50%']); ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'style' => 'width:50%']); ?>

                        <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'style' => 'width:50%']); ?>
                        <?= $form->field($model, 'contrasenia')->hiddenInput()->label(false) ?>

                        <?= $form->field($model, 'id_pantalla')->hiddenInput()->label(false); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="x_panel">
                      <?php  echo '<img src=' . Url::base(true) . '/uploads/avatar/sqr_' . Yii::$app->user->identity->imagen . ' class="img-circle profile_img"   alt="..." >';
                               ?>
                    </div>
                </div>
              </div>

                  <!-- Tab panes -->
                  <div class="form-group">
                      <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary pull-left', 'name' => 'Aceptar']) ?>
                      <!-- Botón para cambiar la contraseña -->
                      <?= Html::a('<i class="glyphicon glyphicon-edit"> Cambiar constraseña</i>', ['usuario/cambiarcontrasenia'],
                       ['role'=>'modal-remote','title'=> 'Crear nuevo medico','class'=>'btn btn-primary','style' => 'margin-left: 337px;']); ?>
                  </div>
           </div>
              <div class="tab-pane vertical-pad" id="photo">

                <?= $form->field($model, 'imagen')->widget(
                    FileInput::classname(), [
                        'options' => ['accept' => 'image/*'],
                        'language' => 'es',
                        'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png'],
                      ],
                    ]) ?>
                    <!-- No hay que cambiar el orden! hiddenInput tiene que estar poder debajo del widget FileInput -->
                    <?= $form->field($model, 'imagen')->hiddenInput(['value' => $model->imagen])->label(false); ?>
              </div> <!-- end of upload photo tab -->

          </div>

          <?php ActiveForm::end(); ?>


        </div>


</div>
</div>

<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
