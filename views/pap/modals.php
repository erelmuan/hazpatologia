<?php
use kartik\grid\GridView;

// Definir todas las configuraciones de columnas en un array
$columnsConfig = [
    'flora' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'flora'],
    ],
    'aspecto' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'aspecto'],
    ],
    'glandular' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'glandular'],
    ],
    'pavimentosa' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'pavimentosa'],
    ],
    'diagnostico' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'diagnostico'],
    ],
    'frase' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'frase'],
    ],
    'cie10' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'id'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'descripcion'],
    ],
];

// Configuración para cada modal
$modales = [
    'flora' => [
        'provider' => 'dataProviderFlora',
        'search' => 'searchModelFlora',
        'function' => 'agregarFormularioFlo',
        'index_class' => 'plantillaflora-index',
    ],
    'aspecto' => [
        'provider' => 'dataProviderAspecto',
        'search' => 'searchModelAspecto',
        'function' => 'agregarFormularioAsp',
        'index_class' => 'plantillaaspecto-index',
    ],
    'glandular' => [
        'provider' => 'dataProviderGlandular',
        'search' => 'searchModelGlandular',
        'function' => 'agregarFormularioGland',
        'index_class' => 'plantillaglandular-index',
    ],
    'pavimentosa' => [
        'provider' => 'dataProviderPavimentosa',
        'search' => 'searchModelPavimentosa',
        'function' => 'agregarFormularioPav',
        'index_class' => 'Plantillapavimentosa-index',
    ],
    'diagnostico' => [
        'provider' => 'dataProviderDiagnostico',
        'search' => 'searchModelDiagnostico',
        'function' => 'agregarFormularioDiag',
        'index_class' => 'plantilladiagnostico-index',
    ],
    'frase' => [
        'provider' => 'dataProviderFrase',
        'search' => 'searchModelFrase',
        'function' => 'agregarFormularioFra',
        'index_class' => 'plantillafrases-index',
    ],
    'cie10' => [
        'provider' => 'dataProviderCie',
        'search' => 'searchModelCie',
        'function' => 'agregarFormularioCie10',
        'index_class' => 'cie10-index',
    ],
];
?>

<?php foreach ($modales as $tipo => $config): ?>
<div class="x_content">
    <div class="modal fade bs-<?= $tipo ?>-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="<?= $config['index_class'] ?>">
                        <div id="ajaxCrudDatatable">
                            <?= GridView::widget([
                                'id' => 'crud-' . $tipo,
                                'dataProvider' => $provider[$config['provider']],
                                'filterModel' => $search[$config['search']],
                                'pjax' => true,
                                'columns' => $columnsConfig[$tipo],
                                'toolbar' => [],
                                'panel' => [
                                    'type' => 'primary',
                                    'heading' => false,
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" onclick="<?= $config['function'] ?>();" class="btn btn-primary">
                            Agregar al formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
