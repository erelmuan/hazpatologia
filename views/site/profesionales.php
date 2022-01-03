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
  <div class="x_title"><h2><i class="icon-pastealt"></i> PROFESIONALES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">

    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."?r=tipoprofesional"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-text-o"></i>
            </div>
            <div class="count"><?=$cantidadTipoProfesional ?></div>
            <h3>TIPO DE PROFRESION</h3>
            <p>Alta-Baja-Modificacion.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."?r=medico"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-square"></i>
          </div>
          <div class="count"><?=$cantidadMedicos ?></div>
          <h3>MEDICOS</h3>
          <p>Lorem ipsum psdea itgum rixt.</p>
        </div>
      </div>
      </a>


    </div>
  </div>

</div>
</div>
