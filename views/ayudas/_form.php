<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\TiposAyudas;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ayudas-form">



    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  
    <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="titulo-seccion">AYUDA ECONOMICA</h2>
            </div>
            <div class="panel-body">
              <div class="row">
                  <div class="col-xs-12 col-sm-6">
                  <div class="form-group has-success">
                    <?php $var1 = \yii\helpers\ArrayHelper::map(TiposAyudas::find()->where(['estado'=>1])->all(), 'id_tipo', 'nombre');?>
                    <?= $form->field($model, 'id_tipo')->dropDownList($var1, ['prompt' => 'Seleccione Tipo de Ayuda']);?>
                  </div>
                  <div class="form-group has-success">
                    <?= $form->field($model, 'entrega_dni') ->checkbox(['uncheck' => '1', 'value' => '2']); ?>
                  </div>
                  <div class="form-group has-success">
                    <?= $form->field($model, 'entrega_cuil') ->checkbox(['uncheck' => '1', 'value' => '2']); ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'doc_adjunta')->textInput(['maxlength' => true]) ?>  
                        </div>
                      </div>     
              </div>
             </div>
        </div>

    <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2 class="titulo-seccion">NOTA DE SOLICITUD</h2>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4">
                        <div class="form-group has-success">
                            <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                        <div class="form-group has-success">
                          <?= $form->field($model, 'monto')->textInput(['maxlength' => true]) ?>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                        <div class="form-group has-success">
                           <?= $form->field($model, 'fecha_nota')->widget(
                            DatePicker::className(), [
                                // inline too, not bad
                                 'inline' => false,
                                 'language' => 'es',
                                 // modify template for custom rendering
                                //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy',
                                    'todayHighlight'=> true
                                ]
                        ]);?>
                        </div>
                        </div>
                      </div>
                    </div>
              </div>
    <div class="panel panel-default">
                  <div class="panel-heading">
                    <h2 class="titulo-seccion">GESTIONADO POR:</h2>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'id_area')->textInput(['maxlength' => true]) ?>  
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'id_referente')->textInput(['maxlength' => true]) ?> 
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
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'file')->fileInput(); ?>                        
                      </div>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'file1')->fileInput(); ?>                        
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'file2')->fileInput(); ?>                        
                      </div>
                      </div>
                      <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?= $form->field($model, 'file3')->fileInput(); ?>                        
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
