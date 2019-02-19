<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

$this->title = 'Update Expedientes: ' . $model->id_expediente;
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_expediente, 'url' => ['view', 'id' => $model->id_expediente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expedientes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
