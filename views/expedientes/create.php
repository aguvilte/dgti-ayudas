<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

$this->title = 'Create Expedientes';
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expedientes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
