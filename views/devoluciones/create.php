<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Devoluciones */

$this->title = 'Especificar motivo de la devolución';
$this->params['breadcrumbs'][] = ['label' => 'Pagos', 'url' => ['/pago/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-create">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
