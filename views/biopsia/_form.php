<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;

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

?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA BIOPSIA" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR BIOPSIA" ; ?> </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', $model->isNewRecord ? ['/solicitudbiopsia/seleccionar']:['/biopsia/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>

<?
CrudAsset::register($this);
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL, 'formConfig'=>['labelSpan'=>4]]);
?>

<div class="x_panel" >
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
         'columns'=>6,
         'attributes'=>[
         'Protocolo'=>['label'=>'Protocolo', 'options'=>['value'=>$dataSol->protocolo ,'readonly'=> true ],'columnOptions'=>['class'=>'col-sm-1',],],
         'Procedencia'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Procedencia', ['procedencia/view' ,'id'=> $dataSol->id_procedencia],
           ['role'=>'modal-remote','title'=> 'Ver procedencia']), 'options'=>['value'=>$dataSol->procedencia->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-dm-1',],],
         'Paciente'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Paciente', ['paciente/view' ,'id'=> $dataSol->id_paciente],
           ['role'=>'modal-remote','title'=> 'Ver paciente']), 'options'=>['value'=>$dataSol->paciente->apellido.' '.$dataSol->paciente->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
         'Medico'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Medico', ['medico/view' ,'id'=> $dataSol->id_medico],
          ['role'=>'modal-remote','title'=> 'Ver medico']), 'options'=>['value'=>$dataSol->medico->apellido.' '.$dataSol->medico->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
         //'Sexo'=>['label'=>'Sexo',  'options'=>['value'=>$dataSol->paciente->sexo, 'readonly'=> true],'columnOptions'=>['class'=>'col-sm-1',]],
         //'Estudio'=>['label'=>'Estudio', 'options'=>['value'=>$dataSol->estudio, 'readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
         'Edad'=>['label'=>'Edad', 'options'=>['value'=>$edadDelPaciente, 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],

        // Esto es de solicitud 'Estado'=>['label'=>'Estado', 'options'=>['value'=>$dataSol->estado ,'readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
      // Esto es de solicitud   'Observación'=>['label'=>'Observación', 'options'=>['value'=>$dataSol->observacion ,'readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
         'id_solicitudbiopsia'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$dataSol->id ]],

          // 'Fecha'=>[ 'label'=>'Fecha de nacimiento', 'widgetClass'=>'\kartik\datecontrol\DateControl','columnOptions'=>['class'=>'col-sm-3'],],
        ]
    ]);

      echo" <div class='col-sm-3'>";

      // echo $form->field($model, 'Fecha')->widget(DatePicker::className(), [
      //        'options' => ['placeholder' => 'Debe agregar una fecha',
      //          'value' =>  date('d/m/Y'),
      //          'type' => DatePicker::TYPE_COMPONENT_APPEND,
      //                ],
      //         'pluginOptions' => [
      //           'format' => 'dd/mm/yyyy',
      //           'todayHighlight' => true,
      //          ],
      //          'pluginEvents' => [
      //                "changeDate" => "function(e){
      //                  cambiarFechaNac();
      //                }",
      //
      //        ],
      //        ]);
      echo"</div>";
      echo"</br>";

      echo '<div class="text-right" style="margin-right: 100px;">' . Html::resetButton('Limpiar', ['class'=>'btn btn-warning']) . '</div>';

?>
</div>
</div>

<legend class="text-info"><small style="margin-left: 18px;">Datos de la biopsia</small></legend>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">

        <?  echo (Html::label('Código material', 'username', ['class' => 'form-group field-biopsias-material has-success'])); ?>

        <?
        // echo  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/plantillamaterialb/plantillamb'],
        //  ['data-toggle'=>'modal', 'data-target'=>'.bs-material-modal-lg' ,'title'=> 'Ver material','class'=>'btn btn-primary btn-xs']); ?>
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-material-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarMaterial()"><i class="glyphicon glyphicon-minus"></i></button>
        <?
        $mapMaterial= ArrayHelper::map($array['arraymaterial'], 'id',  'codigo' );

              echo Select2::widget( [
                            'name' => 'material',
                            'attribute' => 'Material',
                            'data' => $mapMaterial,
                            'language' => 'es',
                            'options' => [
                            'onchange' => 'onEnviarMat (this.value)',
                            'placeholder' => 'Seleccionar código..',
                            'multiple' => false
                              ],
                            'pluginOptions' => [
                                'allowClear' => true
                              ],
                    ]);
             echo (Html::label('Código topografia', 'username', ['class' => 'form-group field-biopsias-material has-success'])); ?>
            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-topografia-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
            <button type="button" class="btn btn-danger btn-xs" onclick="quitarTopografia()"><i class="glyphicon glyphicon-minus"></i></button>
          <?


          $maptopografia = ArrayHelper::map($array['arraytopografia'] , 'id',  'codigo'  );

          echo Select2::widget( [
                        'name' => 'topografia',
                        'attribute' => 'Topografia',
                        'data' => $maptopografia,
                        'language' => 'es',
                        'options' => [
                        'onchange' => 'onEnviarTop (this.value)',
                        'placeholder' => 'Seleccionar código..',
                        'multiple' => false
                          ],
                        'pluginOptions' => [
                            'allowClear' => true
                          ],
                ]);


               echo ( Html::label('Código macroscopia', 'macro', ['class' => 'form-group field-biopsias-macroscopia has-success']));

              ?>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-macroscopia-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="quitarMacroscopia()"><i class="glyphicon glyphicon-minus"></i></button>
             <?
               $mapMacroscopia= ArrayHelper::map($array['arraymacroscopia'] , 'id',  'codigo' );

               echo Select2::widget( [
                          'name' => 'macroscopia',
                          'attribute' => 'Macroscopia',
                          'data' => $mapMacroscopia,
                          'language' => 'es',
                          'options' => [
                          'onchange' => 'onEnviarMac (this.value)',
                          'placeholder' => 'Seleccionar código..',
                          'multiple' => false
                             ],
                          'pluginOptions' => [
                           'allowClear' => true
                                 ],
                 ]);


              echo (Html::label('Código microscopia', 'username', ['class' => 'form-group field-biopsias-microscopia has-success']));
              ?>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-microscopia-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
                <button type="button" class="btn btn-danger btn-xs" onclick="quitarMicroscopia()"><i class="glyphicon glyphicon-minus"></i></button>
             <?
             $mapMicroscopia= ArrayHelper::map($array['arraymicroscopia'] , 'id',  'codigo' );

                 echo Select2::widget( [
                         'name' => 'microscopia',
                         'attribute' => 'Microscopia',
                         'data' => $mapMicroscopia,
                         'language' => 'es',
                         'options' => [
                                 'onchange' => 'onEnviarMic (this.value)',
                                 'placeholder' => 'Seleccionar código..',
                                 'multiple' => false
                                 ],
                                 'pluginOptions' => [
                                 'allowClear' => true
                                   ],
                           ]);

      echo ( $form->field($model, 'ihq')->textarea(['rows' => 3]));

      echo (Html::label('Código diagnostico', 'codigo diagnostico', ['class' => 'form-group field-biopsias-diagnostico has-success']));
      if($model->estado->descripcion!=="LISTO"){
      ?>
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-diagnostico-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarDiagnostico()"><i class="glyphicon glyphicon-minus"></i></button>
     <?}
     $mapdiagnostico = ArrayHelper::map($array['arraydiagnostico'] , 'id',  'codigo'  );

     echo Select2::widget( [
             'name' => 'diagnostico',
             'attribute' => 'Diagnostico',
             'data' => $mapdiagnostico,
             'language' => 'es',
             'options' => [
                     'onchange' => 'onEnviarDiag (this.value)',
                     'placeholder' => 'Seleccionar código..',
                     'multiple' => false,
                      'disabled'=>($model->estado->descripcion=="LISTO")?true:false,

                     ],
                     'pluginOptions' => [
                     'allowClear' => true,
                       ],
               ]);


      echo (Html::label('Código frase', 'frase', ['class' => 'form-group field-biopsias-frase has-success'])) ;
      ?>
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-frases-modal-lg" style="margin-left: 10px;"><i class="glyphicon glyphicon-plus" ></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="quitarFrase()"><i class="glyphicon glyphicon-minus"></i></button>
     <?
      $mapFrases= ArrayHelper::map($array['arrayfrase'] , 'id',  'codigo' );

      echo Select2::widget( [
                    'name' => 'frases',
                    'attribute' => 'Frases',
                    'data' => $mapFrases,
                    'language' => 'es',
                    'options' => [
                          'onchange' => 'onEnviarFra (this.value)',
                          'placeholder' => 'Seleccionar código..',
                          'multiple' => false
                            ],
                    'pluginOptions' => [
                          'allowClear' => true
                            ],
                  ]);

          ?>

        <? if ($model->estado->descripcion=="LISTO") {
          echo  $form->field($model, 'estado')->input("text",['readonly' => true , "value"=>$model->estado->descripcion])->label('Estado');

        }else {
            echo $form->field($model, 'id_estado')->dropDownList($model->estados())->label('Estado') ;
        }?>

        <?= $form->field($model, 'observacion')->textarea(['rows' => 6]) ?>

    </div>


      <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?=$form->field($model, 'topografia')->textarea(['rows' => 4])  ?>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'macroscopia')->textarea(['rows' => 4]) ?>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <?= $form->field($model, 'microscopia')->textarea(['rows' => 4]) ?>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        <? if ($model->estado->descripcion=="LISTO") {
            echo $form->field($model, 'diagnostico')->textarea(['rows' => 4, 'readonly' => true]);
          } else {
            echo $form->field($model, 'diagnostico')->textarea(['rows' => 4 ]);
          }
            ?>
     </div>
     <div class="col-md-8 col-sm-12 col-xs-12 form-group">
      <?= $form->field($model, 'frase')->textarea(['rows' => 4]) ?>
     </div>
    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

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

<script type="text/javascript">
// Hay que tener en cuenta cuando se modifican los div se modifican
//tambien el path con el atrubuto W--- puede que vaya de W4 a W5

    function agregarFormularioMat (){
      $("span#select2-w2-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      $("textarea#biopsia-topografia.form-control").val($("tr.success").find("td:eq(2)").text());
      $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(3)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();

  }
    function quitarMaterial (){
      $("span#select2-w2-container.select2-selection__rendered")[0].innerText ="";
      $("textarea#biopsia-topografia.form-control").val('') ;
      $("textarea#biopsia-diagnostico.form-control").val('') ;
    }

    function agregarFormularioTop (){
      $("span#select2-w3-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      //$("textarea#biopsias-topografia.form-control").val($("tr.success").find("td:eq(2)").text());
      var textArea = document.getElementById('biopsia-topografia');
      $("textarea#biopsia-topografia.form-control").val(textArea.value +"\r\n"+ $("tr.success").find("td:eq(2)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();
  }
    function quitarTopografia (){
      $("span#select2-w3-container.select2-selection__rendered")[0].innerText ="";
      $("textarea#biopsia-topografia.form-control").val('') ;
    }


    function agregarFormularioMac (){
      $("span#select2-w4-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      $("textarea#biopsia-macroscopia.form-control").val($("tr.success").find("td:eq(2)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();
      }
    function quitarMacroscopia(){
      $("span#select2-w4-container.select2-selection__rendered")[0].innerText ="";
      $("textarea#biopsia-macroscopia.form-control").val('') ;
    }

    function agregarFormularioMic (){
      $("span#select2-w5-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      $("textarea#biopsia-microscopia.form-control").val($("tr.success").find("td:eq(2)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();

    }
      function quitarMicroscopia (){
        $("span#select2-w5-container.select2-selection__rendered")[0].innerText ="";
        $("textarea#biopsia-microscopia.form-control").val('') ;
      }

    function agregarFormularioDiag (){
      $("span#select2-w6-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      $("textarea#biopsia-diagnostico.form-control").val($("tr.success").find("td:eq(2)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();
      }
    function quitarDiagnostico (){
      $("span#select2-w6-container.select2-selection__rendered")[0].innerText ="";
      $("textarea#biopsia-diagnostico.form-control").val('') ;

        }


    function agregarFormularioFra (){
      $("span#select2-w7-container.select2-selection__rendered")[0].innerText =$("tr.success").find("td:eq(1)").text();
      var textArea = document.getElementById('biopsia-frase');
      $("textarea#biopsia-frase.form-control").val(textArea.value +"\r\n"+ $("tr.success").find("td:eq(2)").text());
      //vacias el contenido de la variable para que no se anexe con otra eleccion de otro campo
      $('button.close.kv-clear-radio').click();
      alert("Se agrego al formulario");
      $('button.btn.btn-default').click();

      }
    function quitarFrase (){
      $("span#select2-w7-container.select2-selection__rendered")[0].innerText ="";
      $("textarea#biopsia-frase.form-control").val('') ;

        }
// LA FUNCION BUSCAR REGISTRO SE ENCUENTRA EN LA CLASE CONTROLLER UBICADO EN YIISOFT
  function onEnviarTop(val)
   {
        var textArea = document.getElementById('biopsia-topografia');

       $.ajax({
             url: '<?php echo Url::to(['/plantillatopografia/buscaregistro']) ?>',
          type: 'post',
          data: {id: val },
          success: function (data) {
              var current_value = textArea.value;
              var content = JSON.parse(data);
              document.getElementById("biopsia-topografia").value=  current_value +"\r\n"+ content[0].topografia;
             //document.getElementById("biopsias-topografia").value= content[0].Topografía;
        }

     });


   }
   function onEnviarDiag(val)
    {
      var textArea = document.getElementById('biopsia-diagnostico');

        $.ajax({
            url: '<?php echo Url::to(['/plantilladiagnostico/buscaregistro']) ?>',
           type: 'post',
           data: {id: val },
           success: function (data) {
             var current_value = textArea.value;
             var content = JSON.parse(data);
            document.getElementById("biopsia-diagnostico").value=  current_value +"\r\n"+content[0].diagnostico;
            }

      });
    }
    function onEnviarMic(val)
     {
         $.ajax({
             url: '<?php echo Url::to(['/plantillamicroscopia/buscaregistro']) ?>',
            type: 'post',
            data: {id: val },
            success: function (data) {
                var content = JSON.parse(data);
               document.getElementById("biopsia-microscopia").value= content[0].microscopia;

            }

       });
     }

     function onEnviarMac(val)
      {
          $.ajax({
              url: '<?php echo Url::to(['/plantillamacroscopia/buscaregistro']) ?>',
             type: 'post',
             data: {id: val },
             success: function (data) {
                 var content = JSON.parse(data);
                document.getElementById("biopsia-macroscopia").value= content[0].macroscopia;
             }

        });
      }

      function onEnviarMat(val)
       {
           $.ajax({
               url: '<?php echo Url::to(['/plantillamaterial/buscaregistro']) ?>',
              type: 'post',
              data: {id: val },
              success: function (data) {
                  var content = JSON.parse(data);
                  document.getElementById("biopsia-topografia").value= content[0].material;
                 document.getElementById("biopsia-diagnostico").value= content[0].materialdiagnostico;
              }
         });
       }


       function onEnviarFra(val)
        {

          var textArea = document.getElementById('biopsia-frase');
            $.ajax({
                url: '<?php echo Url::to(['/plantillafrase/buscaregistro']) ?>',
               type: 'post',
               data: {id: val },
               success: function (data) {
                   var current_value = textArea.value;
                   var content = JSON.parse(data);
                  document.getElementById("biopsia-frase").value=  current_value +"\r\n"+"\r\n"+content[0].frase;
               }

          });
        }

</script>
