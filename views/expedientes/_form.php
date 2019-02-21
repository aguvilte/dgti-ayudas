<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="expedientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'monto_total')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'fecha_alta')->textInput() ?>

    <?= $form->field($model, 'fecha_cierre')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
