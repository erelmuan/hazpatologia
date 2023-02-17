
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
        <div class='col-sm-6'>
        <?= $form->field($model, 'id_solicitud')->textInput()->label('Pap previo') ?>
        <?= $form->field($model, 'id_biopsia')->textInput()->label('Pap previo') ?>
        <?= $form->field($model, 'paciente')->textInput()->label('Paciente') ?>
        <?= $form->field($model, 'procedencia')->textInput()->label('procedencia') ?>
        <?= $form->field($model, 'estudio')->textInput()->label('estudio') ?>
        <?= $form->field($model, 'medico')->textInput()->label('medico') ?>

        </div>
        <div class='col-sm-6'>

        <?= $form->field($model, 'fechadeingreso')->widget(DatePicker::className(), [
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
        <?= $form->field($model, 'num_documento')->textInput()->label('DNI') ?>
        <?= $form->field($model, 'protocolo')->textInput()->label('Protocolo') ?>

        </div>
       </div>

</div>
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

</div>
