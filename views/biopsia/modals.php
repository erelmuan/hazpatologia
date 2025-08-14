<?
use kartik\grid\GridView;

// Definir todas las configuraciones de columnas en un array
$columns = [
    'Material' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'material'],
    ],
    'Macroscopia' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'macroscopia'],
    ],
    'Microscopia' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'microscopia'],
    ],
    'Diagnostico' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'diagnostico'],
    ],
    'Frase' => [
        ['class' => '\kartik\grid\RadioColumn', 'width' => '20px'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'codigo'],
        ['class' => '\kartik\grid\DataColumn', 'attribute' => 'frase'],
    ],

];

// Configuración para cada modal
$modales = [
    'Material' => [
        'provider' => 'dataProviderMaterial',
        'search' => 'searchModelMaterial',
        'function' => 'agregarFormularioMat',
        'indexClass' => 'plantillamaterialb-index',
    ],
    'Microscopia' => [
        'provider' => 'dataProviderMicroscopia',
        'search' => 'searchModelMicroscopia',
        'function' => 'agregarFormularioMic',
        'indexClass' => 'plantillamicroscopia-index',
    ],
    'Macroscopia' => [
        'provider' => 'dataProviderMacroscopia',
        'search' => 'searchModelMacroscopia',
        'function' => 'agregarFormularioMac',
        'indexClass' => 'plantillamacroscopia-index',
    ],
    'Diagnostico' => [
        'provider' => 'dataProviderDiagnostico',
        'search' => 'searchModelDiagnostico',
        'function' => 'agregarFormularioDiag',
        'indexClass' => 'plantilladiagnostico-index',
    ],
    'Frase' => [
        'provider' => 'dataProviderFrase',
        'search' => 'searchModelFrase',
        'function' => 'agregarFormularioFra',
        'indexClass' => 'plantillafrase-index',
    ],

];
?>

<?php foreach ($modales as $tipo => $config): ?>
<div class="x_content">
    <div class="modal fade bs-<?= strtolower($tipo) ?>-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="<?= $config['indexClass'] ?>">
                        <div id="ajaxCrudDatatable">
                            <?= GridView::widget([
                                'id' => 'crud-'.strtolower($tipo),
                                'dataProvider' => $provider[$config['provider']],
                                'filterModel' => $search[$config['search']],
                                'pjax' => true,
                                'columns' => $columns[$tipo],
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
