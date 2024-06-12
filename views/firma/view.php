<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset;
use quidu\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Firma */
$isAjax = Yii::$app->request->isAjax;
CrudAsset::register($this);

?>
<div class="firma-view">
  <div class="biopsia-view">
      <div id="w0" class="x_panel">
        <?  if (!$isAjax) { ?>
        <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Ir a firmas', ['/firma/index'], ['class'=>'btn btn-danger grid-button']) ?></div>
        <? } ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'attribute'=>'imagen',
                'label'=>'Imagen',
                'value' => function ($model) {
                         return Html::img(Yii::$app->urlManager->baseUrl . '/uploads/firmas/' . $model->imagen, ['width' => '75px', 'height' => '75px', 'style' => 'margin-left: auto; margin-right: auto; position: relative;']);
                     },
                'format'=>'raw',

         ],
            [
                'class'=>'\kartik\grid\DataColumn',
                'attribute'=>'usuario.usuario',
                'width' => '170px',
                'value' => function($model) {
                  return Html::a( $model->usuario->usuario, ['usuario/view',"id"=> $model->usuario->id]
                    ,[    'class' => 'text-success','role'=>'modal-remote','title'=>'Datos del paciente','data-toggle'=>'tooltip']
                   );
                 }
                 ,
                 'format' => 'raw',
            ],

        ],
    ]) ?>

</div>
</div>
</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
