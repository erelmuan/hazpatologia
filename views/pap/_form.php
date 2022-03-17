<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
///////////////////
use yii\helpers\ArrayHelper;
use app\models\Plantillatopografia;
use app\models\Plantilladiagnostico;
use app\models\Plantillamicroscopia;
use app\models\Plantillamacroscopia;
use app\models\Plantillamaterialb;
use app\models\Plantillafrase;
use app\models\Procedencias;
use app\models\Plantillaflora;
use app\models\Plantillaaspecto;
use app\models\Plantillapavimentosa;
use app\models\Plantillaglandular;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\TypeaheadBasic;
///////////////
use kartik\widgets\DepDrop;
use yii\web\JsExpression;
//////////////
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use app\models\Usuario;
use nex\chosen\Chosen;

/* @var $this yii\web\View */
/* @var $model app\models\Biopsias */
/* @var $form yii\widgets\ActiveForm */

?>
<div id="w0" class="x_panel">
    <div class="x_title">
        <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVO PAP" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR PAP" ; ?>
        </h2>
        <div class="clearfix">
            <div class="nav navbar-right panel_toolbox">
                <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', $model->isNewRecord ? ['/solicitudpap/seleccionar']:['/pap/index'], ['class'=>'btn btn-danger grid-button']) ?>
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
               'id_solicitudpap'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$dataSol->id ]],
              ]
          ]);

      ?>

        </div>
    </div>

    <div class="x_panel">

        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <legend class="text-info"><small>Datos del pap</small></legend>

        <div class="x_content" style="display: block;">

            <div class="row">
                <center>

                    <div class="col-md-2 col-sm-12 col-xs-12 form-group"
                        style="padding-right: 10px;margin-right: 0px;margin-left: 0px;">
                        <?= $form->field($model, 'indicepicnotico')->input("text",['style'=>'width:70%','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))])->label('I.Picnótico') ?>
                    </div>
                    <!-- <div class="col-md-2 col-sm-12 col-xs-12 form-group"style="padding-right: 10px;margin-right: 0px;margin-left: 0px;"> -->
                    <?//= $form->field($model, 'indicedemaduracion')->input("text",['style'=>'width:70%'])->label('I.maduración') ?>
                    <!-- </div> -->
                    <!-- <div class="col-md-2 col-sm-12 col-xs-12 form-group"style="padding-right: 10px;margin-right: 0px;margin-left: 0px;"> -->
                    <?//= $form->field($model, 'eosinofilas')->input("text",['style'=>'width:70%'])->label('Eosinofilas %') ?>
                    <!-- </div> -->
                    <!-- <div class="col-md-2 col-sm-12 col-xs-12 form-group"style="padding-right: 10px;margin-right: 0px;margin-left: 0px;"> -->
                    <?//= $form->field($model, 'cianofilas')->input("text",['style'=>'width:70%'])->label('Cianofilas %') ?>
                    <!-- </div> -->
                    <!-- <div class="col-md-2 col-sm-12 col-xs-12 form-group"style="padding-right: 10px;margin-right: 0px;margin-left: 0px;"> -->
                    <?//= $form->field($model, 'intermedias')->input("text",['style'=>'width:70%'])->label('Intermedias %') ?>
                    <!-- </div> -->
                    <!-- <div class="col-md-2 col-sm-12 col-xs-12 form-group"style="padding-right: 10px;margin-right: 0px;margin-left: 0px;"> -->
                    <?//= $form->field($model, 'parabasales')->input("text",['style'=>'width:70%'])->label('Parabasales %') ?>
                    <!-- </div> -->
                </center>


                <?
                echo Form::widget([ // fields with labels
                  //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
                    'model'=>$model,
                    'form'=>$form,
                     'columns'=>4,
                     'attributes'=>[
                     // 'plegamiento'=>[ 'label'=>'Plegamiento', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "" , "+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"] ],
                     // 'agrupamiento'=>['label'=>'Agrupamiento', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"]],
                     'leucocitos'=>['label'=>'Leucocitos', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"] , 'options'=> ['disabled' => (isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]],
                     'hematies'=>['label'=>'Hematíes', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"], 'options'=> ['disabled' => (isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]],
                     // 'histiocitos'=>['label'=>'Histiocitos', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"]],
                     // 'detritus'=>['label'=>'Detritus', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"]],
                     // 'citolisis'=>['label'=>'Citólisis', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"],'columnOptions'=>['colspan'=>2]],
                    ]
                ]);  ?>
            </div>
            <?
                echo Form::widget([ // fields with labels
                  //  'contentBefore'=>'<legend class="text-info"><small>Datos del paciente</small></legend>',
                    'model'=>$model,
                    'form'=>$form,
                     'columns'=>3,
                     'attributes'=>[
                     // 'plegamiento'=>[ 'label'=>'Plegamiento', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "" , "+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"] ],
                     // 'agrupamiento'=>['label'=>'Agrupamiento', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"]],
                     // 'leucocitos'=>['label'=>'Leucocitos', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"]],
                     // 'hematies'=>['label'=>'Hematíes', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++"]],
                     'histiocitos'=>['label'=>'Histiocitos', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"], 'options'=> ['disabled' => (isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]],
                     'detritus'=>['label'=>'Detritus', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"], 'options'=> ['disabled' => (isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]],
                     'citolisis'=>['label'=>'Citólisis', 'type'=>Form::INPUT_DROPDOWN_LIST, 'items'=>["" => "","+" => "+", "++" => "++" ,"+++"=>"+++","++++"=>"++++","-"=>"-"], 'options'=> ['disabled' => (isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]],
                    ]
                ]);
              ?>
        </div>
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
       </br>
        <?  echo (Html::label('Código flora', 'flora', ['class' => 'form-group field-pap-material has-success']));
        if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){

        ?>
        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-flora-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarFlora()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?
      }
        $mapFlora= ArrayHelper::map(plantillaflora::find()->all() , 'id',  'codigo' );
        echo Chosen::widget([
              'name' => 'ChosenTest',
              'items' => $mapFlora,
              'allowDeselect' => true,

              'placeholder' => 'Seleccionar código..',

              'clientOptions' => [
                  'search_contains' => true,
                  'no_results_text'=>"Oops, nothing found!",
              ],
              'options' => [
                    'onchange' => 'onEnviarFlora (this.value)',
                    'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                    ],
          ]);

         ?></br> </br> </br> </br> </br>
        <?    echo ( Html::label('Código aspecto', 'aspecto', ['class' => 'form-group field-pap-aspecto has-success']));
          if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
         ?>

        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-aspecto-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarAspecto()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?
        }
       $mapAspecto= ArrayHelper::map(Plantillaaspecto::find()->all() , 'id',  'codigo' );

       echo Chosen::widget([
             'name' => 'ChosenTest',
             'items' => $mapAspecto,
             'allowDeselect' => true,

             'placeholder' => 'Seleccionar código..',

             'clientOptions' => [
                 'search_contains' => true,
                 'no_results_text'=>"Oops, nothing found!",
             ],
             'options' => [
                   'onchange' => 'onEnviarAspecto (this.value)',
                   'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                   ],
         ]);

      ?>
        </br> </br> </br> </br> </br> </br>
        <?  echo (Html::label('Código pavimentosa', 'pavimentosa', ['class' => 'form-group field-pap-pavimentosa has-success']));
        if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
         ?>

        <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
            data-target=".bs-pavimentosa-modal-lg" style="margin-left: 10px;"><i
                class="glyphicon glyphicon-plus"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarPavimentosas()"><i
                class="glyphicon glyphicon-minus"></i></button>
        <?
        }
     $mapPavimentosa= ArrayHelper::map(Plantillapavimentosa::find()->all() , 'id',  'codigo' );
     echo Chosen::widget([
           'name' => 'ChosenTest',
           'items' => $mapPavimentosa,
           'allowDeselect' => true,

           'placeholder' => 'Seleccionar código..',

           'clientOptions' => [
               'search_contains' => true,
               'no_results_text'=>"Oops, nothing found!",
           ],
           'options' => [
                 'onchange' => 'onEnviarPav (this.value)',
                 'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                 ],
       ]);

             ?>
        </br> </br> </br> </br> </br>
        <?
           echo (Html::label('Código glandular', 'glandular', ['class' => 'form-group field-pap-glandular has-success']));
       if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
            ?>
          <button type="button" class="btn btn-primary btn-xs" onclick="quitarSeleccion()" data-toggle="modal"
              data-target=".bs-glandular-modal-lg" style="margin-left: 10px;"><i
                  class="glyphicon glyphicon-plus"></i></button>
          <button type="button" class="btn btn-danger btn-xs" onclick="quitarGlandular()"><i
                  class="glyphicon glyphicon-minus"></i></button>
        <?
      }
      $mapglandular = ArrayHelper::map(Plantillaglandular::find()->all() , 'id',  'codigo'  );
        echo Chosen::widget([
              'name' => 'ChosenTest',
              'items' => $mapglandular,
              'allowDeselect' => true,

              'placeholder' => 'Seleccionar código..',

              'clientOptions' => [
                  'search_contains' => true,
                  'no_results_text'=>"Oops, nothing found!",
              ],
              'options' => [
                    'onchange' => 'onEnviarGlan (this.value)',
                    'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                    ],
          ]);


        ?>
        </br> </br> </br> </br> </br>
        <?
      echo (Html::label('Código diagnostico', 'codigo diagnostico', ['class' => 'form-group field-pap-diagnostico has-success']));
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
              'name' => 'ChosenTest',
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

      ?>
        </br> </br> </br> </br> </br> </br>
        <?
      echo (Html::label('Código frase', 'frase', ['class' => 'form-group field-pap-frase has-success'])) ;
      if( !isset($model->estado) || $model->estado->descripcion!=="LISTO" || Usuario::isPatologo()){
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
                'disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo())),

                ],
      ]);


          ?>
        </br> </br>
        <? if( !isset($model->estado) || $model->estado->descripcion!=="LISTO"){
            echo $form->field($model, 'id_estado')->dropDownList($model->estados())->label('Estado') ;

          }else {
            echo $form->field($model, 'id_estado')->hiddenInput()->label(false);
            echo  $form->field($model, 'estado')->input("text",['readonly' => true , "value"=>$model->estado->descripcion])->label('Estado');

          }?>
        <?//= $form->field($model, 'observacion')->textarea(['rows' => 7,'style'=> 'font-size:17px;']) ?>
    </div>

    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?=$form->field($model, 'flora')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))])  ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'aspecto')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'pavimentosas')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'glandulares')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
      <?= $form->field($model, 'diagnostico')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'frase')->textarea(['rows' => 3,'style'=> 'font-size:17px;','disabled'=>(isset($model->estado) && ($model->estado->descripcion=="LISTO" && !Usuario::isPatologo()))]) ?>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <? if (Usuario::isPatologo()) { ?>
    <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <div class='col-sm-5'>
            <label class="control-label" for="pap-contrseña">Contraseña</label>
            <input type="password" id="contraseña" class="form-control" name="contrasenia" style="width:50%; "
                aria-required="true" aria-invalid="false">
        </div>
        <div class='col-sm-3'>
            <?= $form->field($model, 'firmado')->checkBox(['label' => 'Firmar']); ?>
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
    ])?>
<?php Modal::end(); ?>
<?= Html::jsFile('@web/js/pap.js'); ?>


<script type="text/javascript">


function onEnviarFlora(val) {
    var textArea = document.getElementById('pap-flora');

    $.ajax({
        url: '<?php echo Url::to(['/plantillaflora/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("pap-flora").value = content[0].flora;
            } else {
                document.getElementById("pap-flora").value = current_value + "\r\n" + content[0].flora;
            }
        }
    });
}

function onEnviarAspecto(val) {
    var textArea = document.getElementById('pap-aspecto');

    $.ajax({
        url: '<?php echo Url::to(['/plantillaaspecto/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("pap-aspecto").value = content[0].aspecto;
            } else {
                document.getElementById("pap-aspecto").value = current_value + "\r\n" + content[0].aspecto;
            }

        }

    });


}

function onEnviarPav(val) {
    var textArea = document.getElementById('pap-pavimentosas');

    $.ajax({
        url: '<?php echo Url::to(['/plantillapavimentosa/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("pap-pavimentosas").value = content[0].pavimentosa;
            } else {
                document.getElementById("pap-pavimentosas").value = current_value + "\r\n" + content[0]
                    .pavimentosa;
            }
        }

    });
}

function onEnviarGlan(val) {
    var textArea = document.getElementById('pap-glandulares');

    $.ajax({
        url: '<?php echo Url::to(['/plantillaglandular/buscaregistro']) ?>',
        type: 'post',
        data: {
            id: val
        },
        success: function(data) {
            var current_value = textArea.value;
            var content = JSON.parse(data);
            if (current_value.trim() == "") {
                document.getElementById("pap-glandulares").value = content[0].glandular;
            } else {
                document.getElementById("pap-glandulares").value = current_value + "\r\n" + content[0]
                    .glandular;
            }
        }

    });
}

function onEnviarDiag(val) {
    var textArea = document.getElementById('pap-diagnostico');

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
                document.getElementById("pap-diagnostico").value = content[0].diagnostico;
            } else {
                document.getElementById("pap-diagnostico").value = current_value + "\r\n" + content[0]
                    .diagnostico;
            }
        }

    });
}



function onEnviarFra(val) {

    var textArea = document.getElementById('pap-frase');
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
                document.getElementById("pap-frase").value = content[0].frase;
            } else {
                document.getElementById("pap-frase").value = current_value + "\r\n" + content[0].frase;
            }
        }

    });
}
</script>
