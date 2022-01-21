<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\export\ExportMenu;
use yii\bootstrap\Collapse;
use kartik\widgets\AlertBlock;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paps';
echo Collapse::widget([
   'items' => [
       [
           'label' => 'Buscar por rango de fecha',
           'content' => $this->render('_search', ['model' => $searchModel]) ,
       ],
   ]
]);
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
// Reemplazo la columna donde el valor es getlink por la funcion anonima, este artilugio es necesario
// porque la clase anonima en el metodo attributeColumns de la clase Biopsia
// arrojaba un error de serializacion
$index=0;
foreach ($columns as $key => $value) {

    if (isset($value["value"])&& $value["value"]=="getlink"){
      $columns[$index]["value"]=function($dataProvider, $key, $index, $widget) {

          return Html::a( $dataProvider->solicitudpap->paciente->apellido  .' '.$dataProvider->solicitudpap->paciente->nombre,["paciente/view","id"=> $dataProvider->solicitudpap->paciente->id]
            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']

           );

         };

    }
    $index ++;

}
$index=0;
foreach ($columns as $key => $value) {

    if (isset($value["value"])&& $value["value"]=="getLinkdos"){
      $columns[$index]["value"]=function($dataProvider, $key, $index, $widget) {

          return Html::a( $dataProvider->solicitudpap->medico->apellido  .' '.$dataProvider->solicitudpap->medico->nombre,["medico/view","id"=> $dataProvider->solicitudpap->medico->id]
            ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del medico','data-toggle'=>'tooltip']

           );

         };

    }
    $index ++;

}
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
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],

        'visibleButtons'=>[
            'view'=> ['view'],
            'update'=> ['update'],
            'delete'=> ['delete']
            ]
    ];

    if (Yii::$app->session->hasFlash('error')) {
      echo AlertBlock::widget([
                      'useSessionFlash' => true,
                      'type' => AlertBlock::TYPE_ALERT
                  ]);
    }?>


<div id="w0pap" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> PAPS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<p>
  <?  if (Yii::$app->user->identity->id_pantalla==2 ){
      echo Html::a('Nuevo Pap', "?r=solicitudpap/seleccionar", ['class' => 'btn btn-success']);
    } ?>
</p>
<?=$export; ?>
<div class="pap-index">
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
                  Html::a('<i class="glyphicon glyphicon-th"></i>', ['select'],
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de paps',
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
