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
.tile-stats{
background: #D5ECF4;
}


</style>
<?php
use kartik\icons\Icon;
use yii\helpers\Html;

Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Administración';
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-gears"></i> ADMINISTRACIÓN  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>

  <div class="body-content">


  <div class="row">

    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."?r=usuario"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-user"></i>
            </div>
            <div class="count"><?=$cantidadUsuarios ?></div>
            <h3>USUARIOS</h3>
            <p>Alta-Baja-Modificacion de los usuarios.</p>


        </div>
      </div>
      </a>

      <a href=<?=Yii::$app->homeUrl."?r=site/permisos"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-key"></i>
          </div>
          <div class="count">3 </div>

          <h3>PERMISOS</h3>
          <p>Definición de los permisos del usuario.</p>
        </div>
      </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=auditoria"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-book"></i>
          </div>
          <div class="count"><?=$cantidadAuditorias ?></div>
          <h3>AUDITORIA</h3>
          <p>Registro de las acciones de los usuarios.</p>


      </div>
    </div>
    </a>
    <a href=<?=Yii::$app->homeUrl."?r=firma"; ?>>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
          <div class="icon"><i class="fa fa-edit"></i>
          </div>
          <div class="count"><?=$cantidadFirmas?></div>
          <h3>FIRMAS</h3>
          <p>Firmas escaneadas.</p>


      </div>
    </div>
    </a>

    </div>

  </div>

</div>

</div>
