<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
 use quidu\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use kartik\export\ExportMenu;

$this->title = 'Roles/permisos';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    // mostrarDetalle se usa cuando hacemos un delete de detalle, desde la accion deletedetalle se
    // devuelve success => mostrarDetalle. para que se renderize nuevamente la ventana de detalle
    // tambien se usa cuando se agrega un detalle createDetalle

    function reloadDetalle(id_maestro){
        $.ajax({
            url: '<?php echo Url::to(['listdetalle']) ?>',
            type:"POST",
            data:{
                expandRowKey: id_maestro,
            },
            success: function(detalle) {
                element = $("tr").find("div[data-key='" + id_maestro + "']");
                $(element).html(detalle);}
        });
    }

    function submitDetalle(id_maestro){
        var keys = $('#cruddetalle-datatable').yiiGridView('getSelectedRows');
        if (keys.length === 0) {
            $('#error-no-seleccion').text('Debes seleccionar al menos una opción.');
            return; // Evita que la función continúe si ninguna opción se ha seleccionado
        }

        $.ajax({
            url: '<?php echo Url::to(['createdetalle']) ?>',
            dataType: 'json',
            type:"POST",
            data:{
                keylist: keys,
                id_maestro: id_maestro

            },
            success: function(data) {
                if( data.status == 'success' ){
                    $('#ajaxCrudModal').modal('hide');
                    reloadDetalle(id_maestro);
                }else{
                    $('#ajaxCrudModal .modal-dialog').css({'width':'600px'});
                    $('#ajaxCrudModal .modal-title')
                        .html('<p style="color:red">ERROR</p>');
                    $('#ajaxCrudModal').modal('show')
                        .find('#cruddetalle-datatable')
                        .html(('<div style=" font-size: 14px">Errores en la operacion indicada. Verifique</div>'));
                }
            }
        });
    }
    //codigo duplicado CORREGIR!!!
    function submitAddaccion(id_permiso){
        var keys = $('#cruddetalle-datatable').yiiGridView('getSelectedRows');
          var keys =$("tr.detalle-seleccionado").find("td:eq(0)").text();
          // Verificar si al menos una opción ha sido seleccionada
         if (keys.length === 0) {
           $('#error-no-seleccion').text('Debes seleccionar al menos una opción.');
             return; // Evita que la función continúe si ninguna opción se ha seleccionado
         }

        $.ajax({
            url: '<?php echo Url::to(['addaccion']) ?>',
            dataType: 'json',
            type:"POST",
            data:{
                keylist: keys,
                id_permiso: id_permiso

            },
            success: function(data) {
                if( data.status == 'success' ){
                    $('#ajaxCrudModal').modal('hide');
                    reloadDetalle(data.id_maestro);
                }else{
                    $('#ajaxCrudModal .modal-dialog').css({'width':'600px'});
                    $('#ajaxCrudModal .modal-title')
                        .html('<p style="color:red">ERROR</p>');
                    $('#ajaxCrudModal').modal('show')
                        .find('#cruddetalle-datatable')
                        .html(('<div style=" font-size: 14px">Errores en la operacion indicada. Verifique</div>'));
                }
            }
        });
    }

</script>



<?
CrudAsset::register($this);
$gridColumns =[  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'id',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'nombre',
  ],
  [
      'class'=>'\kartik\grid\DataColumn',
      'attribute'=>'descripcion',
  ]];


?>

<div id="w0r" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> ROLES/PERMISOS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/permisos'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>

<div class="rol-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            //Para que no busque automaticamente, sino que espere a que se teclee ENTER
            'filterOnFocusOut'=>false,
            'columns' => require(__DIR__.'/_columns.php'),
            'exportConfig'=> [
                         GridView::CSV=>[
                             'label' => 'CSV',
                             'icon' => '',
                             // 'iconOptions' => '',
                             'showHeader' => false,
                             'showPageSummary' => false,
                             'showFooter' => false,
                             'showCaption' => false,
                             'filename' => 'yii',
                             'alertMsg' => 'created',
                             'options' => ['title' => 'Semicolon -  Separated Values'],
                             'mime' => 'application/csv',
                             'config' => [
                                 'colDelimiter' => ";",
                                 'rowDelimiter' => "\r\n",
                             ],
                         ],
                     ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Crear nuevo rol','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                ],

            ],
            'striped' => true,
            'condensed' => true,
            //Adaptacion para moviles
            'responsiveWrap' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de roles',
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
