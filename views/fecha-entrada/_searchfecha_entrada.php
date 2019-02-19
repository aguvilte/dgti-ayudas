<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use app\models\Estados;
?>

<div class="archivos-search">

    <div class="form form-con-margen">
        <?php $form = ActiveForm::begin([
            'action' => ['fechas'],
            'method' => 'get',
        ]); ?>
    


        <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="titulo-seccion">Consulta por fecha de Entrada</h2>
            </div>
            <div class="panel-body">
              <div class="row">
                  <div class="col-xs-12 col-sm-6">
                  <div class="form-group has-success">
                    <?=
                        $form
                            ->field($model, 'fecha_entrada')
                            ->textInput(['maxlength' => 10, 'style' => 'max-width: 100px'])
                            ->label('Fecha (dd/mm/aaaa)')
                        ?>
                  </div>
                  <div class="form-group has-success">
                    <?= 
                        Html::textInput(
                            '',     // Label
                            '',     // Valor
                            [
                                'class' => 'form-control',
                                'id' => 'rango-fecha-2',
                                'maxlength' => 10,
                                'style' => 'max-width: 100px'
                            ]
                        )
                     ?>
                  </div>
                  
                </div>
              </div>
        
        <br>
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        <p style="margin-bottom: 0; color: darkgreen">
            Por fecha exacta: complete sólo el primer campo.
        </p>
        <p style="color: darkgreen">
            Por rango de fechas: complete ambos campos.
        </p>
        <br>

             </div>
        </div>
    </div>
    <br>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Borrar campos', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
