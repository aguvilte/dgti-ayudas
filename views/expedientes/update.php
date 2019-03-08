<?php

use yii\helpers\Html;

$this->title = 'Modificar expedientes: ' . $model->numero;
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero, 'url' => ['view', 'id' => $model->id_expediente]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="expedientes-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
