
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
    echo $form->field($model, 'fecha_desde')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'id' => 'fecha1',
            'autoclose'=>true,
            'format' => 'dd/mm/yyyy',
            'startView' => 'year',
        ]
    ]);

    echo $form->field($model, 'fecha_hasta')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => [
            'id' => 'fecha1',
            'autoclose'=>true,
            'format' => 'dd/mm/yyyy',
            'startView' => 'year',
        ]
    ]);

    ?>


        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpiar', ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

</div>
