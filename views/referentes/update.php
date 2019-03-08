<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Referentes */

$this->title = 'Modificar referente: ' . $model->apeynom;
$this->params['breadcrumbs'][] = ['label' => 'Referentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->apeynom, 'url' => ['view', 'id' => $model->id_referente]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="referentes-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
