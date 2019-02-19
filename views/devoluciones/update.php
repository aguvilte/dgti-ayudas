<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Devoluciones */

$this->title = 'Update Devoluciones: ' . $model->id_devolucion;
$this->params['breadcrumbs'][] = ['label' => 'Devoluciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_devolucion, 'url' => ['view', 'id' => $model->id_devolucion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="devoluciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
