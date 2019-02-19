<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
$id=$_GET["id"];
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['required' => true,'disabled' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['required' => true,'type' => 'text','disabled' => true])->label('Contraseña Actual') ?>

    <?= $form->field($model, 'password')->passwordInput(['type'=>"hidden"])->label(false)?>

    <div class="form-group">
      <label class="control-label">Nueva Contraseña</label>
      <input type="text" class="form-control" name="contraseña-nueva" required>
    </div>

    <div class="form-group">
      <label class="control-label">Confirmar Nueva Contraseña</label>
      <input type="text" class="form-control" name="confirmar-contraseña-nueva" required>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
