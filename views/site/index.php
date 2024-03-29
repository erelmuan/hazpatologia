

<?php
use kartik\icons\Icon;
Icon::map($this, Icon::WHHG);

// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Inicio';
?>

  <?php
  use derekisbusy\panel\PanelWidget;
  ?>
  <div id="w0" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-home"></i> INICIO  </h2>


    <div class="clearfix">
  </div>
  </div>

  <div class="body-content">

  <div class="row">

    <div class="row top_tiles">
      <a href=<?=Yii::$app->homeUrl."site/plantillas"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="icon-pastealt" style="color:#a4d149 ;"></i>
            </div>
            <div class="count">2</div>
            <h3>PLANTILLAS</h3>
            <p>Información de las plantillas - ABM.</p>


        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."site/extras"; ?>>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="tile-stats">
            <div class="icon"><i class="fa fa-table" style="color:#5499c7 ;"></i>
            </div>
            <div class="count">8</div>

            <h3>TABLAS-EXTRAS</h3>
            <p>Tablas complementarias parametrizables.</p>
          </div>
        </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."paciente"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-users" style="color:#f7dc6f ;"></i>
          </div>
          <div class="count"><?=$cantidadPacientes ?></div>

          <h3>PACIENTES </h3>
          <p>Información de los pacientes - ABM.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."medico"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user-md" style="color:#f5b7b1 ;"></i>
          </div>
          <div class="count"><?=$cantidadMedicos ?></div>

          <h3>MEDICOS</h3>
          <p>Información de los medicos - ABM.</p>
        </div>
      </div>
    </a>
      <a href=<?=Yii::$app->homeUrl."biopsia/index?sort=-id"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"> <?  echo Icon::show('microscope', ['class'=>'fa-2x','style'=>"color:#a569bd  ;", 'framework' => Icon::WHHG]); ?>

          </div>
          <div class="count"><?=$cantidadBiopsias ?></div>

          <h3>BIOPSIAS</h3>
          <p>Información de las biopsias - Informe - ABM.</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."pap/index?sort=-id"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-flask" style="color:#a9dfbf ;"></i>
          </div>
          <div class="count"><?=$cantidadPaps ?></div>

          <h3>PAPS</h3>
          <p>Información de los paps - Informe - ABM</p>
        </div>
      </div>
      </a>
      <a href=<?=Yii::$app->homeUrl."solicitud/index?sort=-id"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-file-text" style="color:#f0b27a ;"></i>
          </div>
          <div class="count"><?=$cantidadSolicitudes ?></div>

          <h3> SOLICITUDES </h3>
          <p>Información de las solicitudes - ABM.</p>
        </div>
      </div>
      </a>

     <a href=<?=Yii::$app->homeUrl."site/administracion"; ?>>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-wrench" style="color:#2c3e50 ;"></i>
          </div>
          <div class="count">4</div>

          <h3>ADMINISTRACION</h3>
          <p>Usuarios-Roles-Modulos-Acciones- ABM.</p>
        </div>
      </div>
    </a>
    </div>
  </div>

</div>
</div>
<div id="detalleIndex" >

    <?  echo Icon::show('microscope', ['class'=>'fa-2x', 'framework' => Icon::WHHG]);
     ?>
     <span>DEPARTAMENTO DE ANATOMIA PATOLÓGICA HOSPITAL ARTÉMIDES ZATTI </span>

  <?  echo Icon::show('microscope', ['class'=>'fa-2x', 'framework' => Icon::WHHG]);
  ?>
</div>
