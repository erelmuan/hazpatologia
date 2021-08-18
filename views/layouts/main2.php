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
  <?php  $this->registerCssFile("/patologia/web/css/custom.css"); ?>
<?php  $this->registerCssFile("/patologia/web/css/animate.min.css"); ?>
<?php  $this->registerCssFile("/patologia/web/css/green.css", [
  'media' => 'print',
], 'css-print-theme'); ?>
<!-- en esta plantilla estan cargados estilos de login plantillas intro y demas -->
<?= Html::cssFile('@web/css/plantillas-intro.css') ?>

</head>
<body >
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="container">

        <?= Alert::widget() ?>
        <?= $content ?>
    <!-- variable session para mostrar la pantalla de bievenida -->
        <? $_SESSION['mostrar']="bienvenido";?>

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
