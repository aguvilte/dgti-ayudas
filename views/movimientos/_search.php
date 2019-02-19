<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TiposMovimientos;
use app\models\Usuarios;

/* @var $this yii\web\View */
/* @var $model app\models\MovimientosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="movimientos-search">

    <div class="form form-con-margen">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <!-- <?= $form->field($model, 'id_movimiento') ?> -->

        <!-- <?= $form->field($model, 'id_tipo_movimiento') ?> -->
        

        <div class="panel panel-default">
            <div class="panel-heading">
              <h2 class="titulo-seccion">Movimientos</h2>
            </div>
            <div class="panel-body">
              <div class="row">
                  <div class="col-xs-12 col-sm-6">
                  <div class="form-group has-success">
                    <?=
                    $form
                        ->field(
                            $model,
                            'id_tipo_movimiento'
                        )
                        ->dropDownList(
                            ArrayHelper::map(TiposMovimientos::find()->all(), 'id_tipo_movimiento', 'nombre'),
                            [
                                'prompt' => '',
                                'style' => 'max-width: 400px',
                            ]
                        )
                        ->label('Sección', ['class'=>'label-class'])
                    ?>
                  </div>
                  <div class="form-group has-success">
                    <?=
                    $form
                        ->field(
                            $model,
                            'id_usuario'
                        )
                        ->dropDownList(
                            ArrayHelper::map(Usuarios::find()->all(), 'id', 'username'),
                            [
                                'prompt' => '',
                                'style' => 'max-width: 400px',
                            ]
                        )
                        ->label('Usuario', ['class'=>'label-class'])
                    ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                        <div class="form-group has-success">
                        <?=
                        $form
                            ->field($model, 'fecha')
                            ->textInput(['maxlength' => 10, 'style' => 'max-width: 100px'])
                            ->label('Fecha (dd/mm/aaaa)')
                        ?>

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
             </div>
            <div class="form-group" style="text-align: center;">
                <?= Html::submitButton('Realizar Busqueda', ['class' => 'btn btn-success', 'id'=>'btn-buscar']) ?>
                <!-- <?= Html::resetButton('Borrar campos', ['class' => 'btn btn-default']) ?> -->
            </div>
        </div>

        <!-- <?=
        $form
            ->field($model, 'id_dato_modificado')
            ->textInput(['maxlength' => true, 'style' => 'max-width: 250px'])
            ->label('Número', ['class'=>'label-class'])
        ?> -->


        <!-- <?= $form->field($model, 'fecha') ?> -->
        <br>
    </div>
    <?php // echo $form->field($model, 'hora') ?>

    
    <?php ActiveForm::end(); ?>

</div>
