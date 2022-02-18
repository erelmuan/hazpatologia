<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\grid\GridView;


///////////////////////////
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
///////////////////
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\TypeaheadBasic;
///////////////
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
//////////////
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Biopsias */
/* @var $form yii\widgets\ActiveForm */
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
      //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
        'model'=>$model,
        'form'=>$form,
         'columns'=>5,
         'attributes'=>[
         'Protocolo'=>['label'=>'Protocolo', 'options'=>['value'=>$dataSol->protocolo ,'readonly'=> true ],'columnOptions'=>['class'=>'col-sm-1',],],
         'Paciente'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Paciente', ['paciente/view' ,'id'=> $dataSol->id_paciente],
           ['role'=>'modal-remote','title'=> 'Ver paciente']), 'options'=>['value'=>$dataSol->paciente->apellido." ". $dataSol->paciente->nombre ,'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
           'DNI'=>['label'=>'DNI', 'options'=>['value'=>$dataSol->paciente->num_documento, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
           'Edad'=>['label'=>'Edad', 'options'=>['value'=>$edadDelPaciente, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],
           'Medico'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Medico', ['medico/view' ,'id'=> $dataSol->id_medico],
          ['role'=>'modal-remote','title'=> 'Ver medico']), 'options'=>['value'=>$dataSol->medico->apellido ." ". $dataSol->medico->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
         'id_solicitudbiopsia'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$dataSol->id ]],

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
      ?></br>
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
           'name' => 'id_diagnostico',
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

  ?></br> </br></br> </br></br></br>
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
          <?= $form->field($model, 'diagnostico')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'frase')->textarea(['rows' => 4,'style'=> 'font-size:17px;', 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        if( !$model->isNewRecord &&  $model->ihq){
            if ($model->ihq && isset($model->inmunohistoquimicaEscaneada)){
              // echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Ir inmunostoquimica',['/inmunohistoquimica/update', 'id'=>$model->inmunohistoquimica->id], ['class'=>'btn btn-success grid-button']) ;
              echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Ir inmunostoquimica',['/inmunohistoquimica-escaneada/update', 'id'=>$model->inmunohistoquimicaEscaneada->id], ['class'=>'btn btn-success grid-button']) ;

            }else {
              // echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Crear inmunostoquimica',['/inmunohistoquimica/create', 'id_biopsia'=>$model->id], ['class'=>'btn btn-success grid-button']) ;
              echo Html::a('<i class="glyphicon glyphicon-arrow-right"></i> Crear inmunostoquimica',['/inmunohistoquimica-escaneada/create', 'id_biopsia'=>$model->id], ['class'=>'btn btn-success grid-button']) ;
            }

        }
        ?>
    </div>
    <? if (Usuario::isPatologo()) { ?>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <div class='col-sm-5'>
            <label class="control-label" for="pap-contrseña">Contraseña</label>
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

<script type="text/javascript">
function cambioFirma() {
    if (document.getElementById("biopsia-firmado").value == 1) {
        document.getElementById("biopsia-firmado").value = 0;

    } else {
        document.getElementById("biopsia-firmado").value = 1;
    }
}

function quitarSeleccion() {
    $('span.kv-clear-radio').click();

}
// Hay que tener en cuenta cuando se modifican los div se modifican
//tambien el path con el atrubuto W--- puede que vaya de W4 a W5

function agregarFormularioMat() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        // $("span#select2-w2-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
        var textArea = document.getElementById('biopsia-material');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-material.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-material.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }
        // $("textarea#biopsia-material.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();
    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarMaterial() {
    // $("span#select2-w2-container.select2-selection__rendered")[0].innerText ="";
    $("textarea#biopsia-material.form-control").val('');
}



function agregarFormularioMac() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        // $("span#select2-w3-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
        var textArea = document.getElementById('biopsia-macroscopia');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-macroscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-macroscopia.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }
        // $("textarea#biopsia-macroscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }

}

function quitarMacroscopia() {
    $("textarea#biopsia-macroscopia.form-control").val('');
}

function agregarFormularioMic() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-microscopia');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-microscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-microscopia.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }
        // $("textarea#biopsia-microscopia.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarMicroscopia() {
    $("textarea#biopsia-microscopia.form-control").val('');
}

function agregarFormularioDiag() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-diagnostico');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-diagnostico.form-control").val(textArea.value + "\r\n" + $("tr.success").find(
                "td:eq(2)").text());
        }

        // $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }
}

function quitarDiagnostico() {
    $("textarea#biopsia-diagnostico.form-control").val('');

}


function agregarFormularioFra() {
    if ($("tr.success").find("td:eq(1)").text() != "") {
        var textArea = document.getElementById('biopsia-frase');
        if (textArea.value.trim() == "") {
            $("textarea#biopsia-frase.form-control").val($("tr.success").find("td:eq(2)").text());
        } else {
            $("textarea#biopsia-frase.form-control").val(textArea.value + "\r\n" + $("tr.success").find("td:eq(2)")
                .text());
        }

        //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
        $('span.kv-clear-radio').click();
        $('button.btn.btn-default').click();

    } else {
        swal(
            'No se ha seleccionado a ningún registro',
            'PRESIONAR OK',
            'error'
        );
    }

}

function quitarFrase() {
    $("textarea#biopsia-frase.form-control").val('');

}

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
