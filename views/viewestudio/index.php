<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ViewestudioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Viewestudios';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

echo $this->render('_search', array('model'=>$searchModel));
$searchModelAttributes = $searchModel->getAttributes();
?>
<div id="w0" class="x_panel">
<div class="viewestudio-index">
    <div id="ajaxCrudDatatable">
      <?php if (array_filter($searchModelAttributes) && $dataProvider->totalCount > 0) : ?>
         <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => null, // Deshabilita los filtros
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
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
    <p>No se encontraron resueeltados.</p>
  <?php endif; ?>
    </div>
</div>
</div>

<?php Modal::begin([
    'size' => 'modal-lg',
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
