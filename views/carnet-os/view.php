<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CarnetOs */
?>
<div class="carnet-os-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'class'=>'\kartik\grid\DataColumn',
              'width' => '170px',
              'attribute'=>'paciente.nombre'.' '.'paciente.apellido',
              'label'=>'Paciente',
              'value' => function($model) {

                return Html::a($model->paciente->nombre.' '.$model->paciente->apellido, ['paciente/view',"id"=> $model->paciente->id]

                   ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
                 );

               }
               ,
               'format' => 'raw',
            ],
            [
              'class'=>'\kartik\grid\DataColumn',
              'width' => '170px',
              'attribute'=>'obrasocial.nombre',
              'label'=>'Obra social',

              'value' => function($model) {

                return Html::a($model->obrasocial->sigla, ['obrasocial/view',"id"=> $model->obrasocial->id]

                   ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos de la obra social','data-toggle'=>'tooltip']
                 );

               }
               ,

               'format' => 'raw',
            ],

            'nroafiliado',
        ],
    ]) ?>

</div>
