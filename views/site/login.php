<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="login-wrap">
      <div class="login-html">
        <div class="login-form">
              <div class="login-h1 text-center"><?= Html::encode($this->title) ?></div>
          <div class="_sign-in-htm">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"group\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'label txt-login-blk'],
                ],
            ]); ?>
                <div class="group">
                  <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class' => 'input'])->label('Usuario') ?>
                </div>

                <div class="group">
                  <?= $form->field($model, 'password')->passwordInput(['class' => 'input'])->label('Contraseña') ?>
                </div>
                 

                <div class="group">
                   <?= Html::submitButton('Login', ['class' => 'button', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        <div class="hr"></div>

      </div>
    </div>
  </div>
</div>

</div>
