<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Firma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="firma-form">
  <div class="x_title"><h2><i class="fa fa-edit"></i> NUEVA FIRMA  </h2>
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
          <li class="active"><a href="#general" role="tab" data-toggle="tab">Usuario</a></li>
          <li><a href="#photo" role="tab" data-toggle="tab">Subir o actualizar firma</a></li>
        </ul>




          <div class="perfil-form">
            <?php $form = ActiveForm::begin([
          'options'=>['enctype'=>'multipart/form-data']]); ?>

            <div class="tab-content">
              <div class="tab-pane active vertical-pad" id="general">
                <div class="row">
                  <div class="col-sm-7">
                      <div class="x_panel">
                        <?php $form = ActiveForm::begin(); ?>
                            <button title="Busqueda avanzada de usuarios" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-usuario-modal-lg" style="margin-left: 10px;">Buscar paciente <i class="glyphicon glyphicon-search" ></i></button>
                           <div class="form-group field-medico-usuario">
                           <label class="control-label" for="medico-usuario">Usuario</label>
                           <input type="text" id="firma-usuario" class="form-control" value='<?=($model->usuario)?$model->usuario->usuario:'' ?>'  maxlength="45" style="width:50%" readonly/>

                           <div class="help-block"></div>
                           </div>
                      </div>

                       <?=$form->field($model, 'id_usuario')->hiddenInput()->label(false); ?>
                      </div>
                      <?php  if (!$model->isNewRecord ) { ?>
                      <div class="col-md-4">
                          <div class="x_panel">
                            <?   echo '<img src=uploads/avatar/sqr_'.$model->firma.' class="img-circle profile_img"   alt="..." >'; ?>
                          </div>
                      </div>
                        <?  }?>
                  </div>

                </div>
                <div class="tab-pane vertical-pad" id="photo">

                  <?
                    echo $form->field($model, 'firma')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'firma/*'],
                         'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']],
                    ]);
                  ?>
                </div> <!-- end of upload photo tab -->

            </div>

            <?php ActiveForm::end(); ?>

          </div>



      <?php endif; ?>

  </div>
    <?//php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'firma')->textInput() ?>

    <?//= $form->field($model, 'id_usuario')->textInput() ?>


	<?//php if (!Yii::$app->request->isAjax){ ?>
	  	<!-- <div class="form-group"> -->
	        <?//= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    <!-- </div> -->
	<?// php} ?>

    <?//php ActiveForm::end(); ?>

</div>



<div class="x_content">
       <div class="x_content">
             <div class="modal fade bs-usuario-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="usuario-index">
                         <div id="ajaxCrudDatatable">
                           <?=GridView::widget([
                               'id'=>'crud-usuario',
                               'dataProvider' => $dataProviderUsu,
                               'filterModel' => $searchModelUsu,
                               'pjax'=>true,
                               'columns' => require(dirname(__DIR__).'/firma/_columnsUsuario.php'),
                               'toolbar'=> [

                               ],
                               'panel' => [
                                   'type' => 'primary',
                                   'heading'=> false,
                               ]
                           ])?>
                         </div>
                     </div>
                     <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                       <button type="button"  onclick='agregarFormularioUsu();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>
</div>
<script>
function agregarFormularioUsu (){
  document.getElementById("firma-usuario").value=  $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("firma-id_usuario").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el usuario' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}

</script>
