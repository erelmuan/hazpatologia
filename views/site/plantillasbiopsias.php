<?php
use kartik\icons\Icon;
use yii\helpers\Html;
Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Plantillas';
?>
<style>
.tile-stats{
background: #E6FDBD;
}


</style>

  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="icon-pastealt"></i> PLANTILLAS DE BIOPSIAS </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/plantillas'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">
  <div class="row">
    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."?r=plantilladiagnostico"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text-o"></i>
            </div>
            <div class="count"><?=$cantidadPlantillaDiag ?></div>
            <h3>DIAG. BIOPSIA</h3>
            <p>Alta-Baja-Modificacion.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=plantillamicroscopia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-square"></i>
          </div>
          <div class="count"><?=$cantidadPlantillaMic ?></div>

          <h3>MICROSCOPIA</h3>
          <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=plantillamacroscopia"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-square"></i>
          </div>
          <div class="count"><?=$cantidadPlantillaMac?></div>

          <h3>MACROSCOPIA</h3>
          <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=plantillamaterial"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-flask"></i>
          </div>
          <div class="count"><?=$cantidadPlantillaMatb?></div>

          <h3> MATERIAL BIOPSIA</h3>
          <p>Material de biopsias ABM.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=plantillafrase"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" >
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-comment"></i>
          </div>
          <div class="count"><?=$cantidadPlantillaFra?></div>

          <h3>FRASES</h3>
          <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
      </div>
    </a>

    </div>
  </div>


</div>
</div>
