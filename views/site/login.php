<style>
body {
   background-image: url('/hazpatologia/web/img/laboratorio1.jpg');;
  background-color: #cccccc;
  background-position: center; /* Center the image */
   background-size: 200% 300%;
    backdrop-filter: blur(1px);
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
z-index:-100;
}
.panel-default{
    opacity: 0.9;
}
/* Password field */
.password-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-wrapper .form-control {
    padding-right: 42px;
}

.toggle-eye {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    color: #888;
    display: flex;
    align-items: center;
    transition: color 0.2s ease;
}

.toggle-eye:hover {
    color: #333;
}

.toggle-eye:focus {
    outline: none;
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
                        <h3 class="panel-title"><b><?= Html::encode($this->title) ?></b></h3>
                    </div>
                    <div class="panel-body">
                      <?php $form = ActiveForm::begin([
                          'id' => 'login-form',
                          'fieldConfig' => [
                          ],
                      ]); ?>

                          <?= $form->field($model, 'username')->textInput(['style'=> 'width:100%; text-transform:uppercase;']) ?>

                          <!-- Campo contraseña con ojo profesional -->
                          <?= $form->field($model, 'password', [
                            'template' => '
                                {label}
                                <div class="password-wrapper">
                                    {input}
                                    <button type="button" id="toggle-password" class="toggle-eye" aria-label="Mostrar contraseña">
                                        <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                             style="display:none;">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
                                                     a18.45 18.45 0 0 1 5.06-5.94"/>
                                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8
                                                     a18.5 18.5 0 0 1-2.16 3.19"/>
                                            <line x1="1" y1="1" x2="23" y2="23"/>
                                        </svg>
                                    </button>
                                </div>
                                {error}
                            ',
                        ])->passwordInput([
                            'id' => 'loginform-password',
                            'placeholder' => '••••••••',
                        ])->label('Contraseña') ?>

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
<?php
$js = <<<JS
    var btn   = document.getElementById('toggle-password');
    var input = document.getElementById('loginform-password');
    var open  = document.getElementById('icon-eye-open');
    var closed = document.getElementById('icon-eye-closed');

    btn.addEventListener('click', function () {
        var isPassword = input.type === 'password';
        input.type     = isPassword ? 'text' : 'password';
        open.style.display   = isPassword ? 'none'  : 'block';
        closed.style.display = isPassword ? 'block' : 'none';
    });
JS;
$this->registerJs($js);
?>
