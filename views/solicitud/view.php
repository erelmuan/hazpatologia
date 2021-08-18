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

            'id_plantillamaterial',
            'fecharealizacion',
            'fechadeingreso',
            'estudio',
            'estado',
            'observacion:ntext',

        ],
    ]) ;
    if ($model->estado=="LISTO")
    {
      echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> VER EL INFORME', ['/biopsia/informe', 'id' => $idbiopsia], [
            'class'=>'btn btn-info',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
    }

    else {
      echo "<b>LA SOLICITUD AÚN NO POSEE EL INFORME DE ".$model->estudio."</b>";
    }
     ?>

</div>
