<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use \yii\web\View ;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Alert;
use kartik\widgets\Growl;
use kartik\widgets\SwitchInput;
use app\models\AnioProtocolo;
use app\models\User;

  // Registra el AssetBundle de Gentelella
   $bundle = yiister\gentelella\assets\Asset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/assets/fontawesome/css/all.min.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
     <?= Html::cssFile('@web/css/plantillas-intro.css') ?>
     <!-- efecto sobre los modulos  -->
     <?= Html::cssFile('@web/css/animate.min.css') ?>
     <?= Html::jsFile('@web/js/jquery.min.js') ?>
     <!-- Modal para que muestra el protocolo -->
     <?= Html::jsFile('@web/js/sweetalert2.all.min.js') ?>
     <?= Html::jsFile('@web/js/flashjs/dist/flash.min.js') ?>
     <link href="<?= Yii::$app->request->baseUrl ?>/css/custom.<?=Yii::$app->user->identity->configuracion->tema->descripcion?>.css" rel="stylesheet" id="estilo-original">
     <?=$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base(true).'/favicon.ico']); ?>
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >

<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">

            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <center class="site_title"><i class="fa fa-flask"></i> <span>hazpatologia</span> </center><center id="version" style="color:white; font-size: 10px;"> <b>Version: 2.5.1 </b></center>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                    <? echo '<img src='.Url::base(true).'/uploads/avatar/sm_'.Yii::$app->user->identity->imagen.' class="img-circle profile_img"   alt="..." >';?>
                    </div>
                    <div class="profile_info">
                        <span>BIENVENIDO,</span>
                        <h2><?=Yii::$app->user->identity->nombre ?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

              </br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <p>
                        <h3>MENÚ</h3>
                        </p>
                      <?  if (Yii::$app->user->identity->id_pantalla==1 && !User::isUserAdmin()){ ?>
                        <?= //pantalla 1 es la pantalla de consulta
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Inicio", "url" => ["/site/index"], "icon" => "fa fa-home"]

                                ],
                            ]
                        );
                      }else { ?>
                        <?= //ELIMINE LOS PREFIJOS EN LOS ARCHIVOS FontAwesome.php e Icon para que se puedan ver los iconos
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Inicio", "url" => ["/site/index"], "icon" => "fa fa-home"],
                                    [   "label" => "Plant. biopsia",
                                        "icon" => "fa fa-files-o",
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
                                    [   "label" => "Plant. pap",
                                        "icon" => "fa fa-files-o",
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
                                    ["label" => "Pacientes", "url" => ["/paciente/index"], "icon" => "fa fa-group"],
                                    [ 'separator' => '<br>',"label" => "Biopsias",   "url" => ["/biopsia/index","sort"=>"-id"],  'icon' =>"fa fa-microscope"],
                                    ["label" => "Paps","url" => ["/pap/index","sort"=>"-id"], "icon" => "fa fa-flask"],
                                    ["label" => "Solicitudes", "url" => ["/solicitud/index"], "icon" => "fa fa-file-text-o"],
                                    ["label" => "Consulta", "url" => ["/solicitud/consulta"], "icon" => "fa fa-search"],


                                ],
                            ]
                        );
                      }
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


                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a href=<?=Yii::$app->homeUrl."usuario/perfil"; ?> data-toggle="tooltip" data-placement="top" title="Perfil">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </a>
                    <a href=<?=Yii::$app->homeUrl."usuario/configuracion"; ?> data-toggle="tooltip" data-placement="top" title="Configuración">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a href=<?=Yii::$app->homeUrl."site/ayuda"; ?> data-toggle="tooltip" data-placement="top" title="Ayuda">
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                    </a>
                    <a href="#" onclick="cerrarSesion()" data-toggle="tooltip" data-placement="top" title="Salir">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>

                </div>

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">

                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <? echo '<img src='.Url::base(true).'/uploads/avatar/sm_'.Yii::$app->user->identity->imagen.'   alt="..." >';?>
                               <b style="color:#403d3d;"><?=Yii::$app->user->identity->usuario ?> </b>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href=<?=Yii::$app->homeUrl."usuario/perfil"; ?>> <i class="fa fa-user-circle-o pull-left" ></i>Perfil</a>
                                </li>
                                <li>
                                    <a href=<?=Yii::$app->homeUrl."usuario/configuracion"; ?>>
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span><i class="fa fa-gears pull-left" ></i>Configuración</span>
                                    </a>
                                </li>
                                <li>
                                    <a href=<?=Yii::$app->homeUrl."site/ayuda"; ?>><i class="fa fa-question pull-left" ></i>Ayuda</a>
                                </li>
                              </li>
                                 <li>
                                    <a href="#" onclick="cerrarSesion()"><i class="fa fa-sign-out pull-left" ></i>Salir</a>
                                 </li>

                              </li>
                            </ul>

                        </li>

                        <? if (Yii::$app->user->identity->id_pantalla==2) { ?>
                        <div id="fecha">
                          <b>   <input type="text" class="form-control is-invalid" value = <?= (AnioProtocolo::find()->where(['activo'=>true])->one()!== NULL)? AnioProtocolo::find()->where(['activo'=>true])->one()->anio:'INACTIVOS'  ?> readonly>  </b>
                        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Modificar Año-Protocolo', ['/anio-protocolo/index'], ['class'=>'btn btn-success grid-button']) ?>
                       </div>
                      <? } ?>
                    </ul>


                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">

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
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div id="datosHospital">
                Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro  (<?= date('Y') ?>)<br />
                Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>


<!-- /footer content -->
<?php $this->endBody(); ?>

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
<?php $this->endPage(); ?>
