


<style>
/* Latest compiled and minified CSS included as External Resource*/

/* Optional theme */

/*@import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css');*/

.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}

::before, ::after {

    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;

}
elemento {

}
.panel-primary {

    border-color: #fff;

}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 130%;
    position: relative;

}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
#mensajePaciente{
  display: none
}
#mensajeMedico{
  display: none;
}

</style>
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Procedencia;
use app\models\Plantillamaterialb;

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use kartik\form\ActiveField;
$this->title = 'Creacion de solicitud';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
//CAMBIE EL ID PARA NO TENER QUE HACER DOBLE CLICK PARA LA BUSQUEDA
?><div id="wC" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> NUEVA SOLICITUD  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>

<!-- Smart Wizard -->


<div  id="mensajePaciente" class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Atencion!</strong> SE AÑADIO EL PACIENTE AL FORMULARIO
</div>

<div  id="mensajeMedico" class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Atencion!</strong> SE AÑADIO EL PACIENTE AL FORMULARIO
</div>

<div class="contadinedsr">
    <div class="stepwizard">
        <!-- <div class="stepwizard-row setup-panel"> -->
        <div class="setup-panel">
            <div class="stepwizard-step col-xs-3">
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Paciente</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Medico</small></p>
            </div>
            <div class="stepwizard-step col-xs-3">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Material-Procedencia-Fechas</small></p>
            </div>

        </div>
    </div>

    <!-- <form role="form"> -->

        <div class="panel panel-primary setup-content" id="step-1">
          <div class="panel-heading">
               <h3 class="panel-title">Buscar Paciente por nombre o dni</h3>
          </div>
        </br>

          <?php Pjax::begin(); ?>

          <div class="form-group">
             <div class="col-lg-offset-1">
                <?php echo $this->render('_searchPaciente', ['model' => $searchModelPac]);?>
            </div>
          </div>
          <div class="solicitud-index">
              <div id="ajaxCrudDatatable2">
                <? if ($dataProviderPac !== null){ ?>

                  <?=GridView::widget([
                      'id'=>'crud-datatable2',
                      'dataProvider' => $dataProviderPac,
                      'pjax'=>true,
                      'columns' => require(__DIR__.'/_columnsPaciente.php'),

                      'striped' => true,
                      'condensed' => true,
                      'responsive' => true,

                  ])?>
              <? }?>

              </div>
          </div>
          <?php Pjax::end();?>


          <button onclick="pasarVariablePaciente()" class="btn btn-primary nextBtn pull-right" type="button">Proximo</button>

          <!-- fin de form -->
          </div>

          <div class="panel panel-primary setup-content" id="step-2">
              <div class="panel-heading">
                   <h3 class="panel-title">Buscar Medico por nombre o dni</h3>
              </div>
              <!-- medico -->.

              <?php Pjax::begin(); ?>

              <div class="form-group">
                 <div class="col-lg-offset-1">
                    <?php echo $this->render('_searchMedico', ['model' => $searchModelMed]);?>
                </div>
              </div>
              <div class="solicitud-index">
                  <div id="ajaxCrudDatatable3">
                    <? if ($dataProviderMed !== null){ ?>

                      <?=GridView::widget([
                          'id'=>'crud-datatable3',
                          'dataProvider' => $dataProviderMed,
                          'pjax'=>true,
                          'columns' => require(__DIR__.'/_columnsMedico.php'),
                          'striped' => true,
                          'condensed' => true,
                          'responsive' => true,

                      ])?>
                  <? }?>

                  </div>
              </div>
              <?php Pjax::end();?>

                    <!-- medico -->
              <button onclick="pasarVariableMedico()"class="btn btn-primary nextBtn pull-right" type="button">Proximo</button>


          </div>

          <div class="panel panel-primary setup-content" id="step-3">
              <div class="panel-heading">
                   <h3 class="panel-title">Solicitud</h3>
              </div>

            <?
          $form = ActiveForm::begin([
                'id' => 'my-form-id',
                'action' => '?r=solicitud/create',
                'enableAjaxValidation' => true,
                'method' => 'post',

                'validationUrl' => 'validation-rul',
            ]);
            echo" </br>";
            echo" <div class='row'>";
            echo "<div class='col-sm-3'>";
            echo "<label >"."Paciente:"." <span id='paciente'> </span></label>";
            echo  $form->field($model, 'idpaciente')->hiddenInput()->label(false);

            echo "</div>";

            echo "<div class='col-sm-2'>";
            echo "<label >"."Medico:"."<span id='medico'> </span></label>";
            echo   $form->field($model, 'idmedico')->hiddenInput()->label(false);

            echo "</div>";
                $mapprocedencia = ArrayHelper::map(Procedencia::find()->all() , 'idprocedencia',  'nombre'  );
                $mapmaterial = ArrayHelper::map(Plantillamaterialb::find()->all() , 'idplantillamaterialb',  'material'  );
                echo" <div class='col-sm-2'>";

                echo Form::widget([ // continuation fields to row above without labels
                  'id' => 'login-form-horizontal',
                    'model'=>$model,
                    'form'=>$form,
                    'columns'=>4,
                    'attributes'=>[
                        'idprocedencia'=>['type'=> Form::INPUT_WIDGET,
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
                echo"</div>";
                echo" <div class='col-sm-2'>";

                // echo Form::widget([ // continuation fields to row above without labels
                //     'id' => 'login-form-horizontal',
                //     'model'=>$model,
                //       'form'=>$form,
                //       'columns'=>4,
                //       'attributes'=>[
                //           'idplantillamaterialb'=>['type'=> Form::INPUT_WIDGET,
                //               'widgetClass'=>'kartik\select2\Select2',
                //                 'options'=>[
                //                   'data' => $mapmaterial,
                //                   'language' => 'es',
                //                   ],
                //             'pluginOptions' => [
                //                   'allowClear' => true
                //                   ],
                //             'placeholder' => 'Seleccionar codigo..',
                //                 'label'=>'Material'],
                //                       //  'ID_Factura'=>['label'=>'Codigo factura', 'options'=>['placeholder'=>'Ingrese factura...']],
                //                       //  'Cantidad'=>['label'=>'Cantidad', 'options'=>['placeholder'=>'Ingrese cantidad...',],'columnOptions'=>['class'=>'col-sm-2']]
                //                     ]
                //     ]);




                echo $form->field($model, 'plantillamaterialb', [
                  'hintType' => ActiveField::HINT_SPECIAL,
                  'hintSettings' => [
                      'iconBesideInput' => true,
                      'onLabelClick' => false,
                      'onLabelHover' => false,
                      'onIconClick' => true,
                      'onIconHover' => true,
                      'title' => '<i class="glyphicon glyphicon-info-sign"></i> Aclaración'
                      ]])->widget(Select2::classname(), [
                      'data' => $mapmaterial,
                      'options' => ['placeholder' => 'Seleccionar material ...', 'multiple' => true],
                      'pluginOptions' => [
                          'tags' => true,
                          'tokenSeparators' => [',', ' '],
                          'maximumInputLength' => 25
                      ],
                  ])->label('Material')->hint('<div style="width:200px">El/los <b>nombre/s</b> de el/los materiales, pueden ser diferentes a la interpretación del patologo .</div>');;
                                     echo"</div>";

                   echo" <div class='col-sm-2'>";

                    echo $form->field($model, 'fecharealizacion')->widget(DatePicker::className(), [
                           'options' => ['placeholder' => 'Debe agregar una fecha',
                             'value' =>  date('d/m/Y'),
                             'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                   ],
                              'pluginOptions' => [
                              'format' => 'dd/mm/yyyy',
                              'todayHighlight' => true,
                               ],
                              'pluginEvents' => [
                                   "changeDate" => "function(e){
                                     cambiarFechaNac();
                                   }",
                                   ],
                               ]);
                   echo"</div>";
                   echo" <div class='col-sm-2'>";

                    echo $form->field($model, 'fechadeingreso')->widget(DatePicker::className(), [
                              'options' => ['placeholder' => 'Debe agregar una fecha',
                              'value' =>  date('d/m/Y'),
                              'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                      ],
                              'pluginOptions' => [
                              'format' => 'dd/mm/yyyy',
                               'todayHighlight' => true,],
                               'pluginEvents' => [
                                "changeDate" => "function(e){
                                    cambiarFechaNac();
                                    }",
                                  ],
                                ]);
                  echo"</div>";
                  echo"<div class='col-sm-2'>";
                        echo $form->field($model, 'estudio')->dropDownList(
                    ['BIOPSIA' => 'BIOPSIA ', 'PAP' => 'PAP']
                    );
                  echo"</div>";
                  echo"<div class='col-sm-2'>";
                       //echo $form->field($model, "estado")->textInput(["rows" => 5,'readonly'=> true ,'value'=>"PENDIENTE"]) ;
                       echo $form->field($model, 'estado')->dropDownList(
                   ['PENDIENTE' => 'PENDIENTE ', 'RECHAZADO' => 'RECHAZADO']
                   );
                  echo"</div>";

              echo"</div>";

              echo" <div class='row'>";
              echo"<div class='col-sm-5'>";
                   echo $form->field($model, "observacion")->textarea(["rows" => 10]) ;
              echo"</div>";

              echo"</div>";
              if (!Yii::$app->request->isAjax){
               echo  "<div class='pull-right'>";
                     echo Html::submitButton($model->isNewRecord ? 'Guardar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
               echo  "</div'>";
             }


                $form = ActiveForm::end();
                ?>



      <!-- </form> -->
    </div>
    <!-- End SmartWizard Content -->


</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>



<!-- pace -->
<?= Html::jsFile('@web/js/pace/pace.min.js') ?>

<script type="text/javascript">
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-success').trigger('click');
});
    function pasarVariablePaciente()
    {
      idpaciente=$("#crud-datatable2-container").find("table").find("tr.success").find("td:eq(1)").text();
      var elemento = document.getElementById("mensajePaciente");
       elemento.style.display = "block";
        document.getElementById("paciente").innerHTML = $("#crud-datatable2-container").find("table").find("tr.success").find("td:eq(2)").text();

        document.getElementById("solicitud-idpaciente").value = idpaciente;
        setTimeout(function () {
          elemento.style.display = "none";

        }, 2500);
    }
    function pasarVariableMedico()
    {

     idmedico=$("#crud-datatable3-container").find("table").find("tr.success").find("td:eq(1)").text();
      var elemento = document.getElementById("mensajeMedico");
       elemento.style.display = "block";

       document.getElementById("medico").innerHTML = $("#crud-datatable3-container").find("table").find("tr.success").find("td:eq(2)").text();
       document.getElementById("solicitud-idmedico").value = idmedico;
       setTimeout(function () {
         elemento.style.display = "none";

    }, 2000);

      //Creo un formulario para pasar el dato a traves de POST a tu pagina 2
      // $('<form action="/patologiahaz/web/index.php?r=biopsia/create" method="post"><input type="hidden" name="idpac" value="'+idpaciente+'" /><input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" /></form>')
      //   .appendTo('body').submit();

    }
</script>
