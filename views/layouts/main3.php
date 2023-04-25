
<?php

/* @var $this \yii\web\View */
/* @var $content string */
use \yii\web\View ;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\AnioProtocolo;

use yii\bootstrap\Nav;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FontAwesome;
// $bundle = yiister\gentelella\assets\Asset::register($this);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="<?= Yii::$app->charset ?>" />
  <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/assets/fontawesome/css/all.min.css">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
   <?= Html::cssFile('@web/css/plantillas-intro.css') ?>
   <!-- efecto sobre los modulos  -->
   <?= Html::cssFile('@web/css/animate.min.css') ?>
   <?= Html::jsFile('@web/js/jquery.min.js') ?>
   <?= Html::jsFile('@web/js/sweetalert2.all.min.js') ?>
   <link href="/hazpatologia/web/css/custom.<?=Yii::$app->user->identity->configuracion->tema->descripcion?>.css" rel="stylesheet" id="estilo-original">
   <?=$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base(true).'/favicon.ico']); ?>
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => FontAwesome::icon('fa fa-microscope') ." ".Yii::$app->name ." (v 2.1.0)",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ["label" => FontAwesome::icon('fa fa-home') ." Inicio", "url" => ["/site/index"]],
            [   "label" => FontAwesome::icon('fa fa-paste') ." Plant. biopsia",
                "url" => "#",
                "items" => [
                    ["label" => "Diagnostico", "url" => ["/plantilladiagnostico/index"]],
                    ["label" => "Microscopia  ", "url" => ["/plantillamicroscopia/index"]],
                    ["label" => "Macroscopia", "url" => ["/plantillamacroscopia/index"]],
                    ["label" => "Material", "url" => ["/plantillamaterial/index"]],
                    ["label" => "Frases", "url" => ["/plantillafrase/index"]],
                    ["label" => "Material de solicitud", "url" => ["/materialsolicitud/index"]],

                ],
            ],
            [   "label" => FontAwesome::icon('fa fa-paste') ." Plant. pap",
                "url" => "#",
                "items" => [
                    ["label" => "Diagnostico", "url" => ["/plantilladiagnostico/index"]],
                    ["label" => "Flora", "url" => ["/plantillaflora/index"]],
                    ["label" => "Aspecto", "url" => ["/plantillaaspecto/index"]],
                    ["label" => "Pavimentosa  ", "url" => ["/plantillapavimentosa/index"]],
                    ["label" => "Glandular", "url" => ["/plantillaglandular/index"]],
                    ["label" => "Frases", "url" => ["/plantillafrase/index"]],
                    ["label" => "Material de solicitud", "url" => ["/materialsolicitud/index"]],

                ],
            ],
            ["label" =>FontAwesome::icon('fa fa-users') . " Pacientes", "url" => ["/paciente/index"]],
            [ 'separator' => '<br>',"label" => FontAwesome::icon('fa fa-microscope') ." Biopsias",   "url" => ["/biopsia/index","sort"=>"-id"]],
            ["label" =>FontAwesome::icon('fa fa-flask') . " Paps","url" => ["/pap/index","sort"=>"-id"]],
            ["label" => FontAwesome::icon('fa fa-file-text') ." Solicitudes", "url" => ["/solicitud/index","sort"=>"-id"]],
            ["label" => (AnioProtocolo::find()->where(['activo'=>true])->one()!== NULL)? AnioProtocolo::find()->where(['activo'=>true])->one()->anio:'INACTIVOS', "url" => ["/anio-protocolo/index"],'options' => ['class' => 'btn-success' ]],

            [   "label" => Yii::$app->user->identity->usuario,
              'options' => ['class' => 'btn-primary', ],
                "icon" => "fa fa-files-o",
                "url" => "#",
                "items" => [
                    ["label" => FontAwesome::icon('glyphicon glyphicon-user') ." Perfil", "url" => ["/usuario/perfil"]],
                    ["label" => FontAwesome::icon('glyphicon glyphicon-cog') ." Configuración", "url" => ["/usuario/configuracion"]],
                    ["label" => FontAwesome::icon('glyphicon glyphicon-question-sign') ." Ayuda", "url" => ["/site/ayuda"]],
                ],
            ],

            ["label" => "SALIR", "url" => "#", "icon" => "fa fa-file-text-o" ,'options' => ['class' => 'btn-danger'],'linkOptions' => [ 'onclick' => 'cerrarSesion()'] ],

        ]
        ,'encodeLabels' => false,
    ]);

    NavBar::end();
    // Obtener la instancia de la sesión
    $session = Yii::$app->session;
    // Iniciar la sesión si no está iniciada aún
    if (!$session->isActive) {
        $session->open();
    }

    if($session->get('mensajeDelSistema')=="bienvenido" ){  ?>
      <div id="loader-out">
        <div id="loader-container">
          <p id="loading-text">BIENVENIDO <?=Yii::$app->user->identity->usuario ?> </p>
        </div>
      </div>
      <?
      $session->set('mensajeDelSistema', 'adios');
      }
      ?>

    ?>

    <div class="container">

        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                    <?php
                    echo \kartik\widgets\Growl::widget([
                        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                        'showSeparator' => true,
                        'delay' => 0, //This delay is how long before the message shows
                        'pluginOptions' => [
                          'showProgressbar' => true,
                            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                            'placement' => [
                                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                            ]
                        ]
                    ]);
                    ?>
                <?php endforeach; ?>

        <div class="clearfix"></div>
        <?= $content ?>
    </div>
</div>

<!-- footer content -->
<footer style="margin-left:auto">
    <div id="datosHospital">
        Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro  (<?= date('Y') ?>)<br />
        Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->


<?php $this->endBody() ?>
<script>
$( document ).ready(function() {
  // Handler for .ready() called.
  setTimeout(function(){
    $('#loader-out').fadeOut();
  }, 1300);
});
function cerrarSesion(){
  $.ajax({
      url: '<?php echo Url::to(['/site/logout']) ?>',
      type: 'post',
  });
}

</script>
</body>
</html>
<?php $this->endPage() ?>
