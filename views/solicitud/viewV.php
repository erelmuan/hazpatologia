<!-- <?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
?>
<div class="solicitud-view">
  <div id="w0s" class="x_panel">
    <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUD  </h2>
      <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a solicitudes', ['/solicitud/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
  </div>
    </div>
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
    ]);

    if ($modvel->estvvvvvado=="LISTO")
    {
      echo Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Generar documento', ['/biopsia/informe', 'id' => $model->procedencia->id], [
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
</div>
<script language="JavaScript" type="text/javascript">
    protocolo=document.getElementById("w0").rows[0].cells[1].innerHTML;
    swal(
    'N° de protocolo: '+ protocolo ,
    'PRESIONAR OK',
    'success'
    )
  </script> -->
