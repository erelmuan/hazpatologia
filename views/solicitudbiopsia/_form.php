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
use yii\widgets\MaskedInput;
use kartik\datecontrol\DateControl;
use nex\chosen\Chosen;
use app\models\Usuario;
use app\models\patronState\EstadoBase;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Solicitud de biopsia';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nueva solicitud de biopsia <? if ((isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::esPatologo()))) echo "(SOLO EL PATOLOGO PUEDE MODIFICAR LA SOLICITUD EN ESTADO LISTO)" ?> </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
      </br>
      <div class='row'>
      <div class="x_panel" >
        <legend class="text-info"><small>CABECERA DE LA SOLICITUD</small></legend>
      <div class='row'>
        <div class='col-sm-3'>
        <label >Paciente: <span id='paciente'> </span>
          <button onclick="quitarSeleccion()" title="Busqueda avanzada de paciente" type="button" class="btn btn-primary btn-xs"
              data-toggle="modal" data-target=".bs-paciente-modal-lg" style="margin-left: 10px;"
              <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'disabled' : '' ?>>
              <i class="glyphicon glyphicon-search"></i>
          </button>
          <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear paciente</i>', ['paciente/create'],
           ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-primary btn-xs']); ?>
        </label>
        <input type="text" class="form-control" id="pacientebuscar" name="PacienteSearch[num_documento]" placeholder="Ingresar DNI del paciente"
        <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'readonly' : '' ?>>
        <button id="button_paciente" type="button" class ="btn btn-primary btn-xs" onclick='pacienteba();'              <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'disabled' : '' ?>>Buscar y añadir</button>

        </br>
        </br>

        <label>Medico:<span id='medico'> </span>
          <button onclick="quitarSeleccion()"  title="Busqueda avanzada de medico" type="button" class="btn btn-primary btn-xs"
          data-toggle="modal" data-target=".bs-medico-modal-lg" style="margin-left: 10px;"
            <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'disabled' : '' ?>>
            <i class="glyphicon glyphicon-search" ></i></button>
            <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear medico</i>', ['medico/create'],
             ['role'=>'modal-remote','title'=> 'Crear nuevo medico','class'=>'btn btn-primary btn-xs']); ?>
        </label>
        <input type="text" class="form-control" id="medicobuscar" name="MedicoSearch[matricula]" placeholder="Ingresar matricula del medico"
          <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'readonly' : '' ?> >
        <button id="button_medico"  type="button" class ="btn btn-primary btn-xs" onclick='medicoba();'              <?= (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())) ? 'disabled' : '' ?>>Buscar y añadir</button>

        <p>
      <?
      if ( $model->puedeMostrarAdjuntos() ){
        echo Html::button('<i class="glyphicon glyphicon-open-file"></i> Gestión de adjuntos', [
            'class' => 'btn btn-default grid-button',
            'title' => "Debe crearse primero la solicitud",
            'disabled'=>($model->id)?false:true,
            'onclick' => "location.href='" . Yii::$app->urlManager->createUrl(['/adjuntosolicitud/index', 'id_solicitud' => $model->id]) . "';",
        ]);
        echo Html::button('<i class="glyphicon glyphicon-open-file"></i> Ver archivos adjuntos', [
            'class' => 'btn btn-default grid-button',
            'title' => "Debe crearse primero la solicitud",
            'disabled' => ($model->id) ? false : true,
            'data-url' => Yii::$app->urlManager->createUrl(['/adjuntosolicitud/view-files', 'id_solicitud' => $model->id]),
            'data-toggle' => 'modal',
            'role'=> 'modal-remote',
            'data-target' => '#modal',
        ]);

      }
      ?>
       </p>
        </div>

      <?
        $form = ActiveForm::begin();
      ?>
      <div class='col-sm-3'>
        <b>
        <?
      echo $form->field($model, 'protocolo')->textInput(['style'=> 'font-size:23px;color:red;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::esPatologo()))]) ;

       ?>
    </b>
      <label> Paciente </label></br>
      <input id="solicitud-paciente" class="form-control"  style="width:250px;" value='<?=($model->paciente)?$model->paciente->apellido.", ".$model->paciente->nombre:''; ?>' type="text" disabled>
      <?=$form->field($model, 'id_paciente')->hiddenInput()->label(false); ?>
      <label> Medico </label> </br>
      <input id="solicitud-medico" class="form-control"  style="width:250px;" value='<?=($model->medico)?$model->medico->apellido.", ".$model->medico->nombre:'' ?>' type="text" disabled>
      <?=$form->field($model, 'id_medico')->hiddenInput()->label(false); ?>

        </div>


            <div class='col-sm-3'>
            <?

                echo $form->field($model, 'fecharealizacion')->widget(DateControl::classname(), [
                          'options' => ['placeholder' => 'Debe agregar una fecha',
                          'value'=> ($model->fecharealizacion)?$model->fecharealizacion:"" ,
                                  ],
                          'type'=>DateControl::FORMAT_DATE,
                          'autoWidget'=>true,
                          'displayFormat' => 'php:d/m/Y',
                          'saveFormat' => 'php:Y-m-d',
                          'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::esPatologo()))
                        ])->label('Fecha de realización');


            ?>

             <?=$form->field($model, 'id_estudio')->hiddenInput(['value'=> $model->idEstudio()])->label(false); ?>

             <?=$form->field($model, 'id_estado')->dropDownList(
                 $stateOptions,
                 ['prompt' => 'Seleccione estado']
             ) ?>
             <?
             echo $form->field($model, 'id_procedencia')->widget(
                 Chosen::className(), [
                     'items' => $mapprocedencia,
                     'placeholder' => 'Selecciona una opción',
                     'options' => [
                        'id' => 'id_procedencia',
                        'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::esPatologo()))
                      ],
                     'clientOptions' => [
                       'rtl'=> true,
                         'search_contains' => true,
                         'single_backstroke_delete' => false,
                     ],
             ])->label("Procedencia");
           ?>

           <?
           //Cuando se incorpore esta funcionalidad hay que cambiar la base de datos por NOT NULL
           echo $form->field($model, 'protocolo_automatico')->checkBox([
         'onclick' => 'cambioProtocoloAutomatico();', 'checked' => '1','value' => '0'])->hiddenInput()->label(false);

      ?>
             </div>
             <div class='col-sm-3'>
                  <?
                  echo $form->field($model, 'fechadeingreso')->widget(DateControl::classname(), [
                          'options' => [
                              'placeholder' => 'Debe agregar una fecha',
                              'value' => ($model->fechadeingreso) ? $model->fechadeingreso : "",
                          ],
                          'disabled' => (isset($model->estado) && ($model->estado->descripcion == "LISTO" && !Usuario::esPatologo())),
                          'type' => DateControl::FORMAT_DATE,
                          'autoWidget' => true,
                          'displayFormat' => 'php:d/m/Y',
                          'saveFormat' => 'php:Y-m-d',
                          // ← SOLO añade esto para restringir fechas futuras:
                          'widgetOptions' => [
                              'pluginOptions' => [
                                'endDate' => '0d'// ← Esta es la clave
                              ],
                          ],
                      ])->label('Fecha de ingreso');
                  ?>
                <?=$form->field($model, "observacion")->textarea(["rows" => 4]) ; ?>
              </div>
          </div>
          <div class="x_panel" >
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
              <legend class="text-info"><small>INFORMACIÓN ADICIONAL</small></legend>
              <div class="x_content" style="display: none;">
                <div class='col-sm-6'>
                  <?
                  echo '<label class="control-label">Material de la solicitud</label>';

                  echo Select2::widget([
                      'name' => 'MaterialArray',
                       'value' => $valorMateriales, // initial value
                       'data' => $materialesSolicitud,
                       'maintainOrder' => true,
                       'options' => [
                        'placeholder' => 'Material...',

                      'multiple' => true],
                      'pluginOptions' => [
                            'maximumSelectionLength'=> 7,
                      ],
                      'pluginEvents' => [
                            "select2:select"  => "function(e){
                                 agregarInput(e.params.data.id ,e.params.data.text ,'');
                            }",
                            "select2:unselect" => "function(e) {
                                quitarInput(e.params.data.id);
                            }"
                                 ],
                  ]);

                  ?>
                  <br>
                  <?= $form->field($model, 'sitio_prec_toma')->textInput() ?>
                  <?= $form->field($model, 'datos_clin_interes')->textInput() ?>
                </div>
                <div class='col-sm-6'>
                  <?= $form->field($model, 'diagnostico_presuntivo')->textInput() ?>
                  <?= $form->field($model, 'biopsia_anterior_resultado')->textInput() ?>

                </div>
             </div>
          <div class="x_panel" >
                <legend class="text-info"><center>PARA MATERIAL GINECOLOGICO</center></legend>
                <div class="x_content" style="display: none;">
              <div class='col-sm-6'>
              <?= $form->field($model, 'materialginecologico')->textInput(['value'=>($model->materialginecologico)?$model->materialginecologico->pap_previo:''])->label('Pap previo') ?>
              <?= $form->field($model, 'materialginecologico')->textInput(['value'=>($model->materialginecologico)?$model->materialginecologico->fecha_ult_mestruacion:''])->label('Última fecha mestruación') ?>
              <?= $form->field($model, 'materialginecologico')->textInput(['value'=>($model->materialginecologico)?$model->materialginecologico->ciclos:''])->label('Ciclos') ?>

              </div>
              <div class='col-sm-6'>

              <?= $form->field($model, 'fecha_ult_parto')->widget(DatePicker::className(), [
                     'options' => ['placeholder' => 'Debe agregar una fecha',
                     'value'=> ($model->materialginecologico)?date('d/m/Y',strtotime($model->materialginecologico->fecha_ult_parto)):"" ,
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
                         ])->label('Ultima fecha de parto');;
                             ?>
              <?= $form->field($model, 'materialginecologico')->textInput(['value'=>($model->materialginecologico)?$model->materialginecologico->tratamiento_hormonal:''])->label('Tratamiento hormonal') ?>

              </div>
             </div>
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
                                 'dataProvider' => $modelosDat['dataProviderPac'],
                                 'filterModel' =>$modelosDat['searchModelPac'] ,
                                 'pjax'=>true,
                                 'columns' => require(dirname(__DIR__).'/solicitud/_columnsPaciente.php'),
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
                         <button type="button" id="botonCerrarPaciente" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
                               'dataProvider' => $modelosDat['dataProviderMed'],
                               'filterModel' => $modelosDat['searchModelMed'],
                               'pjax'=>true,
                               'columns' => require(dirname(__DIR__).'/solicitud/_columnsMedico.php'),
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
                       <button type="button" id="botonCerrarMedico" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                       <button type="button"  onclick='agregarFormularioMed();' class="btn btn-primary">Agregar al formulario</button>
                     </div>
               </div>
             </div>
           </div>
       </div>
     </div>

      <?  if (!Yii::$app->request->isAjax){ ?>
         <div class='pull-right'>
            <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
         </div>
      <? }
          $form = ActiveForm::end();
      ?>

    </div>
   </div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>

var input = document.getElementById("pacientebuscar");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("button_paciente").click();
  }
});
var input = document.getElementById("medicobuscar");
input.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
   event.preventDefault();
   document.getElementById("button_medico").click();
  }
});


function pacienteba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/paciente/search' ?>',
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
            swal({
                 title: "Confirmado!",
                 text: "Se agrego el paciente",
                 type: "success",
                 timer: 800
               });

          document.getElementById("solicitud-paciente").value= content['apellido']+", "+content['nombre'];
          document.getElementById("solicitudbiopsia-id_paciente").value= content['id'];
         }
        }
   });

}

function medicoba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/medico/search' ?>',
        type: 'get',
        data: {
              "MedicoSearch[matricula]":$("#medicobuscar").val() ,
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
            swal({
                 title: "Confirmado!",
                 text: "Se agrego el medico",
                 type: "success",
                 timer: 800
               });

          document.getElementById("solicitud-medico").value= content['apellido']+" "+content['nombre'];
          document.getElementById("solicitudbiopsia-id_medico").value= content['id'];
        }
        }
   });

}






///script agregar y quitar paciente desde la busqueda avanzada

function agregarFormularioPac (){

if ($("tr.success").find("td:eq(1)").text() != ""){
  document.getElementById("solicitud-paciente").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("solicitudbiopsia-id_paciente").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('span.kv-clear-radio').click();
  $('#botonCerrarPaciente').click();

  swal({
       title: "Confirmado!",
       text: "Se agrego el paciente",
       type: "success",
       timer: 800
       })
     }
     else {
       swal(
       'No se ha seleccionado a ningún paciente' ,
       'PRESIONAR OK',
       'error'
     );
     }

}
function quitarSeleccion (){
  $('span.kv-clear-radio').click();

}
function agregarFormularioMed (){
if ($("tr.success").find("td:eq(1)").text() != ""){
  document.getElementById("solicitud-medico").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("solicitudbiopsia-id_medico").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
  $('span.kv-clear-radio').click();
  $('#botonCerrarMedico').click();

  swal({
       title: "Confirmado!",
       text: "Se agrego el medico",
       type: "success",
       timer: 800
       })

}
else {
  swal(
  'No se ha seleccionado a ningún medico' ,
  'PRESIONAR OK',
  'error'
);
}

}

</script>
