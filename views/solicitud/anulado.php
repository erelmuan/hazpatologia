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


  $export= ExportMenu::widget([
    'exportConfig' => [
      ExportMenu::FORMAT_TEXT => false,
      ExportMenu::FORMAT_HTML => false,
  ],
           'dataProvider' => $dataProvider,
           'columns' => require(__DIR__.'/_columns.php'),
           'dropdownOptions' => [
             'label' => 'Todo',
             'class' => 'btn btn-secondary',
             'itemsBefore' => [
               '<div class="dropdown-header">Exportar Todos los Datos</div>',
  ],
       ]]);

$columns[]=

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
          'view' => function ($url, $model, $key) {
            return Html::a("<button class='btn-success btn-circle'><span class='glyphicon glyphicon-eye-open'></span></button>", [$model::tableName().$model->estudio->modelo.'/view',"id"=> $key]
            ,[ 'role'=>'modal-remote',
               'title'=>'Ver',
              'data-toggle'=>'tooltip'
              ]
          );
          },
      ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
    ]
    ;

  if (Yii::$app->session->hasFlash('error')) {
    echo AlertBlock::widget([
                    'useSessionFlash' => true,
                    'type' => AlertBlock::TYPE_ALERT
                ]);
  }?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUDES ANULADAS </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/extras'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>

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
