<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;

$this->title = 'Configuración';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0" class="x_panel">
  <h2><i class="fa fa-table"></i> Configuración  </h2>
<div class="usuario-misdatos">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#general" role="tab" data-toggle="tab">Color de fondo</a></li>
        <li><a href="#menu" role="tab" data-toggle="tab">Cambiar posicion del menú</a></li>
        <li><a href="#notificacion" role="tab" data-toggle="tab">Notificaciones</a></li>
      </ul>
        <div class="perfil-form">
          <?$form= ActiveForm::begin(['action'=>"configuracion"]); ?>
          <div class="tab-content">
            <div class="tab-pane active vertical-pad" id="general">
              <div class="row">
                <div class="col-sm-7">
                    <div class="x_panel">
                      <div class="form-group row">
                        <label class="control-label">Seleccionar el tema</label>
                          <?=$form->field($model->configuracion, 'id_tema')->dropDownList($temas, ['id'=>'id_tema',    'prompt'=>'- Seleccionar un tema'])->label('Tema') ;?>
                        </div>
                    </div>
                </div>
              </div>
           </div>
              <div class="tab-pane vertical-pad" id="menu">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="x_panel">
                        <div class="form-group row">
                          <label class="control-label">Seleccionar el menú</label>
                            <?=$form->field($model->configuracion, 'id_menu')->dropDownList($menus, ['id'=>'id_menu',    'prompt'=>'- Seleccionar un menú'])->label('Menú') ;?>
                          </div>
                       </div>
                   </div>
                 </div>
              </div> <!-- end of upload photo tab -->
              <div class="tab-pane vertical-pad" id="notificacion">
                <div class="x_panel">
                <div class="form-group row">
                    <label class="control-label">Habilitar/desabilitar Notificaciones</label>
                  <?  echo ( $form->field($model->configuracion, 'notificacion')->widget(SwitchInput::classname(), [    'pluginOptions' => [
                      'onText' => 'Si',
                      'offText' => 'No',
                    ],
                  ]))->label('Notificación');
                  ?>
                    </div>
                 </div>
              </div> <!-- end of upload photo tab -->

          </div>
          <!-- Tab panes -->
          <div class="form-group">
              <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary pull-left', 'name' => 'Aceptar']) ?>
          </div>

          <?php ActiveForm::end(); ?>

        </div>


</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<script>
function cambiarTema() {
    var temaActual = document.getElementById('estilo-original');
    alert(temaActual.getAttribute('href'));
    var nuevoTema = temaActual.getAttribute('href') === '/hazpatologia/web/css/custom.white.css' ? '/hazpatologia/web/css/custom.dark.css' : '/hazpatologia/web/css/custom.orig.css';
    temaActual.setAttribute('href', nuevoTema);
    alert(temaActual.getAttribute('href'));
}
</script>
