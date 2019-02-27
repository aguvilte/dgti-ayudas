<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Referentes */

$this->title = 'Referente: ' . $model->apeynom;
$this->params['breadcrumbs'][] = ['label' => 'Referentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referentes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id_referente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_referente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres eliminar este referente?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_referente',
            [
                'label' => 'Apellido y nombre',
                'attribute' => 'apeynom',
            ],
        ],
    ]) ?>

</div>
