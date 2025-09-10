<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var int $id_solicitud */

?>


<div class="modal-body">
    <?php if ($dataProvider->totalCount > 0): ?>
          <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'summary' => false,
          'tableOptions' => ['class' => 'table table-bordered table-striped table-condensed'],
          'columns' => [
              [
                  'attribute' => 'nombre_asignado',
                  'contentOptions' => ['style' => 'max-width: 200px; white-space: normal; word-wrap: break-word;'],
              ],
              [
                  'attribute' => 'nombre_archivo',
                  'label' => 'Nombre del Archivo',
                  'format' => 'raw',
                  'value' => function ($model) {
                      return Html::encode($model->nombre_archivo);
                  },
                  'contentOptions' => ['style' => 'max-width: 200px; white-space: normal; word-wrap: break-word;'],
              ],
              [
                  'attribute' => 'observacion',
                  'label' => 'Observacion',
                  'format' => 'raw',
                  'value' => function ($model) {
                      return Html::encode($model->observacion);
                  },
                  'contentOptions' => ['style' => 'max-width: 250px; white-space: normal; word-wrap: break-word;'],
              ],
              [
                  'label' => 'Descargar',
                  'format' => 'raw',
                  'value' => function ($model) {
                      return Html::a('Descargar', ['/adjuntosolicitud/descargar', 'id' => $model->id], [
                          'class' => 'btn btn-primary btn-sm',
                          'data-toggle' => 'tooltip',
                          'target'=>'_blank',
                          'title' => 'Descargar el archivo adjunto'
                      ]);
                  },
                  'contentOptions' => ['style' => 'width: 120px; text-align: center;'],
                  'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
              ],
          ],
      ]); ?>

    <?php else: ?>
        <div class="alert alert-info">No hay archivos adjuntos asociados a esta solicitud.</div>
    <?php endif; ?>
</div>
