<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Expedientes;
use yii\grid\GridView;
use app\models\Areas;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\Estados;
use app\models\Referentes;
use app\models\AyudasExpedientes;
use app\models\TiposAyudas;

$this->title = 'Expediente ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expedientes-view">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id_expediente], ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('Eliminar', ['delete', 'id' => $model->id_expediente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="btn-pdf">
            Generar PDF
        </button>
        
        <!-- <?= Html::a('Cerrar expediente', ['cerrar', 'id' => $model->id_expediente], ['class' => 'btn btn-success']) ?> -->
        <?php
        $expediente = Expedientes::findOne($model->id_expediente);
        if ($expediente->estado == 1) {
            echo Html::a('Cerrar expediente', ['cerrar', 'id' => $model->id_expediente], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'numero',
            [
                'label' => 'Monto total',
                'attribute' => 'monto_total',
                'value' => function ($model) {
                   if (!empty($model->id_expediente))
                    {
                        $expediente = Expedientes::findOne($model->id_expediente);
                        if ($expediente !== null) {
                            return '$' .  number_format($expediente->monto_total, 2, ',', '.');
                        }
                    }
                },
            ],
            [
                'label' => 'Estado',
                'attribute' => 'estado',
                'value' => function ($model) {
                   if (!empty($model->id_expediente))
                   {
                        $expediente = Expedientes::findOne($model->id_expediente);
                        if ($expediente->estado == 1) {
                            return 'Abierto';
                        }
                        else {
                            return 'Cerrado';
                        }
                   }
                },
            ],
            [
                'attribute' => 'fecha_alta',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'fecha_cierre',
                'format' => ['date', 'php:d/m/Y']
            ],
        ],
    ]) ?>

    <!-- <div style="width: 40%; padding: 20px; border: 1px solid darkgrey; text-align: center; border-radius: 10px; margin: 20px auto;">
        <?php
        // $texto = 'Ayudas en expediente';
        // if($ayudasEnExpediente > 0) {
        // }
        // else
        //     echo '<p style="margin: 0;">' . $texto . '</p>';
        ?>
    </div> -->

    <?= GridView::widget([
        'dataProvider' => $dataProviderAyudasExp,
        // 'filterModel' => $modelAyudasExp,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'id_ayuda',
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Nombre y apellido',
                'value' => function($model) {
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if (!empty($ayuda->id_beneficiario)) {
                        $beneficiario = Beneficiarios::findOne($ayuda->id_beneficiario);
                        if ($beneficiario !== null) {
                            return $beneficiario->apeynom;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'DNI',
                'value' => function($model) {
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if (!empty($ayuda->id_beneficiario))
                    {
                        $beneficiario = Beneficiarios::findOne($ayuda->id_beneficiario);
                        if ($beneficiario !== null) {
                            return number_format($beneficiario->documento, 0, ',', '.');
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Tipo de ayuda',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_tipo)){
                        $tipo = TiposAyudas::findOne($ayuda->id_tipo);
                        if ($tipo !== null) {
                            return $tipo->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Estado',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_estado)){
                        $estado = Estados::findOne($ayuda->id_estado);
                        if ($estado !== null) {
                            return $estado->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Area',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_area)){
                        $area = Areas::findOne($ayuda->id_area);
                        if ($area !== null) {
                            return $area->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Referente',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_referente)){
                        $referente = Referentes::findOne($ayuda->id_referente);
                        if ($referente !== null) {
                            return $referente->apeynom;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Monto',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    return number_format($ayuda->monto, 2, ',', '.');
                },
            ],
            // 'id_expediente',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ver/Quitar expediente',
                'template' => '{view} {expediente}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'index.php?r=pago/view&id=' . $model->id_ayuda, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'expediente' => function ($url, $model) {
                        $expediente = Expedientes::findOne($model->id_expediente);
                        if ($expediente->estado == 1) {
                            return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/quitar', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Quitar de expediente'),'class' => 'btn btn-danger btn-xs']);
                        }
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben', 'style' => 'max-width: 20px'],
            ],
        ],
    ]); ?>

</div>

<script src='js/expedientes/view.js'></script>