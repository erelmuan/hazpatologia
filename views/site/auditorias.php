
<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Permisos';
?>


  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-key"></i> PERMISOS  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site/administracion'], ['class'=>'btn btn-danger grid-button']) ?></div>
  </div>
  </div>
  <div class="body-content">
  <div class="row">
    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."auditoria"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats permisos">
            <div class="icon"><i class="fa fa-users"></i>
            </div>
            <div class="count"><?=$cantidadAuditorias?></div>
            <h3>AUDITORIA DE ACCIONES</h3>
            <p>Registro de las acciones de los usuarios.</p>


        </div>
      </div>
      </a>

      <a href=<?=Yii::$app->homeUrl."registrosesion"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats permisos">
          <div class="icon"><i class="fa fa-bars"></i>
          </div>
          <div class="count"><?=$cantidadRegistrosesion?></div>

          <h3>AUDITORIA DE SESIONES</h3>
          <p>Registro de las sesiones de los usuarios.</p>
        </div>
      </div>
    </a>

    </div>

  </div>

</div>
</div>
