<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitudpap */
?>
<div class="solicitudpap-view">
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
            [
            'value'=> $model->procedencia->nombre ,
            'label'=> 'Procedencia',
            ],
            'id_materialsolicitud',
            [
              'value'=>  date('d/m/Y',strtotime($model->fecharealizacion)),
              'label' => 'Fecha de realización'
            ],
            [
              'value'=>  date('d/m/Y',strtotime($model->fechadeingreso)),
              'label' => 'Fecha de ingreso'
            ],
            [
              'value'=> 'estado.descripcion',
              'label' => 'Estado'
            ],            'observacion:ntext',
            [
              'value'=> ($model->tipoMuestra)?$model->tipoMuestra->descripcion:"(No definido)",
              'label'=> 'Tipo de muestra',
            ],
            'pap_previo:boolean',
            'resultado_pap_previo',
            'biopsia_previa:boolean',
            'resultado_biopsia_previo',
            'fum',
            'embarazo_actual:boolean',
            'menopausia:boolean',
            [
              'value'=>  date('d/m/Y',strtotime($model->fecha_ult_parto)),
              'label' => 'Fecha de ult. parto'
            ],
            [
              'value'=> ($model->metodoAnticonceptivo)?$model->metodoAnticonceptivo->descripcion:"(No definido)",
              'label'=> 'Metodo Anticonceptivo',
            ],
            [
              'value'=> ($model->cirugiaPrevia)?$model->cirugiaPrevia->descripcion:"(No definido)",
              'label'=> 'Cirugia previa',
            ],
            'tratamiento_radiante:boolean',
            'quimioterapia:boolean',
            'datos_clinicos_de_interes:ntext',
            'colposcopia:boolean',
            'conclusion:ntext',
        ],
    ]) ?>
<?
      if ($model->estado->ver_informe_solicitud)
    {
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento del informe', ['/pap/informe', 'id' => $model->pap->id], [
            'class'=>'btn btn-danger',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
    }

    else {
      echo "<b>LA SOLICITUD AÚN NO POSEE EL INFORME DE ".$model->estudio->descripcion." </b>";
    }
    echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento de la solicitud', ['/solicitudpap/documento', 'id' => $model->id], [
      'class'=>'btn btn-info',
      'target'=>'_blank',
      'data-toggle'=>'tooltip',
      'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
  ]);
     ?>
</div>
<script language="JavaScript" type="text/javascript">
    // protocolo=document.getElementById("w0").rows[0].cells[1].innerHTML;
    // swal(
    // 'N° de protocolo: '+ protocolo ,
    // 'PRESIONAR OK',
    // 'success'
    // )
  </script>
