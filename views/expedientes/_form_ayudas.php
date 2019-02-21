<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\Expedientes;
use app\models\TiposAyudas;
?>

<div class="expedientes-form">

    <?php $form = ActiveForm::begin(); ?>

    <h6 style="margin-bottom: 1em">Beneficiario</h6>
    <?= 
        Html::textInput(
            'Monto',     // Label
            Beneficiarios::findOne($ayuda->id_beneficiario)->apeynom,     // Valor
            [
                'class' => 'form-control',
                'id' => 'ayudas-beneficiario',
                'maxlength' => 10,
                'style' => 'max-width: 400px',
                'disabled' => true
            ]
        )
    ?>
    <br>

    <h6 style="margin-bottom: 1em">Tipo de ayuda</h6>
    <?= 
        Html::textInput(
            'Monto',     // Label
            TiposAyudas::findOne($ayuda->id_tipo)->nombre,     // Valor
            [
                'class' => 'form-control',
                'id' => 'ayudas-tipo',
                'maxlength' => 10,
                'style' => 'max-width: 400px',
                'disabled' => true
            ]
        )
    ?>
    <br>
    
    <?=
        $form
        ->field($ayuda, 'fecha_entrada')
        ->textInput([
            'maxlength' => true,
            'disabled' => true,
            'style' => 'max-width: 100px',
        ])
    ?>
    
    <h6 style="margin-bottom: 1em">Monto</h6>
    <?= 
        Html::textInput(
            'Monto',     // Label
            '$ ' . Ayudas::findOne($ayuda->id_ayuda)->monto,     // Valor
            [
                'class' => 'form-control',
                'id' => 'ayudas-monto',
                'maxlength' => 10,
                'style' => 'max-width: 400px',
                'disabled' => true
            ]
        )
    ?>
    <br>

    <?=
        $form
        ->field(
            $model,
            'numero'
        )
        ->dropDownList(
            ArrayHelper::map(Expedientes::find()->where(['estado' => '1'])->all(), 'id_expediente', 'numero'),
            [
                'prompt' => '',
                'style' => 'max-width: 200px',
                // 'disabled' => true,
                // 'onchange' => '
                //     $.post("index.php?r=subcategorias-archivos/lists&id=' . '"+$(this).val(), function(data) {
                //         $("select#archivos-id_subcategoria_archivo").html(data);
                //     });
                // '
            ]
        )
        ->label('Número de expediente', ['class'=>'label-class'])
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar al expediente' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>