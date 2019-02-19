<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Observaciones */

$this->title = 'Create Observaciones';
$this->params['breadcrumbs'][] = ['label' => 'Observaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observaciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
