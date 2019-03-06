<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Observaciones */

$this->title = 'Crear Nota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observaciones-create">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
