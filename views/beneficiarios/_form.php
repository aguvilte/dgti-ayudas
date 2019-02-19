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
              <div class="row">
                  <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                      <?= $form->field($model, 'apeynom')->textInput(['maxlength' => true,'placeholder' => 'Apellido,Nombre']) ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                    <?= $form->field($model, 'documento')->textInput(['placeholder' => '37895462','maxlength'=>8,'minlength'=>8,'required'=>true]) ?>
                  </div>
                </div>
                  <div class="col-xs-12 col-sm-3">
                  <div class="form-group has-success">
                    <?= $form->field($model, 'cuil')->textInput(['placeholder' => '21-37895462-4','maxlength'=>13,'minlength'=>13,'required'=>false]) ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
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
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                      <?= $form->field($model, 'lugar_nacimiento')->textInput() ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                    <?= $form->field($model, 'domicilio')->textInput() ?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                    <?= $form->field($model, 'telefono_fijo')->textInput() ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                  <div class="form-group has-success">
                    <?= $form->field($model, 'telefono_celular')->textInput() ?>
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
                            <?= $form->field($model, 'file')->fileInput(); ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 co sm-3">
                        <div class="form-group has-success">
                           <?= $form->field($model, 'file1')->fileInput(); ?>
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
