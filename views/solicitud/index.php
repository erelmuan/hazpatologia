<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\bootstrap\Collapse;
use kartik\widgets\AlertBlock;
$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
// Reemplazo la columna donde el valor es getlink por la funcion anonima, este artilugio es necesario
// porque la clase anonima en el metodo attributeColumns de la clase Biopsia
// arrojaba un error de serializacion


$export = ExportMenu::widget([
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_PDF => [
            'icon' => 'fa fa-file-pdf-o',
        ],
        ExportMenu::FORMAT_CSV => [
            'icon' => 'fa fa-file-text-o',
        ],
        ExportMenu::FORMAT_TEXT => [
            'icon' => 'fa fa-file-text',
        ],
        ExportMenu::FORMAT_EXCEL => [
            'icon' => 'fa fa-file-excel-o',
        ],
        ExportMenu::FORMAT_EXCEL_X => [
            'icon' => 'fa fa-file-excel-o',
        ],
    ],
    'dataProvider' => $dataProvider,
    'columns' => require(__DIR__ . '/_columns.php'),
    'dropdownOptions' => [
        'label' => 'Todo',
        'class' => 'btn btn-secondary',
        'itemsBefore' => [
            '<div class="dropdown-header">Exportar Todos los Datos</div>',
        ],
    ],
    'filename' => 'Solicitudes', // Aquí especifica el nombre de archivo personalizado
]);

$columns[]=
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
            'buttons' => [
              'view' => function ($url, $model, $key) {
                return Html::a("<button class='btn-success btn-circle'><span class='glyphicon glyphicon-eye-open'></span></button>", [$model::tableName().$model->estudio->modelo.'/view',"id"=> $key]
                ,[ 'role'=>'modal-remote',
                   'title'=>'Ver',
                  'data-toggle'=>'tooltip'
                  ]

              );

              },

              'update' => function ($url, $model, $key) {
                return Html::a("<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>", [$model::tableName().$model->estudio->modelo.'/update',"id"=> $key]
                ,[
                   'title'=>'Actualizar',
                  'data-toggle'=>'tooltip'
                  ]

              );
              },
              'delete' => function ($url, $model, $key) {
                return Html::a(
                  "<button class='btn-danger btn-circle'>
                <span class='glyphicon glyphicon-trash'></span></button>",
                 [$model::tableName().$model->estudio->modelo.'/delete',"id"=> $key]
                ,['role'=>'modal-remote',
                  'data-toggle'=>'tooltip',
                  'data-pjax'=>"0",
                   'data-request-method'=>"post",
                   'data-toggle'=>"tooltip",
                   'data-confirm-title'=>"Confirmar",
                   'data-confirm-message'=>"¿Esta seguro de eliminar este elemento?",
                   'data-confirm-cancel' => "Cancelar", // Texto del botón de cancelar
                   'data-confirm-ok' => "Aceptar", // Texto del botón de aceptar
                   'data-original-title'=>"Eliminar",
                  ]
              );
              }
          ],

    ];
    ;

?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUDES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<p>

    <?= Html::a('Nueva Solicitud biopsia', Yii::$app->homeUrl."solicitudbiopsia/create", ['class' => 'btn btn-success']) ?>
    <?= Html::a('Nueva Solicitud pap', Yii::$app->homeUrl."solicitudpap/create", ['class' => 'btn btn-success']) ?>

</p>
<?=$export; ?>
<div class="solicitud-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            //Para que no busque automaticamente, sino que espere a que se teclee ENTER
            'filterOnFocusOut'=>false,
            'columns' => $columns,
            'toolbar'=> [
              ['content'=>
                  Html::a('<i class="glyphicon glyphicon-th"></i>', ['vista/select','modelo' => 'app\models\Solicitud'],
                  ['role'=>'modal-remote','title'=> 'Personalizar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
              ]
            ],
            'striped' => true,
            'condensed' => true,
            //Adaptacion para moviles
            'responsiveWrap' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de solicitudes',
                'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em>',

                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
