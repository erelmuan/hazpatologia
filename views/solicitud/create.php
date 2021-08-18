<? use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\form\ActiveField;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Procedencia;
use app\models\Plantillamaterial;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nueva solicitud  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
      </br>
      <div class='row'>
      <div class='col-sm-3'>
      <label >Paciente: <span id='paciente'> </span>
        <button title="Busqueda avanzada de paciente" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-paciente-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
        <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear paciente</i>', ['paciente/create'],
         ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-primary btn-xs']); ?>
      </label>
      <input type="text" id="pacientebuscar" name="PacienteSearch[num_documento]"  placeholder="Ingresar DNI del paciente" >
      <button type="button" class ="btn btn-primary btn-xs" onclick='pacienteba();'>Buscar y añadir</button>

      </br>
      </br>

      <label>Medico:<span id='medico'> </span>
        <button title="Busqueda avanzada de medico" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-medico-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
          <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear medico</i>', ['medico/create'],
           ['role'=>'modal-remote','title'=> 'Crear nuevo medico','class'=>'btn btn-primary btn-xs']); ?>
      </label>
      <input type="text" id="medicobuscar" name="MedicoSearch[num_documento]" placeholder="Ingresar DNI del medico" >
      <button type="button" class ="btn btn-primary btn-xs" onclick='medicoba();'>Buscar y añadir</button>
      </div>
      <?

      $form = ActiveForm::begin([
            'id' => 'my-form-id-sol',
            'action' => '?r=solicitud/create',
            'enableAjaxValidation' => true,
            'method' => 'post',
            'validationUrl' => '?r=solicitud/create',
        ]);

      $mapprocedencia = ArrayHelper::map(Procedencia::find()->all() , 'id',  'nombre'  );
      $mapmaterial = ArrayHelper::map(Plantillamaterial::find()->all() , 'id',  'material'  );
      ?>



      <div class='col-sm-3'>

      <label> Paciente </label></br>
      <input id="solicitud-paciente"  style="width:250px;" type="text" readonly>
      <?=$form->field($model, 'id_paciente')->hiddenInput()->label(false); ?>
      <label> Medico </label> </br>
      <input id="solicitud-medico" style="width:250px;" type="text" readonly>
      <?=$form->field($model, 'id_medico')->hiddenInput()->label(false); ?>
        <?
          echo Form::widget([ // continuation fields to row above without labels
            'id' => 'login-form-horizontal',
              'model'=>$model,
              'form'=>$form,
              'columns'=>4,
              'attributes'=>[
                  'id_procedencia'=>['type'=> Form::INPUT_WIDGET,
                  'widgetClass'=>'kartik\select2\Select2',
                  'options'=>[
                    'data' => $mapprocedencia,
                        'language' => 'es',
                        ],
                    'pluginOptions' => [
                          'allowClear' => true
                          ],
                    'placeholder' => 'Seleccionar codigo..',
                          'label'=>'Procedencia'
                    ],

              ]]);
      ?>

          </div>


            <div class='col-sm-3'>
            <?
              echo $form->field($model, 'fecharealizacion')->widget(DatePicker::className(), [
                     'options' => ['placeholder' => 'Debe agregar una fecha',
                       'value' =>  date('d/m/Y'),
                       'type' => DatePicker::TYPE_COMPONENT_APPEND,
                             ],
                        'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                        'allowClear' => false
                         ],
                        'pluginEvents' => [
                             "changeDate" => "function(e){
                               cambiarFechaNac();
                             }",
                             ],
                         ]);

            ?>
            <?=$form->field($model, 'estudio')->dropDownList(
              ['BIOPSIA' => 'BIOPSIA ', 'PAP' => 'PAP']
              );
              ?>
              <?=$form->field($model, 'estado')->dropDownList(
             ['PENDIENTE' => 'PENDIENTE ', 'RECHAZADO' => 'RECHAZADO']
             );
             ?>
             </div>
             <div class='col-sm-3'>
              <?
              echo $form->field($model, 'fechadeingreso')->widget(DatePicker::className(), [
                        'options' => ['placeholder' => 'Debe agregar una fecha',
                        'value' =>  date('d/m/Y'),
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                ],
                        'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'allowClear' => false,
                         'todayHighlight' => true,],
                         'pluginEvents' => [
                          "changeDate" => "function(e){
                              cambiarFechaNac();
                              }",
                            ],
                          ]);

            ?>
            <?=$form->field($model, "observacion")->textarea(["rows" => 5]) ; ?>

          </div>

         </div>
         <div class="x_content">
               <div class="modal fade bs-paciente-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                 <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                     <div class="modal-body">
                       <div class="paciente-index">
                           <div id="ajaxCrudDatatable">
                             <?=GridView::widget([
                                 'id'=>'crud-paciente',
                                 'dataProvider' => $dataProviderPac,
                                 'filterModel' => $searchModelPac,
                                 'pjax'=>true,
                                 'columns' => require(__DIR__.'/_columnsPaciente.php'),
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
                         <button type="button"  onclick='agregarFormularioPac();' class="btn btn-primary">Agregar al formulario</button>
                       </div>
                 </div>
               </div>
             </div>
         </div>
       </div>
       <div class="x_content">
             <div class="modal fade bs-medico-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                   <div class="modal-body">
                     <div class="medico-index">
                         <div id="ajaxCrudDatatable">
                           <?=GridView::widget([
                               'id'=>'crud-medico',
                               'dataProvider' => $dataProviderMed,
                               'filterModel' => $searchModelMed,
                               'pjax'=>true,
                               'columns' => require(__DIR__.'/_columnsMedico.php'),
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
                       <button type="button"  onclick='agregarFormularioMed();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>

      <?  if (!Yii::$app->request->isAjax){ ?>
         <div class='pull-right'>
            <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
         </div>
      <? }
          $form = ActiveForm::end();
      ?>

</div>


<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>

function pacienteba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=paciente/search' ?>',
        type: 'get',
        data: {
              "PacienteSearch[num_documento]":$("#pacientebuscar").val() ,
              _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
              },
        success: function (data) {
          var content = JSON.parse(data);
          if (content.status=='error'){
            swal(
            content.mensaje ,
            'PRESIONAR OK',
            'error'
            )
          }else{
            swal(
            'Se agrego el paciente' ,
            'PRESIONAR OK',
            'success'
            )
            // console(content['id_paciente']);
          document.getElementById("solicitud-paciente").value= content['apellido']+", "+content['nombre'];
          document.getElementById("solicitudbiopsia-id_paciente").value= content['id'];
         }
        }
   });

}

function medicoba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=medico/search' ?>',
        type: 'get',
        data: {
              "MedicoSearch[num_documento]":$("#medicobuscar").val() ,
              _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
              },
        success: function (data) {
          var content = JSON.parse(data);
          if (content.status=='error'){
            swal(
            content.mensaje ,
            'PRESIONAR OK',
            'error'
            )
          }else{
            swal(
            'Se agrego el medico' ,
            'PRESIONAR OK',
            'success'
            )
          document.getElementById("solicitud-medico").value= content['apellido']+" "+content['nombre'];
          document.getElementById("solicitud-id_medico").value= content['id_medico'];
        }
        }
   });

}
///script agregar y quitar paciente desde la busqueda avanzada

function agregarFormularioPac (){

console.log($("tr.success").find("td:eq(1)").text());
  document.getElementById("solicitud-paciente").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("solicitudbiopsia-id_paciente").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el paciente' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}
function quitarMat (){
  $("span#select2-w4-container.select2-selection__rendered")[0].innerText ="";
  $("textarea#biopsias-topografia.form-control").val('') ;
  $("textarea#biopsias-diagnostico.form-control").val('') ;

}
function agregarFormularioMed (){
  document.getElementById("solicitud-medico").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("solicitud-id_medico").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('button.close.kv-clear-radio').click();
  swal(
  'Se agrego el medico' ,
  'PRESIONAR OK',
  'success'
  )
  $('button.btn.btn-default').click();

}

</script>
