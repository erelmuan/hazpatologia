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
use app\models\patronState\EstadoBase;
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

        ]
    ]);


?>
        </div>
    </div>

    <legend class="text-info"><small style="margin-left: 18px;">Datos de la biopsia</small></legend>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
      <div class="form-group spacing-top-2">

        <?  echo (Html::label('Código material', 'username', ['class' => 'form-group field-biopsias-material has-success']));
        if( !$model->estaBloqueado()){

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
                  'disabled'=>$model->estaBloqueado(),

                  ],
        ]);
                    ?>
            </div>
      <div class="form-group spacing-top-6">

        <? echo ( Html::label('Código macroscopia', 'macro', ['class' => 'form-group field-biopsias-macroscopia has-success']));
        if(!$model->estaBloqueado()){

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
                         'disabled'=>($model->estaBloqueado()),
                         ],
               ]);

                 ?>
      </div>

         <div class="form-group spacing-top-6">
            <?  echo (Html::label('Código microscopia', 'username', ['class' => 'form-group field-biopsias-microscopia has-success']));
            if( !$model->estaBloqueado()){
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
                             'disabled'=>($model->estaBloqueado()),
                             ],
                   ]);

            ?>
      </div>
      <div class="form-group spacing-top-2">

          <?
        echo ( $form->field($model, 'ihq')->widget(SwitchInput::classname(), [    'pluginOptions' => [
          'onText' => 'Si',
          'offText' => 'No',
        ],
        'disabled'=>($model->estaBloqueado()),
      ]))->label('Estudio inmunostoquimica');
        ?>
      </div>
      <div class="form-group spacing-top-2">
        <?
      echo (Html::label('Código diagnostico', 'codigo diagnostico', ['class' => 'form-group field-biopsias-diagnostico has-success']));
      if( !$model->estaBloqueado()){
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
                 'disabled'=>$model->estaBloqueado(),

                 ],
       ]);
  ?>
  </div>
  <div class="form-group spacing-top-6">

 <?
   echo (Html::label('Código frase', 'frase', ['class' => 'form-group field-biopsias-frase has-success'])) ;
   if(!$model->estaBloqueado()){
   ?>
     <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
         data-target=".bs-frase-modal-lg" style="margin-left: 10px;"><i
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
                'disabled'=>$model->estaBloqueado(),

               ],
     ]);

     ?>
     </div>
      <div class="form-group spacing-top-2">
        <?=$form->field($model, 'id_estado')->dropDownList(
            $stateOptions,
            ['prompt' => 'Seleccione estado']
        ) ?>
      </div>

    </div>


    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?=$form->field($model, 'material')->textarea(['rows' => 4,'style'=> 'font-size:17px;',   'disabled'=>$model->estaBloqueado()])  ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'macroscopia')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>$model->estaBloqueado()]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'microscopia')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>$model->estaBloqueado()]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <div class="form-group spacing-top-2">
          <?= $form->field($model, 'diagnostico')->textarea(['rows' => 4,'style'=> 'font-size:17px;','disabled'=>$model->estaBloqueado()]) ?>
        </div>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'frase')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>$model->estaBloqueado()]) ?>
    </div>

    <div class="col-md-12 form-group"
       style="display:flex; align-items:center; gap:10px;">

      <?= Html::submitButton(
          $model->isNewRecord ? 'Guardar' : 'Actualizar',
          [
              'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
              'disabled' => $model->estaBloqueado()
          ]
      ); ?>

      <?php
      if (!$model->isNewRecord && $model->ihq){

          if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)){

              echo Html::a(
                  '<i class="glyphicon glyphicon-arrow-right"></i> Ir inmunostoquimica',
                  ['/inmunohistoquimica-escaneada/update', 'id'=>$model->inmunohistoquimicaEscaneada->id],
                  ['class'=>'btn btn-success']
              );

          }

      }
      ?>

      <div style="margin-left:auto;">
        <? if($model->estaListoPersistido() ): ?>
        <?php if ($model->informeComplementario !== null): ?>
          <?= Html::a(
              '<i class="fas fa-eye"></i>',
              $model->urlVerInformeComplementario(),
              [
                  'class' => 'btn btn-info',
                  'title' => 'Ver informe complementario',
                  'target' => '_blank',
                  'rel' => 'noopener noreferrer',
              ]
          ) ?>

        <?php endif; ?>
        <?= Html::a(
            $model->informeComplementario !== null
                ? '<i class="fas fa-pen"></i> Actualizar informe complementario'
                : '<i class="fas fa-plus"></i> Crear informe complementario',
            $model->urlInformeComplementario(),
            [
                'class' => $model->informeComplementario !== null
                    ? 'btn btn-warning'
                    : 'btn btn-success',
            ]
        ) ?>
        <?php if ($model->informeComplementario !== null && $model->informeComplementario->estaEnproceso()): ?>
        <?= Html::a('<i class="fas fa-trash"></i>',   ['/informe-complementario/delete', 'id' => $model->informeComplementario->id ],[
             'class' => 'btn btn-danger btn-sm',
             'role' => 'modal-remote',
             'data-request-method' => 'post',
             'data-confirm-title' => 'Confirmar eliminación',
             'data-confirm-message' => '¿Está seguro de eliminar el informe complementario?',
          ])
          ?>

      <?php endif; ?>
      <?php endif ?>
      </div>

  </div>
    <? if (Usuario::esPatologo()) { ?>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <div class='col-sm-5'>
            <label class="control-label" for="biopsia-contraseña">Contraseña</label>
            <input type="password" id="contraseña" class="form-control" name="contrasenia" style="width:50%; "
                aria-required="true" aria-invalid="false">
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
