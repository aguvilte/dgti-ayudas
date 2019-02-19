<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'documento')->textInput(['placeholder' => '25479616','maxlength' => 8]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput() ?>

    <?php
    $a= ['0' => 'Femenino', '1' => 'Masculino'];
    echo $form->field($model, 'sexo')->dropDownList($a,['prompt'=>'Seleccionar opción']);
    ?>

    <?= $form->field($model, 'fecha_nacimiento')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false,
             'language' => 'es',
             // modify template for custom rendering
            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy'
            ]
    ]);?>

    <?= $form->field($model, 'telefono')->textInput(['placeholder' => '(0380)-154514796','maxlength' => true]) ?>

    <?= $form->field($model, 'profesion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correo')->textInput(['placeholder' => 'ejemplo@correo','type' => 'email']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
