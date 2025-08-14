<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
/** @var yii\web\View $this */
/** @var app\models\Archivo $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestión de Archivos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w022" class="x_panel">
  <div class="x_title">
    <h2>
      <i class="glyphicon glyphicon-plus"></i> Gestión de Archivos
    </h2>
    <div class="clearfix">
      <div class="nav navbar-right panel_toolbox">
        <?= Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', [
          'name' => 'btnBack',
          'onclick' => 'js:history.go(-1);returnFalse;',
          'id' => 'botonAtras'
        ]) ?>
      </div>
    </div>
  </div>
  </br>

  <div class="archivo-index container">

    <div class="card p-4 mb-4 shadow-sm">
      <h4>Adjuntar nuevo archivo</h4>

      <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
      ]); ?>

      <div class="row">
        <?= $form->field($model, 'id_solicitud')->hiddenInput()->label(false) ?>
        <div class="col-md-4">
          <?= $form->field($model, 'nombre_asignado')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'nombre_archivo')->fileInput() ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'observacion')->textInput(['maxlength' => true]) ?>
        </div>
      </div>

      <div class="form-group">
        <?= Html::submitButton('Subir archivo', ['class' => 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>

    <div class="card p-4 shadow-sm">
      <h4>Archivos adjuntados</h4>

      <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],

          'nombre_archivo',
          'observacion',
          [
            'attribute' => 'nombre_asignado',
            'format' => 'raw',
            'value' => function ($model) {
              return Html::a('Descargar', ['/adjuntosolicitud/descargar', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'target' => '_blank',
                'data-toggle' => 'tooltip',
                'title' => 'Se abrirá el archivo PDF generado en una nueva pestaña',
                'data-pjax' => '0'
              ]);
            }
          ],

          [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
              'update' => function ($url, $model) {
                return Html::a('<i class="fa fa-pencil"></i>', ['adjuntos-solicitud/update', 'id' => $model->id], [
                  'class' => 'btn btn-warning btn-sm',
                  'title' => 'Modificar archivo',
                  'data-toggle' => 'tooltip',
                  'role' => 'modal-remote',

                ]);
              },

              'delete' => function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>', ['adjuntos-solicitud/delete', 'id' => $model->id], [
                  'data-confirm' => '¿Estás seguro de eliminar este archivo?',
                  'data-method' => 'post',
                  'class' => 'btn btn-danger btn-sm'
                ]);
              }
            ]
          ]
        ],
      ]); ?>
    </div>

  </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
