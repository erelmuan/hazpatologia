<style>
body {
  /* background-image: url("img/lab.jpg"); */
  background-color: #cccccc;
  background-position: center; /* Center the image */
   background-size: cover;
    backdrop-filter: blur(6px);
    /* -webkit-filter: blur(5px);
-moz-filter: blur(5px);
-o-filter: blur(5px);
-ms-filter: blur(5px); */
/* filter: blur(5px); */
/* position: fixed;
width: 100%;
height: 100%; */
/* top: 0;
left: 0; */
z-index: -5;
}
</style>

<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\icons\Icon;
Icon::map($this, Icon::WHHG);
$this->title = 'INICIO SESIÓN';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- fullscreen_bg define el fondo de imagen -->
<nav id="w0" class="navbar-inverse navbar-fixed-top navbar"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse"><span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span></button><a class="navbar-brand" href="/hazpatologia/web/index.php"><?echo Icon::show('microscope', ['class'=>'fa-1x', 'framework' => Icon::WHHG]); ?> HAZ PATOLOGIA</a></div><div id="w0-collapse" class="collapse navbar-collapse"><ul id="w1" class="navbar-nav navbar-right nav">
</ul></div></div></nav>




<div id="fullscreen_bg" />
    <div class="site-login">
        <!-- <p>Please fill out the following fields to login:</p> -->
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                    </div>
                    <div class="panel-body">
                      <?php $form = ActiveForm::begin([
                          'id' => 'login-form',
                          'fieldConfig' => [
                            //  'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                          //    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                          ],
                      ]); ?>

                          <?= $form->field($model, 'username')->textInput(['style'=> 'width:100%; text-transform:uppercase;']) ?>

                          <?= $form->field($model, 'password')->passwordInput() ?>

                          <?= $form->field($model, 'rememberMe')->checkbox([
                              'template' => "{input} {label}\n{error}",
                          ]) ?>

                          <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-11">
                                  <?= Html::submitButton('Entrar', ['class' => 'btn btn-info btn-block', 'name' => 'login-button', 'tabindex' => '4']) ?>
                              </div>
                          </div>

                          <?php ActiveForm::end(); ?>

                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
