<style>
  .x_title h2 {
      margin: 5px 0 6px;
      float: left;
      display: block;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
  }
  .x_title {
    border-bottom: 2px solid #E6E9ED;
    padding: 0px;
    margin-bottom: 10px;
    height:45;
}
</style>
<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Extras';

  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> TABLAS EXTRAS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">
    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."?r=procedencia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-location-arrow"></i>
            </div>
            <div class="count"><?=$cantidadProcedencia ?></div>
            <h3>PROCEDENCIA</h3>
            <p>AMB del lugar de origen de las muestras.</p>
        </div>
      </div>
      </a>

      <a href=<?=Yii::$app->homeUrl."?r=provincia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-map-marker"></i>
          </div>
          <div class="count"><?=$cantidadProvincia ?></div>

          <h3>PROVINCIA</h3>
          <p>ABM de las provincias de Argentina.</p>
        </div>
      </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=localidad"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-map-marker"></i>

          </div>
          <div class="count"><?=$cantidadLocalidad ?></div>
          <h3>LOCALIDAD</h3>
          <p>ABM de las localidades de la Argentina.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=tipoprofesional"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-mortar-board"></i>
          </div>
          <div class="count"><?=$cantidadTipoProfesional ?></div>
          <h3>TIPO DE PROFRESION</h3>
          <p>Alta-Baja-Modificacion.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=obrasocial"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadObrasocial ?></div>
          <h3>OBRA SOCIAL</h3>
          <p>ABM de las obras sociales.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=tipodoc"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadTipoDoc ?></div>
          <h3>TIPO DOCUMENTO</h3>
          <p>ABM de los tipos de doc.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=nacionalidad"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-flag"></i>
          </div>
          <div class="count"><?=$cantidadNacionalidad ?></div>
          <h3>NACIONALIDAD</h3>
          <p>ABM de las nacionalidades.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=estado"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-dashboard"></i>
          </div>
          <div class="count"><?=$cantidadEstado ?></div>
          <h3>ESTADOS</h3>
          <p>Estados de los estudios y solicitudes.</p>


      </div>
    </div>
    </a>

    </div>

  </div>

</div>

</div>
