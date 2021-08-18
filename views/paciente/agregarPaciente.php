<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PacientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Creacion de Biopsia';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> PACIENTES AGREGAR  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>
<div class="pacientes-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columnsPac.php'),
            'toolbar'=> [
                ['content'=>
                    Html::button('<i class="glyphicon glyphicon-search"></i>', ['Buscar' ,'title'=> 'Buscar','class'=>'btn btn-default']).
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> DEBE SELECCIONAR UN PACIENTE Y AGREGARLO AL FORMULARIO',
                'before'=>'<em>* Para poder crear una biopsia necesita elegir un paciente y agregarlo a la biopsia.</em>',

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


<div class="col-md-12 col-sm-12 col-xs-12 form-group">
    <button  onclick="pasarvariable()" class="btn btn-success"  type="button"><i class="glyphicon glyphicon-minus"></i>AGREGAR AL FORMULARIO DE LA SOLICITUD</button>

</div>

<script>

  function pasarvariable()
  {
    idpaciente=$("tr.success").find("td:eq(1)").text();

    //Creo un formulario para pasar el dato a traves de POST a tu pagina 2
    $('<form action="/patologiahaz/web/index.php?r=biopsia/create" method="post"><input type="hidden" name="idpac" value="'+idpaciente+'" /><input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" /></form>')
      .appendTo('body').submit();



  }

</script>
