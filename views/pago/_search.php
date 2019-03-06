<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
// use app\models\TiposArchivos;
// use app\models\CategoriasArchivos;
// use app\models\SubcategoriasArchivos;
use app\models\Areas;
use app\models\Estados;
use app\models\Referentes;
use app\models\TiposAyudas;
use app\models\Expedientes;
use app\models\Usuarios;
?>

<div class="archivos-search">
    <div class="form form-con-margen">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?=
        $form
            ->field($model, 'id_tipo')
            ->dropDownList(
                ArrayHelper::map(TiposAyudas::find()->all(), 'id_tipo', 'nombre'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                    // 'onchange' => '
                    //     $.post("index.php?r=categorias-archivos/lists&id=' . '"+$(this).val(), function(data) {
                    //         $("select#archivossearch-id_categoria_archivo").html(data);
                    //     });
                    // '
                ]
            )
            ->label('Tipo de ayuda', ['class'=>'label-class label-titulo'])
        ?>

        <?=
        $form
            ->field($model, 'id_estado')
            ->dropDownList(
                ArrayHelper::map(Estados::find()->all(), 'id_estado', 'nombre'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                    // 'onchange' => '
                    //     $.post("index.php?r=categorias-archivos/lists&id=' . '"+$(this).val(), function(data) {
                    //         $("select#archivossearch-id_categoria_archivo").html(data);
                    //     });
                    // '
                ]
            )
            ->label('Estado de ayuda', ['class'=>'label-class label-titulo'])
        ?>

        <?=
        $form
            ->field($model, 'id_area')
            ->dropDownList(
                ArrayHelper::map(Areas::find()->all(), 'id_area', 'nombre'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                    // 'onchange' => '
                    //     $.post("index.php?r=categorias-archivos/lists&id=' . '"+$(this).val(), function(data) {
                    //         $("select#archivossearch-id_categoria_archivo").html(data);
                    //     });
                    // '
                ]
            )
            ->label('Área', ['class'=>'label-class label-titulo'])
        ?>

        <?=
        $form
            ->field($model, 'id_referente')
            ->dropDownList(
                ArrayHelper::map(Referentes::find()->all(), 'id_referente', 'apeynom'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                    // 'onchange' => '
                    //     $.post("index.php?r=categorias-archivos/lists&id=' . '"+$(this).val(), function(data) {
                    //         $("select#archivossearch-id_categoria_archivo").html(data);
                    //     });
                    // '
                ]
            )
            ->label('Referente', ['class'=>'label-class label-titulo'])
        ?>

        <?=
        $form
            ->field($model, 'fecha_entrada')
            ->textInput(['maxlength' => 10, 'style' => 'max-width: 100px'])
            ->label('Fecha de entrada (dd/mm/aaaa)')
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
        <br>
        
        <?=
        $form
            ->field($model, 'fecha_pago')
            ->textInput(['maxlength' => 10, 'style' => 'max-width: 100px'])
            ->label('Fecha de pago (dd/mm/aaaa)')
        ?>

        <?= 
        Html::textInput(
            '',     // Label
            '',     // Valor
            [
                'class' => 'form-control',
                'id' => 'rango-fecha-4',
                'maxlength' => 10,
                'style' => 'max-width: 100px'
            ]
        )
        ?>
        <br>

        <?=
        $form
            ->field($model, 'id_beneficiario')
            ->textInput(['maxlength' => true, 'style' => 'max-width: 250px'])
            ->label('Beneficiario (DNI)', ['class'=>'label-class'])
        ?>

        <?=
        $form
            ->field($modelExp, 'id_expediente')
            ->dropDownList(
                ArrayHelper::map(Expedientes::find()->all(), 'id_expediente', 'numero'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                ]
            )
            ->label('Expediente', ['class'=>'label-class label-titulo'])
        ?>

        <?=
            $form
            ->field($model, 'id_usuario')
            ->dropDownList(
                ArrayHelper::map(Usuarios::find()->where(['id_rol' => 2])->all(), 'id', 'username'),
                [
                    'prompt' => '',
                    'style' => 'max-width: 350px',
                ]
            )
            ->label('Usuario de carga', ['class'=>'label-class label-titulo'])
        ?>
    </div>
    <br>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Borrar campos', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>