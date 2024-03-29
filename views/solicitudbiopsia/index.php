<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SolicitudSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\bootstrap\Collapse;
$this->title = 'Solicitudes de biopsias';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

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
        'template' => '{view}{update}',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],

        'visibleButtons'=>[
            'view'=> ['view'],
            'update'=> ['update']
            ]
    ];

?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUDES DE BIOPSIAS</h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/solicitudes'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<p>

    <?= Html::a('Nueva Solicitud de biopsia', "solicitudbiopsia/create", ['class' => 'btn btn-success']) ?>
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
                  // Html::a('<i class="glyphicon glyphicon-th"></i>', ['select'],
                  // ['role'=>'modal-remote','title'=> 'Personalizar','class'=>'btn btn-default']).
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de solicitudes (SOLO SE VISAULIZAN LOS QUE NO TIENEN ESTUDIO ASOCIADO)',
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
