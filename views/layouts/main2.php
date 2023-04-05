<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  <?//php  $this->registerCssFile("/hazpatologia/web/css/custom.css"); ?>
<?php  $this->registerCssFile("/hazpatologia/web/css/animate.min.css"); ?>

<!-- en esta plantilla estan cargados estilos de login plantillas intro y demas -->
<?= Html::cssFile('@web/css/plantillas-intro.css') ?>


</head>
<body >
  <link rel="shortcut icon" href="favicon.ico" />

<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">

        <?
        // Obtener la instancia de la sesión
        $session = Yii::$app->session;
        // Iniciar la sesión si no está iniciada aún
        if (!$session->isActive) {
            $session->open();
        }

        if($session->get('mensajeDelSistema')=="adios" ){  ?>
          <div id="loader-out">
            <div id="loader-container">
              <p id="loading-text">ADIÓS <?=$session->get('usuario_salida');?>  </p>
            </div>
          </div>
        <? }

        echo $content ;
        // Almacenar un valor en la variable de sesión
        $session->set('mensajeDelSistema', 'bienvenido');
         ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
      <p class="pull-left">&copy; Departamento de informática Artémides Zatti <?//= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
$( document ).ready(function() {
  // Handler for .ready() called.
  setTimeout(function(){
    $('#loader-out').fadeOut();
  }, 1300);
});
</script>
