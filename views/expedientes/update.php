<?php

use yii\helpers\Html;

$this->title = 'Modificar expedientes: ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'id' => $model->id_expediente]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="expedientes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
