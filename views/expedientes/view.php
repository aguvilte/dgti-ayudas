<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Expedientes;

$this->title = 'Expediente ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expedientes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id_expediente], ['class' => 'btn btn-primary']) ?>
        <!-- <?= Html::a('Eliminar', ['delete', 'id' => $model->id_expediente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
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
                            return 'Activo';
                        }
                        else {
                            return 'Inactivo';
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
        // $texto = 'Esta norma modifica/complementa a ' . $asModificador . ' norma/s.';
        $texto = 'Ayudas en expediente';
        if($ayudasEnExpediente > 0) {
        }
        else
            echo '<p style="margin: 0;">' . $texto . '</p>';
        ?>
    </div> -->

</div>
