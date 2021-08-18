<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="fullscreen_bg" class="fullscreen_bg"/>
    <div class="site-login">
      <div id="titulo">  SISTEMA DE LABORATORIO DE PATOLOGIA  </div>
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
                          //'layout' => 'horizontal',
                          'fieldConfig' => [
                            //  'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                          //    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                          ],
                      ]); ?>

                          <?= $form->field($model, 'username')->textInput(['autofocus' => true,'style'=> 'width:100%; text-transform:uppercase;']) ?>

                          <?= $form->field($model, 'password')->passwordInput() ?>

                          <?= $form->field($model, 'rememberMe')->checkbox([
                              'template' => "{input} {label}\n{error}",
                          ]) ?>

                          <div class="form-group">
                              <div class="col-lg-offset-1 col-lg-11">
                                  <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button', 'tabindex' => '4']) ?>
                              </div>
                          </div>

                          <?php ActiveForm::end(); ?>

                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
