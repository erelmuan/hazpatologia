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
            'columns' => [
                [
                    'attribute' => 'nombre_asignado',
                ],
                [
                    'attribute' => 'nombre_archivo',
                    'label' => 'Nombre del Archivo',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::encode($model->nombre_archivo);
                    }
                ],
                [
                    'attribute' => 'observacion',
                    'label' => 'Observacion',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::encode($model->observacion);
                    }
                ],
                [
                    'label' => 'Descargar',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a('Descargar', ['/adjuntosolicitud/descargar', 'id' => $model->id], [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'tooltip',
                            'target'=>'_blank',
                            'title' => 'Descargar el archivo adjunto'
                        ]);
                    }
                ],
            ],
        ]); ?>
    <?php else: ?>
        <div class="alert alert-info">No hay archivos adjuntos asociados a esta solicitud.</div>
    <?php endif; ?>
</div>
