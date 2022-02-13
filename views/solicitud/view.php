<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
?>
<div class="solicitud-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'protocolo',
         [
           'value'=> $model->paciente->apellido .' '.$model->paciente->nombre,
           'label'=> 'Paciente',
        ],
        [
          'value'=> $edad,
          'label'=> 'Edad del paciente (años)',
       ],
        [
          'value'=> $model->paciente->sexo,
          'label'=> 'Sexo del paciente',
       ],
       [
         'value'=> $model->medico->apellido .' '.$model->medico->nombre,
         'label'=> 'Medico',
      ],

        'fecharealizacion',
        'fechadeingreso',
      [
          'value'=> $model->estado->descripcion,
          'label'=> 'Estado',
       ],
       [
           'value'=> $model->estudio->descripcion,
           'label'=> 'Estudio',
        ],

        ],
    ]) ;

     ?>

</div>
