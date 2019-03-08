<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Referentes */

$this->title = 'Crer referente';
$this->params['breadcrumbs'][] = ['label' => 'Referentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referentes-create">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
