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
              <h2 class="titulo-seccion">REALIZAR PAGO</h2>
            </div>
            <div class="panel-body">
              <div class="row">
                 
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group has-success">
                        <?= $form->field($model, 'file4')->fileInput(); ?>                        
                    </div>
                </div>     
              </div>
             </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Pagar' : 'Pagar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
