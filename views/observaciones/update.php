<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Observaciones */

$this->title = 'Update Observaciones: ' . $model->id_observacion;
$this->params['breadcrumbs'][] = ['label' => 'Observaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_observacion, 'url' => ['view', 'id' => $model->id_observacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="observaciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
