<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$this->title = 'Realizar Autorización';
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['/pago/index']];
$this->params['breadcrumbs'][] = 'Autorización';
?>
<div class="ayudas-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formautorizacion', [
        'model' => $model,
    ]) ?>

</div>
