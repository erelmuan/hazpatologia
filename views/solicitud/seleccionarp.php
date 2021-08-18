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
  <div class="x_title"><h2><i class="fa fa-table"></i> NUEVO PAP  </h2>
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
            'action' => ['solicitud/seleccionarp'],
            'method' => 'post',
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true
            ],
        ]);
        ?>
        <input type="hidden" id="idsolicitud" name="idsol" data-toggle="tooltip" />
        <div class = "form-group">
          <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#modal_large">Agregar al formulario</button>
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


    <!-- Modal -->
    <div class="modal fade" id="modalElegir" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ERROR!</h4>
         </div>
         <div class="modal-body">
        <h4>   Debe elegir una solicitud. <h4>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalUsado" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ERROR!</h4>
         </div>
         <div class="modal-body">
        <h4>   La solicitud que eligio ya fue agregada a un formulario de un pap  <h4>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  <?php if($exibirEligir == true) : // Si nuestra variable de control "$exibirModal" es igual a TRUE activa nuestro modal y será visible a nuestro usuario. ?>
      <script>
      $(document).ready(function()
      {
        // id de nuestro modal
        $("#modalElegir").modal("show");
      });
      </script>
  <?php endif; ?>
  <?php if($exibirUsado == true) : // Si nuestra variable de control "$exibirModal" es igual a TRUE activa nuestro modal y será visible a nuestro usuario. ?>
      <script>
      $(document).ready(function()
      {
        // id de nuestro modal
        $("#modalUsado").modal("show");
      });
      </script>
  <?php endif; ?>
<script>
$(document).on("change","input[type=radio]",function(){
  document.getElementById("idsolicitud").value = this.value;
    });
</script>
