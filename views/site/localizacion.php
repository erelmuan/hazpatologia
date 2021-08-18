<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Localización';
?>
<style>
.tile-stats{
background: #D5ECF4;
}
.body-content {
  display: flex;
  justify-content: center;
  margin-left: auto;
  margin-right: auto;

}
.row {
  display: flex;
  justify-content: center;
  width: 1000px;
}
.tile-stats {
  width: 300px;


}
</style>

  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-location-arrow"></i> LOCALIZACIÓN  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">
    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."?r=procedencia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-user"></i>
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
          <div class="icon"><i class="fa fa-key"></i>
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
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadLocalidad ?></div>
          <h3>LOCALIDAD</h3>
          <p>ABM de las localidades de la Argentina.</p>


      </div>
    </div>
    </a>


    </div>

  </div>

</div>

</div>
