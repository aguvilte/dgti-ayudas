<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Beneficio */

$this->title = 'Subir Pdf';
$this->params['breadcrumbs'][] = ['label' => 'Ayudas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficio-update">

    <div>
        <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <?= $this->render('_formUpdatePdfdomicilio', [
        'model' => $model,
    ]) ?>

</div>
