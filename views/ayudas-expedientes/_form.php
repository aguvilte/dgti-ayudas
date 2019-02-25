<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AyudasExpedientes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ayudas-expedientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_ayuda')->textInput() ?>

    <?= $form->field($model, 'id_expediente')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
