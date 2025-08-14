<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use app\models\patronState\EstadoBase;
/* @var $this yii\web\View */
/* @var $model app\models\Solicitudbiopsia */
$isAjax = Yii::$app->request->isAjax;

?>
<div class="solicitudbiopsia-view">
  <div id="w0" >
      <?  if (!$isAjax) { ?>
      <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a Solicitudes', ['/solicitud/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
      <? } ?>
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
            'value'=> $model->calcular_edad(),
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
          [
            'value'=> ($model->fecharealizacion)? date('d/m/Y',strtotime($model->fecharealizacion)):$model->fecharealizacion,
            'label' => 'Fecha de realización'
          ],
          [
            'value'=>  date('d/m/Y',strtotime($model->fechadeingreso)),
            'label' => 'Fecha de ingreso'
          ],
          [
            'value'=> $model->estado->descripcion,
            'label' => 'Estado'
          ],
            'observacion:ntext',
        ],
    ]) ?>
    <?
    if ($model->id_estado== EstadoBase::LISTO or $model->id_estado== EstadoBase::ANULADO )
    {
      echo Html::a('<i class="fa fa-file-pdf-o"></i> Documento del informe', ['/biopsia/informe', 'id' => $model->biopsia->id], [
            'class'=>'btn btn-danger',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'Se abrirá el archivo PDF generado en una nueva ventana'
        ]);
    }

    else {
    if (!$model->puedeMostrarAdjuntos()){

      echo "<b>LA SOLICITUD AÚN NO POSEE EL INFORME";
      echo ($model->id_estado== EstadoBase::EN_PROCESO)?" VERIFICADO":"";
       echo " DE ".$model->estudio->descripcion." </b>";
       }
    }
     ?>

</div>
<? if (isset($model->biopsia) && $model->biopsia->ihq ){ ?>
<div id="w0ss" class="x_panel">
<div class="x_title"><h2><i class="fa fa-table"></i> ESTUDIO INMUNOHISTOQUIMICA  </h2>
<div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
</div>
</div>

<?  if (isset($model->biopsia) && $model->biopsia->ihq && isset($model->biopsia->inmunohistoquimicaEscaneada)){
        if($model->id_estado ===EstadoBase::LISTO){
          echo DetailView::widget([
              'model' => $model->biopsia,
              'attributes' => [

              [
                'value'=> Html::a('<i class="fa fa-file-pdf-o"></i> Generar informe inmunostoquimica', ['/inmunohistoquimica-escaneada/informe', 'id' => $model->biopsia->inmunohistoquimicaEscaneada->id], [
                      'class'=>'btn btn-primary',
                      // 'role'=>'modal-remote',
                      'target'=>'_blank',
                      'data-toggle'=>'tooltip',
                      'title'=>'Se abrirá el archivo PDF generado en una nueva pestaña'
                  ]) ,
                'label'=> 'Documento',
                'format'=>'raw',
             ],
             [
               'value'=> $model->biopsia->inmunohistoquimicaEscaneada->observacion ,
               'label'=> 'Observacion',
            ] ,

              ],
              ]) ;}
              else {
                echo "NO SE PUEDE VISUALIZAR PORQUE EL ESTUDIO NO ESTA LISTO";

              }

    }
    else {
        echo "ESTA ACTIVA LA OPCIÓN IHQ PERO NO SE CARGO NINGÚN ESTUDIO";
    }
    ?>
    </div>
    <?
  }
  ?>
  <?php if ($model->puedeMostrarAdjuntos() && !empty($model->adjuntosolicituds)): ?>
  <div class="adjuntos-view">
      <h4>Archivos Adjuntos</h4>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Nombre de asignado</th>
                  <th>Observación</th>
                  <th>Acción</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($model->adjuntosolicituds as $adjunto): ?>
                  <tr>
                      <td><?= Html::encode($adjunto->nombre_asignado) ?></td>
                      <td><?= Html::encode($adjunto->observacion) ?></td>
                      <td>
                          <?= Html::a('Descargar', ['/adjuntosolicitud/descargar', 'id' => $adjunto->id], ['class' => 'btn btn-success' , 'target'=> '_blank']) ?>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  </div>
  <?php endif; ?>
</div>
