<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Referentes */

$this->title = 'Update Referentes: ' . $model->id_referente;
$this->params['breadcrumbs'][] = ['label' => 'Referentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_referente, 'url' => ['view', 'id' => $model->id_referente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="referentes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
