
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use nex\chosen\Chosen;
use yii\helpers\ArrayHelper;
use app\models\Procedencia;
use app\models\Estudio;
use yii\jui\AutoComplete;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\BiopsiaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solilcitud-search">

    <?php $form = ActiveForm::begin([
        'action' => ['consulta'],
        'method' => 'get',
        // 'options' => [
        //     'data-pjax' => 1
        // ],
    ]);
    $mapprocedencia = ArrayHelper::map(Procedencia::find()->all() , 'id',  'nombre'  );
    $mapestudio = ArrayHelper::map(Estudio::find()->all() , 'id',  'descripcion'  );

    ?>
    <div class="x_panel" >

          <legend class="text-info"><center>ESTUDIOS PATOLOGICOS HOSPITAL ARTEMIDES ZATTI</center></legend>
          <div class="x_content">
            <div class="row">

          <div class="col-md-3">

            <?  echo $form->field($searchModel, 'id_tipodoc')->widget(
                  Chosen::className(), [
                    'items' => $searchModel->getTipoDocs(),
                    'placeholder' => 'Selecciona una opción',
                    'clientOptions' => [
                     'language' => 'es',
                      'rtl'=> true,
                     'search_contains' => true,
                     'single_backstroke_delete' => false,
                   ],])->label("Tipo de doc.");
             ?>  </div>
          <div class="col-md-3">
            <?= $form->field($searchModel, 'num_documento')->textInput(['autocomplete' =>'off', 'placeholder'=>'Ingrese numero (sin puntos)']); ?>
          </div>
          <div class="col-md-3">
            <?  echo $form->field($searchModel, 'id_estudio')->widget(
                  Chosen::className(), [
                    'items' => $mapestudio,
                    'placeholder' => 'Selecciona una opción',
                    'clientOptions' => [
                     'language' => 'es',
                      'rtl'=> true,
                     'search_contains' => true,
                     'single_backstroke_delete' => false,
                   ],])->label("Estudio");
             ?>
              </div>
          <div class="col-md-3">
              <?
                 echo $form->field($searchModel, 'id_procedencia')->widget(
                      Chosen::className(), [
                         'items' => $mapprocedencia,
                          'placeholder' => 'Selecciona una opción',
                          'clientOptions' => [
                           'language' => 'es',
                            'rtl'=> true,
                           'search_contains' => true,
                           'single_backstroke_delete' => false,
                             ],])->label("Procedencia");
                 ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-3">
            <?= $form->field($searchModel, 'paciente')
            ->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => Url::to(['solicitud/autocomplete']), // Especifica la URL de la acción para obtener los resultados del autocompletado
                    'minLength' => 4, // Define la cantidad mínima de caracteres para activar el autocompletado
                ],

                'options' => [
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'placeholder' => 'Ingrese parte del nombre o apellido del paciente',
                ],
            ]) ?>

          </div>
          <div class="col-md-3">
            <?
            echo $form->field($searchModel, 'fecha_desde')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Debe agregar una fecha',
                  'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        ],
                        'pluginOptions' => [
                        'id' => 'fecha1',
                        'format' => 'dd/mm/yyyy',
                        'todayHighlight' => true,
                        'allowClear' => false
                         ],
            ]);

            ?>
          </div>
          <div class="col-md-3">
            <?=$form->field($searchModel, 'fecha_hasta')->widget(DatePicker::className(), [
                   'options' => ['placeholder' => 'Debe agregar una fecha',
                     'type' => DatePicker::TYPE_COMPONENT_APPEND,
                           ],
                      'pluginOptions' => [
                      'id' => 'fecha2',
                      'format' => 'dd/mm/yyyy',
                      'todayHighlight' => true,
                      'allowClear' => false
                       ],

                       ])->label('Fecha de hasta');;
                           ?>
          </div>
          <div class="col-md-3">
          </div>
      </div>

       </div>

</div>
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Limpiar', Yii::$app->request->baseUrl.'/solicitud/consulta', ['class' => 'btn btn-default']);?>

    <?php ActiveForm::end(); ?>

</div>
