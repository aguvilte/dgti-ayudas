<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AyudasExpedientes */

$this->title = 'Create Ayudas Expedientes';
$this->params['breadcrumbs'][] = ['label' => 'Ayudas Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ayudas-expedientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
