<?php
use kartik\icons\Icon;
use yii\helpers\Html;
Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Plantillas';
use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="icon-pastealt"></i> PLANTILLAS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/plantillas'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">

    <div class="row top_tiles">
    <a href=<?=Yii::$app->homeUrl."plantillaflora"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats planillas">
        <div class="icon"><i class="fa fa-square"></i>
        </div>
        <div class="count"><?=$cantidadPlantillaflora ?></div>

        <h3>FLORA</h3>
        <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."plantillaaspecto"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats planillas">
        <div class="icon"><i class="fa fa-square"></i>
        </div>
        <div class="count"><?=$cantidadPlantillaAsp ?></div>

        <h3>ASPECTO</h3>
        <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."plantillapavimentosa"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats planillas">
        <div class="icon"><i class="fa fa-square"></i>
        </div>
        <div class="count"><?=$cantidadPlantillaPav ?></div>

        <h3>PAVIMENTOSAS</h3>
        <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."plantillaglandular"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats planillas">
        <div class="icon"><i class="fa fa-square"></i>
        </div>
        <div class="count"><?=$cantidadPlantillaGla ?></div>

        <h3>GLANDULARES</h3>
        <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."plantilladiagnostico"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats planillas">
        <div class="icon"><i class="fa fa-square"></i>
        </div>
        <div class="count"><?=$cantidadPlantillaDiagP ?></div>

        <h3>DIAG. PAP</h3>
        <p>Lorem ipsum psdea itgum rixt.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."plantillafrase"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" >
      <div class="tile-stats planillas">
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
