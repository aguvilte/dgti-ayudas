<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Beneficiarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beneficiarios-form">


    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="titulo-seccion">DATOS PERSONALES</h2>
        </div>

        <div class="panel-body">
            <p>Los campos marcados con (*) son obligatorios</p>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?=
                        $form
                            ->field($model, 'apeynom')
                            ->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Nombre/s y apellido/s'
                            ])
                            ->label('Nombre y apellido (*)', ['class'=>'label-class']);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?=
                        $form
                            ->field($model, 'documento')
                            ->textInput([
                                'placeholder' => '37895462',
                                'maxlength' => 8,
                                'minlength' => 8,
                                'required' => true
                            ])
                            ->label('DNI (*)', ['class'=>'label-class']);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group has-success">
                        <?=
                        $form
                            ->field($model, 'cuil')
                            ->textInput([
                                'placeholder' => '21-37895462-4',
                                'maxlength' => 13,
                                'minlength' => 13,
                                'required' => false
                            ])
                            ->label('CUIL', ['class'=>'label-class']);
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?=
                        $form
                            ->field($model, 'fecha_nacimiento')
                            ->widget(
                                DatePicker::className(), [
                                    // inline too, not bad
                                    'inline' => false,
                                    'language' => 'es',
                                    // modify template for custom rendering
                                    //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd/mm/yyyy'
                                    ]
                            ])
                            ->label('Fecha de nacimiento', ['class'=>'label-class']);
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'lugar_nacimiento')->textInput()->label('Lugar de nacimiento', ['class'=>'label-class']); ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'domicilio')->textInput()->label('Domicilio', ['class'=>'label-class']); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'telefono_fijo')->textInput()->label('Teléfono fijo', ['class'=>'label-class']); ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'telefono_celular')->textInput()->label('Teléfono celular', ['class'=>'label-class']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="titulo-seccion">ARCHIVOS</h2>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 co sm-3">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'file')->fileInput()->label('Archivo PDF de DNI', ['class'=>'label-class']); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 co sm-3">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'file1')->fileInput()->label('Archivo PDF de CUIL', ['class'=>'label-class']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
