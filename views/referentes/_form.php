<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Referentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referentes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'apeynom')->textInput(['maxlength' => true])->label('Apellido y nombre') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
