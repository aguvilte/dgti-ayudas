<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Referentes */

$this->title = 'Create Referentes';
$this->params['breadcrumbs'][] = ['label' => 'Referentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referentes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
