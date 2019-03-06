<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$this->title = 'Realizar Pago';
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['/pago/index']];
$this->params['breadcrumbs'][] = 'Pago';
?>
<div class="ayudas-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formpago', [
        'model' => $model,
    ]) ?>

</div>
