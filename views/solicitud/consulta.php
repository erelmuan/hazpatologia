<style>
.letras-grandes {
  font-size: 18px;
}
</style>
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



  if (Yii::$app->session->hasFlash('error')) {
    echo AlertBlock::widget([
                    'useSessionFlash' => true,
                    'type' => AlertBlock::TYPE_ALERT
                ]);
  }?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-search"></i> ACCESO SOLO CONSULTAS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"></div>
</div>
  </div>
<p>

  <?= $this->render('_searchconsulta', array('searchModel'=>$searchModel));
  $searchModelAttributes = $searchModel->getAttributes();
  ?>



</p>
<div id="w0" class="x_panel">
<div class="solicitud-index">
    <div id="ajaxCrudDatatable">
      <?php if (array_filter($searchModelAttributes) && $dataProvider->totalCount > 0) : ?>
         <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => null, // Deshabilita los filtros
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columnsConsulta.php'),
            'toolbar'=> [
                ['content'=>'',
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',

            ]
        ])?>
      <?php else : ?>
    <p>No se encontraron resultados.</p>
  <?php endif; ?>
    </div>
</div>
</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
   'size' => Modal::SIZE_LARGE,
]);


?>

<?php Modal::end(); ?>
