<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Expedientes;

/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

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
                            return '$' . $expediente->monto_total;
                        }
                   }
                },
              ],
            'estado',
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

</div>
