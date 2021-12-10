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

/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Solicitud de pap';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="glyphicon glyphicon-plus"></i> Nueva solicitud de pap </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
      </br>
      <div class="x_panel" >
        <legend class="text-info"><small>CABECERA DE LA SOLICITUD</small></legend>
      <div class='row'>
      <div class='col-sm-3'>
      <label >Paciente: <span id='paciente'> </span>
        <button onclick="quitarSeleccion()"  title="Busqueda avanzada de paciente" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-paciente-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
        <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear paciente</i>', ['paciente/create'],
         ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-primary btn-xs']); ?>
      </label>
      <input type="text" id="pacientebuscar" name="PacienteSearch[num_documento]"  placeholder="Ingresar DNI del paciente" >
      <button id="button_paciente" type="button" class ="btn btn-primary btn-xs" onclick='pacienteba();'>Buscar y añadir</button>

      </br>
      </br>

      <label>Medico:<span id='medico'> </span>
        <button onclick="quitarSeleccion()" title="Busqueda avanzada de medico" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-medico-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-search" ></i></button>
          <?   echo  Html::a('<i class="glyphicon glyphicon-plus"> Crear medico</i>', ['medico/create'],
           ['role'=>'modal-remote','title'=> 'Crear nuevo medico','class'=>'btn btn-primary btn-xs']); ?>
      </label>
      <input type="text" id="medicobuscar" name="MedicoSearch[matricula]" placeholder="Ingresar matricula del medico" >
      <button id="button_medico" type="button" class ="btn btn-primary btn-xs" onclick='medicoba();'>Buscar y añadir</button>
      </div>


      <?

     $form = ActiveForm::begin();
      $mapprocedencia = ArrayHelper::map(Procedencia::find()->all() , 'id',  'nombre'  );
      ?>



      <div class='col-sm-3'>

      <label> Paciente </label></br>
      <input id="solicitud-paciente"  style="width:250px;" value='<?=($model->paciente)?$model->paciente->apellido.", ".$model->paciente->nombre:''; ?>' type="text" readonly>
      <?=$form->field($model, 'id_paciente')->hiddenInput()->label(false); ?>
      <label> Medico </label> </br>
      <input id="solicitud-medico" style="width:250px;" value='<?=($model->medico)?$model->medico->apellido.", ".$model->medico->nombre:'' ?>' type="text" readonly>
      <?=$form->field($model, 'id_medico')->hiddenInput()->label(false); ?>

      <? if( isset($protocolo_insertar)){
      echo $form->field($model, 'protocolo')->textInput(['readonly'=> true , 'value'=>$protocolo_insertar]) ;
     }else {
       echo $form->field($model, 'protocolo')->textInput(['readonly'=> true ]) ;

    } ?>
        </div>


            <div class='col-sm-3'>
            <?
            // echo $form->field($model, 'fecharealizacion')->widget(MaskedInput::classname(),['name' => 'input-31',
            //         'clientOptions' => ['alias' =>  'dd/mm/yyyy']])->widget(DatePicker::classname(), [
            //         'options' => ['placeholder' => 'Ingrese fecha',
            //         'format' => 'dd/mm/yyyy',
            //       ],
            //         'pluginOptions' => [
            //             'autoclose'=>true,
            //
            //         ]
            //     ]);
                echo $form->field($model, 'fecharealizacion')->widget(DateControl::classname(), [
                          'options' => ['placeholder' => 'Debe agregar una fecha',
                          'value'=> ($model->fecharealizacion)?$model->fecharealizacion:"" ,
                                  ],
                          'type'=>DateControl::FORMAT_DATE,
                          'autoWidget'=>true,
                          'displayFormat' => 'php:d/m/Y',
                          'saveFormat' => 'php:Y-m-d',
                        ])->label('Fecha de realización');


            ?>

             <?=$form->field($model, 'id_estudio')->hiddenInput(['value'=> $model->idEstudio()])->label(false); ?>

             <?= $form->field($model, 'id_estado')->dropDownList($model->estados())->label('Estado') ;?>


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

           <? if( isset($protocolo_insertar)){
             echo $form->field($model, 'protocolo_automatico')->checkBox(['label' => 'Protocolo automatico',
        'onclick' => 'cambioProtocoloAutomatico();', 'checked' => '1','value' => '1']);} ?>
             </div>
             <div class='col-sm-3'>
                  <?
                  echo $form->field($model, 'fechadeingreso')->widget(DateControl::classname(), [
                            'options' => ['placeholder' => 'Debe agregar una fecha',
                            'value'=> ($model->fechadeingreso)?$model->fechadeingreso:"" ,
                                    ],
                            'type'=>DateControl::FORMAT_DATE,
                            'autoWidget'=>true,
                            'displayFormat' => 'php:d/m/Y',
                            'saveFormat' => 'php:Y-m-d',
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
                  <div class='col-sm-3'>
                    <?= $form->field($model, 'id_tipo_muestra')->dropDownList($model->getTipomuestras())->label('Tipo de muestra') ;?>
                    <?= $form->field($model, 'pap_previo')->checkbox() ?>
                    <?= $form->field($model, 'resultado_pap_previo')->textInput() ?>
                    <?= $form->field($model, 'biopsia_previa')->checkbox() ?>
                    <?= $form->field($model, 'resultado_biopsia_previo')->textInput() ?>
                  </div>
                  <div class='col-sm-3'>
                    <?= $form->field($model, 'fum')->textInput() ?>
                    <?= $form->field($model, 'embarazo_actual')->checkbox() ?>
                    <?= $form->field($model, 'menopausia')->checkbox() ?>
                    <?
                 echo $form->field($model, 'fecha_ult_parto')->widget(DateControl::classname(), [
                           'options' => ['placeholder' => 'Debe agregar una fecha',
                           'value'=> ($model->fecha_ult_parto)?$model->fecha_ult_parto:"" ,
                                   ],
                           'type'=>DateControl::FORMAT_DATE,
                           'autoWidget'=>true,
                           'displayFormat' => 'php:d/m/Y',
                           'saveFormat' => 'php:Y-m-d',
                         ])->label('Fecha del ultimo parto');

                ?>
                    <?= $form->field($model, 'id_metodo_anticonceptivo')->dropDownList($model->getMetodoAnticonceptivos())->label('Metodo anticonceptivo') ;?>


                  </div>
                  <div class='col-sm-3'>
                    <?= $form->field($model, 'id_cirugia_previa')->dropDownList($model->getCirugiaPrevias())->label('Cirugia previa') ;?>
                    <?= $form->field($model, 'tratamiento_radiante')->checkbox() ?>
                    <?= $form->field($model, 'quimioterapia')->checkbox() ?>
                    <?= $form->field($model, 'datos_clinicos_de_interes')->textarea(['rows' => 6]) ?>
                  </div>
                  <div class='col-sm-3'>
                  <?= $form->field($model, 'id_materialsolicitud')->dropDownList($model->getMaterialsolicitudes())->label('Material') ;?>
                    <?= $form->field($model, 'colposcopia')->checkbox() ?>
                    <?= $form->field($model, 'conclusion')->textarea(['rows' => 6]) ?>
                  </div>

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
                                 'dataProvider' => $dataProviderPac,
                                 'filterModel' => $searchModelPac,
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
            <?=Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
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
function cambioProtocoloAutomatico(){
    if(document.getElementById("solicitudpap-protocolo_automatico").value==1 ){
      document.getElementById("solicitudpap-protocolo").readOnly = false;
      document.getElementById("solicitudpap-protocolo_automatico").value =0;

    }else {
        $.ajax({
            url: '<?php echo Url::to(['/solicitud/buscarprotocolo']) ?>',
           type: 'get',
           data: {
                 _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
                 },
           success: function (data) {
               var content = JSON.parse(data);
              document.getElementById("solicitudpap-protocolo").value=  content.protocolo;
           }

      });
      document.getElementById("solicitudpap-protocolo_automatico").value =1;
      document.getElementById("solicitudpap-protocolo").readOnly = true;
    }
}

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
          document.getElementById("solicitud-paciente").value= content['apellido']+", "+content['nombre'];
          document.getElementById("solicitudpap-id_paciente").value= content['id'];
         }
        }
   });

}

function medicoba(){

  $.ajax({
        url: '<?php echo Yii::$app->request->baseUrl. '/index.php?r=medico/search' ?>',
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
            swal(
            'Se agrego el medico' ,
            'PRESIONAR OK',
            'success'
            )
          document.getElementById("solicitud-medico").value= content['apellido']+" "+content['nombre'];
          document.getElementById("solicitudpap-id_medico").value= content['id'];
        }
        }
   });

}
///script agregar y quitar paciente desde la busqueda avanzada

function agregarFormularioPac (){

  if ($("tr.success").find("td:eq(1)").text() != ""){

  document.getElementById("solicitud-paciente").value= $("tr.success").find("td:eq(3)").text() +", "+ $("tr.success").find("td:eq(2)").text() ;
  document.getElementById("solicitudpap-id_paciente").value=$("tr.success").find("td:eq(1)").text();
  //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
    $('span.kv-clear-radio').click();
    $('button.btn.btn-default').click();

    swal(
    'Se agrego el paciente' ,
    'PRESIONAR OK',
    'success'
    )
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
    document.getElementById("solicitudpap-id_medico").value=$("tr.success").find("td:eq(1)").text();
    //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
    $('span.kv-clear-radio').click();
    $('button.btn.btn-default').click();

    swal(
    'Se agrego el medico' ,
    'PRESIONAR OK',
    'success'
    )
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
