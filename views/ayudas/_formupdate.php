<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\TiposAyudas;
use app\models\Estados;
use app\models\Referentes;
use app\models\Areas;

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
                        <?=
                        $form
                            ->field($model, 'fecha_nota')
                            ->widget(
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
                            ]);
                        ?>
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
                        <!-- <?= $form->field($model, 'id_area')->textInput(['maxlength' => true]) ?>   -->
                        <?=
                        $form
                            ->field(
                                $model,
                                'id_area'
                            )
                            ->dropDownList(
                                ArrayHelper::map(Areas::find()->orderBy(['nombre' => SORT_ASC])->all(), 'id_area', 'nombre'),
                                [
                                    'prompt' => '',
                                    // 'style' => 'max-width: 400px',
                                ]
                            )
                            ->label('Área', ['class'=>'label-class'])
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group has-success">
                        <!-- <?= $form->field($model, 'id_referente')->textInput(['maxlength' => true]) ?>  -->
                        <?=
                        $form
                            ->field(
                                $model,
                                'id_referente'
                            )
                            ->dropDownList(
                                ArrayHelper::map(Referentes::find()->orderBy(['apeynom' => SORT_ASC])->all(), 'id_referente', 'apeynom'),
                                [
                                    'prompt' => '',
                                    // 'style' => 'max-width: 400px',
                                ]
                            )
                            ->label('Referente', ['class'=>'label-class'])
                        ?>
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
