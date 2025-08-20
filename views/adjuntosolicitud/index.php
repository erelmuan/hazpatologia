<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\Archivo $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestión de Archivos';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);

?>

<div id="w0" class="x_panel">
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

      <?php $form = ActiveForm::begin([
        'action'=>['adjuntosolicitud/create' ,'id_solicitud'=>$model->id_solicitud ],
        'options' => ['enctype' => 'multipart/form-data']
      ]); ?>

<div class="x_panel">
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
    </ul>
    <legend class="text-info"><small>Datos de la solicitud</small></legend>
    <div class="x_content" style="display: block;">
      <?
      echo Form::widget([ // fields with labels
          'model'=>$model,
          'form'=>$form,
           'columns'=>5,
           'attributes'=>[
           'Protocolo'=>['label'=>'Protocolo', 'options'=>['value'=>$solicitud->protocolo ,'readonly'=> true ],'columnOptions'=>['class'=>'col-sm-1',],],
           'Paciente'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Paciente', ['paciente/view' ,'id'=> $solicitud->id_paciente],
             ['role'=>'modal-remote','title'=> 'Ver paciente']), 'options'=>['value'=>$solicitud->paciente->apellido." ". $solicitud->paciente->nombre ,'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
             'DNI'=>['label'=>'DNI', 'options'=>['value'=>$solicitud->paciente->num_documento, 'placeholder'=>'Documento...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-2']],
             'Edad'=>['label'=>'Edad', 'options'=>['value'=>$solicitud->calcular_edad(), 'placeholder'=>'Edad...','readonly'=> true],'columnOptions'=>['class'=>'col-sm-1']],
             'Medico'=>['label'=> Html::a('<i class="glyphicon glyphicon-eye-open"></i>'.' '.'Medico', ['medico/view' ,'id'=> $solicitud->id_medico],
            ['role'=>'modal-remote','title'=> 'Ver medico']), 'options'=>['value'=>$solicitud->medico->apellido ." ". $solicitud->medico->nombre, 'readonly'=> true ,'url' => '#' ],'columnOptions'=>['class'=>'col-lg-3',],],
           'id_solicitudbiopsia'=>['type'=>Form::INPUT_HIDDEN, 'columnOptions'=>['colspan'=>0], 'options'=>['value'=>$solicitud->id ]],

          ]
      ]);
      ?>
      </div>
</div>
<div class="x_panel">

      <h4>Adjuntar nuevo archivo</h4>

      <div class="row">
        <?= $form->field($model, 'id_solicitud')->hiddenInput()->label(false) ?>

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
        'id'=>'crud-datatable',
        'dataProvider' => $dataProvider,
        'pjax'=>true,

        'columns' => [
          ['class' => 'yii\grid\SerialColumn'],

          [
            'attribute' => "nombre_asignado",
          ],

          [
            'attribute' => 'nombre_archivo',
             'format' => 'raw',
             'value' => function ($model) {
                 return Html::encode($model->nombre_archivo); // Solo nombre
             }
          ],
          'observacion',

          [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}{download}{delete} ',
            'header'=> 'Acciones',
            'buttons' => [
              'download' => function ($url, $model) {
                   return Html::a('<i class="fa fa-download"></i>', ['/adjuntosolicitud/descargar', 'id' => $model->id], [
                       'class' => 'btn btn-warning btn-sm',
                       'title' => 'Descargar archivo',
                       'target' => '_blank',
                       'data-toggle' => 'tooltip',
                       'data-pjax' => '0'
                   ]);
               },
              'view' => function ($url, $model) {
                return Html::a('<i class="fa fa-eye"></i>', ['adjuntosolicitud/view', 'id' => $model->id], [
                  'class' => 'btn btn-success btn-sm',
                  'title' => 'Ver archivo',
                  'data-toggle' => 'tooltip',
                  'role' => 'modal-remote',
                  //'data-pjax'=>'0' ,

                ]);
              },
              'update' => function ($url, $model) {
                return Html::a('<i class="fa fa-pencil"></i>', ['adjuntosolicitud/update', 'id' => $model->id], [
                  'class' => 'btn btn-primary btn-sm',
                  'title' => 'Modificar archivo',
                  'data-toggle' => 'tooltip',
                  'role' => 'modal-remote',
                  //'data-pjax'=>'0' ,

                ]);
              },

              'delete' => function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>', ['adjuntosolicitud/delete', 'id' => $model->id], [
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
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
