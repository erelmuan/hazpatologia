<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\widgets\AlertBlock;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PacientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selección de solicitud';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<style>
.panel-primary {
    border-color: #fff;
}
.panel-primary > .panel-heading {
    color: #080808;
    background-color: #fff;
    border-color: #dde6ee;
}

</style>

<div id="w0sel" class="x_panel">

  <div class="x_title"><h2><i class="fa fa-table"></i> <?=$searchModel::labelName() ?> </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="solicitud-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columnsSeleccion.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid'])
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => 'DEBE SELECCIONAR UNA SOLICITUD Y AGREGARLA AL FORMULARIO',
                'before'=>'<em>* Utilice los filtros de busqueda para encontrar la solicitud.</em>',

                        '<div class="clearfix"></div>',
            ]
        ])?>
        <?php
        $form = ActiveForm::begin([
            'id' => 'idmed',
            'action' => [$searchModel::tableName().'/seleccionar'],
            'method' => 'post',
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true
            ],
        ]);
        ?>
        <input type="hidden" id="idsolicitud" name="idsol" data-toggle="tooltip" />
        <div class = "form-group">
          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#modal_large">Agregar al formulario</button>
      </div>
      <?php ActiveForm::end(); ?>

    </div>
</div>

</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script>

$(document).on("change","input[type=radio]",function(){
  document.getElementById("idsolicitud").value = this.value;

    });

</script>
