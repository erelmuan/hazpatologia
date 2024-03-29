<?php
/* @var $this yii\web\View */
/* @var $model app\models\Biopsias */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\TypeaheadBasic;
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\models\Usuario;
use kartik\widgets\SwitchInput;
use nex\chosen\Chosen;
?>
<div id="w0" class="x_panel">
    <div class="x_title">
        <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA BIOPSIA" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR BIOPSIA" ; ?>
        </h2>
        <div class="clearfix">
            <div class="nav navbar-right panel_toolbox">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', $model->isNewRecord ? ['/solicitudbiopsia/seleccionar']:['/biopsia/index'], ['class'=>'btn btn-danger grid-button']) ?>
            </div>
        </div>
    </div>

    <?
CrudAsset::register($this);

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);
?>
    <div class="x_panel">

        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <legend class="text-info"><small>Datos de la solicitud</small></legend>
        <div class="x_content" style="display: block;">
            <?
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
         'columns'=>5,
         'attributes'=>[
         'Protocolo'=>['label'=>'Protocolo', 'options'=>['value'=>$solicitud->protocolo ,'readonly'=> true ],'columnOptions'=>['class'=>'col-sm-1',],],
         'Paciente'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Paciente', ['paciente/view' ,'id'=> $solicitud->id_paciente],
           ['role'=>'modal-remote','title'=> 'Ver paciente']), 'options'=>['value'=>$solicitud->paciente->apellido." ". $solicitud->paciente->nombre ,'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
           'DNI'=>['label'=>'DNI', 'options'=>['value'=>$solicitud->paciente->num_documento, 'placeholder'=>'Documento...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
           'Edad'=>['label'=>'Edad', 'options'=>['value'=>$solicitud->calcular_edad(), 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],
           'Medico'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Medico', ['medico/view' ,'id'=> $solicitud->id_medico],
          ['role'=>'modal-remote','title'=> 'Ver medico']), 'options'=>['value'=>$solicitud->medico->apellido ." ". $solicitud->medico->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
         'id_solicitudbiopsia'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$solicitud->id ]],

        ]
    ]);


?>
        </div>
    </div>

    <legend class="text-info"><small style="margin-left: 18px;">Datos de la biopsia</small></legend>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
    </br>  </br>
        <?  echo (Html::label('Código material', 'username', ['class' => 'form-group field-biopsias-material has-success']));
        if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){

        ?>
        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-material-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarMaterial()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?}
        $mapMaterial= ArrayHelper::map($array['arraymaterial'], 'id',  'codigo' );
      echo Chosen::widget([
            'name' => 'id_material',
            'items' => $mapMaterial,
            'allowDeselect' => true,
            'placeholder' => 'Seleccionar código..',
            'clientOptions' => [
                'search_contains' => true,
                'no_results_text'=>"Oops, nothing found!",
            ],
            'options' => [
                  'onchange' => 'onEnviarMat (this.value)',
                  'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                  ],
        ]);

                    ?>
          </br>  </br>   </br>  </br>  </br>  </br>
        <? echo ( Html::label('Código macroscopia', 'macro', ['class' => 'form-group field-biopsias-macroscopia has-success']));
        if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){

         ?>
        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-macroscopia-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarMacroscopia()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?}
               $mapMacroscopia= ArrayHelper::map($array['arraymacroscopia'] , 'id',  'codigo' );
               echo Chosen::widget([
                   'name' => 'id_macroscopia',
                   'items' => $mapMacroscopia,
                   'allowDeselect' => true,
                   'placeholder' => 'Seleccionar código..',
                   'clientOptions' => [
                       'search_contains' => true,
                       'no_results_text'=>"Oops, nothing found!",
                   ],
                   'options' => [
                         'onchange' => 'onEnviarMac (this.value)',
                         'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),
                         ],
               ]);

                 ?>
         </br>  </br>  </br>  </br>  </br> </br>
        <?  echo (Html::label('Código microscopia', 'username', ['class' => 'form-group field-biopsias-microscopia has-success']));
        if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
        ?>

        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-microscopia-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarMicroscopia()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?}
             $mapMicroscopia= ArrayHelper::map($array['arraymicroscopia'] , 'id',  'codigo' );
             echo Chosen::widget([
                   'name' => 'id_microscopia',
                   'items' => $mapMicroscopia,
                   'allowDeselect' => true,
                   'placeholder' => 'Seleccionar código..',
                   'clientOptions' => [
                       'search_contains' => true,
                       'no_results_text'=>"Oops, nothing found!",
                   ],
                   'options' => [
                         'onchange' => 'onEnviarMic (this.value)',
                         'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                         ],
               ]);

        ?>
        </br></br></br>
        <?
      echo ( $form->field($model, 'ihq')->widget(SwitchInput::classname(), [    'pluginOptions' => [
        'onText' => 'Si',
        'offText' => 'No',
      ],
      'disabled'=>isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()),
    ]))->label('Estudio inmunostoquimica');
      ?>
      </br>
      </br>
        <?
      echo (Html::label('Código diagnostico', 'codigo diagnostico', ['class' => 'form-group field-biopsias-diagnostico has-success']));
      if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
      ?>
        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-diagnostico-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarDiagnostico()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?}
     $mapdiagnostico = ArrayHelper::map($array['arraydiagnostico'] , 'id',  'codigo'  );
     echo Chosen::widget([
           'name' => 'Biopsia[id_plantilladiagnostico]',
           'items' => $mapdiagnostico,
           'allowDeselect' => true,
           'placeholder' => 'Seleccionar código..',
           'clientOptions' => [
               'search_contains' => true,
               'no_results_text'=>"Oops, nothing found!",
           ],
           'options' => [
                 'onchange' => 'onEnviarDiag (this.value)',
                 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                 ],
       ]);
  ?></br> </br>
    <!-- <?//= (Html::label('Código CIE10', 'codigo diagnostico', ['class' => 'form-group field-biopsia-diagnostico has-success'])); ?>

      <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
          data-target=".bs-cie10-modal-lg" style="margin-left: 10px;"><i
              class="glyphicon glyphicon-plus"></i></button>
      <button type="button" class="btn btn-danger btn-xs" onclick="quitarCie10()"><i
          class="glyphicon glyphicon-minus"></i></button>
       <input type="hidden" id="biopsia-id_cie10" name =Biopsia[id_cie10]> -->
      <!-- <input type="text" id="biopsia-cie10" class="form-control" value='<?=($model->biopsiacie10)?$model->biopsiacie10->cie10->codigo:''; ?>' style="width:30%" aria-invalid="false" readonly> -->
      <!-- <input type="text" id="biopsia-cie10" class="form-control"  style="width:30%" aria-invalid="false" readonly> -->

  </br>
  </br>
  </br>
    <?
      echo (Html::label('Código frase', 'frase', ['class' => 'form-group field-biopsias-frase has-success'])) ;
      if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
      ?>
        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-frases-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarFrase()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?
      }
      $mapFrases= ArrayHelper::map($array['arrayfrase'] , 'id',  'codigo' );
      echo Chosen::widget([
            'name' => 'ChosenTest',
            'items' => $mapFrases,
            'allowDeselect' => true,
            'placeholder' => 'Seleccionar código..',
            'clientOptions' => [
                'search_contains' => true,
                'no_results_text'=>"Oops, nothing found!",
            ],
            'options' => [
                  'onchange' => 'onEnviarFra (this.value)',
                  'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                  ],
        ]);

        ?>
        </br> </br>
        <?   if( !isset($model->estado) || $model->estado->descripcion!=="LISTO"){
              echo $form->field($model, 'id_estado')->dropDownList($model->estados())->label('Estado') ;

        }else {
            echo $form->field($model, 'id_estado')->hiddenInput()->label(false);
             echo  $form->field($model, 'estado')->input("text",['readonly' => true , "value"=>$model->estado->descripcion])->label('Estado');

        }?>

        <?//= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    </div>


    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?=$form->field($model, 'material')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))])  ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'macroscopia')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'microscopia')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
          </br>
          </br>
          </br>
          <?= $form->field($model, 'diagnostico')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'frase')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
        <? if (Usuario::isPatologo() && isset($model->estado) && $model->estado->descripcion=="LISTO")  {?>
          <div class="col-lg-2"  style="background-color: #f2dede; border: 0.5px solid #ebccd1; padding: 10px;">
            <label class="control-label">
            Anular estudio
            </label>
          <input type="checkbox" id="biopsia-anulado" class="form-control" name="Biopsia[anulado]" value="1" title="Si esta activo, y actualiza se anulara el estudio">
          </div>
        <? } ?>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]);

        if( !$model->isNewRecord &&  $model->ihq){
            if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)){
              echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Ir inmunostoquimica',['/inmunohistoquimica-escaneada/update', 'id'=>$model->inmunohistoquimicaEscaneada->id], ['class'=>'btn btn-success grid-button']) ;
            }else {
              echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Crear inmunostoquimica',['/inmunohistoquimica-escaneada/create', 'id_biopsia'=>$model->id], ['class'=>'btn btn-success grid-button']) ;
            }

        }
        ?>



    </div>
    <? if (Usuario::isPatologo()) { ?>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <div class='col-sm-5'>
            <label class="control-label" for="biopsia-contraseña">Contraseña</label>
            <input type="password" id="contraseña" class="form-control" name="contrasenia" style="width:50%; "
                aria-required="true" aria-invalid="false">
        </div>
        <div class='col-sm-3'>
            <?= $form->field($model, 'firmado')->checkbox()->label('FIRMAR (si el estado del estudio es EN PROCESO, se ignorara esta opción)'); ?>

        </div>
    </div>
    <? } ?>
    <?= $this->render('modals', [
        'model' => $model,
        'search' => $search,
        'provider' => $provider,

    ]) ?>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::begin([
     "id"=>"ajaxCrudModal",
     "footer"=>"",// always need it for jquery plugin

]);

?>

<?php Modal::end(); ?>
<?= Html::jsFile('@web/js/biopsia.js'); ?>
<script>
function onEnviarDiag(val) {
    var textArea = document.getElementById('biopsia-diagnostico');

    $.ajax({
        url: '<?php echo Url::to(['/plantilladiagnostico/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
          //   document.getElementById("biopsia-cie10").value = content[1];
        //     document.getElementById("biopsia-id_cie10").value = content[0].id_cie10;

            if (current_value.trim() == "") {
                document.getElementById("biopsia-diagnostico").value = content[0].diagnostico;
            } else {
                document.getElementById("biopsia-diagnostico").value = current_value + "\r\n" + content[0]
                    .diagnostico;
            }

        }

    });
}

function onEnviarMic(val) {
    var textArea = document.getElementById('biopsia-microscopia');

    $.ajax({
        url: '<?php echo Url::to(['/plantillamicroscopia/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("biopsia-microscopia").value = content[0].microscopia;
            } else {
                document.getElementById("biopsia-microscopia").value = current_value + "\r\n" + content[0]
                    .microscopia;
            }
        }

    });
}

function onEnviarMac(val) {
    var textArea = document.getElementById('biopsia-macroscopia');

    $.ajax({
        url: '<?php echo Url::to(['/plantillamacroscopia/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("biopsia-macroscopia").value = content[0].macroscopia;
            } else {
                document.getElementById("biopsia-macroscopia").value = current_value + "\r\n" + content[0]
                    .macroscopia;
            }
        }

    });
}

function onEnviarMat(val) {
    var textArea = document.getElementById('biopsia-material');
    $.ajax({
        url: '<?php echo Url::to(['/plantillamaterial/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("biopsia-material").value = content[0].material;
            } else {
                document.getElementById("biopsia-material").value = current_value + "\r\n" + content[0]
                    .material;
            }
        }
    });
}


function onEnviarFra(val) {

    var textArea = document.getElementById('biopsia-frase');
    $.ajax({
        url: '<?php echo Url::to(['/plantillafrase/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("biopsia-frase").value = content[0].frase;
            } else {
                document.getElementById("biopsia-frase").value = current_value + "\r\n" + content[0].frase;
            }
        }

    });
}
</script>
