<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Pacientes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

//me genera error con las obras sociales
// $configexport=[
//
//         GridView::EXCEL => [
//           'export'=> true,
//         'iconOptions' => ['class' => 'text-success'],
//         'showHeader' => true,
//         'showPageSummary' => false,
//         'showFooter' => true,
//          'options' => ['title' => ( 'Microsoft Excel 95+')],
//         'config'=>true,
//         'showCaption' => true,
//           'mime' => 'application/vnd.ms-excel',
//           'config' => [
//               'cssFile' => ''
//           ]
//
// ],
//
//
// ] ;
?>

<div id="w0p" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> PACIENTES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>

<div class="paciente-index">
    <div id="ajaxCrudDatatable">

        <?=GridView::widget([

            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            //Para que no busque automaticamente, sino que espere a que se teclee ENTER
            'filterOnFocusOut'=>false,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::button('<i class="glyphicon glyphicon-search"></i>', ['Buscar' ,'title'=> 'Buscar','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear un paciente','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])//.
                    // '{toggleData}'.
                    //  '{export}'
                ],
                   'exportContainer' => ['class' => 'btn-group-sm']


            ],


            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                  'type' => 'primary',
                  'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de pacientes',
                  'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em>',
                 '<div class="clearfix"></div>',
            ]
        ])
        ?>
    </div>
</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
