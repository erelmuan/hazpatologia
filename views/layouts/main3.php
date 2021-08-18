
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
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="<?= Yii::$app->charset ?>" />
  <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge" /> -->
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!--Plantilla para modificar el link logout-->
   <?= Html::cssFile('@web/css/botonlogout.css') ?>
   <?= Html::cssFile('@web/css/plantillas-intro.css') ?>
   <!-- para que funcione e wizard form -->
   <?//= Html::cssFile('@web/css/icheck/flat/green.css') ?>
   <?//= Html::cssFile('@web/css/custom.css') ?>
   <!-- efecto sobre los modulos  -->
   <?= Html::cssFile('@web/css/animate.min.css') ?>
   <?= Html::jsFile('@web/js/jquery.min.js') ?>
   <!-- Modal para que muestra el protocolo -->


   <?//= Html::cssFile('@web/css/icheck/flat/green.css') ?>
   <?//= Html::cssFile('@web/css/custom.css') ?>
   <?= Html::jsFile('@web/js/sweetalert2.all.min.js') ?>

   <style>
    #demo{
      position:absolute;
      right:123px;      }
   </style>
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ["label" => "Notificaciones", "url" => ["/usuario/perfil"], "icon" => "fa fa-file-text-o"],
            ["label" => "Perfil", "url" => ["/usuario/perfil"], "icon" => "fa fa-file-text-o"],

          Yii::$app->user->isGuest ? (
              ['label' => 'Login', 'url' => ['/site/login']]
          ) : (
              '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
                  'Logout (' . Yii::$app->user->identity->username . ')',
                  ['class' => 'btn btn-link logout']
              )
              . Html::endForm()
              . '</li>'
          )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Hospital Artemides Zatti (Viedma-RN) <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<? if(empty($_SESSION['mostrar']) || $_SESSION['mostrar']=="bienvenido" ){  ?>
<div id="loader-out">
  <div id="loader-container">
    <p id="loading-text">BIENVENIDO <?=Yii::$app->user->identity->username ?> </p>
  </div>
</div>
<?
$_SESSION['mostrar']="nomostrar";
}
?>
<script>

$( document ).ready(function() {
  // Handler for .ready() called.
  setTimeout(function(){
    $('#loader-out').fadeOut();
  }, 3000);
});

</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
