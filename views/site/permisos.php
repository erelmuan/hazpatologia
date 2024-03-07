
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
      <a href=<?=Yii::$app->homeUrl."rol"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats permisos">
            <div class="icon"><i class="fa fa-users"></i>
            </div>
            <div class="count"><?=$cantidadRoles?></div>
            <h3>ROLES</h3>
            <p>Alta-Baja-Modificacion.</p>


        </div>
      </div>
      </a>

      <a href=<?=Yii::$app->homeUrl."modulo"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats permisos">
          <div class="icon"><i class="fa fa-bars"></i>
          </div>
          <div class="count"><?=$cantidadModulos?></div>

          <h3>MODULOS</h3>
          <p>Modulos ABM (Tablas).</p>
        </div>
      </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."accion"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats permisos">
          <div class="icon"><i class="fa fa-asterisk"></i>
          </div>
          <div class="count"><?=$cantidadAcciones?></div>
          <h3>ACCIONES</h3>
          <p>Alta-Baja-Modificacion.</p>
      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."tipo-acceso/index"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats permisos">
          <div class="icon"><i class="fas fa-archive"></i>
          </div>
          <div class="count"><?=$cantidadAcciones ?></div>
          <h3> TIPO DE ACCESOS </h3>
          <p>Listado de accesos.</p>
      </div>
    </div>
    </a>


    </div>

  </div>

</div>
</div>
