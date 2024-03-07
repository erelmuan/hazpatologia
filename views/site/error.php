<?php

use yii\helpers\Html;
use yii\web\HttpException;

?>

<div class="notfound">

  <div class="notfound-404">
    <h1><?= Html::encode($exception->statusCode) ?> </h1>
  </div>
  <h2><?= Html::encode($exception->getMessage())?><?= ($exception->statusCode==404)?'': '<h2>'.$controller.'/'.$action.'<h2>' ?></h2>
  <p>
  Póngase en contacto con nosotros si cree que esto es un error del servidor. Gracias.
  </p>
    <a href=<?=Yii::$app->homeUrl ?>>Pagina principal</a>
  </div>
