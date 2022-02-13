<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AuditoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auditorias';
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
?>
<div id="w0Audi" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> AUDITORIAS </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/administracion'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
  <?=$export;
    $columns=[

            [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'id',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'usuario.usuario',
            'width' => '170px',
            'value' => function($dataProvider, $key, $index, $widget) {
                $key = str_replace("[","",$key);
                $key = str_replace("]","",$key);
                //var_dump ($key);
              return Html::a( $dataProvider->usuario->usuario, ['usuario/view',"id"=> $dataProvider->usuario->id]

                ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
               );

             }
             ,

             'filterInputOptions' => ['placeholder' => 'Ingrese Dni,HC o nombre'],
             'format' => 'raw',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'accion',
        ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'registro',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'tabla',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'fecha',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'hora',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'ip',
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'informacion_usuario',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign'=>'middle',
            'template' => '{view}',

            'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to([$action,'id'=>$key]);
            },

        ],

    ];
  ?>
<div class="auditoria-index">
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de auditorias',
                'before'=>'<p><em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em></p>
                        <p>Debido a cambios importantes en el codigo, considerar la auditoria a partir del 14-2-2022 </p>',

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
