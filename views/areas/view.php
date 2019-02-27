<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Área ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Áreas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id_area], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_area], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres eliminar este área?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
        ],
    ]) ?>

</div>
