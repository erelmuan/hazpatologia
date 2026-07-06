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
      <h2 style="
          border:2px solid #337ab7;
          background:#f5f9fd;
          color:#337ab7;
          padding:12px 15px;
          border-radius:5px;
          margin-bottom:20px;
      ">
          <?= $model->isNewRecord
              ? "<i class='glyphicon glyphicon-plus'></i> NUEVO INFORME COMPLEMENTARIO"
              : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR INFORME COMPLEMENTARIO"; ?>
      </h2>
        <div class="clearfix">
            <div class="nav navbar-right panel_toolbox">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/biopsia/update/' , 'id'=>$model->id_biopsia], ['class'=>'btn btn-danger grid-button']) ?>
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
        'model'=>$biopsia,
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

    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
        <?=$form->field($biopsia, 'material')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>true])  ?>

        <?= $form->field($biopsia, 'diagnostico')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>true]) ?>
        <?= $form->field($model, 'descripcion')->textarea(['rows' => 4,'style'=> 'font-size:17px;', ]) ?>
        <?= $form->field($model, 'id_biopsia')->hiddenInput()->label(false); ?>
        <div class="form-group spacing-top-2">
          <?=$form->field($model, 'id_estado')->dropDownList(
              $stateOptions,
              ['prompt' => 'Seleccione estado']
          ) ?>
        </div>
        <div class="col-md-12 form-group" style="display:flex; align-items:center; gap:10px;">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Guardar' : 'Actualizar',
                [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'disabled' => (
                        isset($model->estado) &&
                        ($model->estado->descripcion=="LISTO" && !Usuario::esPatologo())
                    )
                ]
            ); ?>
      </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <div class='col-sm-8'>
                <label class="control-label" for="biopsia-contraseña">Contraseña</label>
                <input type="password" id="contraseña" class="form-control" name="contrasenia" style="width:50%; "
                    aria-required="true" aria-invalid="false">
            </div>
        </div>

    </div>
    <div class="col-sm-6 col-sm-8 col-dm-9 form-group">
      <label> Estudio IHQ </label>
      <p>
          <? if (isset($biopsia->inmunohistoquimicaEscaneada )&& !empty($biopsia->inmunohistoquimicaEscaneada->documento)){ ?>
            <embed src="<?= Yii::getAlias('@web') . '/uploads/inmunohistoquimicas/' . rawurlencode($biopsia->inmunohistoquimicaEscaneada->documento) ?>" type="application/pdf" width="100%" height="700">
          <? }else {
              echo "NO TIENE ESTUDIO CARGADO";
          }?>


        </p>
      </div>



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
