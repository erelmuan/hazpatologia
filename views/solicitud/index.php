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
use kartik\widgets\AlertBlock;
$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
// Reemplazo la columna donde el valor es getlink por la funcion anonima, este artilugio es necesario
// porque la clase anonima en el metodo attributeColumns de la clase Biopsia
// arrojaba un error de serializacion

$index=0;
foreach ($columns as $key => $value) {

    if (isset($value["value"])&& $value["value"]=="getLink"){
      $columns[$index]["value"]=function($dataProvider, $key, $index, $widget) {

          return Html::a( $dataProvider->paciente->apellido  .' '.$dataProvider->paciente->nombre,["paciente/view","id"=> $dataProvider->paciente->id]
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
          return Html::a( $dataProvider->medico->apellido  .' '.$dataProvider->medico->nombre,["medico/view","id"=> $dataProvider->medico->id]
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
        // 'urlCreator' => function($action, $model, $key, $index) {
        //     return Url::to([$action,'id'=>$key]);
        // },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['title'=>'Editar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Solicitud',
            'data-confirm-message'=>'¿ Desea borrar este registro ?'],

            'buttons' => [
              'view' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [$model::tableName().$model->estudio->modelo.'/view',"id"=> $key]
                ,[ 'role'=>'modal-remote',
                   'title'=>'Ver',
                  'data-toggle'=>'tooltip'
                  ]

              );

              },

              'update' => function ($url, $model, $key) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [$model::tableName().$model->estudio->modelo.'/update',"id"=> $key]
                ,[
                   'title'=>'Actualizar',
                  'data-toggle'=>'tooltip'
                  ]

              );
              }
              ,
                 'delete' => function ($url, $model, $key) {
                $url = Url::to([$model::tableName().$model->estudio->modelo.'/delete', 'id' => $key]);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Borrar',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Solicitud',
                    'data-confirm-message'=>'¿ Desea borrar este registro ?'

                ]);
            },



          ],

    ];
    ;

  if (Yii::$app->session->hasFlash('error')) {
    echo AlertBlock::widget([
                    'useSessionFlash' => true,
                    'type' => AlertBlock::TYPE_ALERT
                ]); 
  }?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUDES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<p>

    <?//= Html::a('Nueva Solicitud', "?r=solicitud/create", ['class' => 'btn btn-success']) ?>
    <?= Html::a('Nueva Solicitud biopsia', "?r=solicitudbiopsia/create", ['class' => 'btn btn-success']) ?>
    <?= Html::a('Nueva Solicitud pap', "?r=solicitudpap/create", ['class' => 'btn btn-success']) ?>

</p>
<?=$export; ?>
<div class="solicitud-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => $columns,
            'toolbar'=> [
              ['content'=>
                  Html::button('<i class="glyphicon glyphicon-search"></i>', ['Buscar' ,'title'=> 'Buscar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-th"></i>', ['select'],
                  ['role'=>'modal-remote','title'=> 'Personalizar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
              ]
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de solicitudes',
                'before'=>'<em>* Para buscar una solicitud, tipear en el filtro y presionar ENTER o el boton <i class="glyphicon glyphicon-search"></i></em>',

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

