<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/* @var $searchModel */
/* @var $resultado */

$this->title="Reporte de Solicitudes";

?>

<div class="card">

    <div class="card-header">

        <h3>Reporte de Solicitudes</h3>

    </div>

    <div class="card-body">

        <?php $form=ActiveForm::begin([
            'method'=>'get'
        ]); ?>

        <div class="row">

            <div class="col-md-3">

                <?= $form->field($searchModel,'fechaDesde')->input('date') ?>

            </div>

            <div class="col-md-3">

                <?= $form->field($searchModel,'fechaHasta')->input('date') ?>

            </div>

            <div class="col-md-3">

                <?= $form->field($searchModel,'procedencia')->dropDownList([
                    ''=>'Todas',
                    1=>'Hospital',
                    2=>'Centro de Salud',
                    3=>'Privados',
                ]) ?>

            </div>

            <div class="col-md-3">

                <?= $form->field($searchModel,'tipoEstudio')->dropDownList([
                    ''=>'Todos',
                    1=>'Biopsia',
                    2=>'PAP',
                ]) ?>

            </div>

        </div>

        <?= Html::submitButton(
            '<i class="fas fa-search"></i> Buscar',
            ['class'=>'btn btn-primary']
        ) ?>

        <?= Html::a(
            '<i class="fas fa-eraser"></i> Limpiar',
            ['solicitudes'],
            ['class'=>'btn btn-secondary']
        ) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<br>

<?php

if(!empty($resultado)){

    $provider = new ArrayDataProvider([
        'allModels'=>$resultado,
        'pagination'=>false
    ]);

    echo GridView::widget([

        'dataProvider'=>$provider,

        'columns'=>[

            'procedencia',

            [
                'attribute'=>'biopsias',
                'contentOptions'=>['class'=>'text-center']
            ],

            [
                'attribute'=>'pap',
                'contentOptions'=>['class'=>'text-center']
            ],

            [
                'attribute'=>'total',
                'contentOptions'=>['class'=>'text-center']
            ],

        ]

    ]);

    echo Html::a(
        '<i class="fas fa-file-pdf"></i> Exportar PDF',
        ['solicitudes-pdf'],
        ['class'=>'btn btn-danger']
    );

}
