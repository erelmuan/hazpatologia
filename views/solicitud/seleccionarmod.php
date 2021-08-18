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
  <div class="x_title"><h2><i class="fa fa-table"></i> MODIFICACION DE SOLICITUD  </h2>
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear nuevo paciente','class'=>'btn btn-default']).
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
            'action' => ['solicitud/seleccionarmod'],
            'method' => 'post',
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true
            ],
        ]);
        ?>
        <input type="hidden" id="idsolicitud" name="idsol" data-toggle="tooltip" />
        <div class = "form-group">
          <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#modal_large">Browse</button>

         <!-- <a class="btn btn-success" id="link" href="/patologiahaz/web/index.php?r=biopsia%2Fcreate&amp;" title="Se abrirá el archivo PDF generado en una nueva ventana" role="modal-remote" target="_blank" data-toggle="tooltip"> -->
          <!-- <i class="fa glyphicon glyphicon-hand-up"></i> AGREGAR AL FORMULARIO</a> -->
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
        <h4>   La solicitud que eligio ya fue agregada a un formulario de una biopsia  <h4>
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

    // var rad = document.kvradio;
    // var prev = null;
    // for(var i = 0; i < rad.length; i++) {
    //     rad[i].addEventListener('change', function() {
    //         (prev)? console.log(prev.value):null;
    //         if(this !== prev) {
    //             prev = this;
    //         }
    //         console.log(this.value)
    //     });
    // }


$(document).on("change","input[type=radio]",function(){
  document.getElementById("idsolicitud").value = this.value;

    });


//
//   function pasarvariable()
//   {
//     $('input').on('change', function(ev) {
//      $.pjax({container: '#pjax-grid-view'})
//
// });
// $(function(){
//     $('#widgetId-form input[name="valueType"]').change(function(){
//         //could be also hardcoded :
//         $('input[name="' + $(this).attr("name") + '"]').each(function(){
//                  if ($(this).is(":checked"))
//             {
//                 console.log("habilitando "+$(this).data("class"));
//                 $("."+$(this).data("class")).prop("disabled", false);
//             }
//             else
//             {
//                 console.log("deshabilitando "+$(this).data("class"));
//                 $("."+$(this).data("class")).prop("disabled", true);
//             }
//         });
//     });
//
//     $('#widgetId-form input[name="valueType"]:first').change();
// });
    // idsolicitud=$("tr.success").find("td:eq(1)").text();
    //
    // //Creo un formulario para pasar el dato a traves de POST a tu pagina 2
    // $('<form action="/patologiahaz/web/index.php?r=biopsia/create" method="post" ><input type="hidden" name="idsol" value="'+idsolicitud+'" /><input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" data-toggle="tooltip" /></form>')
    //   .appendTo('body').submit();
  //
  //
  //
  // }

</script>
