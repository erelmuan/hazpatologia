
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\BiopsiaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biopsia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        // 'options' => [
        //     'data-pjax' => 1
        // ],
    ]); ?>

    <?
    // echo $form->field($model, 'fecha_desde')->widget(DatePicker::classname(), [
    //     'options' => ['placeholder' => ''],
    //     'pluginOptions' => [
    //         'id' => 'fecha1',
    //         'autoclose'=>true,
    //         'format' => 'dd/mm/yyyy',
    //         'startView' => 'year',
    //     ]
    // ]);
    //
    // echo $form->field($model, 'fecha_hasta')->widget(DatePicker::classname(), [
    //     'options' => ['placeholder' => ''],
    //     'pluginOptions' => [
    //         'id' => 'fecha1',
    //         'autoclose'=>true,
    //         'format' => 'dd/mm/yyyy',
    //         'startView' => 'year',
    //     ]
    // ]);


    ?>
    <div class="x_panel" >

          <legend class="text-info"><center>ESTUDIOS PATOLOGICOS HOSPITAL ARTEMIDES ZATTI</center></legend>
          <div class="x_content">
            <div class="row">
      <div class="col-md-3">
              <?= $form->field($model, 'tipo_documento') ?>
          </div>
          <div class="col-md-3">
            <?= $form->field($model, 'num_documento')->textInput()->label('Nro. Documento') ?>
          </div>
          <div class="col-md-3">
            <?= $form->field($model, 'estudio') ?>
            <?//= $form->field($model, 'id_estudio')->dropDownList($model->getEstudios())->label('Estudios') ;?>
          </div>
          <div class="col-md-3">
              <?= $form->field($model, 'procedencia') ?>
          </div>
      </div>
      <div class="row">
          <div class="col-md-3">
              <?= $form->field($model, 'pacientenomb') ?>

          </div>
          <div class="col-md-3">
            <?=$form->field($model, 'fechadeingreso')->widget(DatePicker::className(), [
                   'options' => ['placeholder' => 'Debe agregar una fecha',
                   'value'=> ($model->fechadeingreso)?date('d/m/Y',strtotime($model->fechadeingreso)):"" ,
                     'type' => DatePicker::TYPE_COMPONENT_APPEND,
                           ],
                      'pluginOptions' => [
                      'format' => 'dd/mm/yyyy',
                      'todayHighlight' => true,
                      'allowClear' => false
                       ],
                      'pluginEvents' => [
                           "changeDate" => "function(e){
                             cambiarFechaNac();
                           }",
                           ],
                       ])->label('Fecha de desde');;
                           ?>
          </div>
          <div class="col-md-3">
            <?=$form->field($model, 'fechadeingreso')->widget(DatePicker::className(), [
                   'options' => ['placeholder' => 'Debe agregar una fecha',
                   'value'=> ($model->fechadeingreso)?date('d/m/Y',strtotime($model->fechadeingreso)):"" ,
                     'type' => DatePicker::TYPE_COMPONENT_APPEND,
                           ],
                      'pluginOptions' => [
                      'format' => 'dd/mm/yyyy',
                      'todayHighlight' => true,
                      'allowClear' => false
                       ],
                      'pluginEvents' => [
                           "changeDate" => "function(e){
                             cambiarFechaNac();
                           }",
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
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

</div>
