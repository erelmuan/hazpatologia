 <?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\bootstrap\ActiveForm; //used to enable bootstrap layout options
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Provincia;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;

?>

<script>
//Tiene que estar antes que se cargue la llamada, para que no arroje error de sincronizacion
function agregarInput(id ,text, nroafiliado){

    if (nroafiliado=="")
    {
        nroafiliado="";
    }
        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
        div.setAttribute("id", "afiliado"+id);
        div.innerHTML = '<div style="clear:both" class="col-md-offset-1 col-md-8"><b>N° Afiliado</b>'+' ('+text+') '+
        '<input class="form-control" value="'+nroafiliado+'" name="nroafiliado[]" type="text" required/></div>';
        document.getElementById('afiliado').appendChild(div);
        // document.get1ElementById('canciones').appendChild(div);
    }
</script>
<div id="w0" class="x_panel">

<div class="paciente-form">
  <? if($model->estudios()){ ?>
    <span style="color:red">  Advertencia: La modificacion del nombre, apellido, dni o historia clinica impactara en todos los estudios anteriores del paciente <b>(NO CAMBIE LA IDENTIDAD DEL MISMO)</b>.</span>
  <? } ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="form-row mt-4">
      <div class="col-sm-5 pb-3">
        <? if($model->estudios()){
            echo $form->field($model, 'nombre')->textInput(['maxlength' => true,'readonly' => true]);
              }else {
            echo $form->field($model, 'nombre')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;']) ;
            }
        ?>
      </div>
      <div class="col-sm-5 pb-3">
        <? if($model->estudios()){
            echo $form->field($model, 'apellido')->textInput(['maxlength' => true,'readonly' => true]);
              }else {
            echo $form->field($model, 'apellido')->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;']) ;
            }
        ?>
      </div>
     </div>
  </div>
  <div class="row">

    <div class="form-row mt-4">
        <div class="col-sm-3 pb-5">
          <?=$form->field($model, 'id_tipodoc')->dropDownList($model->getTipodocs())->label('Tipo Doc.') ;  ?>
        </div>

        <div class="col-sm-3 pb-5">
          <label class="control-label d-flex align-items-center"
                 for="paciente-num_documento"
                 style="margin-bottom: 2px;"> <!-- ajustado -->
              N° doc.
              <button type="button"
                      class="btn btn-info btn-xs btn-renaper ml-2"
                      id="btnRenaper"
                      onclick="consultarRenaper()"
                      title="Consultar Renaper"
                      <?= $model->estudios() > 0 ? 'disabled' : '' ?>>
                  R
              </button>
          </label>

          <?php
          if($model->estudios()){
              echo $form->field($model, 'num_documento')
                  ->textInput(['maxlength' => true,'readonly' => true])
                  ->label(false);
          } else {
              echo $form->field($model, 'num_documento')
                  ->textInput(['maxlength' => true,'style'=> 'width:100%; text-transform:uppercase;'])
                  ->label(false);
          }
          ?>
      </div>

        <div class="col-sm-2 pb-5">
          <? echo $form->field($model, 'sexo')->dropDownList(
              ['F' => 'F ', 'M' => 'M']
              );
          ?>

       </div>
       <div class="col-dm-2 pb-5">
         <? if($model->estudios()){
           echo $form->field($model, 'fecha_nacimiento')->widget(DateControl::classname(), [
            'options' => ['placeholder' => 'Debe agregar una fecha',
            'value'=> ($model->fecha_nacimiento )?$model->fecha_nacimiento:'' ,
                  ],
            'type'=>DateControl::FORMAT_DATE,
              'displayFormat' => 'php:d/m/Y',
              'saveFormat' => 'php:Y-m-d',
              'readonly' => true,
              'widgetOptions' => [
              'pluginOptions' => [
                  'disabled' => true,
                  'autoclose' => true,
                  'showMeridian' => false,
                  'todayHighlight' => true,
                  'keyboardNavigation' => false,
                  'enableOnReadonly' => false,
                  'removeButton' => false // Desactivar el botón de eliminación
              ],
          ]

              ])->label('Fecha de nacimiento');


           }else {
            echo $form->field($model, 'fecha_nacimiento')->widget(DateControl::classname(), [
             'options' => ['placeholder' => 'Debe agregar una fecha',
             'value'=> ($model->fecha_nacimiento )?$model->fecha_nacimiento:'' ,
                   ],
             'type'=>DateControl::FORMAT_DATE,
              'autoWidget'=>true,
               'displayFormat' => 'php:d/m/Y',
               'saveFormat' => 'php:Y-m-d',
               ])->label('Fecha de nacimiento');
             }
         ?>

      </div>

    </div>
</div>
<div class="row">
  <div class="form-row mt-4">
    <div class="col-sm-3 pb-5">
        <?= $form->field($model, 'hc')->input("text",['style'=>'width:70%'])->label('Historia Clinica') ?>
    </div>

    <div class="col-sm-4 pb-5">
      <?= $form->field($model, 'id_provincia')->dropDownList($provincias, ['id'=>'id_provincia',    'prompt'=>'- Seleccionar provincia'])->label('Provincia') ;?>
      <?//=  $form->field($model, 'id_provincia')->widget(Select2::classname(), ['data' => ArrayHelper::map(Provincia::find()->asArray()->all(), 'id', 'nombre')])->label('Provincia'); ?>

    </div>
    <div class="col-sm-4 pb-5">
<?      echo $form->field($model, 'id_localidad')->widget(DepDrop::classname(), [
          'data'=> $localidades,
          'options'=>['id'=>'id_localidad'],
          'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
          'pluginOptions'=>[
            'depends'=>['id_provincia'],
             'placeholder'=>'Seleccionar localidad...',
             'url'=>Url::to(['/paciente/subcat'])
          ]
      ])->label('Localidad');

      ?>
  </div>

    </div>

  </div>
<div class="row">
  <div class="form-row mt-4">
    <div class="col-sm-3 pb-4">
      <?= $form->field($model, 'id_nacionalidad')->dropDownList($model->getNacionalidades())->label('Nacionalidad') ;?>
    </div>
     <div class="col-sm-2 pb-5">
       <?= $form->field($model, 'cp')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-7 pb-5">
        <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
      </div>

    </div>
</div>
<div class="row">
  <div class="form-row mt-4">
      <div class="col-sm-5 pb-5">
        <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

      </div>
      <div class="col-sm-6 pb-5">
        <?= $form->field($model, 'email')->widget(MaskedInput::classname(),[
          'name' => 'input-36',
          'clientOptions' => [  'alias' =>  'email'],  ])->input("email",['style'=>'width:100%; text-transform:uppercase;']); ?>

      </div>
    </div>
</div>
<div class="row">
  <div class="form-row mt-8">
      <div class="col-lg-9 pb-5">
        <div class="nav navbar-left panel_toolbox">
              <button type="button" class="btn btn-primary btn-xs" onclick="pucoAjax()" ><i
                      class="glyphicon glyphicon-plus"></i>Consultar al PUCO</button>
        </div>
        <textarea id="resultadoPuco"  class="form-control" name="resultado"  cols="50" rows="4" style="resize: both;" placeholder="Resultado puco"></textarea>

        <!-- Checkbox indicador: marcado si existe al menos 1 registro en pacientecheckos -->
        <div class="form-check mt-2">
          <input type="checkbox"
                 id="obra_social_check"
                 name="obra_social_check"
                 class="form-check-input ms-2"
                 value="1"
                 style="transform: scale(1.3);" >
          <label class="form-check-label ms-4" for="obra_social_check">
            Obra social chequeada
          </label>
        </div>


              <!-- Mostrar último chequeo si existe -->
              <?php if ($lastCheck):
                $dateTime = new DateTime($lastCheck['fechahora']);
                // Configurar el formatter con locale español
                $formatter = new \yii\i18n\Formatter([
                    'locale' => 'es-AR', // o 'es-ES'
                    'timeZone' => 'America/Argentina/Buenos_Aires'
                ]);
                ?>
                <div class="mt-1">
                  <small>
                    Último chequeo: <strong><?= Html::encode($formatter->asDatetime($dateTime->getTimestamp())) ?></strong>
                    &nbsp;|&nbsp;
                    Resultado: <strong><?= $lastCheck['tiene_os'] ? 'Tiene obra social' : 'Sin obra social' ?></strong>
                  </small>
                </div>
              <?php else: ?>
                <div class="mt-1">
                  <small class="text-muted">Aún no se registró ningún chequeo para este paciente.</small>
                </div>
              <?php endif; ?>

      </div>

    </div>
</div>

<?
echo '<label class="control-label">Obra social</label>';

echo Select2::widget([
    'name' => 'id_obrasocial',
     'value' => $valorObrasocial, // initial value
     'data' => $obrasociales,
     'maintainOrder' => true,
     'options' => [
      'placeholder' => 'Seleccionar obra social ...',

    'multiple' => true],
    'pluginOptions' => [
          'maximumSelectionLength'=> 2,
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
<!-- El id="afiliado" indica que la función de JavaScript dejará aquí el resultado -->
  <div class="row" id="afiliado">

    <? if (!empty($afiliado) ){
      foreach ($valorObrasocial as $key => $value) {
          echo "<script language='JavaScript' type='text/javascript'>";
            echo 'agregarInput('.$valorObrasocial[$value].',"'.$obrasociales[$value].'","'.$afiliado[$value].'");';
          echo "</script>";

      }

    }
    ?>
  </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>
</div>
<?= Html::jsFile('@web/js/biopsia.js'); ?>

<script>
  function pucoAjax() {
      let dni_paciente = document.getElementById('paciente-num_documento').value;
      document.getElementById("resultadoPuco").value ="";
      document.getElementById("resultadoPuco").placeholder ="Espere, buscando en el puco";
      $.ajax({
        url: '<?php echo Url::to(['/paciente/puco']) ?>',
          type: 'post',
          data: {
              dni: dni_paciente
          },
          success: function(data) {
              document.getElementById("resultadoPuco").value = "";
              var content = JSON.parse(data);

              if (content.error) {
                  document.getElementById("resultadoPuco").placeholder = content.error;
              } else if (Array.isArray(content)) {
                  document.getElementById("resultadoPuco").value = content[0];
              } else if (content.resultado) {
                  document.getElementById("resultadoPuco").value = content.resultado;
              }
          }


      });
  }
  function consultarRenaper() {
      let dni_paciente = document.getElementById("paciente-num_documento").value;
      let sexo_paciente = document.getElementById("paciente-sexo").value;
      const btn = document.getElementById("btnRenaper");

      // Validar que se hayan ingresado los datos necesarios
      if (!dni_paciente || !sexo_paciente) {
          alert('Por favor, complete el DNI y el sexo del paciente');
          return;
      }

      // Mostrar spinner
      btn.disabled = true;
      btn.innerHTML = '<span class="mini-spinner"></span>';

      // Realizar la consulta al endpoint
      $.ajax({
          url: '<?php echo Url::to(['/paciente/renaper']) ?>',
          type: 'post',
          data: {
              dni: dni_paciente,
              sexo: sexo_paciente
          },
          success: function(response) {
              // Restaurar el botón
              btn.disabled = false;
              btn.innerHTML = 'R';

              // Verificar si la respuesta tiene la estructura esperada
              if (response && response.success) {
                  // Caso 1: Datos encontrados
                  if (response.data.success && response.data.response && typeof response.data.response === 'object') {
                      const datos = response.data.response;

                      // Llenar los campos con los datos recibidos
                      if (datos.nombre) {
                          document.getElementById('paciente-nombre').value = datos.nombre;
                      }
                      if (datos.apellido) {
                          document.getElementById('paciente-apellido').value = datos.apellido;
                      }
                      if (datos.fecha_nacimiento) {
                          // Formatear la fecha de Y-m-d a d/m/Y
                          const fechaParts = datos.fecha_nacimiento.split('-');
                          if (fechaParts.length === 3) {
                              const fechaFormateada = `${fechaParts[2]}/${fechaParts[1]}/${fechaParts[0]}`;
                              document.getElementById('paciente-fecha_nacimiento').value = datos.fecha_nacimiento;
                              document.getElementById('paciente-fecha_nacimiento-disp').value = fechaFormateada;
                          }
                      }
                      if (datos.sexo) {
                          document.getElementById('paciente-sexo').value = datos.sexo;
                      }
                  }
                  // Caso 2: No se encontraron datos
                  else if (!response.data.success && response.data.response === "Datos no encontrados") {
                      alert('No se encontraron datos para el DNI y sexo ingresados');
                  }
                  // Caso 3: Respuesta inesperada
                  else {
                      alert('Error inesperado en la respuesta del servicio Renaper');
                  }
              } else {
                  alert(response.error || 'Error en la consulta al Renaper');
              }
          },
          error: function(xhr, status, error) {
              // Restaurar el botón en caso de error
              btn.disabled = false;
              btn.innerHTML = 'R';
              alert('Error al consultar el servicio. Por favor, intente nuevamente.');
              console.error('Error en la consulta:', error, xhr.responseText);
          }
      });
  }


      function quitarInput(id){
        // Eliminando todos los hijos de un elemento
        let  element  = document.getElementById("afiliado"+id);
        while (element.firstChild) {
          element.removeChild(element.firstChild);
        }
        element.remove();
      }



</script>
